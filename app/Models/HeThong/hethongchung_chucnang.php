<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Model;

class hethongchung_chucnang extends Model
{
    protected $table = 'hethongchung_chucnang';
    protected $fillable = [
        'id',
        'machucnang',
        'tenchucnang',
        'hienthi',
        'sudung',
        'tenbang',
        'api',
        'capdo',
        'machucnang_goc', //Áp dụng cho cấp độ 2 trở lên
        'sapxep',
        //Các trường mặc định cho chức năng
        'mahinhthuckt',
        'maloaihinhkt',
        'trangthai',//trạng thái hồ sơ để tính đơn vị gửi
    ];
}
