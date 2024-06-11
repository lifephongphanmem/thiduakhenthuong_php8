<?php

namespace App\Http\Controllers\HeThong;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\HeThong\dsvanphonghotro;
use App\Models\HeThong\hethongchung_chucnang;
use Illuminate\Support\Facades\Session;

class dsvanphonghotroController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            chkaction();
            return $next($request);
        });
    }

    public function ThongTin()
    {
        if (!chkPhanQuyen('hethongchung_chucnang', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung_chucnang');
        }
        $model = dsvanphonghotro::all();
        $a_vp = array_column($model->toArray(), 'vanphong', 'vanphong');
        $col = (int) 12 / (count($a_vp) > 0 ? count($a_vp) : 1);
        $col = $col < 4 ? 4 : $col;
        return view('HeThongChung.VanPhongHoTro.ThongTin')
            ->with('model', $model)
            ->with('a_vp', $a_vp)
            ->with('col', $col)
            ->with('pageTitle', 'Danh sách cán bộ hỗ trợ');
    }

    public function Them(Request $request)
    {        
        $inputs = $request->all();
        $model = dsvanphonghotro::where('id', $inputs['id'])->first();
        if ($model == null) {
            unset($inputs['id']);
            dsvanphonghotro::create($inputs);
        } else {
            $model->update($inputs);
        }
        return redirect('/VanPhongHoTro/ThongTin');
    }

    public function LayChucNang(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if (!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        //dd($request);
        $inputs = $request->all();
        $model = hethongchung_chucnang::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaChucNang(Request $request)
    {
        if (!chkPhanQuyen('hethongchung_chucnang', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung_chucnang');
        }
        $inputs = $request->all();
        $model = hethongchung_chucnang::findorfail($inputs['iddelete']);
        $model->delete();
        return redirect('/ChucNang/ThongTin');
    }
}
