<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KhachhangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt

        for ($i = 0; $i < 10; $i++) {
            DB::table('khachhang')->insert([
                'makhachhang' => strtoupper(Str::random(6)), // Tạo mã khách hàng ngẫu nhiên, ví dụ: 6 ký tự
                'hotenkh'      => $faker->name,
                'diachi'       => $faker->address,
                'sodienthoai'  => $faker->unique()->phoneNumber,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
