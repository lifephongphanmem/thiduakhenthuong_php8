<?php

namespace App\Models\VanBan;

use Illuminate\Database\Eloquent\Model;

class dsquyetdinhkhenthuong extends Model
{
    protected $table = 'dsquyetdinhkhenthuong';
    protected $fillable = [
        'id',
        'maquyetdinh',
        'soqd',
        'ngayqd',
        'maloaihinhkt',
        'donvikhenthuong',
        'capkhenthuong',
        'chucvunguoiky',
        'hotennguoiky',
        'tieude',
        'ghichu',
        'phanloai',
        'trangthai',
        'madonvi',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
    ];
}
