<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events', [HomeController::class, 'allEvents'])->name('events.all');

Route::prefix('dashboard')->middleware(['auth', 'verified', 'role:admin,organizer'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'index'])
            ->name('dashboard.profile');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('dashboard.profile.update');
    
    Route::prefix('users')->middleware(['role:admin'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/add', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/{id}/show', [UserController::class, 'show'])->name('users.show');
    });
});

require __DIR__ . '/auth.php';
