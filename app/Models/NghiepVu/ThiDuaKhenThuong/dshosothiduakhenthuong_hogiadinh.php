<?php

namespace App\Models\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong_hogiadinh extends Model
{
    protected $table = 'dshosothiduakhenthuong_hogiadinh';
    protected $fillable = [
        'id',
        'stt',
        'mahosotdkt',
        'linhvuchoatdong',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình          
        //Thông tin tập thể            
        'tentapthe',
        'ghichu', //
        //Kết quả đánh giá
        'ketqua',
        'madanhhieutd', //bỏ
        'mahinhthuckt', //bỏ
        'madanhhieukhenthuong', //gộp danh hiệu & khen thưởng
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
