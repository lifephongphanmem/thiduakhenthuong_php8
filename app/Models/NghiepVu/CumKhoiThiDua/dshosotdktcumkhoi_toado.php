<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi_toado extends Model
{
    protected $table = 'dshosotdktcumkhoi_toado';
    protected $fillable = [
        'id',
        'pldoituong', //CANHAN; TAPTHE; HOGIADINH
        'plkhenthuong', //BANGKHEN; GIAYKHEN
        'id_doituong',
        'toado_tendoituongin',
        'toado_noidungkhenthuong',
        'toado_quyetdinh',
        'toado_ngayqd',
        'toado_chucvunguoikyqd',
        'toado_hotennguoikyqd',
        'toado_donvikhenthuong',
        'toado_sokhenthuong',
        'toado_chucvudoituong',
        'toado_pldoituong',
    ];
}
