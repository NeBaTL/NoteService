<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use App\Models\NoteCategory;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
    public ?NoteCategory $category = null;

    public function query(NoteCategory $category): array
    {
        return [
            'category' => $category,
        ];
    }

    public function name(): ?string
    {
        return $this->category->exists ? 'Редактирование категории' : 'Создание категории';
    }

    public function description(): ?string
    {
        return 'Заполните информацию о категории';
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
                ->canSee($this->category->exists),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('category.name')
                    ->title('Название')
                    ->placeholder('Введите название категории')
                    ->required(),
            ]),
        ];
    }

    public function save(NoteCategory $category, Request $request)
    {
        $request->validate([
            'category.name' => 'required|string|max:255',
        ]);

        $categoryData = $request->get('category');
        
        $category->fill($categoryData);
        $category->user_id = auth()->id();
        $category->save();

        Toast::info('Категория успешно сохранена');

        return redirect()->route('platform.category.list');
    }

    public function remove(NoteCategory $category)
    {
        $category->delete();

        Toast::info('Категория успешно удалена');

        return redirect()->route('platform.category.list');
    }
}