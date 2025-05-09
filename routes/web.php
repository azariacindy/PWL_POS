<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\AuthController;

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

// Auth
Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('signup', [AuthController::class, 'postSignup'])->name('signup.post');

Route::get('/profile', [UserController::class, 'profile']);
Route::post('/profile/update_picture', [UserController::class, 'updateProfilePicture']);

Route::middleware(['auth'])->group(function(){ // artinya semua route di dalam group ini harus login dulu
    Route::get('/', [WelcomeController::class, 'index']);

    // artinya semua route di dalam group ini harus punya role ADM (Administrator)
    Route::middleware(['authorize:ADM'])->group(function(){
        // route user
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);                  // Menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']);              // Menampilkan data user dalam bentuk json untuk datatable
            Route::get('/create', [UserController::class, 'create']);           // Menampilkan halaman form tambah user
            Route::post('/', [UserController::class, 'store']);                 // Menyimpan data user baru
            Route::get('/{id}', [UserController::class, 'show']);               // Menampilkan detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']);          // Menampilkan halaman form edit user
            Route::put('/{id}', [UserController::class, 'update']);             // Menyimpan perubahan data user
            Route::delete('/{id}', [UserController::class, 'destroy']);         // Menghapus data user
        
            // ajax
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);           // menampilkan data user dengan ajax
            Route::get('/create_ajax', [UserController::class, 'create_ajax']);            // Menampilkan halaman form tambah user Ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']);                   // Menyimpan data user baru Ajax
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);           // Menampilkan halaman form edit user Ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);       // Menyimpan perubahan data user Ajax
            Route:: get('/{id}/delete_ajax', [UserController:: class, 'confirm_ajax' ]);   // Untuk tampilkan form confirm delete user Ajax
            Route:: delete('/{id}/delete_ajax', [UserController:: class, 'delete_ajax' ]); // Untuk hapus data user Ajax
        });
        
        // route level
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index']);                  
            Route::post('/list', [LevelController::class, 'list']);              
            Route::get('/create', [LevelController::class, 'create']);
            Route::post('/', [LevelController::class, 'store']);           
            Route::get('/{id}/show', [LevelController::class, 'show']);              
            Route::get('/{id}/edit', [LevelController::class, 'edit']);          
            Route::put('/{id}', [LevelController::class, 'update']);             
            Route::delete('/{id}', [LevelController::class, 'destroy']);         
        
            // ajax
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']); 
            Route::post('/ajax', [LevelController::class, 'store_ajax']);        
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);      
            Route:: get('/{id}/delete_ajax', [LevelController:: class, 'confirm_ajax' ]);  
            Route:: delete('/{id}/delete_ajax', [LevelController:: class, 'delete_ajax' ]);
        });
        
        // route kategori
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']);
            Route::post('/list', [KategoriController::class, 'list']);
            Route::get('/create', [KategoriController::class, 'create']);
            Route::post('/', [KategoriController::class, 'store']);
        
            // ajax
            Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); 
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);      
            Route:: get('/{id}/delete_ajax', [KategoriController:: class, 'confirm_ajax' ]);  
            Route:: delete('/{id}/delete_ajax', [KategoriController:: class, 'delete_ajax' ]);
        });
    });

    Route::middleware(['authorize: STF, MNG, ADM'])->group(function () {
        // route barang
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']);
            Route::post('/list', [BarangController::class, 'list']);
            Route::get('/create', [BarangController::class, 'create']);
            Route::post('/', [BarangController::class, 'store']);
        
            // ajax
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']); 
            Route::post('/ajax', [BarangController::class, 'store_ajax']);
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);      
            Route:: get('/{id}/delete_ajax', [BarangController:: class, 'confirm_ajax' ]);  
            Route:: delete('/{id}/delete_ajax', [BarangController:: class, 'delete_ajax' ]);

            Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
            Route::get('/export/excel', [BarangController::class, 'export_excel']); // export excel
            Route::get('/export/pdf', [BarangController::class, 'export_pdf']); // export pdf
        });
        
        // route stok
        Route::group(['prefix' => 'stok'], function () {
            Route::get('/', [StokController::class, 'index']);
            Route::post('/list', [StokController::class, 'list']);
            Route::get('/create', [StokController::class, 'create']);
            Route::post('/', [StokController::class, 'store']);
            Route::get('/create_ajax', [StokController::class, 'create_ajax']);
            Route::get('/stok/create_ajax', [StokController::class, 'create_ajax'])->name('stok.create_ajax');
            Route::post('/ajax', [StokController::class, 'store_ajax']);
            Route::get('/{id}', [StokController::class, 'show']);
            Route::get('/{id}/show', [StokController::class, 'show'])->name('stok.show');
            Route::get('/{id}/edit', [StokController::class, 'edit']);
            Route::put('/{id}', [StokController::class, 'update']);
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
            Route::delete('/{id}', [StokController::class, 'destroy']);
        });
        
        
        // route penjualan
        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('/', [PenjualanController::class, 'index']);
            Route::post('/list', [PenjualanController::class, 'list']);
            Route::get('/create', [PenjualanController::class, 'create']);
            Route::post('/', [PenjualanController::class, 'store']);
            Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
            Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
            Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
            Route::get('/{id}', [PenjualanController::class, 'show']);
            Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
            Route::put('/{id}', [PenjualanController::class, 'update']);
            Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
            Route::delete('/{id}', [PenjualanController::class, 'destroy']);
        });
    });
});


