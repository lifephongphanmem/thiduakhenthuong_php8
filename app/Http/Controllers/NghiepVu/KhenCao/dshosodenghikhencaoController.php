<?php

namespace App\Http\Controllers\NghiepVu\KhenCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tailieu;
use App\Models\NghiepVu\KhenCao\dshosokhencao;
use App\Models\NghiepVu\KhenCao\dshosokhencao_canhan;
use App\Models\NghiepVu\KhenCao\dshosokhencao_hogiadinh;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhencaoController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenCao/HoSoDeNghi/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = static::$url;
        $inputs['url_xd'] = '/KhenCao/XetDuyetHoSoDN/';
        $inputs['url_qd'] = '/KhenCao/PeDuyetDeNghi/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosokhencao';
        $inputs['url_tailieudinhkem']='/DungChung/DinhKemHoSoKhenCao';

        $m_donvi = getDonVi(session('admin')->capdo);
        // $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhencao');

        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhencao']['maloaihinhkt'] ?? 'ALL';
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhencao']['trangthai'] ?? 'CC';


        $model = dshosokhencao::where('madonvi', $inputs['madonvi']);
        //->where('maloaihinhkt', $inputs['maloaihinhkt']);

        //->orderby('ngayhoso')->get();

        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);
        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();
        $model_canhan = dshosokhencao_canhan::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $model_tapthe = dshosokhencao_tapthe::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        foreach ($model as $hoso) {
            $hoso->soluongkhenthuong = $model_canhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $model_tapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
        }

        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        $model_hoso = dshosokhencao::where(function ($qr) use ($inputs) {
            $qr->where('madonvi_xd', $inputs['madonvi'])->orwhere('madonvi_kt', $inputs['madonvi']);
        })->get();

        return view('NghiepVu.KhenCao.HoSoDeNghi.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('model_hoso', $model_hoso)
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('a_donviql', getDonViXetDuyetDiaBan($donvi))
            ->with('a_donvinganh', getDonViQuanLyNganh($donvi))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENCAO'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ đề nghị khen thưởng chuyên đề');
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['phanloai'] = 'KHENTHUONG';

        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSo($inputs);
        //Lưu nhật ký
        dshosokhencao::create($inputs);
        $trangthai = new trangthaihoso();
        $trangthai->trangthai = $inputs['trangthai'];
        $trangthai->madonvi = $inputs['madonvi'];
        $trangthai->thongtin = "Thêm mới hồ sơ đề nghị khen thưởng";
        $trangthai->phanloai = 'dshosodenghikhencao';
        $trangthai->mahoso = $inputs['mahosotdkt'];
        $trangthai->thoigian = $inputs['ngayhoso'];
        $trangthai->save();

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }
    
    public function ThemTongHop(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();

        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['phanloai'] = 'KHENTHUONG';
        //lấy danh sách chi tiết
        if (isset($inputs['hoso'])) {
            $a_hoso = array_keys($inputs['hoso']);
            //Cá nhân
            $m_canhan = dshosokhencao_canhan::wherein('mahosotdkt', $a_hoso)->where('ketqua', 1)->get();
            $a_canhan = [];
            foreach ($m_canhan as $canhan) {
                $a_canhan[] = [
                    'mahosotdkt' => $inputs['mahosotdkt'],
                    'maccvc' => $canhan->maccvc,
                    'socancuoc' => $canhan->socancuoc,
                    'tendoituong' => $canhan->tendoituong,
                    'ngaysinh' => $canhan->ngaysinh,
                    'gioitinh' => $canhan->gioitinh,
                    'chucvu' => $canhan->chucvu,
                    'diachi' => $canhan->diachi,
                    'tencoquan' => $canhan->tencoquan,
                    'tenphongban' => $canhan->tenphongban,
                    'maphanloaicanbo' => $canhan->maphanloaicanbo,
                    'ketqua' => 1,
                    'madanhhieukhenthuong' => $canhan->madanhhieukhenthuong,
                ];
            }
            dshosokhencao_canhan::insert($a_canhan);
            //Tập thể
            $m_tapthe = dshosokhencao_tapthe::wherein('mahosotdkt', $a_hoso)->where('ketqua', 1)->get();
            $a_tapthe = [];
            foreach ($m_tapthe as $tapthe) {
                $a_tapthe[] = [
                    'mahosotdkt' => $inputs['mahosotdkt'],
                    'ketqua' => 1,
                    'madanhhieukhenthuong' => $tapthe->madanhhieukhenthuong,
                    'linhvuchoatdong' => $tapthe->linhvuchoatdong,
                    'maphanloaitapthe' => $tapthe->maphanloaitapthe,
                    'tentapthe' => $tapthe->tentapthe,
                ];
            }
            dshosokhencao_tapthe::insert($a_tapthe);
            //Hộ gia đình
            $m_hogiadinh = dshosokhencao_hogiadinh::wherein('mahosotdkt', $a_hoso)->where('ketqua', 1)->get();
            $a_hogiadinh = [];
            foreach ($m_hogiadinh as $hogiadinh) {
                $a_hogiadinh[] = [
                    'mahosotdkt' => $inputs['mahosotdkt'],
                    'ketqua' => 1,
                    'madanhhieukhenthuong' => $hogiadinh->madanhhieukhenthuong,
                    'linhvuchoatdong' => $hogiadinh->linhvuchoatdong,
                    'maphanloaitapthe' => $hogiadinh->maphanloaitapthe,
                    'tentapthe' => $hogiadinh->tentapthe,
                ];
            }
            dshosokhencao_hogiadinh::insert($a_hogiadinh);
            //Cập nhật trạng thái hồ sơ
            dshosokhencao::wherein('mahosotdkt', $a_hoso)->update(['trangthai' => 'DTH', 'trangthai_xd' => 'DTH']);
        }

        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSo($inputs);
        //Lưu nhật ký
        dshosokhencao::create($inputs);
        $trangthai = new trangthaihoso();
        $trangthai->trangthai = $inputs['trangthai'];
        $trangthai->madonvi = $inputs['madonvi'];
        $trangthai->thongtin = "Thêm mới hồ sơ đề nghị khen thưởng";
        $trangthai->phanloai = 'dshosothiduakhenthuong';
        $trangthai->mahoso = $inputs['mahosotdkt'];
        $trangthai->thoigian = $inputs['ngayhoso'];
        $trangthai->save();

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['url_hs'] = static::$url;

        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosokhencao';

        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosokhencao_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosokhencao_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosokhencao_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tailieu = dshosokhencao_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        //30.03.2023 Hồ sơ đề nghị thì mở hết danh hiệu để chọn do đề nghị là gửi cấp trên 
        $a_dhkt_canhan = getDanhHieuKhenThuong('ALL');
        $a_dhkt_tapthe = getDanhHieuKhenThuong('ALL', 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong('ALL', 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        $inputs['mahinhthuckt'] = $model->mahinhthuckt;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        return view('NghiepVu.KhenCao.HoSoDeNghi.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_canhan', $a_canhan)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng chuyên đề');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        //$model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosokhencao_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosokhencao_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        //$model_detai = dshosodenghikhencao_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosokhencao_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('NghiepVu.KhenCao.HoSoDeNghi.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }



    public function LuuHoSo(Request $request)
    {

        if (!chkPhanQuyen('dshosodenghikhencao', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first()->update($inputs);

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
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
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        die(json_encode($model));
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahoso'])->first();
        //đơn vị sử dụng trạng thái CXKT => hồ sơ chuyển đi sẽ có trạng thái CXKT vì đã có đơn vị khen thưởng trong lúc tạo hồ so
        //đơn vị sử dụng trạng thái CC => hồ sơ chuyển đi sẽ có trạng thái DD để đơn vị xét duyệt chuyển cho đơn vị cấp trên
        // $trangthai = session('chucnang')['dshosodenghikhencao']['trangthai'] ?? 'CC';
        // $inputs['trangthai'] = $trangthai == 'CC' ? 'DD' : 'CXKT';
        $inputs['trangthai'] = getTrangThaiChuyenHS(session('chucnang')['dshosodenghikhencao']['trangthai'] ?? 'CC');
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['lydo'] = ''; //Xóa lý do trả lại
        setChuyenDV($model, $inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
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
        $model = dshosokhencao::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
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
        $model = dshosokhencao_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosokhencao_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosokhencao_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
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
        $model = dshosokhencao_canhan::findorfail($inputs['id']);
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
        $model = dshosokhencao_canhan::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosokhencao_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
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
        $model = dshosokhencao_tapthe::where('id', $inputs['id'])->first();

        unset($inputs['id']);
        unset($inputs['_token']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            //return response()->json($inputs);
            $model = new dshosokhencao_tapthe();
            $model->ketqua = 1;
            $model->linhvuchoatdong = $inputs['linhvuchoatdong'];
            $model->madanhhieukhenthuong = $inputs['madanhhieukhenthuong'];
            $model->mahosotdkt = $inputs['mahosotdkt'];
            // $model->maloaihinhkt = $inputs['maloaihinhkt'];
            $model->maphanloaitapthe = $inputs['maphanloaitapthe'];
            $model->tencoquan = $inputs['tencoquan'];
            $model->tentapthe = $inputs['tentapthe'];
            $model->save();
            //dshosokhencao_tapthe::create($inputs);
        } else
            $model->update($inputs);

        $danhsach = dshosokhencao_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        //return response()->json($danhsach);
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
        $model = dshosokhencao_tapthe::findorfail($inputs['id']);
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
        $model = dshosokhencao_tapthe::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosokhencao_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function NhanExcel(Request $request)
    {
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelKhenThuong($request);
        return redirect(static::$url . 'Sua?mahosotdkt=' . $request->all()['mahosotdkt']);
    }

    public function ThemHoGiaDinh(Request $request)
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
        $model = dshosokhencao_hogiadinh::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosokhencao_hogiadinh::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosokhencao_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlHoGiaDinh($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }

    public function LayHoGiaDinh(Request $request)
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
        $model = dshosokhencao_hogiadinh::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaHoGiaDinh(Request $request)
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
        $model = dshosokhencao_hogiadinh::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosokhencao_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlHoGiaDinh($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }
}
