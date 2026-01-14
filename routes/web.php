<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events', [HomeController::class, 'allEvents'])->name('events.all');
Route::get('/events/{id}', [HomeController::class, 'show'])->name('events.detail')->middleware(['auth']);
Route::middleware(['role:user', 'auth'])->group(function () {
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/my-tickets', [HomeController::class, 'myTickets'])->name('ticket');
    Route::get('/tickets/{order}', [HomeController::class, 'showTiket'])
        ->name('ticket.show');
    Route::get('/profile', [ProfileController::class, 'user'])
        ->name('profile');
});
Route::put('/profile', [ProfileController::class, 'update'])
    ->name('dashboard.profile.update')->middleware(['auth']);

Route::prefix('dashboard')->middleware(['auth', 'role:admin,organizer'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('dashboard.profile');


    Route::prefix('events')->group(function () {
        Route::middleware(['role:admin,organizer'])->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('events.index');
            Route::get('/{id}/show', [EventController::class, 'show'])->name('events.show');
        });
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/verify', [EventController::class, 'verif'])->name('events.verif');
            Route::put('/{id}/verified', [EventController::class, 'accept'])->name('events.accept');
        });
        Route::middleware(['role:organizer'])->group(function () {
            Route::get('/add', [EventController::class, 'create'])->name('events.create');
            Route::post('/store', [EventController::class, 'store'])->name('events.store');
            Route::get('/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
            Route::get('/{id}/harga', [EventController::class, 'createPrice'])->name('events.createPrice');
            Route::post('/{id}/store_price', [EventController::class, 'storePrice'])->name('events.storePrice');
            Route::put('/{id}/update', [EventController::class, 'update_event'])->name('events.update_event');
            Route::put('/{id}/update_price', [EventController::class, 'update_event_price'])->name('events.update_event_price');
            Route::put('/{id}/destroy', [EventController::class, 'destroy'])->name('events.destroy');
        });
    });
    Route::prefix('orders')->group(function () {
        Route::middleware(['role:organizer'])->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::put('/orders/{id}/validate', [OrderController::class, 'validatePayment'])->name('orders.validate');
        });
    });

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
