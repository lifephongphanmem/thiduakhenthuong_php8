<?php

namespace App\Models\NghiepVu\KhenThuongKhangChien;

use Illuminate\Database\Eloquent\Model;

class dshosochongphap_canhan extends Model
{
    protected $table = 'dshosochongphap_canhan';
    protected $fillable = [
        'id',
        'mahosokt',
        'maloaihinhkt',
        'mahinhthuckt',
        'soqd',
        'noitrinhkt',
        'sodd',
        'ngaysinh',
        'chinhquan',
        'noio',
        'chucvu',
        'loaihosokc',
        'tgiantgkc',
        'tgiankcqd',
        'ngayhoso',
        'noidung',
        'tendoituong',
        'ghichu',
        //File đính kèm
        'tailieukhac', //tài liệu khác
        //Trạng thái đơn vị
        'madonvi',
        'madonvi_nhan',
        'lydo',
        'thongtin', //chưa dùng
        'trangthai',
        'thoigian',
        //Trạng thái huyện
        'madonvi_h',
        'madonvi_nhan_h',
        'lydo_h',
        'thongtin_h', //chưa dùng
        'trangthai_h',
        'thoigian_h',
        //Trạng thái tỉnh
        'madonvi_t',
        'madonvi_nhan_t',
        'lydo_t',
        'thongtin_t', //chưa dùng
        'trangthai_t',
        'thoigian_t',
        //Trạng thái trung ương
        'madonvi_tw',
        'madonvi_nhan_tw',
        'lydo_tw',
        'thongtin_tw', //chưa dùng
        'trangthai_tw',
        'thoigian_tw',
        //Thông tin khen thưởng
        'donvikhenthuong',
        'capkhenthuong',
        'chucvunguoikyqd',
        'hotennguoikyqd',
        'ngayqd',
    ];
}