// Route::get('/', [WelcomeController::class, 'index']); 

// Route::get('/profile', [UserController::class, 'profile']);
// Route::post('/profile/update_picture', [UserController::class, 'updateProfilePicture']);

// Route::group(['prefix' => 'user'], function () {
//     Route::get('/', [UserController::class, 'index']);                  // Menampilkan halaman awal user
//     Route::post('/list', [UserController::class, 'list']);              // Menampilkan data user dalam bentuk json untuk datatable
//     Route::get('/create', [UserController::class, 'create']);           // Menampilkan halaman form tambah user
//     Route::post('/', [UserController::class, 'store']);                 // Menyimpan data user baru
//     Route::get('/{id}', [UserController::class, 'show']);               // Menampilkan detail user
//     Route::get('/{id}/edit', [UserController::class, 'edit']);          // Menampilkan halaman form edit user
//     Route::put('/{id}', [UserController::class, 'update']);             // Menyimpan perubahan data user
//     Route::delete('/{id}', [UserController::class, 'destroy']);         // Menghapus data user

//     // ajax
//     Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);           // menampilkan data user dengan ajax
//     Route::get('/create_ajax', [UserController::class, 'create_ajax']);            // Menampilkan halaman form tambah user Ajax
//     Route::post('/ajax', [UserController::class, 'store_ajax']);                   // Menyimpan data user baru Ajax
//     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);           // Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);       // Menyimpan perubahan data user Ajax
//     Route:: get('/{id}/delete_ajax', [UserController:: class, 'confirm_ajax' ]);   // Untuk tampilkan form confirm delete user Ajax
//     Route:: delete('/{id}/delete_ajax', [UserController:: class, 'delete_ajax' ]); // Untuk hapus data user Ajax
// });

// Route::group(['prefix' => 'level'], function () {
//     Route::get('/', [LevelController::class, 'index']);                  
//     Route::post('/list', [LevelController::class, 'list']);              
//     Route::get('/create', [LevelController::class, 'create']);
//     Route::post('/', [LevelController::class, 'store']);           
//     Route::get('/{id}/show', [LevelController::class, 'show']);              
//     Route::get('/{id}/edit', [LevelController::class, 'edit']);          
//     Route::put('/{id}', [LevelController::class, 'update']);             
//     Route::delete('/{id}', [LevelController::class, 'destroy']);         

//     // ajax
//     Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
//     Route::get('/create_ajax', [LevelController::class, 'create_ajax']); 
//     Route::post('/ajax', [LevelController::class, 'store_ajax']);        
//     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);      
//     Route:: get('/{id}/delete_ajax', [LevelController:: class, 'confirm_ajax' ]);  
//     Route:: delete('/{id}/delete_ajax', [LevelController:: class, 'delete_ajax' ]);
// });

// Route::group(['prefix' => 'kategori'], function () {
//     Route::get('/', [KategoriController::class, 'index']);
//     Route::post('/list', [KategoriController::class, 'list']);
//     Route::get('/create', [KategoriController::class, 'create']);
//     Route::post('/', [KategoriController::class, 'store']);

//     // ajax
//     Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
//     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); 
//     Route::post('/ajax', [KategoriController::class, 'store_ajax']);
//     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);      
//     Route:: get('/{id}/delete_ajax', [KategoriController:: class, 'confirm_ajax' ]);  
//     Route:: delete('/{id}/delete_ajax', [KategoriController:: class, 'delete_ajax' ]);
// });

