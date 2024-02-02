<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi_detai extends Model
{
    protected $table = 'dshosotdktcumkhoi_detai';
    protected $fillable = [
        'stt',
        'mahosotdkt',
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
        'madonvi', //phục vụ lấy dữ liệu
    ];
}
