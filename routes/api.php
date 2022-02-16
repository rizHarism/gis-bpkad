<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\SkpdController;
use App\Models\Kelurahan;
use App\Models\MasterBarang;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware(['auth'])->group(function () {
Route::get('/inventaris/dashboard', [InventarisController::Class, 'dashboard']);
Route::get('/inventaris', [InventarisController::Class, 'index']);
Route::get('/inventaris/{id}/edit', [InventarisController::Class, 'edit']);
Route::get('/getinventaris', [InventarisController::Class, 'getInventaris']);
Route::post('/getinventaris/sertifikat', [InventarisController::Class, 'getInventarisSertifikat']);
Route::post('/getinventaris/nonsertifikat', [InventarisController::Class, 'getInventarisNonSertifikat']);
Route::get('/{kecamatan}/getgeometry', [InventarisController::Class, 'get_geometry']);
Route::get('/inventaris/{keyword}/search', [InventarisController::Class, 'searchInventaris']);
Route::post('/inventaris/{status}/{kelurahan}/{skpd}/queryskpd', [InventarisController::Class, 'queryKelSkpd']);
Route::post('/inventaris/{status}/{kelurahan}/{sertifikat}/querysertifikat', [InventarisController::Class, 'queryKelSertifikat']);
Route::get('/inventaris/{id}', [InventarisController::Class, 'show']);
Route::put('/inventaris/{id}', [InventarisController::Class, 'update']);

// menampilkan data master barang
Route::get('/masterbarang', [MasterBarangController::Class, 'datatables']);
Route::get('/masterbarang/{id}', [MasterBarangController::Class, 'show'])->name('masterbarang.show');

// menampilkan data skpd
Route::get('/skpd', [SkpdController::Class, 'datatables']);
Route::get('/kelurahan', [KelurahanController::Class, 'index']);
// });
