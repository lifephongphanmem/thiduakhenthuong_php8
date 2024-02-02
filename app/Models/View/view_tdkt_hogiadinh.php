<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_tdkt_hogiadinh extends Model
{
    protected $table = 'view_tdkt_hogiadinh';
    protected $fillable = [        
    ];
}

// SELECT        dbo.dshosothiduakhenthuong.mahosotdkt, dbo.dshosothiduakhenthuong.ngayhoso, dbo.dshosothiduakhenthuong.noidung, dbo.dshosothiduakhenthuong.maloaihinhkt, dbo.dshosothiduakhenthuong.phanloai, 
//                          dbo.dshosothiduakhenthuong.maphongtraotd, dbo.dshosothiduakhenthuong.madonvi, dbo.dshosothiduakhenthuong.baocao, dbo.dshosothiduakhenthuong.bienban, dbo.dshosothiduakhenthuong.tailieukhac, 
//                          dbo.dshosothiduakhenthuong.soqd, dbo.dshosothiduakhenthuong.ngayqd, dbo.dshosothiduakhenthuong.donvikhenthuong, dbo.dshosothiduakhenthuong.capkhenthuong, 
//                          dbo.dshosothiduakhenthuong_hogiadinh.linhvuchoatdong, dbo.dshosothiduakhenthuong_hogiadinh.maphanloaitapthe, dbo.dshosothiduakhenthuong_hogiadinh.tentapthe, dbo.dshosothiduakhenthuong_hogiadinh.ketqua, 
//                          dbo.dshosothiduakhenthuong_hogiadinh.madanhhieukhenthuong, dbo.dshosothiduakhenthuong_hogiadinh.noidungkhenthuong, dbo.dsdonvi.madiaban
// FROM            dbo.dshosothiduakhenthuong INNER JOIN
//                          dbo.dshosothiduakhenthuong_hogiadinh ON dbo.dshosothiduakhenthuong.mahosotdkt = dbo.dshosothiduakhenthuong_hogiadinh.mahosotdkt INNER JOIN
//                          dbo.dsdonvi ON dbo.dshosothiduakhenthuong.madonvi = dbo.dsdonvi.madonvi