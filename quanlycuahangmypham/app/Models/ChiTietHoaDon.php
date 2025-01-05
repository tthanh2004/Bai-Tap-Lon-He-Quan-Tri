<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    use HasFactory;

    protected $table = 'chitiethoadon';
    public $incrementing = false;

    protected $fillable = [
        'idhoadon',
        'idsanpham',
        'soluongmua',
        'giamgia',
        'thanhtien',
    ];

    // Quan hệ với Hoadon
    public function hoadon()
    {
        return $this->belongsTo(Hoadon::class, 'idhoadon', 'mahoadon');
    }

    // Quan hệ với SanPham
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsanpham', 'masanpham');
    }
}
