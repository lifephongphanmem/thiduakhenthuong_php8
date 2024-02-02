<?php

namespace App\Models\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong_detai extends Model
{
    protected $table = 'dshosothiduakhenthuong_detai';
    protected $fillable = [
        'id',
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
        'tenchucvu',
        //Đề tài, sáng kiến
        'tensangkien', //tên đề tài, sáng kiến
        'donvicongnhan',
        'thoigiancongnhan',
        'thanhtichdatduoc',
        'filedk',
        'madonvi', //phục vụ lấy dữ liệu
    ];
}
