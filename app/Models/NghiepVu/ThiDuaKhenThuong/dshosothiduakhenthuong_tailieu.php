<?php

namespace App\Models\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong_tailieu extends Model
{
    protected $table = 'dshosothiduakhenthuong_tailieu';
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
