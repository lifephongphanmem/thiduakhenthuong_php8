<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosotdktcumkhoi_tailieu extends Model
{
    protected $table = 'dshosotdktcumkhoi_tailieu';
    protected $fillable = [
        'id',
        'mahosotdkt',
        'phanloai',
        'madonvi', //Lưu đơn vị đính kèm (sử lý trường hợp tổng hợp hồ sơ)
        'tentailieu',
        'noidung',
        'base64',
        'ngaythang',
        'ghichu',
    ];
}
