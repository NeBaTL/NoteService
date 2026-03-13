<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Note;

use App\Models\Note;
use App\Orchid\Layouts\Note\NoteListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class NoteListScreen extends Screen
{
    public function query(): array
    {
        return [
            'notes' => auth()->user()->notes()->paginate()
        ];
    }
    public function name(): ?string
    {
        return 'Управление заметками';
    }

    public function description(): ?string
    {
        return 'Список всех заметок';
    }

    public function commandBar(): array
    {
        return [
            Link::make('Создать заметку')
                ->icon('bs.plus-circle')
                ->route('platform.note.create'),
        ];
    }

    public function layout(): array
    {
        return [
            NoteListLayout::class,
        ];
    }
}