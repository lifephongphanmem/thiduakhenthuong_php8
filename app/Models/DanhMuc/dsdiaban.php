<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dsdiaban extends Model
{
    protected $table = 'dsdiaban';
    protected $fillable = [
        'id',
        'madiaban',
        'tendiaban',
        'capdo',
        'madonviQL',//Đơn vị phê duyệt khen thưởng
        'madonviKT',//Đơn vị xét duyệt hồ sơ
        'madiabanQL',
        'ghichu',
    ];
}
