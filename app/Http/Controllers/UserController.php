<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()       
    {
        $user = UserModel::findOr(20, ['username', 'nama'], function() {
            abort(404);
        });
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

        // //  coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);
    }
}
