<?php

namespace App\Models\ThongBao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taikhoan_nhanthongbao extends Model
{
    use HasFactory;
    protected $table='taikhoan_nhanthongbao';
    protected $fillable=['mathongbao','tendangnhap'];
}
