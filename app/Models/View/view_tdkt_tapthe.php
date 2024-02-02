<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_tdkt_tapthe extends Model
{
    protected $table = 'view_tdkt_tapthe';
    protected $fillable = [        
    ];
}

// SELECT        dbo.dshosothiduakhenthuong.mahosotdkt, dbo.dshosothiduakhenthuong.noidung, dbo.dshosothiduakhenthuong.ngayhoso, dbo.dshosothiduakhenthuong.phanloai, dbo.dshosothiduakhenthuong.maloaihinhkt, 
//                          dbo.dshosothiduakhenthuong.maphongtraotd, dbo.dshosothiduakhenthuong.madonvi, dbo.dshosothiduakhenthuong.trangthai, dbo.dshosothiduakhenthuong.sototrinh, dbo.dshosothiduakhenthuong.chucvunguoiky, 
//                          dbo.dshosothiduakhenthuong.nguoikytotrinh, dbo.dshosothiduakhenthuong.soqd, dbo.dshosothiduakhenthuong.ngayqd, dbo.dshosothiduakhenthuong.donvikhenthuong, dbo.dshosothiduakhenthuong.capkhenthuong, 
//                          dbo.dshosothiduakhenthuong.chucvunguoikyqd, dbo.dshosothiduakhenthuong.hotennguoikyqd, dbo.dshosothiduakhenthuong_tapthe.maphanloaitapthe, dbo.dshosothiduakhenthuong_tapthe.tentapthe, 
//                          dbo.dshosothiduakhenthuong_tapthe.ketqua, dbo.dshosothiduakhenthuong_tapthe.madanhhieutd, dbo.dshosothiduakhenthuong_tapthe.mahinhthuckt, dbo.dshosothiduakhenthuong_tapthe.lydo, 
//                          dbo.dshosothiduakhenthuong_tapthe.noidungkhenthuong, dbo.dshosothiduakhenthuong_tapthe.madanhhieukhenthuong, dbo.dshosothiduakhenthuong_tapthe.linhvuchoatdong, dbo.dsdonvi.madiaban
// FROM            dbo.dshosothiduakhenthuong INNER JOIN
//                          dbo.dshosothiduakhenthuong_tapthe ON dbo.dshosothiduakhenthuong.mahosotdkt = dbo.dshosothiduakhenthuong_tapthe.mahosotdkt INNER JOIN
//                          dbo.dsdonvi ON dbo.dshosothiduakhenthuong.madonvi = dbo.dsdonvi.madonvi