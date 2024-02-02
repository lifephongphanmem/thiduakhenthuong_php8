<?php

namespace App\Models\NghiepVu\DangKyDanhHieu;

use Illuminate\Database\Eloquent\Model;

class dshosodangkyphongtraothidua_hogiadinh extends Model
{
    protected $table = 'dshosodangkyphongtraothidua_hogiadinh';
    protected $fillable = [
        'id',
        'stt',
        'mahosodk',
        'linhvuchoatdong',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình                   
        'tentapthe',
        'ghichu',
        'madanhhieutd',//bỏ
        'mahinhthuckt',//bỏ
        'madanhhieukhenthuong',//gộp danh hiệu & khen thưởng
        'madonvi',
    ];
}
