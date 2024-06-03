<?php

namespace App\Http\Controllers\NhatKy;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use Illuminate\Http\Request;

class nhatkytruycapController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = dsdonvi::all();
        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        $model = trangthaihoso::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get();
        return view('HeThong.NhatKyHeThong')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_donvi', $a_donvi)
            ->with('pageTitle', 'Thông tin hỗ trợ');
    }
}
