<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('events', EventController::class)->only(['index', 'create', 'store']);
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');
Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Utilisez la méthode resource pour définir les routes pour les événements





});

require __DIR__.'/auth.php';

