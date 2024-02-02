<?php

namespace App\Http\Controllers\API;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_detai;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIquanlycanboController extends Controller
{
    public static $url = '/HeThongAPI/XuatDuLieu/';

    public function getKhenThuongCaNhan(Request $request)
    {
    }
    public function postKhenThuongCaNhan(Request $request)
    {
    }
}
