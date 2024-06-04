<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi_tieuchuan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Models\View\view_dscumkhoi;
use App\Models\View\view_dstruongcumkhoi;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dsphongtraothiduacumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/PhongTraoThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothiduacumkhoi');
        }
        
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        //2023.11.28 Chỉ các đơn vị trưởng cụm khối mới thêm đc phong trào
        
        $model_donvi = getDonViTruongCumKhoi('MODEL');
        // $m_donvi=dsdonvi::wherein('madonvi',array_column($model_donvi->toarray(),'madonvi'))->get();
        $a_madonvi=array_column($model_donvi->toarray(),'madonvi'); 
        $m_donvi = getDonVi(session('admin')->capdo, 'dsphongtraothiduacumkhoi');
        // $m_donvi=$m_donvi->wherein('madonvi',$a_madonvi);      
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        
    //    dd($m_diaban);
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        // dd($inputs['madonvi']);
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        // $m_cumkhoi = view_dscumkhoi::where('madonvi', $inputs['madonvi'])->get();
        // dd($m_cumkhoi);
        $m_cumkhoi = view_dscumkhoi::all();

        // dd($m_cumkhoi);
        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? $m_cumkhoi->first()->macumkhoi;
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';
        $model = dsphongtraothiduacumkhoi::where('madonvi', $inputs['madonvi']);
        $truongcumkhoi=view_dstruongcumkhoi::where('macumkhoi',$inputs['macumkhoi'])->orderBy('ngayden','desc')->first();
        if(isset($truongcumkhoi)){
            if($truongcumkhoi->madonvi == $inputs['madonvi']){
                $inputs['thaotacthem']=true;
            }else{
                $inputs['thaotacthem']=false;
            }
        }else{
            $inputs['thaotacthem']=false;
        }
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereYear('ngayqd', $inputs['nam']);
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);
        $model=$model->orderby('ngayqd')->get();
        // dd($model->get());

        $m_hoso=dshosothamgiathiduacumkhoi::wherein('maphongtraotd',array_column($model->toarray(),'maphongtraotd'))->get();
        $m_hoso_denghi=dshosotdktcumkhoi::wherein('maphongtraotd',array_column($model->toarray(),'maphongtraotd'))->get();
        foreach($model as $ct)
        {
            // dd($m_hoso->where('maphongtraotd',$ct->maphongtraotd));
            $sohoso_thamgia=count($m_hoso->where('maphongtraotd',$ct->maphongtraotd)->wherein('trangthai', ['CD', 'DD', 'CNXKT', 'DXKT', 'CXKT', 'DKT']));
            $ct->sohoso_thamgia=$sohoso_thamgia;
            $ct->sohoso_kt=count($m_hoso_denghi->where('maphongtraotd',$ct->maphongtraotd));
        }
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.DanhSachPhongTrao.ThongTin')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_cumkhoi', $m_cumkhoi->unique('macumkhoi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao($m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo ?? 'T'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothiduacumkhoi');
        }

        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['maphongtraotd'] = $inputs['maphongtraotd'] ?? null;
        $model = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $model->madonvi;
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';
        
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();

        if ($model == null) {
            $model = new dsphongtraothiduacumkhoi();
            $model->madonvi = $inputs['madonvi'];
            $model->maphongtraotd = $inputs['maphongtraotd']??getdate()[0];
            $model->trangthai = 'CC';
            $model->phanloai = $donvi->capdo;
            // $model->macumkhoi = $inputs['macumkhoi'];
            $model->maloaihinhkt = session('chucnang')['dsphongtraothiduacumkhoi']['mahinhthuckt'] ?? '';
            // $model->save();
        }
        // dd($model);
        $m_cumkhoi = view_dscumkhoi::where('madonvi', $inputs['madonvi'])->get();
        // $m_cumkhoi = dscumkhoi::where('macumkhoi', $model->macumkhoi)->get();//lấy cụm khối theo đơn vị
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->orderby('phanloaidoituong')->get();
        // dd($model_tieuchuan);
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.DanhSachPhongTrao.ThayDoi')
            ->with('model', $model)
            ->with('model_tieuchuan', $model_tieuchuan)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('a_cumkhoi', array_column($m_cumkhoi->toArray(), 'tencumkhoi', 'macumkhoi'))
            ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_phamvi', getPhamViPhatDongPhongTrao($donvi->capdo))
            ->with('a_phanloaidt', getPhanLoaiTDKT())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua trong cụm, khối');
    }

    public function XemThongTin(Request $request)
    {
        $inputs = $request->all();
        $model = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model_tieuchi = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->orderby('phanloaidoituong')->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $cumkhoi=dscumkhoi::where('macumkhoi',$model->macumkhoi)->first();
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.DanhSachPhongTrao.InPhongTrao')
            ->with('model', $model)
            ->with('model_tieuchi', $model_tieuchi)
            ->with('m_donvi', $m_donvi)
            ->with('cumkhoi', $cumkhoi)
            ->with('a_phamvi', getPhamViPhongTrao('T'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('a_phanloaidt', getPhanLoaiTDKT())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function LuuPhongTrao(Request $request)
    {

        if (!chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothiduacumkhoi');
        }
        $inputs = $request->all();
        // dd($inputs);
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

        $model = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        if ($model == null) {
            $inputs['trangthai'] = 'CC';
            dsphongtraothiduacumkhoi::create($inputs);

            $trangthai = new trangthaihoso();
            $trangthai->trangthai = 'CC';
            $trangthai->madonvi = $inputs['madonvi'];
            $trangthai->phanloai = 'dsphongtraothiduacumkhoi';
            $trangthai->mahoso = $inputs['maphongtraotd'];
            $trangthai->thoigian = date('Y-m-d H:i:s');
            $trangthai->save();
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function delete(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothiduacumkhoi');
        }
        $inputs = $request->all();
        $model = dsphongtraothiduacumkhoi::findorfail($inputs['iddelete']);
        dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->delete();
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function ThemKhenThuong(Request $request)
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
        $m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        $model = dsphongtraothidua_khenthuong::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->first();
        if ($model == null) {
            $model = new dsphongtraothidua_khenthuong();
            $model->madanhhieutd = $m_danhhieu->madanhhieutd;
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
            $model->maphongtraotd = $inputs['maphongtraotd'];
            $model->soluong = $inputs['soluong'];
            $model->tendanhhieutd = $m_danhhieu->tendanhhieutd;
            $model->phanloai = $m_danhhieu->phanloai;
            $model->save();
            $m_tieuchuan = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();
            foreach ($m_tieuchuan as $tieuchuan) {
                $model = new dsphongtraothidua_tieuchuan();
                $model->maphongtraotd = $inputs['maphongtraotd'];
                $model->madanhhieutd = $tieuchuan->madanhhieutd;
                $model->matieuchuandhtd = $tieuchuan->matieuchuandhtd;
                $model->tentieuchuandhtd = $tieuchuan->tentieuchuandhtd;
                $model->cancu = $tieuchuan->cancu;
                $model->batbuoc = 1;
                $model->save();
            }
        } else {
            $model->soluong = $inputs['soluong'];
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
            $model->tendanhhieutd = $m_danhhieu->tendanhhieutd;
            $model->phanloai = $m_danhhieu->phanloai;
            $model->save();
        }

        $modelct = dsphongtraothidua_khenthuong::where('maphongtraotd', $inputs['maphongtraotd'])->get();
        $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dskhenthuong">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center" width="25%">Phân loại</th>';
            $result['message'] .= '<th style="text-align: center">Danh hiệu thi đua</th>';
            $result['message'] .= '<th style="text-align: center">Hình thức khen thưởng</th>';
            $result['message'] .= '<th style="text-align: center" width="8%">Số lượng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->phanloai . '</td>';
                $result['message'] .= '<td class="active">' . $ct->tendanhhieutd . '</td>';
                $result['message'] .= '<td>' . ($a_hinhthuckt[$ct->mahinhthuckt] ?? '') . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->soluong . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->madanhhieutd . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i></button>' .
                    '<button title="Xóa" type="button" onclick="getId(' . $ct->id . ')"  class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal" data-toggle="modal">  <i class="icon-lg la fa-trash-alt text-danger"></i></button>' .
                    '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        die(json_encode($result));
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

        $inputs = $request->all();
        $model = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();

        if ($model == null) {
            $model = new dsphongtraothiduacumkhoi_tieuchuan();
            $model->maphongtraotd = $inputs['maphongtraotd'];
            $model->tentieuchuandhtd = $inputs['tentieuchuandhtd'];
            $model->phanloaidoituong = $inputs['phanloaidoituong'];
            $model->matieuchuandhtd = getdate()[0];
            $model->batbuoc = $inputs['batbuoc'];
            $model->save();
        } else {
            $model->batbuoc = $inputs['batbuoc'];
            $model->tentieuchuandhtd = $inputs['tentieuchuandhtd'];
            $model->phanloaidoituong = $inputs['phanloaidoituong'];
            $model->save();
        }
        $modelct = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->orderby('phanloaidoituong')->get();
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
            $result['message'] .= '<th style="text-align: center" width="10%">Tiêu chuẩn</br>Bắt buộcc</th>';
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

                if ($ct->batbuoc == 0) {
                    $result['message'] .= '<td style="text-align: center"></td>';
                } else {
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">'
                        . '<i class="icon-lg la fa-check text-success"></i></button></td>';
                }

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
        die(json_encode($result));
    }

    public function XoaTieuChuan(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothiduacumkhoi');
        }
        $inputs = $request->all();
        $model = dsphongtraothiduacumkhoi_tieuchuan::findorfail($inputs['id']);
        $model->delete();
        // return redirect(static::$url . 'Them?madonvi='.$inputs['madonvi'].'&maphongtraotd=' . $model->maphongtraotd);
        return redirect(static::$url . 'Sua?madonvi='.$inputs['madonvi'].'&maphongtraotd=' . $model->maphongtraotd);
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
        $model = dsphongtraothiduacumkhoi_tieuchuan::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['mahs'])->first();
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

    public function GanTrangThai(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $model = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model->trangthai = $inputs['trangthai'];
        $model->thoigian = date('Y-m-d H:i:s');
        $model->save();

        return redirect('/CumKhoiThiDua/PhongTraoThiDua/ThongTin?madonvi=' . $model->madonvi);
    }
    public function Xoa(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsphongtraothiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $id=$request->id;
        $model=dsphongtraothiduacumkhoi::findOrFail($id);
        if(isset($model)){
            $model->delete();
        }

        return redirect('/CumKhoiThiDua/PhongTraoThiDua/ThongTin');
    }
}
