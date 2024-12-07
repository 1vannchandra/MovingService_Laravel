<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard', [DashboardController::class, 'updateProfile'])->name('update-profile');

Route::get('/dashboard-service', [DashboardController::class, 'indexService'])->name('dashboard-service');
Route::post('/dashboard-service-process', [DashboardController::class, 'createService'])->name('dashboard-service-process');

Route::get('/dashboard-edit', [DashboardController::class, 'indexEdit'])->name('dashboard-edit');
Route::post('/update-request', [DashboardController::class, 'updateEdit'])->name('update-edit');
Route::post('/delete-request', [DashboardController::class, 'updateDelete'])->name('update-delete');

Route::get('/dashboard-print', [DashboardController::class, 'indexPrint'])->name('dashboard-print');
Route::post('/process-print', [DashboardController::class, 'printProcess'])->name('process-print');
