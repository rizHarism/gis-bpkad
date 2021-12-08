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
Route::get('/inventaris_kib_a', [App\Http\Controllers\HomeController::class, 'inventaris_kib_a'])->name('inventaris_kib_a')->can('data aset.inventaris kib a');
Route::get('/datadasarbmd', [App\Http\Controllers\HomeController::class, 'datadasarbmd'])->name('inventaris_kib_a')->can('dasar bmd.index');
Route::get('admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
Route::get('admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
Route::post('admin/roles', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
Route::post('admin/roles/{role}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
Route::put('admin/roles/{role}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
Route::delete('admin/roles/{role}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');