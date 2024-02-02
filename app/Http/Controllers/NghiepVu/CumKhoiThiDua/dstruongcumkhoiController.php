<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstruongcumkhoi;
use App\Models\DanhMuc\dstruongcumkhoi_chitiet;
use App\Models\View\view_dscumkhoi;
use Illuminate\Support\Facades\Session;

class dstruongcumkhoiController extends Controller
{
    public static $url = '/CumKhoiThiDua/TruongCumKhoi/';
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
        if (!chkPhanQuyen('dstruongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dstruongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dstruongcumkhoi::all();
        $m_donvi = getDonVi(session('admin')->capdo);
        return view('NghiepVu.CumKhoiThiDua.TruongCumKhoi.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách trưởng cụm, khối thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dstruongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstruongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['madanhsach'] = $inputs['madanhsach'] ?? null;
        $inputs['url'] = static::$url;
        $model = dstruongcumkhoi::where('madanhsach', $inputs['madanhsach'])->first();
        if ($model == null) {
            $model = new dstruongcumkhoi();
            $model->madanhsach = getdate()[0];
        }
        return view('NghiepVu.CumKhoiThiDua.TruongCumKhoi.ThayDoi')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin cụm, khối thi đua');
    }

    public function LuuDanhSach(Request $request)
    {
        if (!chkPhanQuyen('dstruongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstruongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = $inputs['madanhsach'] . '_qd.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/qdkt/', $inputs['ipf1']);
        }

        if (isset($inputs['ipf2'])) {
            $filedk = $request->file('ipf2');
            $inputs['ipf2'] = $inputs['madanhsach'] . '_tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['ipf2']);
        }

        $model = dstruongcumkhoi::where('madanhsach', $inputs['madanhsach'])->first();
        if ($model == null) {
            dstruongcumkhoi::create($inputs);
            $a_truongcum = [];
            $m_cumkhoi = dscumkhoi::all();
            foreach ($m_cumkhoi as $cum) {
                $a_truongcum[] = [
                    'madanhsach' => $inputs['madanhsach'],
                    'macumkhoi' => $cum->macumkhoi,
                    'madonvi' => $cum->madonviql,
                ];
            }
            dstruongcumkhoi_chitiet::insert($a_truongcum);
        } else {
            $model->update($inputs);
        }
        return redirect(static::$url . 'ThongTin');
    }

    public function XoaDS(Request $request)
    {
        if (!chkPhanQuyen('dstruongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstruongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();

        $model = dstruongcumkhoi::findorfail($inputs['id']);
        dstruongcumkhoi_chitiet::where('madanhsach', $model->madanhsach)->delete();
        $model->delete();
        return redirect(static::$url . 'ThongTin');
    }

    public function DanhSach(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $m_cumkhoi = dstruongcumkhoi::where('madanhsach', $inputs['madanhsach'])->first();
        $model = dstruongcumkhoi_chitiet::where('madanhsach', $inputs['madanhsach'])->get();

        $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
        //$m_donvi = viewdiabandonvi::all();

        return view('NghiepVu.CumKhoiThiDua.TruongCumKhoi.DanhSach')
            ->with('model', $model)
            ->with('m_cumkhoi', $m_cumkhoi)
            //->with('m_donvi', $m_donvi)
            ->with('a_donvi', $a_donvi)
            ->with('a_cumkhoi', array_column(dscumkhoi::all()->toArray(), 'tencumkhoi', 'macumkhoi'))
            //->with('a_diaban', array_column($m_donvi->toArray(), 'tendiaban', 'madiaban'))
            // ->with('a_phanloai', getPhanLoaiDonViCumKhoi())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin danh sách trưởng cụm, khối');
    }

    public function LuuTruongCum(Request $request)
    {

        if (!chkPhanQuyen('dstruongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstruongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dstruongcumkhoi_chitiet::where('macumkhoi', $inputs['macumkhoi'])
            ->where('madanhsach', $inputs['madanhsach'])->first();

        $model->update($inputs);

        return redirect(static::$url . 'DanhSach?madanhsach=' . $inputs['madanhsach']);
    }

    public function LayDSDonVi(Request $request)
    {
        $inputs = $request->all();
        $model = view_dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->get();

        $result['status'] = 'success';
        $result['message'] = '<div id="dSDonVi" class="col-12">';
        $result['message'] .= '<label>Tên đơn vị</label>';
        $result['message'] .= '<select class="form-control select2_modal" required="true" name="madonvi">';
        foreach ($model as $ct) {
            $result['message'] .= '<option value="' . $ct->madonvi . '" ' . ($ct->madonvi == $inputs['madonvi'] ? 'selected' : '') . '>' . $ct->tendonvi . '</option>';
        }
        $result['message'] .= '</select></div>';
        die(json_encode($result));
    }
}
