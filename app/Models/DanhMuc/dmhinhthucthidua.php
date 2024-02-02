<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmhinhthucthidua extends Model
{
    protected $table = 'dmhinhthucthidua';
    protected $fillable = [
        'id',
        'mahinhthucthidua',
        'tenhinhthucthidua',
        'phanloai',       
        'ghichu',
    ];
}
