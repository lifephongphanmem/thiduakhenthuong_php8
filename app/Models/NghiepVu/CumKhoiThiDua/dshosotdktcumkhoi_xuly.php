<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi_xuly extends Model
{
    protected $table = 'dshosotdktcumkhoi_xuly';
    protected $fillable = [
        'id',
        'mahosotdkt',
        'trangthai_xl',
        'tendangnhap_xl', //Thông tin tài khoản xử lý hồ sơ
        'tendangnhap_tn', //Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
        'noidung_xl',
        'ngaythang_xl',
        'ghichu',
    ];
}
