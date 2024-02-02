<?php

namespace App\Http\Controllers\DanhMuc;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmdanhhieuthidua_tieuchuan;
use Illuminate\Support\Facades\Session;

class dmdanhhieuthiduaController extends Controller
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

        if (!chkPhanQuyen('dmdanhhieuthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dmdanhhieuthidua');
        }
        $inputs = $request->all();
        $model = dmdanhhieuthidua::all();
        $a_phamviapdung = getPhamViApDung();
        foreach ($model as $ct) {
            $ct->tenphamviapdung = '';
            foreach (explode(';', $ct->phamviapdung) as $phamvi) {
                $ct->tenphamviapdung .= ($a_phamviapdung[$phamvi] ?? '') . '; ';
            }
        }
        
        //dd($model);
        return view('DanhMuc.DanhHieuThiDua.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phanloai', getPhanLoaiTDKT())
            ->with('pageTitle', 'Danh mục danh hiệu thi đua');
    }

    public function store(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdanhhieuthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdanhhieuthidua');
        }
        $inputs = $request->all();
        $inputs['phamviapdung'] = implode(';', $inputs['phamviapdung']);
        $model = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        if ($model == null) {
            $inputs['madanhhieutd'] = getdate()[0];
            dmdanhhieuthidua::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DanhHieuThiDua/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdanhhieuthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdanhhieuthidua');
        }
        $inputs = $request->all();
        dmdanhhieuthidua::findorfail($inputs['id'])->delete();
        return redirect('/DanhHieuThiDua/ThongTin');
    }

    public function TieuChuan(Request $request)
    {
        $inputs = $request->all();
        $model = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();
        $m_danhhieu = dmdanhhieuthidua::all();
        return view('DanhMuc.DanhHieuThiDua.TieuChuan')
            ->with('model', $model)
            ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('m_danhhieu', $m_danhhieu->where('madanhhieutd', $inputs['madanhhieutd'])->first())
            ->with('pageTitle', 'Danh sách danh mục tiêu chuẩn danh hiệu thi đua');
    }

    public function ThemTieuChuan(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdanhhieuthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdanhhieuthidua');
        }
        $inputs = $request->all();
        $model = dmdanhhieuthidua_tieuchuan::where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();
        if ($model == null) {
            $inputs['matieuchuandhtd'] = getdate()[0];
            dmdanhhieuthidua_tieuchuan::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DanhHieuThiDua/TieuChuan?madanhhieutd=' . $inputs['madanhhieutd']);
    }

    public function delete_TieuChuan(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmdanhhieuthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmdanhhieuthidua');
        }
        $inputs = $request->all();
        $model = dmdanhhieuthidua_tieuchuan::findorfail($inputs['id']);
        $model->delete();
        return redirect('/DanhHieuThiDua/TieuChuan?madanhhieutd=' . $model->madanhhieutd);
    }
}
