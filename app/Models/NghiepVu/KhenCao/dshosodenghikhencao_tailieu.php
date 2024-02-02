<?php

namespace App\Models\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosodenghikhencao_tailieu extends Model
{
    protected $table = 'dshosodenghikhencao_tailieu';
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
