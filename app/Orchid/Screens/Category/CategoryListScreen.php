<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use App\Models\NoteCategory;
use App\Orchid\Layouts\Category\CategoryListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class CategoryListScreen extends Screen
{
        public function query(): array
    {
        return [
            'categories' => NoteCategory::withCount('notes')->paginate(20),
        ];
    }

    public function name(): ?string
    {
        return 'Управление категориями';
    }

    public function description(): ?string
    {
        return 'Список всех категорий заметок';
    }

    public function commandBar(): array
    {
        return [
            Link::make('Создать категорию')
                ->icon('bs.plus-circle')
                ->route('platform.category.create'),
        ];
    }

    public function layout(): array
    {
        return [
            CategoryListLayout::class,
        ];
    }
}