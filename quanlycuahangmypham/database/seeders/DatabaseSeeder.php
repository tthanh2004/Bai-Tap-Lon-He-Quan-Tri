<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KhachhangSeeder::class,
            NhanvienSeeder::class,
            TheTichDiemSeeder::class,
            HangSeeder::class,
            SanPhamSeeder::class,
            NhapHangSeeder::class,
            HoaDonSeeder::class,
            ChiTietHoaDonSeeder::class,
        ]);
    }
}
