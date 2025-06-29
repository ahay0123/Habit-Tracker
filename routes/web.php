<?php

use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitTrackingController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

/* list dan hapus tetap pakai controller + Livewire index */

Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
Route::get('/habits/add', [HabitController::class, 'create'])->name('habits.create');
Route::post('/habits/add', [HabitController::class, 'store'])->name('habits.store');
Route::get('/habits/{habit}/edit', [HabitController::class, 'edit'])->name('habits.edit');
Route::post('/habits/{habit}/edit', [HabitController::class, 'update'])->name('habits.update');
Route::post('/habits/{habit}/delete', [HabitController::class, 'destroy'])->name('habits.delete');
Route::get('/habits/{habit}', [HabitController::class, 'show'])->name('habits.show');

Route::post('/habits/{habit}/track', [HabitTrackingController::class, 'store'])->name('habits.track');
