<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;

use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level',[LevelController::class,'index']);
// Route::get('/kategori',[KategoriController::class,'index']);
// Route::get('/user',[UserController::class,'index']);


// //practicum 2.6 jobsheet 4
// Route::get('/user/tambah',[UserController::class,'tambah'])->name('/user/tambah');
// Route::get('/user/ubah/{id}',[UserController::class,'ubah'])->name('/user/ubah');
// Route::get('/user/hapus/{id}',[UserController::class,'hapus'])->name('/user/hapus');
// Route::get('/user',[UserController::class,'index'])->name('/user');
// Route::post('/user/tambah_simpan',[UserController::class,'tambah_simpan'])->name('/user/tambah_simpan');
// Route::put('/user/ubah_simpan/{id}',[UserController::class,'ubah_simpan'])->name('/user/ubah_simpan');


// //jobsheet 5
// Route::get('/',[WelcomeController::class,'index']);

// Route :: get ('/public/user', [UserController::class, 'index' ]);
// Route :: get ('/user', [UserController::class, 'index' ]);
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);                  // Menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);              // Menampilkan data user dalam bentuk json untuk datatable
    Route::get('/create', [UserController::class, 'create']);           // Menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);                 // Menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);        // Menyimpan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']);               // Menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);          // Menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);             // Menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']);         // Menghapus data user
});

