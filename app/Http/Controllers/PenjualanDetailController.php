<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        // DB::insert('insert into t_penjualan_detail(detail_kode, penjualan_kode, barang_kode, jumlah, harga_satuan, created_at) values(?, ?, ?, ?, ?, ?)', ['DTRX001', 'TRX001', 'BRG001', 2, 250000, now()]);
        // return 'Insert data detail penjualan berhasil';

        // $row = DB::update('update t_penjualan_detail set jumlah = ? where detail_kode = ?', [3, 'DTRX001']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        // $row = DB::delete('delete from t_penjualan_detail where detail_kode = ?', ['DTRX001']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        $data = DB::select('select * from t_penjualan_detail');
        return view('penjualan_detail', ['data' => $data]);
    }
}
