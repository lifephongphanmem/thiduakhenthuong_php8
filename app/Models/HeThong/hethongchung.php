<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Model;

class hethongchung extends Model
{
    protected $table = 'hethongchung';
    protected $fillable = [
        'id',
        'phanloai',
        'tendonvi',
        'maqhns',
        'diachi',
        'dienthoai',
        'thutruong',
        'ketoan',
        'nguoilapbieu',
        'diadanh',
        'thietlap',
        'thongtinhd',
        'emailql',
        'tendvhienthi',
        'tendvcqhienthi',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
        'solandn',
        //thông tin Form giới thiệu
        'tencongtycongty',
        'sodienthoaicongty',
        'diachicongty',
        'logocongty',
        //Tuỳ chọn
        'hskhenthuong_totrinh',
        'opt_duthaototrinh',
        'opt_duthaoquyetdinh',
        'madonvi_macdinhphoi',
        'maduthaototrinhdenghi',
        'maduthaototrinhketqua',
        'maduthaoquyetdinh',
        'madonvi_inphoi',
        'opt_trinhhosodenghi',  
        'opt_trinhhosoketqua',
        'opt_pheduyethoso',
        'opt_quytrinhkhenthuong',
        //api
        'keypublic',
        'accesstoken',
        'thoigianhethong',
        'dangnhap2thietbi'
    ];
}
