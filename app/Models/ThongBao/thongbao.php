<?php

namespace App\Models\ThongBao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thongbao extends Model
{
    use HasFactory;
    protected $table='thongbao';
    protected $fillable=[
        'mathongbao','noidung','url','chucnang','trangthai','mahs_mapt','phamvi','madonvi_thongbao','madonvi_nhan','phanloai','taikhoan_tn'
    ];
}
