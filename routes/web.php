<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');

// Маршрут для создания токена (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::get('/tokens/create', function () {
        $token = auth()->user()->createToken('api-token');
        return ['token' => $token->plainTextToken];
    });
});