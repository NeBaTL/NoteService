<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * GET /api/notes - получение всех заметок текущего пользователя
     */
    public function index(Request $request)
    {
        $notes = $request->user()
            ->notes()
            ->with('categories')
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => NoteResource::collection($notes),
            'meta' => [
                'total' => $notes->total(),
                'per_page' => $notes->perPage(),
                'current_page' => $notes->currentPage(),
                'last_page' => $notes->lastPage(),
            ]
        ]);
    }

    /**
     * POST /api/notes - добавление новой заметки
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_ids' => 'sometimes|array',
            'category_ids.*' => 'exists:note_categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Создаем заметку для текущего пользователя
        $note = $request->user()->notes()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // Привязываем категории (если переданы)
        if ($request->has('category_ids')) {
            $note->categories()->sync($request->category_ids);
        }

        return response()->json([
            'success' => true,
            'message' => 'Заметка успешно создана',
            'data' => new NoteResource($note->load('categories'))
        ], 201);
    }
}