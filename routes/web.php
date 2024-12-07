<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::view('/', 'welcome');

/*Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); */


Route::get('/dashboard', [TaskController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/task-list', [TaskController::class, 'taskList'])->middleware(['auth', 'verified'])->name('task.list');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
