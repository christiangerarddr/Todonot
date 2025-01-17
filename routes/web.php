<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/todo');
    })->name('dashboard');
});

Route::resource('todo', TodoController::class);
Route::get('todos', [TodoController::class, 'listTodos'])->name('todo.list');
