<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserDashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

Route::view('/', 'welcome')->name('home');

/*
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});*/

require __DIR__.'/settings.php';
