<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrintController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('data', DataController::class);
Route::get('edit/{id}', [DataController::class, 'edit']);
Route::get('detail/{id}', [DataController::class, 'show']);
Route::put('update/{id}', [DataController::class, 'update']);
Route::get('download/{id}', [PrintController::class, 'printOut']);