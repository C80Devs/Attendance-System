<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


Route::middleware(['auth', 'verified','account_active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/activity', [DashboardController::class, 'showActivity'])->name('activity');

    Route::get('/leave', function() {
        return view('leave-dashboard');
    })->name('leave');


    Route::get('/tasks', function() {
        return view('tasks');
    })->name('tasks');


    Route::get('/poll', function() {
        return view('poll-dashboard');
    })->name('poll');


    Route::get('/board', function() {
        return view('employee-board.blade.php');
    })->name('board');
});




Route::middleware(['auth','account_active'])->group(function () {

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


    Route::get('/employee-board', [DashboardController::class, 'employees'])->name('employee.board');


});

require __DIR__.'/auth.php';
