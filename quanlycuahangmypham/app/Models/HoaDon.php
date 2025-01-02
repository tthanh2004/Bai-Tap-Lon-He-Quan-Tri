<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'hoadon';
    protected $primaryKey = 'mahoadon';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mahoadon',
        'idkhachhang',
        'idnhanvien',
        'ngaylaphoadon',
        'sudungTTD',
        'tongtien',
    ];

    public function khachhang()
    {
        return $this->belongsTo(KhachHang::class, 'idkhachhang', 'makhachhang');
    }

    public function nhanvien()
    {
        return $this->belongsTo(NhanVien::class, 'idnhanvien', 'manhanvien');
    }

    public function chitiethoadons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'idhoadon', 'mahoadon');
    }
}
