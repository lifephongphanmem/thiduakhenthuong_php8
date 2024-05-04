<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi extends Model
{
    protected $table = 'dshosotdktcumkhoi';
    protected $fillable = [
        'id',
        'mahosotdkt',
        'ngayhoso',
        'noidung',
        'phanloai', //hồ sơ thi đua; hồ sơ khen thưởng (để sau thống kê)
        'maloaihinhkt', //lấy từ phong trào nếu là hồ sơ thi đua
        'maphongtraotd', //tùy theo phân loại
        'macumkhoi',
        'ghichu',
        'sototrinh',
        'nguoikytotrinh',
        'chucvunguoiky',
        //File đính kèm
        'totrinh', //tờ trình khen thưởng
        'baocao', //báo cáo thành tích
        'bienban', //biên bản cuộc họp
        'tailieukhac', //tài liệu khác
        //Kết quả khen thưởng
        'mahosokt',
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
        //mới thêm ngày 20.09.22
        'soqd',
        'ngayqd',
        'donvikhenthuong',
        'capkhenthuong',
        'chucvunguoikyqd',
        'hotennguoikyqd',
        'thongtinquyetdinh',
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
        //091122
        'thongtintotrinhhoso',
        'thongtintotrinhdenghi',
        'noidungtotrinhdenghi',
        'sototrinhdenghi',
        'ngaythangtotrinhdenghi',
        'nguoikytotrinhdenghi',
        'chucvutotrinhdenghi',
        'totrinhdenghi',
        'quyetdinh',
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
