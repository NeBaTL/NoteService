<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Note;

use App\Models\Note;
use App\Models\NoteCategory;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NoteEditScreen extends Screen
{
    public ?Note $note = null;

    public function query(Note $note): array
    {
        if ($note->exists && $note->user_id !== auth()->id()) {
        abort(403, 'У вас нет доступа к этой заметке');
    }

    return [
        'note' => $note,
    ];
    }

    public function name(): ?string
    {
        return $this->note->exists ? 'Редактирование заметки' : 'Создание заметки';
    }

    public function description(): ?string
    {
        return 'Заполните информацию о заметке';
    }

    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('bs.check-circle')
                ->method('save'),

            Button::make('Удалить')
                ->icon('bs.trash3')
                ->method('remove')
                ->canSee($this->note->exists),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('note.title')
                    ->title('Заголовок')
                    ->placeholder('Введите заголовок заметки')
                    ->required(),

                Quill::make('note.content')
                    ->title('Содержание')
                    ->placeholder('Введите текст заметки'),

                Relation::make('note.categories.')
                    ->fromModel(NoteCategory::class, 'name')
                    ->title('Категории')
                    ->multiple()
                    ->chunk(100)
                    ->help('Выберите категории для заметки'),
            ]),
        ];
    }

    public function save(Note $note, Request $request)
    {
        $request->validate([
            'note.title' => 'required|string|max:255',
            'note.content' => 'nullable|string',
        ]);

        $noteData = $request->get('note');
        
        $note->fill($noteData);
        $note->user_id = auth()->id();
        $note->save();

        if ($request->has('note.categories')) {
            $note->categories()->sync($request->input('note.categories', []));
        }

        Toast::info('Заметка успешно сохранена');

        return redirect()->route('platform.note.list');
    }

    public function remove(Note $note)
    {
        $note->delete();

        Toast::info('Заметка успешно удалена');

        return redirect()->route('platform.note.list');
    }
}