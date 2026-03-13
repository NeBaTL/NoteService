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
                ->render(fn (NoteCategory $category) => $category->id),

            TD::make('name', 'Название')
                ->sort()
                ->render(fn (NoteCategory $category) => Link::make($category->name)
                    ->route('platform.category.edit', $category)),

            TD::make('user_id', 'Создатель')
                ->render(fn (NoteCategory $category) => $category->user->name ?? 'Неизвестно'),

            TD::make('notes_count', 'Количество заметок')
                ->sort()
                ->render(fn (NoteCategory $category) => $category->notes_count),

            TD::make('created_at', 'Создано')
                ->sort()
                ->render(fn (NoteCategory $category) => $category->created_at->format('d.m.Y H:i')),
        ];
    }
}