<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmhinhthuckhenthuong extends Model
{
    protected $table = 'dmhinhthuckhenthuong';
    protected $fillable = [
        'id',
        'stt',
        'mahinhthuckt',
        'tenhinhthuckt',
        'phanloai',
        'phamviapdung',
        'ghichu',
        'doituongapdung',
        'muckhencanhan',
        'muckhentapthe',
    ];
}
