<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_khencao_tapthe extends Model
{
    protected $table = 'view_khencao_tapthe';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_khencao_tapthe]
// AS
// SELECT        dbo.dshosokhencao.ngayhoso, dbo.dshosokhencao.maloaihinhkt, dbo.dshosokhencao.capkhenthuong, dbo.dsdonvi.madiaban, dbo.dsdonvi.madonvi, dbo.dshosokhencao.mahosotdkt, 
//                          dbo.dshosokhencao_tapthe.maphanloaitapthe, dbo.dshosokhencao_tapthe.tentapthe, dbo.dshosokhencao_tapthe.ketqua, dbo.dshosokhencao_tapthe.madanhhieukhenthuong, dbo.dshosokhencao_tapthe.linhvuchoatdong, 
//                          dbo.dshosokhencao_tapthe.tencoquan
// FROM            dbo.dshosokhencao INNER JOIN
//                          dbo.dsdonvi ON dbo.dshosokhencao.madonvi = dbo.dsdonvi.madonvi INNER JOIN
//                          dbo.dshosokhencao_tapthe ON dbo.dshosokhencao.mahosotdkt = dbo.dshosokhencao_tapthe.mahosotdkt