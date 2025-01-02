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

    public function hang()
    {
        return $this->belongsTo(Hang::class, 'idhang', 'mahang');
    }
}
