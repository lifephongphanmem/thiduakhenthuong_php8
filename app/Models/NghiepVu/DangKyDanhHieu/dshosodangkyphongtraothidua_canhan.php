<?php

namespace App\Models\NghiepVu\DangKyDanhHieu;

use Illuminate\Database\Eloquent\Model;

class dshosodangkyphongtraothidua_canhan extends Model
{
    protected $table = 'dshosodangkyphongtraothidua_canhan';
    protected $fillable = [
        'id',
        'stt',
        'mahosodk',
        'maccvc',
        'socancuoc',
        'tendoituong',
        'ngaysinh',
        'gioitinh',
        'chucvu',
        'diachi',
        'tencoquan',
        'tenphongban',
        'maphanloaicanbo',
        'madanhhieutd',//bỏ
        'mahinhthuckt',//bỏ
        'madanhhieukhenthuong',//gộp danh hiệu & khen thưởng
    ];
}
