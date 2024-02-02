<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthucthidua;
use Illuminate\Support\Facades\Session;

class dmhinhthucthiduaController extends Controller
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
        if (!chkPhanQuyen('dmhinhthucthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthucthidua');
        }
        $inputs = $request->all();
        $model = dmhinhthucthidua::all();
        
        //dd($model);
        return view('DanhMuc.HinhThucThiDua.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh mục danh hiệu thi đua');
    }

    public function store(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmhinhthucthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthucthidua');
        }
        $inputs = $request->all();
       
        $model = dmhinhthucthidua::where('mahinhthucthidua', $inputs['mahinhthucthidua'])->first();
        if ($model == null) {
            $inputs['mahinhthucthidua'] = getdate()[0];
            dmhinhthucthidua::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/HinhThucThiDua/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmhinhthucthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthucthidua');
        }
        $inputs = $request->all();
        dmhinhthucthidua::findorfail($inputs['id'])->delete();
        return redirect('/HinhThucThiDua/ThongTin');
    } 
    
    public function LayChiTiet(Request $request)
    {      
        $inputs = $request->all();
        $model = dmhinhthucthidua::findorfail($inputs['id']);       
        return die( $model);
    }
}
