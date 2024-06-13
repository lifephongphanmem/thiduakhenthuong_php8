<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdetaisangkien;
use Illuminate\Support\Facades\Session;

class dmdetaisangkienController extends Controller
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

        if (!chkPhanQuyen('dmdetaisangkien', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dmdetaisangkien');
        }
        $inputs = $request->all();
        $model = dmdetaisangkien::all();
        
        //dd($model);
        return view('DanhMuc.DeTaiSangKien.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh mục đề tài, sáng kiến');
    }

    public function store(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdetaisangkien', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdetaisangkien');
        }
        $inputs = $request->all();
        $model = dmdetaisangkien::where('madetaisangkien', $inputs['madetaisangkien'])->first();
        if ($model == null) {
            $inputs['madetaisangkien'] = getdate()[0];
            dmdetaisangkien::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DeTaiSangKien/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdetaisangkien', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdetaisangkien');
        }
        $inputs = $request->all();
        dmdetaisangkien::findorfail($inputs['id'])->delete();
        return redirect('/DeTaiSangKien/ThongTin');
    }  

    public function LayChiTiet(Request $request)
    {      
        $inputs = $request->all();
        $model = dmdetaisangkien::findorfail($inputs['id']);       
        return die( $model);
    }  
}
