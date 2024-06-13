<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmcoquandonvi;
use App\Models\DanhMuc\dsdonvi;
use Illuminate\Support\Facades\Session;

class dmcoquandonviController extends Controller
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

    public function LayDonVi()
    {
        if (!chkPhanQuyen('dmcoquandonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmcoquandonvi');
        }

        $model=dsdonvi::all();
        $m_coquan=dmcoquandonvi::all();
        $a_macoquan=array_column($m_coquan->toarray(),'macoquandonvi');
        $a_donvi=array();
        if(count($model) > 0){
            foreach($model as $ct){
                if(in_array($ct->madonvi,$a_macoquan)){
                    continue;
                }
                // $a_donvi[$k]=[$ct->madonvi=>$ct->tendonvi];
                $a_donvi['macoquandonvi']=$ct->madonvi;
                $a_donvi['tencoquandonvi']=$ct->tendonvi;

                dmcoquandonvi::create($a_donvi);
            }
        }
        return redirect('/CoQuanDonVi/ThongTin');
    }
}
