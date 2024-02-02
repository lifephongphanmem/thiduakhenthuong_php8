<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_dscumkhoi extends Model
{
    protected $table = 'view_dscumkhoi';
    protected $fillable = [        
    ];
}
// SELECT    dbo.dscumkhoi.macumkhoi, dbo.dscumkhoi.tencumkhoi, dbo.dscumkhoi.ngaythanhlap, dbo.dscumkhoi.capdo, dbo.dscumkhoi.madonviql, dbo.dscumkhoi_chitiet.madonvi, dbo.dscumkhoi.phamvi, 
//                       dbo.dscumkhoi_chitiet.phanloai, dbo.dsdonvi.tendonvi, dbo.dsdonvi.madiaban
// FROM         dbo.dscumkhoi INNER JOIN
//                       dbo.dscumkhoi_chitiet ON dbo.dscumkhoi.macumkhoi = dbo.dscumkhoi_chitiet.macumkhoi INNER JOIN
//                       dbo.dsdonvi ON dbo.dscumkhoi_chitiet.madonvi = dbo.dsdonvi.madonvi
// GO