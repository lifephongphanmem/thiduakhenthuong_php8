<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class view_dsphongtrao_cumkhoi extends Model
{
    protected $table = 'view_dsphongtrao_cumkhoi';
    protected $fillable = [        
    ];
}

// CREATE OR ALTER VIEW [dbo].[view_dsphongtrao_cumkhoi]
// AS
// SELECT        dbo.dsdonvi.tendonvi, dbo.dsdiaban.tendiaban, dbo.dsdiaban.madiaban, dbo.dsdiaban.capdo, dbo.dsphongtraothiduacumkhoi.maphongtraotd, dbo.dsphongtraothiduacumkhoi.macumkhoi, 
//                          dbo.dsphongtraothiduacumkhoi.maloaihinhkt, dbo.dsphongtraothiduacumkhoi.phanloai, dbo.dsphongtraothiduacumkhoi.soqd, dbo.dsphongtraothiduacumkhoi.ngayqd, dbo.dsphongtraothiduacumkhoi.noidung, 
//                          dbo.dsphongtraothiduacumkhoi.khauhieu, dbo.dsphongtraothiduacumkhoi.phamviapdung, dbo.dsphongtraothiduacumkhoi.tungay, dbo.dsphongtraothiduacumkhoi.denngay, dbo.dsphongtraothiduacumkhoi.ghichu, 
//                          dbo.dsphongtraothiduacumkhoi.totrinh, dbo.dsphongtraothiduacumkhoi.qdkt, dbo.dsphongtraothiduacumkhoi.bienban, dbo.dsphongtraothiduacumkhoi.tailieukhac, dbo.dsphongtraothiduacumkhoi.madonvi, 
//                          dbo.dsphongtraothiduacumkhoi.madonvi_nhan, dbo.dsphongtraothiduacumkhoi.lydo, dbo.dsphongtraothiduacumkhoi.thongtin, dbo.dsphongtraothiduacumkhoi.trangthai, dbo.dsphongtraothiduacumkhoi.thoigian, 
//                          dbo.dsphongtraothiduacumkhoi.madonvi_h, dbo.dsphongtraothiduacumkhoi.madonvi_nhan_h, dbo.dsphongtraothiduacumkhoi.lydo_h, dbo.dsphongtraothiduacumkhoi.thongtin_h, dbo.dsphongtraothiduacumkhoi.trangthai_h, 
//                          dbo.dsphongtraothiduacumkhoi.thoigian_h, dbo.dsphongtraothiduacumkhoi.madonvi_t, dbo.dsphongtraothiduacumkhoi.madonvi_nhan_t, dbo.dsphongtraothiduacumkhoi.lydo_t, dbo.dsphongtraothiduacumkhoi.thongtin_t, 
//                          dbo.dsphongtraothiduacumkhoi.trangthai_t, dbo.dsphongtraothiduacumkhoi.thoigian_t, dbo.dsphongtraothiduacumkhoi.madonvi_tw, dbo.dsphongtraothiduacumkhoi.madonvi_nhan_tw, dbo.dsphongtraothiduacumkhoi.lydo_tw, 
//                          dbo.dsphongtraothiduacumkhoi.thongtin_tw, dbo.dsphongtraothiduacumkhoi.trangthai_tw, dbo.dsphongtraothiduacumkhoi.thoigian_tw, dbo.dsphongtraothiduacumkhoi.thoihanthidua, dbo.dsphongtraothiduacumkhoi.phuongthuctochuc
// FROM            dbo.dsdonvi INNER JOIN
//                          dbo.dsdiaban ON dbo.dsdonvi.madiaban = dbo.dsdiaban.madiaban INNER JOIN
//                          dbo.dsphongtraothiduacumkhoi ON dbo.dsdonvi.madonvi = dbo.dsphongtraothiduacumkhoi.madonvi