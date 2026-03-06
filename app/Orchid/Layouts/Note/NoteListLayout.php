<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Note;

use App\Models\Note;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NoteListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'notes';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->render(function (Note $note) {
                    return $note->id;
                }),

            TD::make('title', 'Заголовок')
                ->sort()
                ->render(function (Note $note) {
                    return Link::make($note->title)
                        ->route('platform.note.edit', $note);
                }),

            TD::make('content', 'Содержание')
                ->render(function (Note $note) {
                    return $note->content ? substr($note->content, 0, 50) . '...' : '';
                }),

            TD::make('created_at', 'Создано')
                ->sort()
                ->render(function (Note $note) {
                    return $note->created_at->format('d.m.Y H:i');
                }),
        ];
    }
}