<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhapHang extends Model
{
    use HasFactory;

    protected $table = 'nhaphang';
    protected $primaryKey = 'manhaphang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'manhaphang',
        'idsanpham',
        'soluongnhap',
        'gianhap',
        'ngaynhap',
    ];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsanpham', 'masanpham');
    }
}
