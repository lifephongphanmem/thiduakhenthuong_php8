<?php

namespace App\Models\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosokhencao_tailieu extends Model
{
    protected $table = 'dshosokhencao_tailieu';
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
