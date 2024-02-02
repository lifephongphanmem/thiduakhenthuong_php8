<?php

namespace App\Models\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosokhencao_detai extends Model
{
    //chưa dùng
    protected $table = 'dshosokhencao_detai';
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
        //Đề tài, sáng kiến
        'tensangkien', //tên đề tài, sáng kiến
        'donvicongnhan',
        'thoigiancongnhan',
        'thanhtichdatduoc',
        'filedk',
        'madonvi', //phục vụ lấy dữ liệu
    ];
}
