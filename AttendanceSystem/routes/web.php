<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/activity', [DashboardController::class, 'showActivity'])->name('activity');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Livewire::setUpdateRoute(function ($handle) {
        return Route::post("/tams/public/livewire/update",$handle);
    });
});

require __DIR__.'/auth.php';
