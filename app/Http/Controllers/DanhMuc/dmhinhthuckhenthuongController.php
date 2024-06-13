<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use Illuminate\Support\Facades\Session;

class dmhinhthuckhenthuongController extends Controller
{
    static $url = '/HinhThucKhenThuong/';
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
        if (!chkPhanQuyen('dmhinhthuckhenthuong', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthuckhenthuong');
        }
        $inputs = $request->all();
        $a_phanloai = getPhanLoaiHinhThucKT();
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        $inputs['url'] = static::$url;

        if ($inputs['phanloai'] != 'ALL')
            $model = dmhinhthuckhenthuong::where('phanloai', $inputs['phanloai'])->get();
        else
            $model = dmhinhthuckhenthuong::all();
        $a_phamviapdung = getPhamViApDung();
        $a_doituongapdung = getDoiTuongApDung();
        //doituongapdung
        foreach ($model as $key => $ct) {
            //lọc phạm vi áp dụng
            $ct->tenphamviapdung = '';
            $phamvi = explode(';', $ct->phamviapdung);
            foreach ($phamvi as $val) {
                $ct->tenphamviapdung .= ($a_phamviapdung[$val] ?? '') . '; ';
            }
            
            if ($inputs['phamviapdung'] != 'ALL' && !in_array($inputs['phamviapdung'], $phamvi)) {                
                $model->forget($key);
            }

            //đối tượng
            $ct->tendoituongapdung = '';
            foreach (explode(';', $ct->doituongapdung) as $doituong) {
                $ct->tendoituongapdung .= ($a_doituongapdung[$doituong] ?? '') . '; ';
            }

            if (strpos($ct->doituongapdung, 'CANHAN') !== false)
                $ct->canhan_ad = true;
            else
                $ct->canhan_ad = false;

            if (strpos($ct->doituongapdung, 'TAPTHE') !== false || strpos($ct->doituongapdung, 'HOGIADINH') !== false)
                $ct->tapthe_ad = true;
            else
                $ct->tapthe_ad = false;
        }

        // dd($model);
        return view('DanhMuc.HinhThucKhenThuong.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phanloai', $a_phanloai)
            ->with('a_phamvi', $a_phamviapdung)
            ->with('pageTitle', 'Danh mục loại hình khen thưởng');
    }

    public function store(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmhinhthuckhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthuckhenthuong');
        }
        $inputs = $request->all();
        $inputs['phamviapdung'] = implode(';', $inputs['phamviapdung']);
        $inputs['doituongapdung'] = implode(';', $inputs['doituongapdung']);
        //dd($inputs);
        $model = dmhinhthuckhenthuong::where('mahinhthuckt', $inputs['mahinhthuckt'])->first();
        if ($model == null) {
            $inputs['mahinhthuckt'] = getdate()[0];
            dmhinhthuckhenthuong::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin?phanloai=' . $inputs['phanloai']);
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmhinhthuckhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthuckhenthuong');
        }
        $inputs = $request->all();
        dmhinhthuckhenthuong::findorfail($inputs['id'])->delete();
        return redirect('/HinhThucKhenThuong/ThongTin');
    }

    public function LayChiTiet(Request $request)
    {
        $inputs = $request->all();
        $model = dmhinhthuckhenthuong::findorfail($inputs['id']);
        die(json_encode($model));
    }
}
