<?php

namespace App\Models\VanBan;

use Illuminate\Database\Eloquent\Model;

class dsvanbanphaply extends Model
{
    protected $table = 'dsvanbanphaply';
    protected $fillable = [
        'id',
        'mavanban',
        'kyhieuvb',
        'dvbanhanh',
        'loaivb',
        'trangthai',
        'ngayqd',
        'ngayapdung',
        'tieude',
        'ghichu',
        'phanloai',
        'madonvi',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
        //21.09.22
        'tinhtrang',
        'ngaytinhtrang',
        'vanbanbosung',
    ];
}
