<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheTichDiem extends Model
{
    use HasFactory;

    protected $table = 'thetichdiem';
    protected $primaryKey = 'mathetichdiem';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mathetichdiem',
        'diemtichluy',
        'idkhachhang',
    ];

    public function khachhang()
    {
        return $this->belongsTo(KhachHang::class, 'idkhachhang', 'makhachhang');
    }
}
