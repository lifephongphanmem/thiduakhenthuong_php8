<?php

namespace App\Models\NghiepVu\DangKyDanhHieu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dshosodangkyphongtraothidua_tailieu extends Model
{
    use HasFactory;
    protected $table = 'dshosodangkyphongtraothidua_tailieu';
    protected $fillable = [
        'id',
        'mahosotdkt',
        'phanloai',
        'madonvi', //Lưu đơn vị đính kèm (xử lý trường hợp tổng hợp hồ sơ)
        'tentailieu',
        'noidung',
        'base64',
        'ngaythang',
        'ghichu',
    ];
}
