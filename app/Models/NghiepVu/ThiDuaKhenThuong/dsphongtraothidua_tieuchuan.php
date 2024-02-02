<?php

namespace App\Models\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dsphongtraothidua_tieuchuan extends Model
{
    protected $table = 'dsphongtraothidua_tieuchuan';
    protected $fillable = [
        'id',
        'stt',
        'maphongtraotd', // ký hiệu
        'madanhhieutd',//bỏ
        'matieuchuandhtd',//bỏ
        'phanloaidoituong',//Áp dụng cho cá nhân, tập thể
        'tentieuchuandhtd',
        'cancu',
        'ghichu',
        'batbuoc',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
    ];
}
