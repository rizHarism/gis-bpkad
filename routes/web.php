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


Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('maps');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/inventaris_kib_a', [App\Http\Controllers\HomeController::class, 'inventaris_kib_a'])->name('inventaris_kib_a')->can('data aset.inventaris kib a');
    Route::get('/inventaris/edit', [App\Http\Controllers\HomeController::class, 'inventaris_edit'])->name('inventaris_kib_a_edit')->can('data aset.inventaris kib a edit');
    Route::get('/datadasarbmd', [App\Http\Controllers\HomeController::class, 'datadasarbmd'])->name('datadasarbmd')->can('dasar bmd.index');
    Route::get('/admin/opd', [App\Http\Controllers\HomeController::class, 'dataopd'])->name('dataopd')->can('data opd.index');

    Route::get('admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index')->can('roles.index');
    Route::get('admin/roles/datatables', [App\Http\Controllers\Admin\RoleController::class, 'datatables'])->name('roles.datatables')->can('roles.index');
    Route::get('admin/roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->can('roles.create');
    Route::post('admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->can('roles.create');
    Route::get('admin/roles/{role}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->can('roles.edit');
    Route::put('admin/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->can('roles.edit');
    Route::delete('admin/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->can('roles.destroy');

    Route::get('admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index')->can('users.index');
    Route::get('admin/users/datatables', [App\Http\Controllers\Admin\UserController::class, 'datatables'])->name('users.datatables')->can('users.index');
    Route::get('admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create')->can('users.create');
    Route::post('admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store')->can('users.create');
    Route::get('admin/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit')->can('users.edit');
    Route::put('admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update')->can('users.edit');
    Route::delete('admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy')->can('users.destroy');
});
