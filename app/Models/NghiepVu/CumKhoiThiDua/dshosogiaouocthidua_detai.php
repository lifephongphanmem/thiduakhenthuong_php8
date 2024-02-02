<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosogiaouocthidua_detai extends Model
{
    protected $table = 'dshosogiaouocthidua_detai';
    protected $fillable = [
        'id',
        'stt',
        'mahosodk',
        //Thông tin tác giả
        'maccvc',
        'socancuoc',
        'tendoituong',
        'ngaysinh',
        'gioitinh',
        'tencoquan',
        'tenphongban',
        //Đề tài, sáng kiến
        'tensangkien', //tên đề tài, sáng kiến
        'donvicongnhan',
        'thoigiancongnhan',
        'thanhtichdatduoc',
        'filedk',
        'madonvi',
    ];
}
