<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Model;

class dsvanphonghotro extends Model
{
    protected $table = 'dsvanphonghotro';
    protected $fillable = [
        'id',
        'vanphong',
        'hoten',
        'chucvu',
        'sdt',
        'skype',
        'facebook',
        'stt',
        'email',
    ];
}
