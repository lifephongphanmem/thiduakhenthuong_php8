<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class dsphongtraothiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/PhongTraoThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothidua');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'dsphongtraothidua');
        // dd($m_donvi);
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        $model = dsphongtraothidua::where('madonvi', $inputs['madonvi']);
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereYear('ngayqd', $inputs['nam']);
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);
        $model = $model->orderby('ngayqd')->get();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao_captren = dsphongtraothidua::where('phamviapdung', getCapDoDiaBanCapTren($donvi->capdo))->get();
        // dd( $model);
        return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.ThongTin')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_phongtrao_captren', $m_phongtrao_captren)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao($m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo ?? 'T'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothidua');
        }

        $inputs = $request->all();
        // dd($inputs);
        $inputs['maphongtraotd'] = $inputs['maphongtraotd'] ?? null;
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $model->madonvi;
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $inputs['maloaihinhkt'] = session('chucnang')['dsphongtraothidua']['maloaihinhkt'] ?? '';
        if ($model == null) {
            $model = new dsphongtraothidua();
            $model->madonvi = $inputs['madonvi'];
            $model->maphongtraotd = getdate()[0];
            $model->trangthai = 'CC';
            $model->phanloai = $donvi->capdo;
            $model->maloaihinhkt = $inputs['maloaihinhkt'];
            $model->maphongtraotd_coso = $inputs['maphongtraotd_coso'] ?? '';
            $model->mahinhthuckt = session('chucnang')['dsphongtraothidua']['mahinhthuckt'] ?? '';
            //dd( $model);
        }
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->orderby('phanloaidoituong')->get();

        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        $capdo = $donvi->capdo;
        //Đơn vị cấp tỉnh
        if ($donvi->capdo == 'T') {
            $a_donvi_ql = array_column(dsdiaban::wherein('capdo', ['T'])->get()->toarray(), 'madonviQL');
            if (!in_array($inputs['madonvi'], $a_donvi_ql))
                $capdo = 'H';
        }
        $a_phamvi = getPhamViPhatDongPhongTrao($capdo);
        $a_phongtrao_captren = array_column(dsphongtraothidua::where('phamviapdung', getCapDoDiaBanCapTren($donvi->capdo))->get()->toarray(), 'noidung', 'maphongtraotd');
        if (isset($inputs['maphongtraotd_coso'])) {
            $m_phongtrao_captren = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd_coso'])->first();
            if (!isset($m_phongtrao_captren)) {
                $m_phongtrao_captren = new Collection();
            }
        }else{
            $m_phongtrao_captren = new Collection(); 
        }
        // dd($inputs);
        // dd($m_phongtrao_captren);
        return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.ThayDoi')
            ->with('model', $model)
            ->with('model_tieuchuan', $model_tieuchuan)
            ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_phongtrao_captren', $a_phongtrao_captren)
            ->with('m_phongtrao_captren', $m_phongtrao_captren)
            ->with('a_phamvi', $a_phamvi)
            ->with('a_phanloaidt', getPhanLoaiTDKT())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function XemThongTin(Request $request)
    {
        $inputs = $request->all();
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model_tieuchi = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->orderby('phanloaidoituong')->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.InPhongTrao')
            ->with('model', $model)
            ->with('model_tieuchi', $model_tieuchi)
            ->with('m_donvi', $m_donvi)
            ->with('a_phamvi', getPhamViPhongTrao('T'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('a_phanloaidt', getPhanLoaiTDKT())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function LuuPhongTrao(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothidua');
        }
        $inputs = $request->all();
        if (isset($inputs['qdkt'])) {
            $filedk = $request->file('qdkt');
            $inputs['qdkt'] = $inputs['maphongtraotd'] . '_qd.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/qdkt/', $inputs['qdkt']);
        }

        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['maphongtraotd'] . '_tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }

        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        if ($model == null) {
            $inputs['trangthai'] = 'CC';
            dsphongtraothidua::create($inputs);

            $trangthai = new trangthaihoso();
            $trangthai->trangthai = 'CC';
            $trangthai->madonvi = $inputs['madonvi'];
            $trangthai->phanloai = 'dsphongtraothidua';
            $trangthai->mahoso = $inputs['maphongtraotd'];
            $trangthai->thoigian = date('Y-m-d H:i:s');
            $trangthai->save();
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function Xoa(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothidua');
        }
        $inputs = $request->all();
        $model = dsphongtraothidua::findorfail($inputs['id']);
        dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->delete();
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function ThemTieuChuan(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if (!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        //dd($request);
        $inputs = $request->all();
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = getdate()[0] . '_tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['ipf1']);
        }
        //return response()->json($inputs);
        $model = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();
        if ($model == null) {
            $model = new dsphongtraothidua_tieuchuan();
            $model->maphongtraotd = $inputs['maphongtraotd'];
            $model->tentieuchuandhtd = $inputs['tentieuchuandhtd'];
            $model->phanloaidoituong = $inputs['phanloaidoituong'];
            $model->matieuchuandhtd = getdate()[0];
            //$model->batbuoc = $inputs['batbuoc'];
            $model->ghichu = $inputs['ghichu'];
            $model->ipf1 = $inputs['ipf1'] ?? null;
            $model->save();
        } else {
            //$model->batbuoc = $inputs['batbuoc'];
            $model->tentieuchuandhtd = $inputs['tentieuchuandhtd'];
            $model->phanloaidoituong = $inputs['phanloaidoituong'];
            $model->ghichu = $inputs['ghichu'];
            $model->ipf1 = $inputs['ipf1'] ?? null;
            $model->save();
        }

        $modelct = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->orderby('phanloaidoituong')->get();
        if (isset($modelct)) {
            $a_phanloaidt = getPhanLoaiTDKT();
            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="5%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Đối tượng áp dụng</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn xét khen thưởng</th>';
            $result['message'] .= '<th style="text-align: center" width="25%">Ghi chú</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . ($a_phanloaidt[$ct->phanloaidoituong] ?? $ct->phanloaidoituong) . '</td>';
                $result['message'] .= '<td class="active">' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td>' . $ct->ghichu . '</td>';

                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-tieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getTieuChuan(' . $ct->id . ')" ><i class="icon-lg la fa-edit text-dark"></i></button>' .
                    '<button type="button" data-target="#delete-modal" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getId(' . $ct->id . ')"><i class="icon-lg la fa-trash-alt text-danger"></i></button>'
                    . '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
            $result['maphongtraotd']=$inputs['maphongtraotd'];
        }
        return response()->json($result);
    }

    public function XoaTieuChuan(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothidua');
        }
        $inputs = $request->all();
        $model = dsphongtraothidua_tieuchuan::findorfail($inputs['id']);

        $model->delete();
        return redirect(static::$url . 'Sua?maphongtraotd=' . $model->maphongtraotd);
    }

    public function LayTieuChuan(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if (!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        //dd($request);
        $inputs = $request->all();
        $model = dsphongtraothidua_tieuchuan::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';

        if (isset($model->qdkt)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }

        if (isset($model->tailieukhac)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function KetThuc(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongthidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model->trangthai = $inputs['trangthai'];
        $model->thoigian = date('Y-m-d H:i:s');
        $model->save();

        return redirect('/PhongTraoThiDua/ThongTin?madonvi=' . $model->madonvi);
    }

    public function HuyKetThuc(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongthidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model->trangthai = 'CC';
        $model->thoigian = date('Y-m-d H:i:s');
        $model->save();

        return redirect('/PhongTraoThiDua/ThongTin?madonvi=' . $model->madonvi);
    }

    public function DinhKemTieuChuan(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dsphongtraothidua_tieuchuan::where('id', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';

        if (isset($model->ipf1)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu đính kèm:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->ipf1) . '">' . $model->ipf1 . '</a ></div>';
            $result['message'] .= '</div>';
        }

        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
