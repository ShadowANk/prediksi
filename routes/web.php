<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModelEvaluationController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes (Landing & Auth)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/evaluasi-model', [ModelEvaluationController::class, 'index'])->name('evaluasi.index');
    Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');

    Route::get('/alumni-google', [GoogleSheetController::class, 'index']);
    Route::get('/sync-google-sheet', [GoogleSheetController::class, 'sync'])->name('sync.google');

});