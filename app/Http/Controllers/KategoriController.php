<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        // DB::insert('insert into m_kategori(kategori_kode, kategori_nama, created_at) values(?, ?, ?)', ['KTG001', 'Elektronik', now()]);
        // return 'Insert data kategori berhasil';

        // $row = DB::update('update m_kategori set kategori_nama = ? where kategori_kode = ?', ['Gadget', 'KTG001']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        // $row = DB::delete('delete from m_kategori where kategori_kode = ?', ['KTG001']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        $data = DB::select('select * from m_kategori');
        return view('kategori', ['data' => $data]);
    }
}
