<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class duthaoquyetdinh extends Model
{
    protected $table = 'dmduthaomacdinh';
    protected $fillable = [
        'id',
        'maduthao',
        'mahinhthuckt',
        'noidung',
        'codehtml',
        'ghichu',
        'madonvi',
        'phanloai',
        'theodoi',
        'stt',
    ];
}
