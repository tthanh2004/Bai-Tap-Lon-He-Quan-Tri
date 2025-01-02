<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt

        for ($i = 0; $i < 10; $i++) {
            DB::table('sanpham')->insert([
                'masanpham' => strtoupper(Str::random(6)), // Mã sản phẩm ngẫu nhiên gồm 6 ký tự
                'idhang' => strtoupper(Str::random(6)), // Mã hãng ngẫu nhiên, phải tồn tại trong bảng hang
                'tensanpham' => $faker->word, // Tên sản phẩm ngẫu nhiên
                'donvitinh' => 'Cái', // Đơn vị tính cố định hoặc ngẫu nhiên nếu cần
                'dongia' => $faker->randomFloat(2, 1000, 100000), // Giá từ 1,000 đến 100,000
                'soluongton' => $faker->numberBetween(0, 100), // Số lượng tồn từ 0 đến 100
                'anhsanpham' => $faker->imageUrl(640, 480, 'products', true), // URL ảnh ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
