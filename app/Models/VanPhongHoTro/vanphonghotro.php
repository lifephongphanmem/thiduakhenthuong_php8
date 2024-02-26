<?php

namespace App\Models\VanPhongHoTro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vanphonghotro extends Model
{
    use HasFactory;
    protected $table= "dsvanphonghotro";
    protected $fillable=[
        'maso',
        'vanphong',
        'hoten',
        'chucvu',
        'sdt',
        'skype',
        'facebook',
        'stt'
    ];
}
