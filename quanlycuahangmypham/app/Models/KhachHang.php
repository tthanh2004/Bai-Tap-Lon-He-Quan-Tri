<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;

    protected $table = 'khachhang';
    protected $primaryKey = 'makhachhang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'makhachhang',
        'hotenkh',
        'diachi',
        'sodienthoai',
    ];

    public function theTichDiems()
    {
        return $this->hasOne(Thetichdiem::class, 'idkhachhang', 'makhachhang');
    }

    public function hoadons()
    {
        return $this->hasMany(HoaDon::class, 'idkhachhang', 'makhachhang');
    }
}
