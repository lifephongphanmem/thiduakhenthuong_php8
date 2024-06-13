<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmphongtraothidua;
use Illuminate\Support\Facades\Session;

class dmphongtraothiduaController extends Controller
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
        if (!chkPhanQuyen('dmphongtraothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dmphongtraothidua');
        }
        $inputs = $request->all();
        $model = dmphongtraothidua::all();
        
        //dd($model);
        return view('DanhMuc.PLPhongTrao.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh mục phân loại phong trào thi đua');
    }

    public function store(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmphongtraothidua');
        }
        $inputs = $request->all();
       
        $model = dmphongtraothidua::where('maplphongtrao', $inputs['maplphongtrao'])->first();
        if ($model == null) {
            $inputs['maplphongtrao'] = getdate()[0];
            dmphongtraothidua::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/PLPhongTrao/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmphongtraothidua');
        }
        $inputs = $request->all();
        dmphongtraothidua::findorfail($inputs['id'])->delete();
        return redirect('/PLPhongTraoThiDua/ThongTin');
    } 
    
    public function LayChiTiet(Request $request)
    {      
        $inputs = $request->all();
        $model = dmphongtraothidua::findorfail($inputs['id']);       
        return die( $model);
    }
}
