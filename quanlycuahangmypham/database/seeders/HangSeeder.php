<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt

        for ($i = 0; $i < 10; $i++) {
            DB::table('hang')->insert([
                'mahang' => strtoupper(Str::random(6)), // Mã hãng ngẫu nhiên gồm 6 ký tự
                'tenhang' => $faker->company, // Tên hãng ngẫu nhiên
                'diachi' => $faker->address, // Địa chỉ ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
