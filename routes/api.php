<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TelegramMessageController;
use App\Http\Controllers\Api\NoteController;

// Тестовый маршрут (доступен всем)
Route::get("/test", function () {
    return response()->json([
        "success" => true,
        "message" => "API is working",
        "time" => now()->toDateTimeString()
    ]);
});

// Маршруты для Telegram (пока без аутентификации, для тестирования)
Route::prefix("telegram")->group(function () {
    Route::post("/messages", [TelegramMessageController::class, "store"]);
    Route::get("/messages", [TelegramMessageController::class, "index"]);
});

// Маршруты, требующие аутентификации
Route::middleware('auth:sanctum')->group(function () {
    // Заметки
    Route::apiResource('notes', NoteController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
});