<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TelegramMessageController;

// Тестовый маршрут
Route::get("/test", function () {
    return response()->json([
        "success" => true,
        "message" => "API is working",
        "time" => now()->toDateTimeString()
    ]);
});

// Telegram маршруты
Route::prefix("telegram")->group(function () {
    Route::post("/messages", [TelegramMessageController::class, "store"]);
    Route::get("/messages", [TelegramMessageController::class, "index"]);
});
