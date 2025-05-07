<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CsvImportController;

Route::get('/import-csv-data', [CsvImportController::class, 'importCsvData']);

Route::middleware(['auth', 'verified', 'account_active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/activity', [DashboardController::class, 'showActivity'])->name('activity');

    Route::get('/leave', function () {
        return view('leave-dashboard');
    })->name('leave');

    Route::prefix('admin')->middleware('isAdmin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
        Route::post('/clock-in', [AttendanceController::class, 'faceClockin'])->name('users.clock-in');
        Route::post('users/enroll', [AdminController::class, 'enroll'])->name('users.enroll');

    })->middleware(['isAdmin']);

    Route::get('/tasks', function () {
        return view('tasks');
    })->name('tasks');

    Route::get('/poll', function () {
        return view('poll-dashboard');
    })->name('poll');

    Route::get('/board', function () {
        return view('employee-board.blade.php');
    })->name('board');
});

Route::middleware(['auth', 'account_active'])->group(function () {

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/employee-board', [DashboardController::class, 'employees'])->name('employee.board');

});

require __DIR__ . '/auth.php';
