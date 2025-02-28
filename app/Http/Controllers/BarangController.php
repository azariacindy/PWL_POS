<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
        public function index()
        {
        // DB::insert('insert into m_barang(barang_kode, barang_nama, barang_harga, created_at) values(?, ?, ?, ?)', ['BRG001', 'Laptop', 15000000, now()]);
        // return 'Insert data barang berhasil';

        // $row = DB::update('update m_barang set barang_harga = ? where barang_kode = ?', [16000000, 'BRG001']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        // $row = DB::delete('delete from m_barang where barang_kode = ?', ['BRG001']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        $data = DB::select('select * from m_barang');
        return view('barang', ['data' => $data]);
        }
}
