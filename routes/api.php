<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;

// Маршруты, требующие аутентификации
Route::middleware('auth:sanctum')->group(function () {
    // Заметки
    Route::apiResource('notes', NoteController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
});