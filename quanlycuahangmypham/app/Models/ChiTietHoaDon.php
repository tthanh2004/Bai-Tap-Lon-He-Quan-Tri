<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    protected $table = 'chitiethoadon';

    // Eloquent mặc định sử dụng 'id' làm khóa chính, nên không cần đặt lại nếu dùng 'id'

    public $incrementing = true; // 'id' là auto-incrementing
    protected $keyType = 'int';   // 'id' là integer

    protected $fillable = [
        'id',
        'idhoadon',
        'idsanpham',
        'soluongmua',
        'giamgia',
        'thanhtien',
        // Thêm các trường fillable khác nếu cần
    ];

    // Định nghĩa các mối quan hệ
    public function hoadon()
    {
        return $this->belongsTo(HoaDon::class, 'idhoadon', 'mahoadon');
    }

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsanpham', 'masanpham');
    }
}
