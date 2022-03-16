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

    Route::get('/admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index')->can('administrator.pengaturan role');
    Route::get('/admin/roles/datatables', [App\Http\Controllers\Admin\RoleController::class, 'datatables'])->name('roles.datatables')->can('administrator.pengaturan role');
    Route::get('/admin/roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->can('administrator.pengaturan role');
    Route::post('/admin/roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->can('administrator.pengaturan role');
    Route::get('/admin/roles/{role}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->can('administrator.pengaturan role');
    Route::put('/admin/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->can('administrator.pengaturan role');
    Route::delete('/admin/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->can('administrator.pengaturan role');

    Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index')->can('administrator.manajemen user');
    Route::get('/admin/users/datatables', [App\Http\Controllers\Admin\UserController::class, 'datatables'])->name('users.datatables')->can('administrator.manajemen user');
    Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create')->can('administrator.manajemen user');
    Route::post('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store')->can('administrator.manajemen user');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit')->can('administrator.manajemen user');
    Route::put('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update')->can('administrator.manajemen user');
    Route::put('/user/selfupdate/{user}', [App\Http\Controllers\Admin\UserController::class, 'selfUpdate'])->name('users.selfupdate');
    Route::delete('admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy')->can('administrator.manajemen user');

    Route::get('/datadasarbmd', [App\Http\Controllers\MasterBarangController::class, 'index'])->name('datadasarbmd')->can('data dasar.bmd');
    Route::get('/datadasarbmd/create', [App\Http\Controllers\MasterBarangController::class, 'create'])->name('bmd.create')->can('data dasar.bmd');
    Route::get('/datadasarbmd/{bmd}', [App\Http\Controllers\MasterBarangController::class, 'show'])->name('bmd.show')->can('data dasar.bmd');
    Route::post('/datadasarbmd', [App\Http\Controllers\MasterBarangController::class, 'store'])->name('bmd.store')->can('data dasar.bmd');
    Route::get('/datadasarbmd/{bmd}/edit', [App\Http\Controllers\MasterBarangController::class, 'edit'])->name('bmd.edit')->can('data dasar.bmd');
    Route::put('/datadasarbmd/{bmd}', [App\Http\Controllers\MasterBarangController::class, 'update'])->name('bmd.update')->can('data dasar.bmd');
    Route::delete('/datadasarbmd/{bmd}', [App\Http\Controllers\MasterBarangController::class, 'destroy'])->name('bmd.destroy')->can('data dasar.bmd');

    Route::get('/opd', [App\Http\Controllers\SkpdController::class, 'index'])->name('dataopd')->can('data dasar.opd');
    Route::get('/opd/create', [App\Http\Controllers\SkpdController::class, 'create'])->name('dataopd.create')->can('data dasar.opd');
    Route::get('/opd/{opd}', [App\Http\Controllers\SkpdController::class, 'show'])->name('dataopd.show')->can('data dasar.opd');
    Route::post('/opd', [App\Http\Controllers\SkpdController::class, 'store'])->name('dataopd.store')->can('data dasar.opd');
    Route::get('/opd/{opd}/edit', [App\Http\Controllers\SkpdController::class, 'edit'])->name('dataopd.edit')->can('data dasar.opd');
    Route::put('/opd/{opd}', [App\Http\Controllers\SkpdController::class, 'update'])->name('dataopd.update')->can('data dasar.opd');
    Route::delete('/opd/{opd}', [App\Http\Controllers\SkpdController::class, 'destroy'])->name('dataopd.destroy')->can('data dasar.opd');

    Route::get('/inventaris', [App\Http\Controllers\InventarisController::class, 'index'])->name('inventaris_kib_a')->can('data aset.aset tanah');
    Route::get('/inventaris/create', [App\Http\Controllers\InventarisController::class, 'create'])->name('inventaris.create')->can('data aset.aset tanah');
    Route::post('/inventaris/store', [App\Http\Controllers\InventarisController::class, 'store'])->name('inventaris.store')->can('data aset.aset tanah');
    Route::get('/inventaris/{id}/edit', [App\Http\Controllers\InventarisController::class, 'edit'])->name('inventaris.edit')->can('data aset.aset tanah');
    Route::get('/inventaris/{id}/print', [App\Http\Controllers\InventarisController::class, 'print'])->name('inventaris.print')->can('data aset.aset tanah');
    Route::put('/inventaris/{id}', [App\Http\Controllers\InventarisController::class, 'update'])->name('inventaris.update')->can('data aset.aset tanah');
    Route::delete('/inventaris/{id}', [App\Http\Controllers\InventarisController::class, 'destroy'])->name('inventaris.destroy')->can('data aset.aset tanah');
    Route::post('/inventaris/fetch', [App\Http\Controllers\InventarisController::class, 'fetch'])->name('autocomplete.fetch');

    Route::get('/inventaris/gedung', [App\Http\Controllers\InventarisController::class, 'indexGedung'])->name('inventaris_kib_c')->can('data aset.aset gedung');
    Route::get('/inventaris/jaringan', [App\Http\Controllers\InventarisController::class, 'indexJaringan'])->name('inventaris_kib_d')->can('data aset.aset jaringan');
});
