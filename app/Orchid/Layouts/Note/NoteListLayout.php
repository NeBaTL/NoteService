<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Note;

use App\Models\Note;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Illuminate\Support\Str;

class NoteListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'notes';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->align(TD::ALIGN_CENTER),

            TD::make('title', 'Заголовок')
                ->sort()
                ->filter()
                ->render(function (Note $note) {
                    return Link::make($note->title)
                        ->route('platform.note.edit', $note);
                }),

            TD::make('content', 'Содержание')
                ->render(function (Note $note) {
                    return Str::limit($note->content, 50);
                }),

            TD::make('categories', 'Категории')
                ->render(function (Note $note) {
                    if ($note->categories->isEmpty()) {
                        return '—';
                    }
                    return $note->categories
                        ->pluck('name')
                        ->map(function ($name) {
                            return "<span class='badge bg-secondary'>$name</span>";
                        })
                        ->implode(' ');
                }),

            TD::make('created_at', 'Создано')
                ->sort()
                ->render(function (Note $note) {
                    return $note->created_at->format('d.m.Y H:i');
                }),
        ];
    }
}