<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/', function () {
//     return view('maps');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('maps');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/inventaris_kib_a', [App\Http\Controllers\HomeController::class, 'inventaris_kib_a'])->name('inventaris_kib_a');
Route::get('/datadasarbmd', [App\Http\Controllers\HomeController::class, 'datadasarbmd'])->name('inventaris_kib_a');
