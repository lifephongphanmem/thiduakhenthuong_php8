<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dsphongtraothiduacumkhoi extends Model
{
    protected $table = 'dsphongtraothiduacumkhoi';
    protected $fillable = [
        'id',
        'maphongtraotd',
        'macumkhoi',
        'maloaihinhkt',
        'phanloai',
        'dotxetkhenthuong',
        'soqd', // Số quyết định
        'ngayqd', // Ngày quyết định
        'noidung',
        'khauhieu',
        'phamviapdung',
        'thoihanthidua',
        'phuongthuctochuc',
        'tungay', // Ngày bắt đầu nhận hồ sơ
        'denngay', // Ngày kết thúc nhận hồ sơ
        'ghichu',
        //tài liệu đính kèm
        'totrinh', // Tờ trình
        'qdkt', // Quyết định
        'bienban', // Biên bản           
        'tailieukhac', // Tài liệu khác
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
       
    ];
}
