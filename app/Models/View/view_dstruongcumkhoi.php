<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_dstruongcumkhoi extends Model
{
    protected $table = 'view_dstruongcumkhoi';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_dstruongcumkhoi]
// AS
// SELECT    dbo.dstruongcumkhoi_chitiet.macumkhoi, dbo.dstruongcumkhoi_chitiet.madonvi, dbo.dstruongcumkhoi.ngaytu, dbo.dstruongcumkhoi.ngayden, dbo.dscumkhoi.tencumkhoi, dbo.dsdonvi.tendonvi, 
//                       YEAR(dbo.dstruongcumkhoi.ngayden) AS nam, dbo.dsdonvi.madiaban
// FROM         dbo.dstruongcumkhoi INNER JOIN
//                       dbo.dstruongcumkhoi_chitiet ON dbo.dstruongcumkhoi.madanhsach = dbo.dstruongcumkhoi_chitiet.madanhsach INNER JOIN
//                       dbo.dscumkhoi ON dbo.dstruongcumkhoi_chitiet.macumkhoi = dbo.dscumkhoi.macumkhoi INNER JOIN
//                       dbo.dsdonvi ON dbo.dstruongcumkhoi_chitiet.madonvi = dbo.dsdonvi.madonvi
