<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi_hogiadinh extends Model
{
    protected $table = 'dshosotdktcumkhoi_hogiadinh';
    protected $fillable = [
        'id',
        'mahosotdkt',
        'stt',
        'linhvuchoatdong',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
        //Thông tin tập thể            
        'tentapthe',
        'ghichu', //
        //Kết quả đánh giá
        'ketqua',
        'madanhhieutd',//bỏ
        'mahinhthuckt',//bỏ
        'madanhhieukhenthuong',//gộp danh hiệu & khen thưởng
        'lydo',
        'noidungkhenthuong', //in trên phôi bằng khen
        'madonvi', //phục vụ lấy dữ liệu
        //in phôi
        'toado_tendoituongin',
        'toado_noidungkhenthuong',
        'toado_quyetdinh',
        'toado_ngayqd',
        'toado_chucvunguoikyqd',
        'toado_hotennguoikyqd',
        'toado_donvikhenthuong',
        'toado_sokhenthuong',
        'tendoituongin',
        'quyetdinh',
        'ngayqd',
        'chucvunguoikyqd',
        'hotennguoikyqd',
        'donvikhenthuong',
        'sokhenthuong',
        'toado_chucvudoituong',
        'chucvudoituong',
        'toado_pldoituong',
        'pldoituong',
        //Thêm các trường số qd khen thưởng do 1 hồ sơ khen thưởng có thể có nhiều qd khen thưởng, nhiều tờ trình khen thưởng
        'soqdkhenthuong',
        'ngayqdkhenthuong',
        'sototrinhkhenthuong',
        'ngaytrinhkhenthuong',
    ];
}
