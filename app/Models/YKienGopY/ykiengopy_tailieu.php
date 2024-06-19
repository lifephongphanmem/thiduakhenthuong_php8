<?php

namespace App\Models\YKienGopY;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ykiengopy_tailieu extends Model
{
    use HasFactory;
    protected $table='ykiengopy_tailieu';
    protected $fillable=[
        'magopy',
        'phanloai',
        'noidung',
        'tentailieu'
    ];
}
