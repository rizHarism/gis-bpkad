<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\SkpdController;
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

Route::get('/inventaris/dashboard', [InventarisController::Class, 'dashboard']);
Route::get('/inventaris', [InventarisController::Class, 'index']);
Route::get('/getinventaris', [InventarisController::Class, 'getInventaris']);
Route::get('/inventaris/{keyword}/search', [InventarisController::Class, 'searchInventaris']);
Route::post('/inventaris/{status}/{skpd}/query', [InventarisController::Class, 'queryInventaris']);
Route::get('/inventaris/{id}', [InventarisController::Class, 'show']);
Route::put('/inventaris/{id}', [InventarisController::Class, 'update']);

// menampilkan seluruh data master barang
Route::get('/masterbarang', [MasterBarangController::Class, 'index']);

// menampilkan data skpd
Route::get('/skpd', [SkpdController::Class, 'index']);
