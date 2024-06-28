<?php

namespace App\Models\DanhMuc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dmdonvikhenthuongkhac extends Model
{
    use HasFactory;
    protected $table='dmdonvikhenthuongkhac';
    protected $fillable=[
        'madonvi','tendonvi','madonvi_nhap'
    ];
}
