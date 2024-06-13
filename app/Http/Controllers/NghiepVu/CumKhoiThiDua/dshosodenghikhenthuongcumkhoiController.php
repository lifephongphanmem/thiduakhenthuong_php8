<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstruongcumkhoi;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_detai;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\View\view_dscumkhoi;
use App\Models\View\view_dstruongcumkhoi;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhenthuongcumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
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
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';
        //$m_donvi = getDonViCK(session('admin')->capdo, null, 'MODEL');
        $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongcumkhoi');
        //dd($m_donvi);
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $m_cumkhoi_chitiet = dscumkhoi_chitiet::where('madonvi', $inputs['madonvi'])->get();
        $model = dscumkhoi::wherein('macumkhoi', array_column($m_cumkhoi_chitiet->toarray(), 'macumkhoi'))->get();
        $m_hoso = dshosotdktcumkhoi::where('madonvi', $inputs['madonvi'])->get();
        foreach ($model as $ct) {
            $ct->sohoso = $m_hoso->where('macumkhoi', $ct->macumkhoi)->count();
        }

        //dd($model);
        return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThongTin')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng cụm, khối thi đua');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = view_dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->get();
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['nam'] = $inputs['nam'] ?? date('Y');
        $inputs['maloaihinhkt'] = $inputs['maloaihinhkt'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';
       
        $model = dshosotdktcumkhoi::where('macumkhoi', $inputs['macumkhoi']);
            //->wherein('phanloai', ['KHENTHUONG', 'KTNGANH', 'KHENCAOTHUTUONG' ,'KHENCAOCHUTICHNUOC']);
            //->where('madonvi', $inputs['madonvi']);
        if ($inputs['nam'] != 'ALL') {
            $model = $model->whereyear('ngayhoso', $inputs['nam']);
        }
        if ($inputs['maloaihinhkt'] != 'ALL') {
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);
        }
        $model = $model->orderby('ngayhoso')->get();
