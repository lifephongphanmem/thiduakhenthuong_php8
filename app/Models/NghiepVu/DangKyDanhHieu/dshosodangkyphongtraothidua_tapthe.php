<?php

namespace App\Models\NghiepVu\DangKyDanhHieu;

use Illuminate\Database\Eloquent\Model;

class dshosodangkyphongtraothidua_tapthe extends Model
{
    protected $table = 'dshosodangkyphongtraothidua_tapthe';
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
