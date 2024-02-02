<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmcoquandonvi;
use Illuminate\Support\Facades\Session;

class dmcoquandonviController extends Controller
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
        if (!chkPhanQuyen('dmcoquandonvi', 'danhsach')) {
            return view('errors.noperm')
                ->with('machucnang', 'dmcoquandonvi');
        }
        $inputs = $request->all();
        $model = dmcoquandonvi::all();

        //dd($model);
        return view('DanhMuc.CoQuanDonVi.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phanloai', getPhanLoaiTDKT())
            ->with('pageTitle', 'Danh mục cơ quan, đơn vị, tập thể');
    }

    public function store(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmcoquandonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmcoquandonvi');
        }
        $inputs = $request->all();
      
        $model = dmcoquandonvi::where('macoquandonvi', $inputs['macoquandonvi'])->first();
        if ($model == null) {
            $inputs['macoquandonvi'] = getdate()[0];
            dmcoquandonvi::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/CoQuanDonVi/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmcoquandonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmcoquandonvi');
        }
        $inputs = $request->all();
        dmcoquandonvi::findorfail($inputs['id'])->delete();
        return redirect('/CoQuanDonVi/ThongTin');
    }

    public function LayChiTiet(Request $request)
    {
        $inputs = $request->all();
        $model = dmcoquandonvi::findorfail($inputs['id']);
        return die($model);
    }
}
