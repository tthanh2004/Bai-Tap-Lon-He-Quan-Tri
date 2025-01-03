<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ChitiethoadonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN'); // Sử dụng locale tiếng Việt

        // Lấy tất cả các ID hóa đơn và mã sản phẩm hiện có
        $hoadonIds = DB::table('hoadon')->pluck('mahoadon')->toArray();
        $sanphamIds = DB::table('sanpham')->pluck('masanpham')->toArray();

        // Tạo một tập hợp để lưu trữ các cặp đã sử dụng
        $usedPairs = [];

        for ($i = 0; $i < 10; $i++) {
            // Chọn ngẫu nhiên một hóa đơn và một sản phẩm
            $idhoadon = $faker->randomElement($hoadonIds);
            $idsanpham = $faker->randomElement($sanphamIds);

            // Kiểm tra xem cặp đã được sử dụng chưa
            if (in_array("$idhoadon-$idsanpham", $usedPairs)) {
                $i--;
                continue;
            }

            // Thêm cặp vào danh sách đã sử dụng
            $usedPairs[] = "$idhoadon-$idsanpham";

            // Tính toán giá trị các trường khác
            $soluongmua = $faker->numberBetween(1, 20);
            $dongia = DB::table('sanpham')->where('masanpham', $idsanpham)->value('dongia');
            $giamgia = $faker->randomFloat(2, 0, 50); // Giảm giá từ 0% đến 50%
            $thanhtien = ($dongia * $soluongmua) * ((100 - $giamgia) / 100);

            // Chèn dữ liệu vào bảng
            DB::table('chitiethoadon')->insert([
                'idhoadon'    => $idhoadon,
                'idsanpham'   => $idsanpham,
                'soluongmua'  => $soluongmua,
                'giamgia'     => $giamgia,
                'thanhtien'   => $thanhtien,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
