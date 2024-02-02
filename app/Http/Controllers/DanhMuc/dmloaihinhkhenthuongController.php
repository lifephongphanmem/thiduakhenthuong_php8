<?php

namespace App\Http\Controllers\DanhMuc;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use Illuminate\Support\Facades\Session;

class dmloaihinhkhenthuongController extends Controller
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

        if (!chkPhanQuyen('dmloaihinhkhenthuong', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dmloaihinhkhenthuong');
        }
        $model = dmloaihinhkhenthuong::all();
        $inputs = $request->all();
        //dd($model);
        return view('DanhMuc.LoaiHinhKhenThuong.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh mục loại hình khen thưởng');
    }

    public function store(Request $request)
    {

        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmloaihinhkhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmloaihinhkhenthuong');
        }
        $inputs = $request->all();
        $model = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->first();
        if ($model == null) {
            $inputs['maloaihinhkt'] = getdate()[0];
            dmloaihinhkhenthuong::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/LoaiHinhKhenThuong/ThongTin');
    }

    public function delete(Request $request)
    {

        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmloaihinhkhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmloaihinhkhenthuong');
        }
        $inputs = $request->all();
        dmloaihinhkhenthuong::findorfail($inputs['id'])->delete();
        return redirect('/LoaiHinhKhenThuong/ThongTin');
    }
}
