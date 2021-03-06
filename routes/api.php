<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\MasterBarangController;
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
Route::get('/inventaris/{keywoard}/search', [InventarisController::Class, 'searchInventaris']);
Route::get('/inventaris/{id}', [InventarisController::Class, 'show']);
Route::put('/inventaris/{id}', [InventarisController::Class, 'update']);
Route::get('/masterbarang', [MasterBarangController::Class, 'index']);
