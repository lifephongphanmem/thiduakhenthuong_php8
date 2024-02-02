<?php

namespace App\Models\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosothamgiathiduacumkhoi_tailieu extends Model
{
    protected $table = 'dshosothamgiathiduacumkhoi_tailieu';
    protected $fillable = [
        'id',
        'mahoso',
        'phanloai',
        'madonvi', //Lưu đơn vị đính kèm (sử lý trường hợp tổng hợp hồ sơ)
        'tentailieu',
        'noidung',
        'base64',
        'ngaythang',
        'ghichu',
    ];
}
