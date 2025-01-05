<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    protected $table = 'sanpham';
    protected $primaryKey = 'masanpham';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'masanpham',
        'idhang',
        'tensanpham',
        'donvitinh',
        'dongia',
        'soluongton',
        'anhsanpham',
    ];

    // Quan hệ với Hang
    public function hang()
    {
        return $this->belongsTo(Hang::class, 'idhang', 'mahang');
    }

    // Accessor để lấy URL hình ảnh sản phẩm
    public function getAnhsanphamUrlAttribute()
    {
        return $this->anhsanpham && $this->anhsanpham !== 'default.jpg'
            ? asset('uploads/sanpham/' . $this->anhsanpham)
            : asset('uploads/sanpham/default.jpg');
    }
}
