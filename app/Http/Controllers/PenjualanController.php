<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        // DB::insert('insert into t_penjualan(penjualan_kode, penjualan_tanggal, total_harga, created_at) values(?, ?, ?, ?)', ['TRX001', now(), 500000, now()]);
        // return 'Insert data penjualan berhasil';

        // $row = DB::update('update t_penjualan set total_harga = ? where penjualan_kode = ?', [550000, 'TRX001']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        // $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['TRX001']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        $data = DB::select('select * from t_penjualan');
        return view('penjualan', ['data' => $data]);
    }
}
