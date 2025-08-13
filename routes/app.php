<?php

use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('app.dashboard');

    Route::get('/reniec', [DataController::class, 'index'])->name('app.reniec-data.index');

    Route::resource('users', UserController::class)->names('');
    Route::prefix('/')->name('app.users.')->controller(UserController::class)->group(function () {
        Route::resource('users', UserController::class)->names('');
    });
});
