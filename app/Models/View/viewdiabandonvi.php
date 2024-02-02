<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class viewdiabandonvi extends Model
{
    protected $table = 'viewdiabandonvi';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[viewdiabandonvi]
// AS
// SELECT    dbo.dsdiaban.tendiaban, dbo.dsdiaban.capdo, dbo.dsdiaban.madiaban, dbo.dsdiaban.madonviQL, dbo.dsdiaban.madiabanQL, dbo.dsdonvi.madonvi, dbo.dsdonvi.tendonvi, dbo.dsdonvi.tendvhienthi, 
//                       dbo.dsdonvi.tendvcqhienthi, dbo.dsdonvi.linhvuchoatdong, dbo.dsdiaban.madonviKT, dbo.dsdonvi.lanhdao, dbo.dsdonvi.cdlanhdao
// FROM         dbo.dsdonvi INNER JOIN
//                       dbo.dsdiaban ON dbo.dsdonvi.madiaban = dbo.dsdiaban.madiaban