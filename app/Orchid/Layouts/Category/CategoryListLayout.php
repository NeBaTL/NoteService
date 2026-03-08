<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use App\Models\NoteCategory;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    protected $target = 'categories';

    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->render(function (NoteCategory $category) {
                    return $category->id;
                }),

            TD::make('name', 'Название')
                ->sort()
                ->render(function (NoteCategory $category) {
                    return Link::make($category->name)
                        ->route('platform.category.edit', $category);
                }),

            TD::make('notes_count', 'Количество заметок')
                ->render(function (NoteCategory $category) {
                    return $category->notes_count ?? 0;
                }),

            TD::make('created_at', 'Создано')
                ->sort()
                ->render(function (NoteCategory $category) {
                    return $category->created_at->format('d.m.Y H:i');
                }),
        ];
    }
}