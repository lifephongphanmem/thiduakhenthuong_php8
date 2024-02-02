<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_tdkt_canhan extends Model
{
    protected $table = 'view_tdkt_canhan';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_tdkt_canhan]
// AS
// SELECT        dbo.dshosothiduakhenthuong.mahosotdkt, dbo.dshosothiduakhenthuong.noidung, dbo.dshosothiduakhenthuong.phanloai, dbo.dshosothiduakhenthuong.maloaihinhkt, dbo.dshosothiduakhenthuong.maphongtraotd, 
//                          dbo.dshosothiduakhenthuong.madonvi, dbo.dshosothiduakhenthuong.sototrinh, dbo.dshosothiduakhenthuong.chucvunguoiky, dbo.dshosothiduakhenthuong.nguoikytotrinh, dbo.dshosothiduakhenthuong.soqd, 
//                          dbo.dshosothiduakhenthuong.ngayqd, dbo.dshosothiduakhenthuong.donvikhenthuong, dbo.dshosothiduakhenthuong.capkhenthuong, dbo.dshosothiduakhenthuong.hotennguoikyqd, 
//                          dbo.dshosothiduakhenthuong.chucvunguoikyqd, dbo.dshosothiduakhenthuong_canhan.maccvc, dbo.dshosothiduakhenthuong_canhan.socancuoc, dbo.dshosothiduakhenthuong_canhan.tendoituong, 
//                          dbo.dshosothiduakhenthuong_canhan.ngaysinh, dbo.dshosothiduakhenthuong_canhan.gioitinh, dbo.dshosothiduakhenthuong_canhan.chucvu, dbo.dshosothiduakhenthuong_canhan.diachi, 
//                          dbo.dshosothiduakhenthuong_canhan.tencoquan, dbo.dshosothiduakhenthuong_canhan.tenphongban, dbo.dshosothiduakhenthuong_canhan.maphanloaicanbo, dbo.dshosothiduakhenthuong_canhan.ketqua, 
//                          dbo.dshosothiduakhenthuong_canhan.mahinhthuckt, dbo.dshosothiduakhenthuong_canhan.madanhhieutd, dbo.dshosothiduakhenthuong_canhan.noidungkhenthuong, dbo.dshosothiduakhenthuong.ngayhoso, 
//                          dbo.dshosothiduakhenthuong.trangthai, dbo.dshosothiduakhenthuong_canhan.madanhhieukhenthuong, dbo.dsdonvi.madiaban
// FROM            dbo.dshosothiduakhenthuong INNER JOIN
//                          dbo.dshosothiduakhenthuong_canhan ON dbo.dshosothiduakhenthuong.mahosotdkt = dbo.dshosothiduakhenthuong_canhan.mahosotdkt INNER JOIN
//                          dbo.dsdonvi ON dbo.dshosothiduakhenthuong.madonvi = dbo.dsdonvi.madonvi