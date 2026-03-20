<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Маршрут для админ-панели Orchid
Route::get('/dashboard', function () {
    return redirect('/admin');
})->name('dashboard')->middleware('auth');

// Или если у вас установлена Orchid, то админка доступна по /admin
// Маршруты аутентификации
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        return redirect()->intended('/notes');
    }
    
    return back()->withErrors(['email' => 'Неверные учетные данные']);
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Маршруты для заметок
Route::middleware('auth')->group(function () {
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
});