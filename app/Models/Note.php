<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Note extends Model
{
    use AsSource, Filterable;

    protected $fillable = ['user_id', 'title', 'content'];

    /**
     * The attributes for which you can use filters in the backend.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes for which can be sorted in the backend.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(NoteCategory::class, 'category_note', 'note_id', 'category_id');
    }
}