<?php

namespace App\Models\KetNoi;

use Illuminate\Database\Eloquent\Model;

class thongtintruyennhan extends Model
{
    protected $table = 'thongtintruyennhan';
    protected $fillable = [
        'id',
        'phanmem', //Phần mềm truyền nhận
        'madonvi', //Mã đơn vị - TĐKT
        'madonvitn', //Mã đơn vị - kết nối
        'mahosotdkt', //Mã hồ sơ trên pm TĐKT
        'mahosotn', //Mã hồ sơ trên pm kết nối
        'thoigian',
        'thoihan',
        'canboketnoi', //Tên đăng nhập TĐKT
        'canbotiepnhan', //Tên đăng nhập truyền nhận
        'ykiengopy',
        'tenfileykiengopy',
        'fileykiengopy',
        'trangthai', //Trạng thái tiếp nhận
        'tenfiledulieu',
        'filedulieu',
        //Thông tin người nộp cho HCC
        'hoten',
        'diachi',
        'email',
        'sodienthoai',
        //
    ];
}
