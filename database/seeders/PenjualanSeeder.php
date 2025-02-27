<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'pembeli' => 'Rizal Mahendra',
                'penjualan_kode' => 'J001',
                'penjualan_tanggal' => Carbon::parse('2025-02-10 10:15:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Siti Aisyah',
                'penjualan_kode' => 'J002',
                'penjualan_tanggal' => Carbon::parse('2025-02-11 12:30:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Dimas Prasetyo',
                'penjualan_kode' => 'J003',
                'penjualan_tanggal' => Carbon::parse('2025-02-12 14:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Lestari Indah',
                'penjualan_kode' => 'J004',
                'penjualan_tanggal' => Carbon::parse('2025-02-15 16:20:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Bayu Ramadhan',
                'penjualan_kode' => 'J005',
                'penjualan_tanggal' => Carbon::parse('2025-02-18 18:10:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Nadia Permata',
                'penjualan_kode' => 'J006',
                'penjualan_tanggal' => Carbon::parse('2025-02-20 19:45:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Rafi Kurniawan',
                'penjualan_kode' => 'J007',
                'penjualan_tanggal' => Carbon::parse('2025-02-22 21:00:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Melati Sari',
                'penjualan_kode' => 'J008',
                'penjualan_tanggal' => Carbon::parse('2025-02-24 22:15:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Dion Saputra',
                'penjualan_kode' => 'J009',
                'penjualan_tanggal' => Carbon::parse('2025-02-26 23:30:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Aulia Rahman',
                'penjualan_kode' => 'J010',
                'penjualan_tanggal' => Carbon::parse('2025-02-28 08:45:00'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        
        DB::table('t_penjualan')->insert($data);
    }
}
