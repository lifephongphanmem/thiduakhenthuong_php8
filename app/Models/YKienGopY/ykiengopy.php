<?php

namespace App\Models\YKienGopY;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ykiengopy extends Model
{
    use HasFactory;
    protected $table='ykiengopy';
    protected $fillable=[
        'magopy',
        'madonvi',
        'tieude',
        'noidung',
        'madonviphanhoi',
        'noidungphanhoi',
        'trangthai',//0:đã gửi ý kiến,1:đã tiếp nhận,2:Đã phản hồi
    ];
}
