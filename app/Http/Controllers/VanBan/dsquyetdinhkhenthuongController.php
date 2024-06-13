<?php

namespace App\Http\Controllers\VanBan;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\VanBan\dsquyetdinhkhenthuong;
use App\Models\VanBan\dsvanbanphaply;
use Illuminate\Support\Facades\Session;

class dsquyetdinhkhenthuongController extends Controller
{
    public static $url = '/QuanLyVanBan/KhenThuong/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            if(!chkaction()){
                Session::flush();
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('quyetdinhkhenthuong', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'quyetdinhkhenthuong')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dsquyetdinhkhenthuong::all();
        foreach($model as $hoso){
            $hoso->thaotac=true;
        }
        //dd($model);
        $inputs['capkhenthuong'] = $inputs['capkhenthuong'] ?? 'ALL';
        //dd($model);
        //Hô sơ khen thưởng
        $dshosothiduakhenthuong = dshosothiduakhenthuong::where('trangthai', 'DKT')->get();
        foreach ($dshosothiduakhenthuong as $hoso) {
            $hoso->tieude = $hoso->noidung;
            $hoso->maquyetdinh = $hoso->mahosotdkt;
            $hoso->phanloaikhenthuong = 'dshosothiduakhenthuong';
            $hoso->thaotac=false;
            $model->add($hoso);
        }
        $dshosotdktcumkhoi = dshosotdktcumkhoi::where('trangthai', 'DKT')->get();
        foreach ($dshosotdktcumkhoi as $hoso) {
            $hoso->tieude = $hoso->noidung;
            $hoso->phanloaikhenthuong = 'dshosotdktcumkhoi';
            $hoso->maquyetdinh = $hoso->mahosotdkt;
            $hoso->thaotac=false;
            $model->add($hoso);
        }
        $inputs['capkhenthuong'] = $inputs['capkhenthuong'] ?? 'ALL';
        if ($inputs['capkhenthuong'] != 'ALL') {
            $model = $model->where('capkhenthuong', $inputs['capkhenthuong']);
        }
        return view('VanBan.KhenThuong.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phamvi', getPhamViApDung())
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Danh sách quyết định khen thưởng');
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('quyetdinhkhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'quyetdinhkhenthuong')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dsquyetdinhkhenthuong::where('maquyetdinh', $inputs['maquyetdinh'])->first();
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = $inputs['maquyetdinh'] . '1.' . $filedk->getClientOriginalName() . '.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['ipf1']);
        }
        if ($model == null) {
            dsquyetdinhkhenthuong::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin');
    }

    public function XoaHoSo(Request $request)
    {
        if (!chkPhanQuyen('quyetdinhkhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'quyetdinhkhenthuong')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($inputs);
        dsquyetdinhkhenthuong::findorfail($inputs['id'])->delete();
        return redirect(static::$url . 'ThongTin');
    }

    public function Them()
    {
        if (!chkPhanQuyen('quyetdinhkhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'quyetdinhkhenthuong')->with('tenphanquyen', 'thaydoi');
        }
        $inputs['url'] = static::$url;
        $model = new dsvanbanphaply();
        $model->maquyetdinh = getdate()[0];

        return view('VanBan.KhenThuong.ThayDoi')
            ->with('model', $model)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin quyết định khen thưởng');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('quyetdinhkhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'quyetdinhkhenthuong')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dsquyetdinhkhenthuong::where('maquyetdinh', $inputs['maquyetdinh'])->first();
        $inputs['url'] = static::$url;
        return view('VanBan.KhenThuong.ThayDoi')
            ->with('model', $model)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin quyết định khen thưởng');
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();

        $model = dsquyetdinhkhenthuong::where('maquyetdinh', $inputs['mahs'])->first();
        //dd($model);
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if (isset($model->ipf1)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 1: </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf1) . '">' . $model->ipf1 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf2)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 2 </label >';
            $result['message'] .= '<p ><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->ipf2) . '">' . $model->ipf2 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf3)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 3 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf3) . '">' . $model->ipf3 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf4)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 4 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf4) . '">' . $model->ipf4 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf5)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 5 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf5) . '">' . $model->ipf5 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
