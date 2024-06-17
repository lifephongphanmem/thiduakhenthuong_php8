<?php

namespace App\Models\VanBan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vanbanphaply_tailieu extends Model
{
    use HasFactory;
    protected $table='vanbanphaply_tailieu';
    protected $fillable=[
        'mavanban','stt','phanloai','noidung','tentailieu'
    ];
}
