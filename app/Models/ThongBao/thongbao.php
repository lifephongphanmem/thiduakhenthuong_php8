<?php

namespace App\Models\ThongBao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thongbao extends Model
{
    use HasFactory;
    protected $table='thongbao';
    protected $fillable=[
        'mathongbao','noidung','url','table','trangthai','maphongtrao','phamvi','madonvi_thongbao'
    ];
}
