<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniImportController;
use App\Http\Controllers\AlumniController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [AlumniImportController::class, 'showDashboard']
)->name('dashboard');


/*
|--------------------------------------------------------------------------
| Alumni
|--------------------------------------------------------------------------
*/
Route::get(
    '/evaluasi-model',
    [AlumniImportController::class, 'evaluasiModel']
)->name('evaluasi.index');

Route::get(
    '/alumni',
    [AlumniController::class, 'index']
)->name('alumni.index');


/*
|--------------------------------------------------------------------------
| Import
|--------------------------------------------------------------------------
*/




/*
|--------------------------------------------------------------------------
| Prediction
|--------------------------------------------------------------------------
|
| Route predict-all WAJIB ditempatkan sebelum route parameter {id}.
|
*/

Route::post(
    '/alumni/predict-all',
    [AlumniImportController::class, 'predictAll']
)->name('alumni.predict_all');


Route::post(
    '/alumni/{id}/predict',
    [AlumniImportController::class, 'predict']
)
    ->whereNumber('id')
    ->name('alumni.predict');