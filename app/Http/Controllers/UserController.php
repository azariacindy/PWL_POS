<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{    
    public function index(){
        $user = UserModel::with('level')->get();
        return view ('user', ['data' => $user]);
    }

    public function tambah(){
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request){
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }
    
    public function ubah($id){
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request){
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->level_id = $request->level_id;

        $user->save();
        return redirect('/user');
    }

    public function hapus($id){
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }

    // public function index()       
    // {
    //     $user = UserModel::firstOrNew(
    //         [
    //             'username' => 'manager55',
    //             'nama' => 'Manager55',
    //             'password' => Hash::make('1234'),
    //             'level_id' => 2
    //         ]
    //     );
    //     $user->username = 'manager55';

    //    // debugging perubahan data
    //    dump($user->isDirty()); // true
    //    dump($user->isDirty('username')); // true
    //    dump($user->isDirty('nama')); // false
    //    dump($user->isDirty(['nama', 'username'])); // true

    //    dump($user->isClean()); // false
    //    dump($user->isClean('username')); // false
    //    dump($user->isClean('nama')); // true
    //    dump($user->isClean(['nama', 'username'])); // false

    //    // menyimpan perubahan
    //    $user->save();

    //    dump($user->isDirty()); // false
    //    dump($user->isClean()); // true
        
    //     return view ('user', ['data' => $user]);

        // // tambah data user dengan Eluquenr Model
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager3',
        //     'nama' => 'Mananger 3',
        //     'password' => Hash::make('12345'),
        // ];
        // UserModel::create($data); // tambahkan data ke table m_user

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // $data = [
        //     'nama' => 'Pelanggan Pertama'
        // ];
        // UserModel::where('username', 'customer-1') -> update($data); // update data user

        //  coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);
    // }
}
