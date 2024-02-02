<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosothamgiathiduacumkhoi_canhan extends Model
{
    protected $table = 'dshosothamgiathiduacumkhoi_canhan';
    protected $fillable = [
        'id',
        'mahoso',
        //Thông tin cá nhân
        'maccvc',
        'socancuoc',
        'tendoituong',
        'ngaysinh',
        'gioitinh',
        'chucvu',
        'diachi',
        'tencoquan',
        'tenphongban',
        'maphanloaicanbo', //phân loại cán bộ
        //Kết quả đánh giá
        'madanhhieukhenthuong', //gộp danh hiệu & khen thưởng
        'madonvi', //phục vụ lấy dữ liệu
    ];
}
