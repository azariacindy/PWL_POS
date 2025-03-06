<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()       
    {
        $user = UserModel::firstOrNew(
            [
                'username' => 'manager55',
                'nama' => 'Manager55',
                'password' => Hash::make('1234'),
                'level_id' => 2
            ]
        );
        $user->username = 'manager55';

       // debugging perubahan data
       dump($user->isDirty()); // true
       dump($user->isDirty('username')); // true
       dump($user->isDirty('nama')); // false
       dump($user->isDirty(['nama', 'username'])); // true

       dump($user->isClean()); // false
       dump($user->isClean('username')); // false
       dump($user->isClean('nama')); // true
       dump($user->isClean(['nama', 'username'])); // false

       // menyimpan perubahan
       $user->save();

       dump($user->isDirty()); // false
       dump($user->isClean()); // true
        
        return view ('user', ['data' => $user]);

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
    }
}
