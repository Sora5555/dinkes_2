<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\TagihanController;
// use App\Http\Controllers\Api\TagihanPemasanganController;
use App\Http\Controllers\Api\HomeController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [UserController::class, 'login']);

Route::post('send_password_email',[PasswordController::class, 'send_password_email']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('pelanggan_list',[PelangganController::class, 'data_pelanggan']);
    Route::get('pelanggan_detail',[PelangganController::class, 'detail_pelanggan']);
    Route::post('tambah_penggunaan',[PelangganController::class, 'store']);
    Route::get('tagihan_terlambat',[TagihanController::class,'tagihan_terlambat']);
    Route::get('tagihan_terlambat_detail',[TagihanController::class,'tagihan_terlambat_detail']);
    Route::get('home', [HomeController::class,'index']);
});
Route::get('tagihan_list',[TagihanController::class,'tagihan']);
Route::get('tagihan_detail',[TagihanController::class,'tagihan_detail']);

Route::post('/qrismpm/transaction/callback',[TagihanController::class,'callbackQris']);
Route::post('/va/transaction/callback',[TagihanController::class,'callbackVa']);

