<?php

namespace Database\Seeders;

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

        for ($i = 0; $i < 10; $i++) {
            DB::table('thetichdiem')->insert([
                'mathetichdiem' => strtoupper(Str::random(6)), // Mã thẻ ngẫu nhiên gồm 6 ký tự
                'diemtichluy' => $faker->numberBetween(0, 1000), // Điểm tích lũy từ 0 đến 1000
                'idkhachhang' => strtoupper(Str::random(6)), // Mã khách hàng ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
