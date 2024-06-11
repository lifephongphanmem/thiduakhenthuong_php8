<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tailieuhuongdan extends Model
{
    use HasFactory;
    protected $table='tailieuhuongdan';
    protected $fillable=[
        'id',
        'matailieu',
        'tentailieu',
        'phanloai',
        'noidung',
        'link1',
        'link2',
        'file',
        'stt'
    ];
}
