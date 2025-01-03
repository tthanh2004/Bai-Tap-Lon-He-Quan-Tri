<?php

namespace Database\Seeders;

use App\Models\KhachHang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TheTichDiemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt

        $khachhangIds = DB::table('khachhang')->pluck('makhachhang')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('thetichdiem')->insert([
                'mathetichdiem' => strtoupper(Str::random(6)), // Mã thẻ ngẫu nhiên gồm 6 ký tự
                'diemtichluy' => $faker->numberBetween(0, 0), // Điểm tích lũy từ 0 đến 1000
                'idkhachhang'   => $faker->randomElement($khachhangIds), // Mã khách hàng ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
