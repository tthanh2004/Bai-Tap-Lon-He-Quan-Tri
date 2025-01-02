<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NhanvienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt

        $gioitinhOptions = ['Nam', 'Nữ', 'Khác'];

        for ($i = 0; $i < 10; $i++) {
            DB::table('nhanvien')->insert([
                'manhanvien'   => strtoupper(Str::random(6)), // Tạo mã nhân viên ngẫu nhiên, ví dụ: 6 ký tự
                'hoten'        => $faker->name,
                'gioitinh'     => $faker->randomElement($gioitinhOptions),
                'ngaysinh'     => $faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d H:i:s'),
                'diachi'       => $faker->address,
                'sodienthoai'  => $faker->unique()->phoneNumber,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
