<?php

namespace App\Models\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothamgiaphongtraotd_tieuchuan extends Model
{
    protected $table = 'dshosothamgiaphongtraotd_tieuchuan';
    protected $fillable = [
        'id',
        'stt',
        'mahosothamgiapt', // ký hiệu
        'iddoituong', //id
        'matieuchuandhtd', //Lưu sau cần thì tham chiếu
        'tentieuchuandhtd',
        'phanloaidoituong',
        'batbuoc',
        'dieukien',
        'mota',
    ];
}
