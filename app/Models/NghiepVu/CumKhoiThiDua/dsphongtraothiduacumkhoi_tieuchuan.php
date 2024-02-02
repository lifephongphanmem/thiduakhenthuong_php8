<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dsphongtraothiduacumkhoi_tieuchuan extends Model
{
    protected $table = 'dsphongtraothiduacumkhoi_tieuchuan';
    protected $fillable = [
        'id',
        'stt',
        'maphongtraotd', // ký hiệu
        'madanhhieutd',
        'matieuchuandhtd',
        'tentieuchuandhtd',
        'phanloaidoituong',
        'cancu',
        'ghichu',
        'batbuoc',

    ];
}
