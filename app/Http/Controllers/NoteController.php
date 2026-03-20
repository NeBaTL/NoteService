<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Отображение списка заметок текущего пользователя
     */
    public function index()
    {
        $notes = Auth::user()->notes()
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('notes.index', compact('notes'));
    }
    
    /**
     * Показать форму для создания новой заметки
     */
    public function create()
    {
        return view('notes.create');
    }
    
    /**
     * Сохранить новую заметку
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        $note = Auth::user()->notes()->create($validated);
        
        return redirect()->route('notes.show', $note)
            ->with('success', 'Заметка успешно создана!');
    }
    
    /**
     * Отображение конкретной заметки
     */
    public function show(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'У вас нет доступа к этой заметке');
        }
        
        return view('notes.show', compact('note'));
    }
    
    /**
     * Показать форму для редактирования заметки
     */
    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'У вас нет доступа к этой заметке');
        }
        
        return view('notes.edit', compact('note'));
    }
    
    /**
     * Обновить заметку
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'У вас нет доступа к этой заметке');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        $note->update($validated);
        
        return redirect()->route('notes.show', $note)
            ->with('success', 'Заметка обновлена!');
    }
    
    /**
     * Удалить заметку
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'У вас нет доступа к этой заметке');
        }
        
        $note->delete();
        
        return redirect()->route('notes.index')
            ->with('success', 'Заметка удалена!');
    }
}