<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NhapHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt
        $sanphamIds = DB::table('sanpham')->pluck('masanpham')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('nhaphang')->insert([
                'manhaphang' => strtoupper(Str::random(6)), // Mã nhập hàng ngẫu nhiên gồm 6 ký tự
                'idsanpham' => $faker->randomElement($sanphamIds), // Mã sản phẩm ngẫu nhiên, phải tồn tại trong bảng sanpham
                'soluongnhap' => $faker->numberBetween(1, 100), // Số lượng nhập từ 1 đến 100
                'gianhap' => $faker->randomFloat(2, 1000, 50000), // Giá nhập từ 1,000 đến 50,000
                'ngaynhap' => $faker->dateTimeBetween('-1 years', 'now'), // Ngày nhập trong vòng 1 năm qua
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
