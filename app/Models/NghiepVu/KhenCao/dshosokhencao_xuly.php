<?php

namespace App\Models\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosokhencao_xuly extends Model
{
    protected $table = 'dshosokhencao_xuly';
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
