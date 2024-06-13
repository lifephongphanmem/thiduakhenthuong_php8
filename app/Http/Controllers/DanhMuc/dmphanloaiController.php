<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmnhomphanloai;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use Illuminate\Support\Facades\Session;

class dmphanloaiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            if(!chkaction()){
                Session::flush();
                return response()->view('errors.error_login');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {

        if (!chkPhanQuyen('dmnhomphanloai','danhsach')) {
            return view('errors.noperm')->with('machucnang','dmnhomphanloai');
        }
        $inputs = $request->all();
        $inputs['url'] = '/DMPhanLoai/';
        $a_nhomphanloai = array_column(dmnhomphanloai::all()->toArray(), 'tennhomphanloai', 'manhomphanloai');
        $inputs['manhomphanloai'] = $inputs['manhomphanloai'] ?? array_key_first($a_nhomphanloai);
        $model = dmnhomphanloai_chitiet::where('manhomphanloai', $inputs['manhomphanloai'])->get();
        //dd($model);
        return view('DanhMuc.PhanLoai.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_nhomphanloai', $a_nhomphanloai)
            ->with('pageTitle', 'Danh mục danh hiệu thi đua');
    }

    public function ThemNhom(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmnhomphanloai','thaydoi')) {
            return view('errors.noperm')->with('machucnang','dmnhomphanloai');
        }
        $inputs = $request->all();
        $model = dmnhomphanloai::where('manhomphanloai', $inputs['manhomphanloai'])->first();
        if ($model == null) {
            $inputs['manhomphanloai'] = getdate()[0];
            dmnhomphanloai::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DMPhanLoai/ThongTin?manhomphanloai=' . $inputs['manhomphanloai']);
    }

    public function Them(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmnhomphanloai','thaydoi')) {
            return view('errors.noperm')->with('machucnang','dmnhomphanloai');
        }
        $inputs = $request->all();
        $model = dmnhomphanloai_chitiet::where('maphanloai', $inputs['maphanloai'])->first();
        if ($model == null) {
            $inputs['maphanloai'] = getdate()[0];
            dmnhomphanloai_chitiet::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DMPhanLoai/ThongTin?manhomphanloai=' . $inputs['manhomphanloai']);
    }


    public function Xoa(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmnhomphanloai','thaydoi')) {
            return view('errors.noperm')->with('machucnang','dmnhomphanloai');
        }
        $inputs = $request->all();
        $model = dmnhomphanloai_chitiet::findorfail($inputs['id']);
        $model->delete();
        return redirect('/DMPhanLoai/ThongTin?manhomphanloai=' . $model->manhomphanloai);
    }
}
