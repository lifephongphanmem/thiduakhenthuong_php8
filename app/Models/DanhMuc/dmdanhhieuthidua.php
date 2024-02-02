<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmdanhhieuthidua extends Model
{
    protected $table = 'dmdanhhieuthidua';
    protected $fillable = [
        'id',
        'stt',
        'madanhhieutd',
        'tendanhhieutd',
        'phanloai',
        'ghichu',
        'ttnguoitao',
        'phamviapdung',
        'muckhencanhan',
        'muckhentapthe',
    ];
}
