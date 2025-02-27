<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // kategori Makanan (MKN)
            [
                'barang_id' => 1,
                'kategori_id' => 1, 
                'barang_kode' => 'MKN001',
                'barang_nama' => 'Nasi Instan',
                'harga_beli' => 12000,
                'harga_jual' => 14000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1, 
                'barang_kode' => 'MKN002',
                'barang_nama' => 'Mie Instan',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
            ],

            // kategori Minuman (MIN)
            [
                'barang_id' => 3,
                'kategori_id' => 2, 
                'barang_kode' => 'MIN001',
                'barang_nama' => 'Teh Botol',
                'harga_beli' => 5000,
                'harga_jual' => 7000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2, 
                'barang_kode' => 'MIN002',
                'barang_nama' => 'Air Mineral 600ml',
                'harga_beli' => 3000,
                'harga_jual' => 5000,
            ],

            // kategori Snack (SNK)
            [
                'barang_id' => 5,
                'kategori_id' => 3, 
                'barang_kode' => 'SNK001',
                'barang_nama' => 'Keripik Kentang',
                'harga_beli' => 10000,
                'harga_jual' => 12000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3, 
                'barang_kode' => 'SNK002',
                'barang_nama' => 'Coklat Batangan',
                'harga_beli' => 7000,
                'harga_jual' => 9000,
            ],

            // kategori Bumbu (BMB)
            [
                'barang_id' => 7,
                'kategori_id' => 4, 
                'barang_kode' => 'BMB001',
                'barang_nama' => 'Garam 500gr',
                'harga_beli' => 4000,
                'harga_jual' => 8000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4, 
                'barang_kode' => 'BMB002',
                'barang_nama' => 'Kecap Manis',
                'harga_beli' => 12000,
                'harga_jual' => 14000,
            ],

            // kategori Sabun (SBN)
            [
                'barang_id' => 9,
                'kategori_id' => 5, 
                'barang_kode' => 'SBN001',
                'barang_nama' => 'Sabun Mandi Cair',
                'harga_beli' => 15000,
                'harga_jual' => 17000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5, 
                'barang_kode' => 'SBN002',
                'barang_nama' => 'Detergen Bubuk',
                'harga_beli' => 18000,
                'harga_jual' => 20000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
