<?php

namespace App\Models\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosokhencao extends Model
{
    protected $table = 'dshosokhencao';
    protected $fillable = [
        'id',
        'mahosotdkt',
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
        //File đính kèm
        'totrinh', // Tờ trình
        'qdkt', // Quyết định
        'baocao', // Quyết định
        'bienban', //biên bản cuộc họp
        'tailieukhac', //tài liệu khác
        'quyetdinh',//đính kèm quyết định khen thưởng
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
        //Lưu quy trình xử lý
        'tendangnhap_xd',
        'tendangnhap_kt',
        'noidungxuly_xd',
        'noidungxuly_kt',
        //Xử lý hồ so theo TQ
        'trangthai_xl', //Trạng thái xử lý hồ sơ
        'tendangnhap_xl', //Tài khoản đang xử lý hồ sơ
    ];
}
