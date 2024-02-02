<?php

namespace App\Models\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosodenghikhencao extends Model
{
    protected $table = 'dshosodenghikhencao';
    protected $fillable = [
        'id',
        'mahoso',
        'ngayhoso',
        'noidung',
        'maloaihinhkt',
        'maphongtraotd',
        'donvikhenthuong',
        'capkhenthuong',
        'chucvunguoiky',
        'hotennguoiky',
        'ghichu',
        'phanloai', //Cụm khối, phong trào
        
        //Trạng thái đơn vị
        'madonvi',
        'madonvi_nhan',
        'lydo',
        'thongtin', //chưa dùng
        'trangthai',
        'thoigian',

        'soqd',
        'ngayqd',
        'chucvunguoikyqd',
        'hotennguoikyqd',
        'thongtinquyetdinh',
        'sototrinh',
        'nguoikytotrinh',

        //Trạng thái xét duyệt
        'madonvi_xd',
        'madonvi_nhan_xd',
        'lydo_xd',
        'thongtin_xd',
        'trangthai_xd',
        'thoigian_xd',
        //Trạng thái khen thưởng
        'madonvi_kt',
        'madonvi_nhan_kt',
        'lydo_kt',
        'thongtin_kt',
        'trangthai_kt',
        'thoigian_kt',
    ];
}
