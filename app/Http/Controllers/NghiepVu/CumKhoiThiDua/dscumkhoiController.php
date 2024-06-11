<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\View\view_dscumkhoi;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class dscumkhoiController extends Controller
{
    public static $url = '/CumKhoiThiDua/CumKhoi/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            chkaction();
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dscumkhoi::all();
        $m_chitiet = dscumkhoi_chitiet::all();
        foreach ($model as $ct) {
            $ct->sodonvi = $m_chitiet->where('macumkhoi', $ct->macumkhoi)->count();
        }
        //dd($m_chitiet);
        $m_donvi = dsdonvi::all();
        return view('NghiepVu.CumKhoiThiDua.DanhSach.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', array_column($m_chitiet->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách cụm, khối thi đua');
    }   

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? null;

        $model = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            $model = new dscumkhoi();
            $model->macumkhoi = getdate()[0];
        }
        $model_chitiet = view_dscumkhoi::where('macumkhoi', $model->macumkhoi)->select('tendonvi', 'madonvi')->distinct()->get();        
        $a_donviql = array_column($model_chitiet->toarray(), 'tendonvi', 'madonvi');
        $a_donvixd = getDonViXetDuyetCumKhoi();
        $a_donvikt = getDonViPheDuyetCumKhoi();
        // dd($model_chitiet);
        // $m_donvi = dsdonvi::wherein('madonvi', function ($qr) {
        //     $qr->select('madonviQL')->from('dsdiaban')->get();
        // })->get();
        return view('NghiepVu.CumKhoiThiDua.DanhSach.ThayDoi')
            ->with('model', $model)
            ->with('a_donvixd', $a_donvixd)
            ->with('a_donviql', $a_donviql)
            ->with('a_donvikt', $a_donvikt)
            ->with('pageTitle', 'Thông tin cụm, khối thi đua');
    }

    public function LuuCumKhoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = $inputs['macumkhoi'] . '_qd.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['ipf1']);
        }

        if (isset($inputs['ipf2'])) {
            $filedk = $request->file('ipf2');
            $inputs['ipf2'] = $inputs['macumkhoi'] . '_tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['ipf2']);
        }
        $model = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            dscumkhoi::create($inputs);
        } else {
            $model->update($inputs);
        }
        return redirect(static::$url . 'ThongTin');
    }

    public function Xoa(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $dscumkhoi=dscumkhoi::findorfail($inputs['id']);
        if(isset($dscumkhoi)){
            if (file_exists('/data/quyetdinh/' . $dscumkhoi->ipf1)){
                File::Delete('/data/quyetdinh/' . $dscumkhoi->ipf1);
            }
            if (file_exists('/data/tailieukhac/' . $dscumkhoi->ipf2)){
                File::Delete('/data/tailieukhac/' . $dscumkhoi->ipf2);
            }
            $dscumkhoi->delete();
        }
        return redirect(static::$url . 'ThongTin');
    }

    public function DanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_cumkhoi = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        $model = dscumkhoi_chitiet::where('macumkhoi', $inputs['macumkhoi'])->get();

        $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
        $m_donvi = viewdiabandonvi::all();
        //$m_donvi = viewdiabandonvi::wherenotin('madonvi', array_column($model->toarray(), 'madonvi'))->get();
        //$m_donvi = viewdiabandonvi::where('capdo', $m_cumkhoi->capdo)->get();
        return view('NghiepVu.CumKhoiThiDua.DanhSach.DanhSach')
            ->with('model', $model)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('m_donvi', $m_donvi)
            ->with('a_donvi', $a_donvi)
            ->with('a_diaban', array_column($m_donvi->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_phanloai', getPhanLoaiDonViCumKhoi())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin đơn vị trong cụm, khối thi đua');
    }

    public function ThemDonVi(Request $request)
    {

        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi_chitiet::where('madonvi', $inputs['madonvi'])->where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            dscumkhoi_chitiet::create($inputs);
        } else {
            $model->update($inputs);
        }
        if ($inputs['phanloai'] == "TRUONGKHOI") {
            dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->update(['madonviql' => $inputs['madonvi']]);
        }
        return redirect(static::$url . 'DanhSach?macumkhoi=' . $inputs['macumkhoi']);
    }

    public function XoaDonVi(Request $request)
    {

        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi_chitiet::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'DanhSach?macumkhoi=' . $model->macumkhoi);
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dscumkhoi::where('macumkhoi', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';

        if ($model->ipf1 != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->ipf1) . '">' . $model->ipf1 . '</a ></div>';
            $result['message'] .= '</div>';
        }

        if ($model->ipf2 != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->ipf2) . '">' . $model->ipf2 . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
