<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvu_tailieuController;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_detai;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\View\view_dscumkhoi;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class xetduyethosokhenthuongcumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
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
        if (!chkPhanQuyen('xdhosokhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = getDonViXetDuyetHoSoCumKhoi(session('admin')->capdo, 'MODEL');
        if ($m_donvi->count() == 0) {
            return view('errors.403')
                ->with('message', 'Chưa có đơn vị được phân công nhiệm xét duyệt hồ sơ đề nghị khen thưởng cho cụm, khối thi đua.')
                ->with('url', '/');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        // $model = dscumkhoi::where('madonvixd', $inputs['madonvi'])->get();
        $model = dscumkhoi::all();
        $m_hoso = dshosotdktcumkhoi::wherein('macumkhoi', array_column($model->toarray(), 'macumkhoi'))
            ->where('madonvi_xd', $inputs['madonvi'])->get();
        $a_trangthai = array_unique(array_column($m_hoso->toarray(), 'trangthai'));
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        // dd($a_donvilocdulieu);
        //dd($model);
        foreach ($model as $key => $chitiet) {
            $hoso = $m_hoso->where('macumkhoi', $chitiet->macumkhoi);
            foreach ($a_trangthai as $trangthai) {
                $chitiet->$trangthai = $hoso->where('trangthai', $trangthai)->count();
            }
            $chitiet->tonghoso = $hoso->count();
            if (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($chitiet->macumkhoi, $a_donvilocdulieu))
                    $model->forget($key);
            }
        }
        //dd($model);
        $inputs['url_xd'] = static::$url;
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';


        return view('NghiepVu.CumKhoiThiDua.HoSoKT.DanhSach')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthai_hoso', $a_trangthai)
            ->with('a_trangthai', getTrangThaiHoSo())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng của cụm, khối');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $m_donvi = getDonViXetDuyetHoSoCumKhoi(session('admin')->capdo, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        //dd($m_donvi);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        //lấy danh sách lọc cụm khối theo tài khoản

        //
        $m_cumkhoi = view_dscumkhoi::where('madonvi', $inputs['madonvi'])->get();
        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? $m_cumkhoi->first()->macumkhoi;
        $model = dshosotdktcumkhoi::where('macumkhoi', $inputs['macumkhoi'])
            ->where('madonvi_xd', $inputs['madonvi'])->get();
        //--lấy địa bàn quản lý theo tài khoản
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        //--
        $m_khencanhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        $m_khentapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();

        foreach ($model as $key => $hoso) {
            $hoso->soluongkhenthuong = $m_khencanhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $m_khentapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
            //Gán lại trạng thái hồ sơ
            $hoso->madonvi_hoso = $hoso->madonvi_xd;
            $hoso->trangthai_hoso = $hoso->trangthai_xd;
            $hoso->thoigian_hoso = $hoso->thoigian_xd;
            $hoso->lydo_hoso = $hoso->lydo_xd;
            $hoso->madonvi_nhan_hoso = $hoso->madonvi_kt;
            //lọc theo địa bàn
            if (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->macumkhoi, $a_donvilocdulieu))
                    $model->forget($key);
            }
        }
        //  dd($model);
        $inputs['trangthai'] = session('chucnang')['xdhosokhenthuongcumkhoi']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        //dd($inputs);
        return view('NghiepVu.CumKhoiThiDua.XetDuyetHoSoKhenThuong.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViPheDuyetCumKhoi($inputs['macumkhoi']))
            // ->with('a_donviql', getDonViQuanLyCumKhoi($inputs['macumkhoi']))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Danh sách hồ sơ thi đua');
    }

    public function TraLai(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //dd($model);
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiXDCK($model, $inputs);
        return redirect(static::$url . 'DanhSach?madonvi=' . $inputs['madonvi'] . '&macumkhoi=' . $model->macumkhoi);
    }

    public function NhanHoSo(Request $request)
    {
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        $model->trangthai = 'DD';
        $model->trangthai_xd = 'DD';
        $model->thoigian_xd = $thoigian;
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosotdktcumkhoi',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Tiếp nhận hồ sơ đề nghị khen thưởng.',
        ]);

        return redirect(static::$url . 'DanhSach?madonvi=' . $inputs['madonvi_nhan'] . '&macumkhoi=' . $model->macumkhoi);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodenghikhenthuongchuyende')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'CXKT';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->madonvi_nhan_xd = $inputs['madonvi_nhan'];

        $model->madonvi_kt = $inputs['madonvi_nhan'];
        $model->trangthai_kt = $model->trangthai;
        $model->thoigian_kt = $thoigian;
        getTaoDuThaoKT($model);
        $model->save();

        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosotdktcumkhoi',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi_nhan' => $inputs['madonvi_nhan'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Trình đề nghị khen thưởng.',
        ]);

        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi);
    }

    public function XetKT(Request $request)
    {
        if (!chkPhanQuyen('xdhosodenghikhenthuongchuyende', 'thaydoi')) {
            return view('errors.noperm')
                ->with('machucnang', 'xdhosodenghikhenthuongchuyende')
                ->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['url'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $inputs['mahinhthuckt'] = session('chucnang')['xdhosokhenthuongcumkhoi']['mahinhthuckt'] ?? 'ALL';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $model->tendonvi = $donvi->tendonvi;
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        return view('NghiepVu.CumKhoiThiDua.XetDuyetHoSoKhenThuong.XetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_danhhieutd', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function ThemTapThe(Request $request)
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
        //$id =  $inputs['id'];       
        $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosotdktcumkhoi_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $model = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $this->htmlTapThe($result, $model);
        return response()->json($result);
        //return die(json_encode($result));
    }

    public function XoaTapThe(Request $request)
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
        $model = dshosotdktcumkhoi_tapthe::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlTapThe($result, $m_tapthe);
        return response()->json($result);
    }

    public function ThemCaNhan(Request $request)
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
        //$id =  $inputs['id'];       
        $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosotdktcumkhoi_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $model = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $this->htmlCaNhan($result, $model);
        return response()->json($result);
    }

    public function XoaCaNhan(Request $request)
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
        $model = dshosotdktcumkhoi_canhan::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
        return response()->json($result);
    }

    function htmlCaNhan(&$result, $model)
    {
        if (isset($model)) {
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');

            $result['message'] = '<div class="row" id="dskhenthuongcanhan">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Tên đối tượng</th>';
            $result['message'] .= '<th width="8%">Ngày sinh</th>';
            $result['message'] .= '<th width="5%">Giới</br>tính</th>';
            $result['message'] .= '<th width="15%">Phân loại cán bộ</th>';
            $result['message'] .= '<th>Thông tin công tác</th>';
            $result['message'] .= '<th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
                $result['message'] .= '<td class="text-center">' . getDayVn($tt->ngaysinh) . '</td>';
                $result['message'] .= '<td>' . $tt->gioitinh . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaicanbo] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';
                $result['message'] .= '<td class="text-center"> ' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-check text-primary icon-2x"></i></button></td>';
                else
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></button></td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';
                // $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                //                                                     <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    function htmlTapThe(&$result, $model)
    {
        if (isset($model)) {
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tập thể</th>';
            $result['message'] .= '<th>Phân loại<br>tập thể</th>';
            $result['message'] .= '<th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"> ' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><a class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-check text-primary icon-2x"></i></a></td>';
                else
                    $result['message'] .= '<td class="text-center"><a class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></a></td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';
                // $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                //                                                     <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';

            $result['status'] = 'success';
        }
    }

    public function GanKhenThuong(Request $request)
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
        //dd($inputs);
        if ($inputs['phanloai'] == 'TAPTHE') {
            dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $this->htmlTapThe($result, $model);
        } else {
            dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $this->htmlCaNhan($result, $model);
        }

        return response()->json($result);
    }

    // public function QuyetDinh(Request $request)
    // {
    //     $inputs = $request->all();
    //     $inputs['url'] = static::$url;
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $inputs['madonvi'] = $model->madonvi_xd;
    //     if ($model->thongtinquyetdinh == '') {
    //         $thongtinquyetdinh = duthaoquyetdinh::all()->first()->codehtml ?? '';
    //         //noidung
    //         $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
    //         //chucvunguoiky
    //         $thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $thongtinquyetdinh);
    //         //hotennguoiky
    //         $thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoiky, $thongtinquyetdinh);

    //         $m_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
    //         if ($m_canhan->count() > 0) {
    //             $s_canhan = '';
    //             $i = 1;
    //             foreach ($m_canhan as $canhan) {
    //                 $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
    //                     ($i++) . '. ' . $canhan->tendoituong .
    //                     ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
    //                     ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
    //                     '</p>';
    //                 //dd($s_canhan);
    //             }
    //             //dd($s_canhan);
    //             // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
    //             $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
    //         }

    //         //Tập thể
    //         $m_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
    //         if ($m_tapthe->count() > 0) {
    //             $s_tapthe = '';
    //             $i = 1;
    //             foreach ($m_tapthe as $chitiet) {
    //                 $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
    //                     ($i++) . '. ' . $chitiet->tentapthe .
    //                     '</p>';
    //             }
    //             $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
    //         }
    //         $model->thongtinquyetdinh = $thongtinquyetdinh;
    //     }
    //     //dd($inputs);
    //     $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
    //     $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
    //     return view('BaoCao.DonVi.QuyetDinh.MauChung')
    //         ->with('model', $model)
    //         ->with('a_duthao', $a_duthao)
    //         ->with('inputs', $inputs)
    //         ->with('pageTitle', 'Quyết định khen thưởng');
    // }

    // public function InQuyetDinh(Request $request)
    // {
    //     $inputs = $request->all();
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     // if ($model->thongtinquyetdinh == '') {
    //     //     $model->thongtinquyetdinh = getQuyetDinhCKE('QUYETDINH');
    //     // }
    //     $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
    //     //dd($model);
    //     return view('BaoCao.DonVi.XemQuyetDinh')
    //         ->with('model', $model)
    //         ->with('pageTitle', 'Quyết định khen thưởng');
    // }

    // public function DuThaoQuyetDinh(Request $request)
    // {
    //     $inputs = $request->all();
    //     $inputs['url'] = static::$url;
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
    //     $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
    //     $thongtinquyetdinh = duthaoquyetdinh::where('maduthao', $inputs['maduthao'])->first()->codehtml ?? '';
    //     //noidung
    //     $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
    //     //chucvunguoiky
    //     $thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $thongtinquyetdinh);
    //     //hotennguoiky
    //     $thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoiky, $thongtinquyetdinh);

    //     $m_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
    //     if ($m_canhan->count() > 0) {
    //         $s_canhan = '';
    //         $i = 1;
    //         foreach ($m_canhan as $canhan) {
    //             $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
    //                 ($i++) . '. ' . $canhan->tendoituong .
    //                 ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
    //                 ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
    //                 '</p>';
    //             //dd($s_canhan);
    //         }
    //         //dd($s_canhan);
    //         // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
    //         $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
    //     }

    //     //Tập thể
    //     $m_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
    //     if ($m_tapthe->count() > 0) {
    //         $s_tapthe = '';
    //         $i = 1;
    //         foreach ($m_tapthe as $chitiet) {
    //             $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
    //                 ($i++) . '. ' . $chitiet->tentapthe .
    //                 '</p>';
    //         }
    //         $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
    //     }
    //     $model->thongtinquyetdinh = $thongtinquyetdinh;

    //     return view('BaoCao.DonVi.QuyetDinh.CongHien')
    //         ->with('model', $model)
    //         ->with('a_duthao', $a_duthao)
    //         ->with('inputs', $inputs)
    //         ->with('pageTitle', 'Quyết định khen thưởng');
    // }

    // public function LuuQuyetDinh(Request $request)
    // {
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
    //     $model->save();
    //     return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd);
    // }

    public function LayLyDo(Request $request)
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
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->lydo = $model->lydo_xd;
        die(json_encode($model));
    }

    public function ToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhPheDuyetCumKhoi($model, $inputs['maduthao']);
        $a_duthao = array_column(duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->get()->toArray(), 'noidung', 'maduthao');

        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChungToTrinhKT')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình khen thưởng');
    }

    public function LuuToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
        $model->save();
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd);
    }

    public function TrinhKetQua(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['url'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        // $model_tailieu = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', 'TOTRINHKQ')->first();
        $model_tailieu = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        // $model->totrinhdenghi = $model_tailieu->tentailieu ?? '';
        return view('NghiepVu.CumKhoiThiDua.XetDuyetHoSoKhenThuong.TrinhKetQua')
            ->with('model', $model)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuTrinhKetQua(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->update($inputs);
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi);
    }
}
