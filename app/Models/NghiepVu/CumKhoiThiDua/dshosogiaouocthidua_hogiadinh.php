<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosogiaouocthidua_hogiadinh extends Model
{
    protected $table = 'dshosogiaouocthidua_hogiadinh';
    protected $fillable = [
        'id',
        'stt',
        'mahosodk',
        'linhvuchoatdong',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
        //Thông tin tập thể            
        'tentapthe',
        'ghichu',           
        'madanhhieutd',//bỏ
        'mahinhthuckt',//bỏ
        'madanhhieukhenthuong',//gộp danh hiệu & khen thưởng
        'madonvi',
    ];
}
