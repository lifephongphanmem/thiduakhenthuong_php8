<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_khencao_hogiadinh extends Model
{
    protected $table = 'view_khencao_hogiadinh';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_khencao_hogiadinh]
// AS
// SELECT        dbo.dshosokhencao.ngayhoso, dbo.dshosokhencao.maloaihinhkt, dbo.dshosokhencao.capkhenthuong, dbo.dsdonvi.madiaban, dbo.dsdonvi.madonvi, dbo.dshosokhencao.mahosotdkt, 
//                          dbo.dshosokhencao_hogiadinh.linhvuchoatdong, dbo.dshosokhencao_hogiadinh.maphanloaitapthe, dbo.dshosokhencao_hogiadinh.tentapthe, dbo.dshosokhencao_hogiadinh.madanhhieukhenthuong, 
//                          dbo.dshosokhencao_hogiadinh.ketqua
// FROM            dbo.dshosokhencao INNER JOIN
//                          dbo.dsdonvi ON dbo.dshosokhencao.madonvi = dbo.dsdonvi.madonvi INNER JOIN
//                          dbo.dshosokhencao_hogiadinh ON dbo.dshosokhencao.mahosotdkt = dbo.dshosokhencao_hogiadinh.mahosotdkt