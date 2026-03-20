<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\Auth\CustomAuthController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');

// Гостевые маршруты (неавторизованные)
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'login'])->name('login.submit');
});

// Защищённые маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');
    Route::get('/tokens/create', function () {
        $token = auth()->user()->createToken('api-token');
        return ['token' => $token->plainTextToken];
    });
});