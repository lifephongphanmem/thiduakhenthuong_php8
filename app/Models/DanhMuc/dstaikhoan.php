<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dstaikhoan extends Model
{
    protected $table = 'dstaikhoan';
    protected $fillable = [
        'id',
        'tentaikhoan',
        'tendangnhap',
        'matkhau',
        'madonvi',
        'email',
        'sodienthoai',
        'trangthai',
        'sadmin',
        'ttnguoitao',
        'lydo',
        'solandn',
        'manhomchucnang',
        'nhaplieu',
        'tonghop',
        'hethong',
        'chucnangkhac',
        'dstaikhoan',
        'phanloai',
        'taikhoantiepnhan', //Danh sách tài khoản: tk1;tk2;tk3;...
        'ngaysinh',
        'trinhdodaotao',
        'ngaycongtac', //Thời gian làm công tác để tính thâm niên
        'gioitinh', //0: Nam; 1: Nữ
        'timeaction',
        'islogout',
        'sessionID'
    ];
}
