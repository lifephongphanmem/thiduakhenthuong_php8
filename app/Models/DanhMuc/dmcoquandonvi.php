<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmcoquandonvi extends Model
{
    protected $table = 'dmcoquandonvi';
    protected $fillable = [
        'id',
        'macoquandonvi',
        'tencoquandonvi',
        'phanloai',
        'ghichu',        
    ];
}
