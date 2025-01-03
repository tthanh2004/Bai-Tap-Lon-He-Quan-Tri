<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HoaDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('vi_VN'); // Sử dụng ngôn ngữ tiếng Việt

        $nhanvienIds = DB::table('nhanvien')->pluck('manhanvien')->toArray();
        $khachhangIds = DB::table('khachhang')->pluck('makhachhang')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('hoadon')->insert([
                'mahoadon' => strtoupper(Str::random(6)), // Mã hóa đơn ngẫu nhiên gồm 6 ký tự
                'idkhachhang' => $faker->randomElement($khachhangIds), // Mã khách hàng ngẫu nhiên, phải tồn tại trong bảng khachhang
                'idnhanvien' => $faker->randomElement($nhanvienIds), // Mã nhân viên ngẫu nhiên, phải tồn tại trong bảng nhanvien
                'ngaylaphoadon' => $faker->dateTimeBetween('-1 years', 'now'), // Ngày lập hóa đơn trong vòng 1 năm qua
                'sudungTTD' => $faker->boolean, // Sử dụng thẻ tích điểm ngẫu nhiên (true/false)
                'tongtien' => $faker->randomFloat(2, 50000, 5000000), // Tổng tiền từ 50,000 đến 5,000,000
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
