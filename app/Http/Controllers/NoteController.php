<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteCategory;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::with('categories')->latest();
        
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('note_categories.id', $request->category);
            });
        }
        
        $notes = $query->get();
        $categories = NoteCategory::all();
        
        return view('notes.index', compact('notes', 'categories'));
    }

    public function show(Note $note)
    {
        $note->load('categories');
        return view('notes.show', compact('note'));
    }
}