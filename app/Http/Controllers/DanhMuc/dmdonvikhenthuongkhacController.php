<?php

namespace App\Http\Controllers\DanhMuc;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdonvikhenthuongkhac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class dmdonvikhenthuongkhacController extends Controller
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

    public function ThongTin()
    {
        $model=dmdonvikhenthuongkhac::all();
        $inputs['madonvi_nhap']=session('admin')->madonvi;
        return view('DanhMuc.DonViKhenThuongKhac.ThongTin')
                ->with('model',$model)
                ->with('inputs',$inputs)
                ->with('pageTitle','Danh mục đơn vị khen thưởng khác');
    }
    
    public function Them(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdonvikhenthuongkhac', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdonvikhenthuongkhac');
        }
        $inputs = $request->all();
        $model = dmdonvikhenthuongkhac::where('madonvi', $inputs['madonvi'])->first();
        if ($model == null) {
            $inputs['madonvi'] = getdate()[0];
            dmdonvikhenthuongkhac::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DonViKhenThuongKhac/ThongTin');
    }

    public function Xoa(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdonvikhenthuongkhac', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdonvikhenthuongkhac');
        }
        $inputs = $request->all();
        dmdonvikhenthuongkhac::findorfail($inputs['id'])->delete();
        return redirect('/DonViKhenThuongKhac/ThongTin');
    }

    public function LayChiTiet(Request $request)
    {
        $inputs = $request->all();
        $model = dmdonvikhenthuongkhac::findorfail($inputs['id']);
        return die($model);
    }
}
