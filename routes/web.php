<?php

use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('maps')->can('home.peta sebaran');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard')->can('dashboard.index');
    // Route::get('/admin/opd', [App\Http\Controllers\SkpdController::class, 'index'])->name('dataopd')->can('data opd.index');

    Route::get('/admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index')->can('roles.index');
    Route::get('/admin/roles/datatables', [App\Http\Controllers\Admin\RoleController::class, 'datatables'])->name('roles.datatables')->can('roles.index');
    Route::get('/admin/roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->can('roles.create');
    Route::post('/admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->can('roles.create');
    Route::get('/admin/roles/{role}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->can('roles.edit');
    Route::put('/admin/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->can('roles.edit');
    Route::delete('/admin/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->can('roles.destroy');

    Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index')->can('users.index');
    Route::get('/admin/users/datatables', [App\Http\Controllers\Admin\UserController::class, 'datatables'])->name('users.datatables')->can('users.index');
    Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create')->can('users.create');
    Route::post('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store')->can('users.create');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit')->can('users.edit');
    Route::put('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update')->can('users.edit');
    Route::put('/user/selfupdate/{user}', [App\Http\Controllers\Admin\UserController::class, 'selfUpdate'])->name('users.selfupdate');
    Route::delete('admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy')->can('users.destroy');

    Route::get('/datadasarbmd', [App\Http\Controllers\MasterBarangController::class, 'index'])->name('datadasarbmd')->can('dasar bmd.index');
    Route::get('/datadasarbmd/create', [App\Http\Controllers\MasterBarangController::class, 'create'])->name('bmd.create')->can('dasar bmd.create');
    Route::get('/datadasarbmd/{bmd}', [App\Http\Controllers\MasterBarangController::class, 'show'])->name('bmd.show')->can('dasar bmd.show');
    Route::post('/datadasarbmd', [App\Http\Controllers\MasterBarangController::class, 'store'])->name('bmd.store')->can('dasar bmd.create');
    Route::get('/datadasarbmd/{bmd}/edit', [App\Http\Controllers\MasterBarangController::class, 'edit'])->name('bmd.edit')->can('dasar bmd.edit');
    Route::put('/datadasarbmd/{bmd}', [App\Http\Controllers\MasterBarangController::class, 'update'])->name('bmd.update')->can('dasar bmd.edit');
    Route::delete('/datadasarbmd/{bmd}', [App\Http\Controllers\MasterBarangController::class, 'destroy'])->name('bmd.destroy')->can('dasar bmd.destroy');

    Route::get('/opd', [App\Http\Controllers\SkpdController::class, 'index'])->name('dataopd')->can('data opd.index');
    Route::get('/opd/create', [App\Http\Controllers\SkpdController::class, 'create'])->name('dataopd.create')->can('data opd.index');
    Route::get('/opd/{opd}', [App\Http\Controllers\SkpdController::class, 'show'])->name('dataopd.show')->can('data opd.index');
    Route::post('/opd', [App\Http\Controllers\SkpdController::class, 'store'])->name('dataopd.store')->can('data opd.create');
    Route::get('/opd/{opd}/edit', [App\Http\Controllers\SkpdController::class, 'edit'])->name('dataopd.edit')->can('data opd.edit');
    Route::put('/opd/{opd}', [App\Http\Controllers\SkpdController::class, 'update'])->name('dataopd.update')->can('data opd.edit');
    Route::delete('/opd/{opd}', [App\Http\Controllers\SkpdController::class, 'destroy'])->name('dataopd.destroy')->can('data opd.destroy');

    Route::get('/inventaris', [App\Http\Controllers\InventarisController::class, 'index'])->name('inventaris_kib_a')->can('data aset.inventaris');
    Route::get('/inventaris/create', [App\Http\Controllers\InventarisController::class, 'create'])->name('inventaris.create')->can('data aset.inventaris.create');
    Route::post('/inventaris/store', [App\Http\Controllers\InventarisController::class, 'store'])->name('inventaris.store')->can('data aset.inventaris.create');
    Route::get('/inventaris/{id}/edit', [App\Http\Controllers\InventarisController::class, 'edit'])->name('inventaris.edit')->can('data aset.inventaris');
    Route::get('/inventaris/{id}/print', [App\Http\Controllers\InventarisController::class, 'print'])->name('inventaris.print')->can('data aset.inventaris');
    Route::put('/inventaris/{id}', [App\Http\Controllers\InventarisController::class, 'update'])->name('inventaris.update')->can('data aset.inventaris');
    Route::delete('/inventaris/{id}', [App\Http\Controllers\InventarisController::class, 'destroy'])->name('inventaris.destroy')->can('data aset.inventaris.destroy');

    Route::post('/inventaris/fetch', [App\Http\Controllers\InventarisController::class, 'fetch'])->name('autocomplete.fetch');
});
