<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class NoteCategory extends Model
{
    use AsSource, Filterable;

    protected $table = 'note_categories';
    
    protected $fillable = ['user_id', 'name'];

    /**
     * The attributes for which you can use filters in the backend.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'created_at',
    ];

    /**
     * The attributes for which can be sorted in the backend.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notes(): BelongsToMany
{
    return $this->belongsToMany(Note::class, 'note_category', 'note_category_id', 'note_id');
}
}