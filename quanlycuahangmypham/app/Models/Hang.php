<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SanPham;

class Hang extends Model
{
    use HasFactory;

    protected $table = 'hang';
    protected $primaryKey = 'mahang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mahang',
        'tenhang',
        'diachi',
    ];

    public function sanphams()
    {
        return $this->hasMany(SanPham::class, 'idhang', 'mahang');
    }
}
