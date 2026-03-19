<?php
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');

Route::get('/tokens/create', function (){
    $token = Auth::user()->createToken('name');
    return ['token' => $token->plainTextToken];
});