//  dd($inputs);
        $model_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        foreach ($model as $hoso) {
            $hoso->soluongkhenthuong = $model_canhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $model_tapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
        }

        $m_cumkhoi = view_dscumkhoi::where('madonvi', $inputs['madonvi'])->get();
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongcumkhoi']['trangthai'] ?? 'CC';
        //Gán đường dẫn
        if ($inputs['trangthai'] == 'CC') {
            //Đi theo quy trình bình thường
            $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
            $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
            $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        } else {
            //Chỉ sử lý ở màn hình "ThongTin"
            $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
            $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
            $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        }

        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        //Thiết lập thông tin trưởng cụm khối (nếu năm nay chưa thiết lập danh sách thì lấy năm trước)
        $inputs['truongcumkhoi'] = chkTruongCumKhoi($inputs['nam'],$inputs['macumkhoi'],$inputs['madonvi']);       
        

        // $a_donviql = array_column($m_cumkhoi->where('macumkhoi',$inputs['macumkhoi'])->madonvi);
        return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.DanhSach')
            ->with('model', $model)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViXetDuyetCumKhoi($inputs['macumkhoi']))
            ->with('a_donvinganh', getDonViXetDuyetCumKhoi($inputs['macumkhoi']))
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng của cụm, khối');
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['phanloai'] = 'KHENTHUONG';
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $inputs['mahosotdkt'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSo($inputs);
        dshosotdktcumkhoi::create($inputs);
        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $inputs['mahinhthuckt'] = session('chucnang')['dshosodenghikhenthuongcumkhoi']['mahinhthuckt'] ?? 'ALL';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $model->tendonvi = $donvi->tendonvi;
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $model->tencumkhoi = dscumkhoi::where('macumkhoi', $model->macumkhoi)->first()->tencumkhoi;
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tailieu = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');


        return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_phongtraotd', array_column(dsphongtraothidua::all()->toArray(), 'noidung', 'maphongtraotd'))
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Hồ sơ khen thưởng');
    }


    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model->tencumkhoi = dscumkhoi::where('macumkhoi', $model->macumkhoi)->first()->tencumkhoi ?? '';
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.Xem')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();

        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->update($inputs);

        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    }

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
        die(json_encode($model));
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        $inputs['trangthai'] = getTrangThaiChuyenHS(session('chucnang')['dshosodenghikhenthuongcumkhoi']['trangthai'] ?? 'CC');
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['lydo'] = ''; //Xóa lý do trả lại
        setChuyenDV_CumKhoi($model, $inputs);

        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    }

    public function XoaHoSo(Request $request)
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
        $model = dshosotdktcumkhoi::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
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
            $inputs['ketqua'] = 1;
            dshosotdktcumkhoi_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function LayCaNhan(Request $request)
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
        die(json_encode($model));
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

        $danhsach = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);


        return response()->json($result);
    }

    public function NhanExcelCaNhan(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tendoituong']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                'gioitinh' => $data[$i][$inputs['gioitinh']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
            );
        }

        dshosotdktcumkhoi_canhan::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
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
            $inputs['ketqua'] = 1;
            dshosotdktcumkhoi_tapthe::create($inputs);
        } else
            $model->update($inputs);

        $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }

    public function LayTapThe(Request $request)
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
        die(json_encode($model));
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

        $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function NhanExcelTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tentapthe']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
            );
        }
        dshosotdktcumkhoi_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
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
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

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

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

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

    public function ThemDeTai(Request $request)
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
        $model = dshosotdktcumkhoi_detai::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosotdktcumkhoi_detai::create($inputs);
        } else
            $model->update($inputs);

        $model = dshosotdktcumkhoi_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $this->htmlDeTai($result, $model);
        return response()->json($result);
    }

    public function LayDeTai(Request $request)
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
        $model = dshosotdktcumkhoi_detai::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaDeTai(Request $request)
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
        $model = dshosotdktcumkhoi_detai::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosotdktcumkhoi_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlDeTai($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelDeTai(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tensangkien']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tensangkien' => $data[$i][$inputs['tensangkien']] ?? '',
                'donvicongnhan' => $data[$i][$inputs['donvicongnhan']] ?? '',
                'thoigiancongnhan' => $data[$i][$inputs['thoigiancongnhan']] ?? '',
                'thanhtichdatduoc' => $data[$i][$inputs['thanhtichdatduoc']] ?? '',
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
            );
        }
        dshosotdktcumkhoi_detai::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }


    function htmlDeTai(&$result, $model)
    {
        if (isset($model)) {
            $result['message'] = '<div class="row" id="dsdetai">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_5" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên đề tài, sáng kiến</th>';
            $result['message'] .= '<th>Thông tin tác giả</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tensangkien . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->tendoituong . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getDeTai(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-detai" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delDeTai(' . $tt->id . ', &#39;' . static::$url . 'XoaDeTai&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-detai" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

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

    // public function TaiLieuDinhKem(Request $request)
    // {
    //     $result = array(
    //         'status' => 'fail',
    //         'message' => 'error',
    //     );

    //     $inputs = $request->all();
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahs'])->first();
    //     $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
    //     if ($model->totrinh != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->qdkt != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->bienban != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->tailieukhac != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     $result['message'] .= '</div>';
    //     $result['status'] = 'success';

    //     die(json_encode($result));
    // }

    // public function QuyetDinh(Request $request)
    // {
    //     $inputs = $request->all();
    //     //dd();
    //     $inputs['url'] = static::$url;
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $inputs['madonvi'] = $model->madonvi;
    //     getTaoDuThaoKTCumKhoi($model);
    //     $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
    //     $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
    //     return view('BaoCao.DonVi.QuyetDinh.MauChung')
    //         ->with('model', $model)
    //         ->with('a_duthao', $a_duthao)
    //         ->with('inputs', $inputs)
    //         ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    // }

    // public function DuThaoQuyetDinh(Request $request)
    // {
    //     $inputs = $request->all();
    //     $inputs['url'] = static::$url;
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $model->thongtinquyetdinh = '';
    //     $inputs['madonvi'] = $model->madonvi_xd;
    //     $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
    //     $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
    //     getTaoDuThaoKTCumKhoi($model, $inputs['maduthao']);

    //     return view('BaoCao.DonVi.QuyetDinh.MauChung')
    //         ->with('model', $model)
    //         ->with('a_duthao', $a_duthao)
    //         ->with('inputs', $inputs)
    //         ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    // }

    // public function LuuQuyetDinh(Request $request)
    // {
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
    //     $model->save();
    //     return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    // }

    // public function PheDuyet(Request $request)
    // {
    //     $inputs = $request->all();
    //     $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
    //     $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi//HoSo/';
    //     $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi//HoSo/';
    //     $inputs['mahinhthuckt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['mahinhthuckt'] ?? 'ALL';
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
    //     $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
    //     $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();
    //     $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
    //     $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
    //     $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
    //     $model->tendonvi = $donvi->tendonvi;
    //     $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
    //     $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
    //     //Gán thông tin đơn vị khen thưởng
    //     $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();

    //     $model->capkhenthuong =  $donvi_kt->capdo;
    //     $model->donvikhenthuong =  $donvi_kt->tendvhienthi;

    //     return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.PheDuyetKT')
    //         ->with('model', $model)
    //         ->with('model_canhan', $model_canhan)
    //         ->with('model_tapthe', $model_tapthe)
    //         ->with('model_detai', $model_detai)
    //         ->with('a_dhkt_canhan', $a_dhkt_canhan)
    //         ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
    //         ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
    //         ->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
    //         ->with('a_tapthe', $a_tapthe)
    //         ->with('a_canhan', $a_canhan)
    //         ->with('inputs', $inputs)
    //         ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    // }

    // public function LuuPheDuyet(Request $request)
    // {
    //     $inputs = $request->all();
    //     if (isset($inputs['quyetdinh'])) {
    //         $filedk = $request->file('quyetdinh');
    //         $inputs['quyetdinh'] = $inputs['mahosotdkt'] . '_quyetdinh.' . $filedk->getClientOriginalExtension();
    //         $filedk->move(public_path() . '/data/quyetdinh/', $inputs['quyetdinh']);
    //     }
    //     $thoigian = date('Y-m-d H:i:s');
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $model->trangthai = 'DKT';
    //     //gán trạng thái hồ sơ để theo dõi
    //     $model->trangthai_xd = $model->trangthai;
    //     $model->trangthai_kt = $model->trangthai;
    //     $model->thoigian_kt = $thoigian;

    //     $model->donvikhenthuong = $inputs['donvikhenthuong'];
    //     $model->capkhenthuong = $inputs['capkhenthuong'];
    //     $model->soqd = $inputs['soqd'];
    //     $model->ngayqd = $inputs['ngayqd'];
    //     $model->chucvunguoikyqd = $inputs['chucvunguoikyqd'];
    //     $model->hotennguoikyqd = $inputs['hotennguoikyqd'];
    //     //dd($model);
    //     getTaoQuyetDinhKTCumKhoi($model);
    //     $model->save();
    //     trangthaihoso::create([
    //         'mahoso' => $inputs['mahosotdkt'],
    //         'phanloai' => 'dshosotdktcumkhoi',
    //         'trangthai' => $model->trangthai,
    //         'thoigian' => $thoigian,
    //         'madonvi' => $inputs['madonvi'],
    //         'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
    //     ]);
    //     return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    // }

    // public function HuyPheDuyet(Request $request)
    // {
    //     $inputs = $request->all();
    //     $thoigian = date('Y-m-d H:i:s');
    //     $trangthai = 'CXKT';
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();

    //     $model->trangthai = $trangthai;
    //     $model->trangthai_xd = $model->trangthai;
    //     $model->trangthai_kt = $model->trangthai;
    //     $model->thoigian_kt = null;

    //     $model->donvikhenthuong = null;
    //     $model->capkhenthuong = null;
    //     $model->soqd = null;
    //     $model->ngayqd = null;
    //     $model->chucvunguoikyqd = null;
    //     $model->hotennguoikyqd = null;
    //     //dd($model);
    //     $model->save();
    //     trangthaihoso::create([
    //         'mahoso' => $inputs['mahosotdkt'],
    //         'phanloai' => 'dshosotdktcumkhoi',
    //         'trangthai' => $model->trangthai,
    //         'thoigian' => $thoigian,
    //         'madonvi' => $inputs['madonvi'],
    //         'thongtin' => 'Hủy phê duyệt đề nghị khen thưởng.',
    //     ]);
    //     return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    // }

    public function ToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhHoSoCumKhoi($model, $inputs['maduthao']);
        $a_duthao = array_column(duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->get()->toArray(), 'noidung', 'maduthao');

        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChungToTrinh')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình khen thưởng');
    }

    public function LuuToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
        $model->save();
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    }

    // public function InToTrinhHoSo(Request $request)
    // {
    //     $inputs = $request->all();
    //     $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     getTaoDuThaoToTrinhHoSoCumKhoi($model);
    //     $model->thongtinquyetdinh = $model->thongtintotrinhhoso;
    //     $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
    //     //dd($model);
    //     return view('BaoCao.DonVi.XemQuyetDinh')
    //         ->with('model', $model)
    //         ->with('pageTitle', 'Tờ trình khen thưởng');
    // }

    public function NhanExcel(Request $request)
    {
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelCumKhoi($request);
        return redirect(static::$url . 'Sua?mahosotdkt=' . $request->all()['mahoso']);
    }
}