// Route::group(['prefix' => 'barang'], function () {
//     Route::get('/', [BarangController::class, 'index']);
//     Route::post('/list', [BarangController::class, 'list']);
//     Route::get('/create', [BarangController::class, 'create']);
//     Route::post('/', [BarangController::class, 'store']);

//     // ajax
//     Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']); 
//     Route::post('/ajax', [BarangController::class, 'store_ajax']);
//     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);      
//     Route:: get('/{id}/delete_ajax', [BarangController:: class, 'confirm_ajax' ]);  
//     Route:: delete('/{id}/delete_ajax', [BarangController:: class, 'delete_ajax' ]);
    
//     Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
//     Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
//     Route::get('/export/excel', [BarangController::class, 'export_excel']); // export excel
//     Route::get('/export/pdf', [BarangController::class, 'export_pdf']); // export pdf
// });

// Route::group(['prefix' => 'stok'], function () {
//     Route::get('/', [StokController::class, 'index']);
//     Route::post('/list', [StokController::class, 'list']);
//     Route::get('/create', [StokController::class, 'create']);
//     Route::post('/', [StokController::class, 'store']);
//     Route::get('/create_ajax', [StokController::class, 'create_ajax']);
//     Route::get('/stok/create_ajax', [StokController::class, 'create_ajax'])->name('stok.create_ajax');
//     Route::post('/ajax', [StokController::class, 'store_ajax']);
//     Route::get('/{id}', [StokController::class, 'show']);
//     Route::get('/{id}/show', [StokController::class, 'show'])->name('stok.show');
//     Route::get('/{id}/edit', [StokController::class, 'edit']);
//     Route::put('/{id}', [StokController::class, 'update']);
//     Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
//     Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
//     Route::delete('/{id}', [StokController::class, 'destroy']);
// });


// Route::group(['prefix' => 'penjualan'], function () {
//     Route::get('/', [PenjualanController::class, 'index']);
//     Route::post('/list', [PenjualanController::class, 'list']);
//     Route::get('/create', [PenjualanController::class, 'create']);
//     Route::post('/', [PenjualanController::class, 'store']);
//     Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
//     Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
//     Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
//     Route::get('/{id}', [PenjualanController::class, 'show']);
//     Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
//     Route::put('/{id}', [PenjualanController::class, 'update']);
//     Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
//     Route::delete('/{id}', [PenjualanController::class, 'destroy']);
// });

// Route::group(['prefix' => 'penjualan_detail'], function () {
//     Route::get('/', [PenjualanDetailController::class, 'index']);
//     Route::post('/list', [PenjualanDetailController::class, 'list']);
//     Route::get('/create', [PenjualanDetailController::class, 'create']);
//     Route::post('/', [PenjualanDetailController::class, 'store']);
//     Route::get('/create_ajax', [PenjualanDetailController::class, 'create_ajax']);
//     Route::post('/ajax', [PenjualanDetailController::class, 'store_ajax']);
//     Route::get('/{id}', [PenjualanDetailController::class, 'show']);
//     Route::get('/{id}/edit', [PenjualanDetailController::class, 'edit']);
//     Route::put('/{id}', [PenjualanDetailController::class, 'update']);
//     Route::get('/{id}/edit_ajax', [PenjualanDetailController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [PenjualanDetailController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [PenjualanDetailController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [PenjualanDetailController::class, 'delete_ajax']);
//     Route::delete('/{id}', [PenjualanDetailController::class, 'destroy']);
//     Route::post('/penjualan-detail/store_ajax', [PenjualanDetailController::class, 'store_ajax']);
//     Route::get('/{id}/show_ajax', [PenjualanDetailController::class, 'show_ajax']);

//     // Route::post('t_penjualan_detail/list', [PenjualanDetailController::class, 'list']);
//     Route::get('/penjualan-detail', [PenjualanDetailController::class, 'index'])->name('penjualan-detail.index');
//     Route::get('/penjualan-detail/create', [PenjualanDetailController::class, 'create'])->name('penjualan-detail.create');
//     Route::post('/penjualan-detail', [PenjualanDetailController::class, 'store'])->name('penjualan-detail.store');
//     Route::get('/penjualan-detail', [PenjualanDetailController::class, 'index'])->name('penjualan-detail.index');

// });