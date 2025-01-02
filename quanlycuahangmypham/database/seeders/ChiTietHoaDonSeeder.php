<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChiTietHoaDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt

        for ($i = 0; $i < 10; $i++) {
            DB::table('chitiethoadon')->insert([
                'idhoadon' => strtoupper(Str::random(6)), // Mã hóa đơn ngẫu nhiên, phải tồn tại trong bảng hoadon
                'idsanpham' => strtoupper(Str::random(6)), // Mã sản phẩm ngẫu nhiên, phải tồn tại trong bảng sanpham
                'soluongmua' => $faker->numberBetween(1, 10), // Số lượng mua từ 1 đến 10
                'giamgia' => $faker->randomFloat(2, 0, 50), // Giảm giá từ 0% đến 50%
                'thanhtien' => $faker->randomFloat(2, 10000, 1000000), // Thành tiền từ 10,000 đến 1,000,000
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
