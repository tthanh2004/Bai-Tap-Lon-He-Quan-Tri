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

        // Lấy tất cả mã khách hàng hiện có
        $khachhangIds = DB::table('khachhang')->pluck('makhachhang')->toArray();

        // Xáo trộn mảng để chọn ngẫu nhiên mà không trùng lặp
        shuffle($khachhangIds);

        // Giới hạn số lượng thẻ tích điểm không vượt quá số khách hàng
        $numberOfCards = min(10, count($khachhangIds));

        for ($i = 0; $i < $numberOfCards; $i++) {
            $makhachhang = $khachhangIds[$i];

            // Sử dụng updateOrCreate để tránh trùng lặp
            DB::table('thetichdiem')->updateOrInsert(
                ['idkhachhang' => $makhachhang],
                [
                    'mathetichdiem' => strtoupper(Str::random(6)), // Mã thẻ ngẫu nhiên gồm 6 ký tự
                    'diemtichluy' => $faker->numberBetween(0, 1000), // Điểm tích lũy từ 0 đến 1000
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
