<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\BarangController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user')
    ->controller(UserController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/user', 'store');
    Route::get('/{user}', 'show');
    Route::put('/{user_id}', 'update');
    Route::delete('/{username}', 'destroy');
});

Route::prefix('level')
    ->controller(LevelController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{level}', 'show');
    Route::put('/{level_id}', 'update');
    Route::delete('/{level}', 'destroy');
});

Route::prefix('kategori')
    ->controller(KategoriController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{kategori}', 'show');
    Route::put('/{kategori_id}', 'update');
    Route::delete('/{kategori}', 'destroy');
});

Route::prefix('barang')
    ->controller(BarangController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{barang}', 'show');
    Route::put('/{barang_id}', 'update');
    Route::delete('/{barang}', 'destroy');
});