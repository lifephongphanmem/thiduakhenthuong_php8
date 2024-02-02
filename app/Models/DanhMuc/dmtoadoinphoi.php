<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmtoadoinphoi extends Model
{
    protected $table = 'dmtoadoinphoi';
    protected $fillable = [
        'id',
        'phanloaikhenthuong', //Cụm khối; Khen thưởng
        'phanloaidoituong', //Cá nhân, tập thể, hộ gia đình
        'phanloaiphoi', //Cá nhân, tập thể, hộ gia đình
        'madonvi',
        'maloaihinhkt',
        'toado_tendoituongin',
        'toado_noidungkhenthuong',
        'toado_quyetdinh',
        'toado_ngayqd',
        'toado_chucvunguoikyqd',
        'toado_hotennguoikyqd',
        'toado_donvikhenthuong',
        'toado_sokhenthuong',
        'toado_pldoituong',
        'toado_chucvudoituong',
    ];
}
