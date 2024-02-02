<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dsnhomtaikhoan_phanquyen extends Model
{
    protected $table = 'dsnhomtaikhoan_phanquyen';
    protected $fillable = [
        'id',
        'manhomchucnang',
        'machucnang',
        'phanquyen', //phân quyền chung để lọc
        'danhsach', //phân quyền; nếu 2 chức năng còn lại true => mặc định true
        'thaydoi',
        'hoanthanh',
        'ghichu',
    ];
}
