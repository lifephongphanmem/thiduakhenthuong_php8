<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstruongcumkhoi;
use App\Models\DanhMuc\dstruongcumkhoi_chitiet;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_tailieu;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_tapthe;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi_tieuchuan;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoicumkhoi;
use App\Models\View\view_dscumkhoi;
use App\Models\View\view_dsphongtrao_cumkhoi;
use App\Models\View\view_dstruongcumkhoi;
use App\Models\View\viewdiabandonvi;
use App\Models\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosothiduacumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/ThamGiaThiDua/';
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
        $inputs['url_hs'] = static::$url;
        $inputs['url_xd'] = '/CumKhoiThiDua/DeNghiThiDua/';
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosothamgiathiduacumkhoi';
        //$m_donvi = getDonViCK(session('admin')->capdo, null, 'MODEL');
        $m_donvi = getDonViCK(session('admin')->capdo, 'dshosodenghikhenthuongcumkhoi');
        //dd($m_donvi);
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $m_cumkhoi_chitiet = dscumkhoi_chitiet::where('madonvi', $inputs['madonvi'])->get();
        $model = dscumkhoi::wherein('macumkhoi', array_column($m_cumkhoi_chitiet->toarray(), 'macumkhoi'))->get();
        // $m_hoso = dshosothamgiathiduacumkhoi::where('madonvi', $inputs['madonvi'])->get();
        // dd($m_hoso);
        // $m_phongtrao=dsphongtraothiduacumkhoi::all();
        $firstDayOfYear = Carbon::now()->startOfYear();
        $lastDayOfYear = Carbon::now()->endOfYear();
        $tungay=$firstDayOfYear->toDateString();
        $denngay=$lastDayOfYear->toDateString();
        $dsphantruongcumkhoi=dstruongcumkhoi::where('ngaytu','>=',$tungay)->where('ngayden','<=',$denngay)->first();
        $a_truongcumkhoi = array_column(dstruongcumkhoi_chitiet::where('madanhsach', $dsphantruongcumkhoi->madanhsach)->get()->toarray(), 'madonvi', 'macumkhoi');
        // dd($m_phongtrao);
        // dd($m_hoso);
        foreach ($model as $ct) {
            // $ct->sohoso = $m_hoso->where('macumkhoi', $ct->macumkhoi)->count();
            $model_cumkhoi = view_dsphongtrao_cumkhoi::where('macumkhoi', $ct->macumkhoi)->orderby('tungay')->get();
            $ct->sohoso = dshosothamgiathiduacumkhoi::wherein('maphongtraotd', array_column($model_cumkhoi->toarray(), 'maphongtraotd'))
                ->where('macumkhoi', $ct->macumkhoi)->wherein('trangthai', ['CD', 'DD', 'CNXKT', 'DXKT', 'CXKT', 'DKT'])->get()->count();
            // $ct->noidungphongtrao=$m_phongtrao->where('macumkhoi',$ct->macumkhoi)->first()->noidung??'';
            $ct->madonviql = $a_truongcumkhoi[$ct->macumkhoi] ?? '';
        }

        // dd($model);
        return view('NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThongTin')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_truongcumkhoi', $a_truongcumkhoi)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng cụm, khối thi đua');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dshosothiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosothiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosothamgiathiduacumkhoi';
        //$inputs['url'] = static::$url;
        $inputs['url_hs'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';
        // $m_donvi = getDonViCK(session('admin')->capdo);
        $m_donvi = getDonVi(session('admin')->capdo, 'dshosothiduacumkhoi');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_cumkhoi_chitiet = dscumkhoi_chitiet::where('madonvi', $inputs['madonvi'])->get();
        $model_cumkhoi = dscumkhoi::wherein('macumkhoi', array_column($m_cumkhoi_chitiet->toarray(), 'macumkhoi'))->get();
        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? $model_cumkhoi->first()->macumkhoi;
        //lấy hết phong trào cấp tỉnh
        $model = view_dsphongtrao_cumkhoi::where('macumkhoi', $inputs['macumkhoi'])->orderby('tungay')->get();

        $ngayhientai = date('Y-m-d');
        // $m_hoso = dshosothamgiathiduacumkhoi::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->get();
        //Đơn vị chỉ nhìn thấy phong trào thuộc cụm khối 
        $m_hoso = dshosothamgiathiduacumkhoi::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->where('macumkhoi', $inputs['macumkhoi'])->get();
        // dd($m_hoso);
        //$m_hoso_khenthuong = dshosothamgiathiduacumkhoi::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->where('trangthai', 'DKT')->get();

        foreach ($model as $DangKy) {
            if ($DangKy->trangthai == 'CC') {
                $DangKy->nhanhoso = 'CHUABATDAU';
                if ($DangKy->tungay < $ngayhientai && $DangKy->denngay > $ngayhientai) {
                    $DangKy->nhanhoso = 'DANGNHAN';
                }
                if (strtotime($DangKy->denngay) < strtotime($ngayhientai)) {
                    $DangKy->nhanhoso = 'KETTHUC';
                }
            } else {
                $DangKy->nhanhoso = 'KETTHUC';
            }

            $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd)->wherein('trangthai', ['CD', 'DD', 'CNXKT', 'DXKT', 'CXKT', 'DKT']);
            $DangKy->sohoso = $HoSo == null ? 0 : $HoSo->count();


            $hoso = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd)->where('madonvi', $inputs['madonvi'])->first();
            $DangKy->trangthai = $hoso->trangthai ?? 'CXD';
            $DangKy->thoigian = $hoso->thoigian ?? '';
            $DangKy->hosodonvi = $hoso == null ? 0 : 1;
            $DangKy->id = $hoso == null ? -1 : $hoso->id;
            $DangKy->mahoso = $hoso == null ? -1 : $hoso->mahoso;
            $DangKy->mahosotdkt = $hoso->mahosotdkt ?? '-1';
        }
        // dd($model);
        $inputs['trangthai'] = session('chucnang')['dshosothiduacumkhoi']['trangthai'] ?? 'CC';
        $m_cumkhoi = view_dscumkhoi::where('madonvi', $inputs['madonvi'])->get();
        $m_truongcum = view_dstruongcumkhoi::where('macumkhoi', $inputs['macumkhoi'])->orderBy('ngayden', 'desc')->get();
        // dd($m_cumkhoi);
        $a_donviql = array();
        if (count($m_truongcum) > 0) {
            $a_truongcum = array_column($m_truongcum->unique('macumkhoi')->toarray(), 'madonvi');
            $a_donviql = array_column(dsdonvi::wherein('madonvi', $a_truongcum)->get()->toarray(), 'tendonvi', 'madonvi');
        }
        // dd($a_donviql);
        if ($m_cumkhoi->count() == 0) {
            return view('errors.404')->with('message', 'Cụm, khối thi đua chưa có trưởng cụm, khối. Bạn hãy liên hệ đơn vị quản lý để thêm trưởng cụm khối')
                ->with('url', '/CumKhoiThiDua/ThamGiaThiDua/ThongTin?madonvi=' . $inputs['madonvi']);
        }

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoThiDua.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('m_donvi', $m_donvi)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('m_diaban', $m_diaban)
            // ->with('a_donviql', array_column($m_truongcum->toarray(),'tendonvi', 'madonvi'))
            ->with('a_donviql', $a_donviql)
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('pageTitle', 'Danh sách hồ sơ thi đua');
    }

    public function ThemHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = static::$url;
        $inputs['url_xd'] = '/CumKhoiThiDua/DeNghiThiDua/';
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $inputs['maloaihinhkt'] = session('chucnang')['dshosothiduacumkhoi']['maloaihinhkt'] ?? 'ALL';
        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        $model = new dshosothamgiathiduacumkhoi();
        $model->madonvi = $inputs['madonvi'];
        $model->mahoso = (string)getdate()[0];
        $model->maloaihinhkt = $m_phongtrao->maloaihinhkt;
        $model->maphongtraotd = $inputs['maphongtraotd'];
        $model->macumkhoi = $inputs['macumkhoi'];
        $model->ngayhoso = date('Y-m-d');
        $model->phanloai = 'THIDUA';
        $model->trangthai = 'CC';
        $model->save();
        return redirect(static::$url . 'Sua?mahoso=' . $model->mahoso.'&madonvi='.$inputs['madonvi']);
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $inputs['url'] = static::$url; //Dùng cho nhận excel
        $inputs['url_hs'] = static::$url;
        $inputs['url_xd'] = '/CumKhoiThiDua/DeNghiThiDua/';
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';
        $inputs['phanloaihoso'] = 'dshosothamgiathiduacumkhoi';

        $inputs['mahinhthuckt'] = session('chucnang')['dshosothiduacumkhoi']['mahinhthuckt'] ?? 'ALL';
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        if (isset($model)) {
            $model->mahosotdkt = $model->mahoso;
        }
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');

        //dd($a_dhkt_hogiadinh);
        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model->tenphongtrao = $m_phongtrao->noidung;

        $model_canhan = dshosothamgiathiduacumkhoi_canhan::where('mahoso', $model->mahoso)->get();
        $model_tapthe = dshosothamgiathiduacumkhoi_tapthe::where('mahoso', $model->mahoso)->get();
        // dd($model_tapthe);
        $model_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        // $m_danhhieu = dmdanhhieuthidua::all();;
        $m_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $model_tailieu = dshosothamgiathiduacumkhoi_tailieu::where('mahoso', $model->mahoso)->get();
        // dd($model);
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoThiDua.ThayDoi')
            ->with('model', $model)
            ->with('model_tailieu', $model_tailieu)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_tieuchuan', $model_tieuchuan)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('m_tieuchuan', $m_tieuchuan)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Hồ sơ thi đua');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahosothamgiapt'])->first();
        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model->tenphongtrao = $m_phongtrao->noidung;
        $model_canhan = dshosothamgiathiduacumkhoi_canhan::where('mahoso', $model->mahoso)->get();
        $model_tapthe = dshosothamgiathiduacumkhoi_tapthe::where('mahoso', $model->mahoso)->get();

        //$m_danhhieu = dmdanhhieuthidua::all();
        $m_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        //dd( $model_canhan);

        return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.Xem')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', getDanhHieuKhenThuong('ALL'))
            //->with('a_danhhieutd', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('pageTitle', 'Hồ sơ thi đua');
    }

    public function LuuHoSo(Request $request)
    {

        if (!chkPhanQuyen('dshosothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();

        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $inputs['mahoso'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['baocao'])) {
            $filedk = $request->file('baocao');
            $inputs['baocao'] = $inputs['mahoso'] . '_baocao.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $inputs['mahoso'] . '_bienban.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['mahoso'] . 'tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }

        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        $model->update($inputs);

        return redirect('/CumKhoiThiDua/ThamGiaThiDua/DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    }

    public function XoaHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosothiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $model = dshosothamgiathiduacumkhoi::findorfail($inputs['id']);
        //dshosothamgiathiduacumkhoi_tieuchuan::where('mahoso', $model->mahoso)->delete();
        dshosothamgiathiduacumkhoi_canhan::where('mahoso', $model->mahoso)->delete();
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosothiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosothiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();

        $inputs['trangthai'] = getTrangThaiChuyenHS(session('chucnang')['dshosothiduacumkhoi']['trangthai'] ?? 'CC');
        $model->trangthai = $inputs['trangthai'];
        $model->madonvi_nhan = $inputs['madonvi_nhan'];
        $model->thoigian = date('Y-m-d H:i:s');
        $model->madonvi_xd = $inputs['madonvi_nhan'];
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $model->thoigian;
        $model->save();

        $trangthai = new trangthaihoso();
        $trangthai->trangthai = $inputs['trangthai'];
        $trangthai->madonvi = $model->madonvi;
        $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
        $trangthai->phanloai = 'dshosothamgiathiduacumkhoi';
        $trangthai->mahoso = $model->mahoso;
        $trangthai->thoigian = $model->thoigian;
        $trangthai->save();

        return redirect('/CumKhoiThiDua/ThamGiaThiDua/DanhSach?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    }

    // public function LayTieuChuan(Request $request)
    // {
    //     $result = array(
    //         'status' => 'fail',
    //         'message' => 'error',
    //     );
    //     if (!Session::has('admin')) {
    //         $result = array(
    //             'status' => 'fail',
    //             'message' => 'permission denied',
    //         );
    //         die(json_encode($result));
    //     }
    //     //dd($request);
    //     $inputs = $request->all();

    //     $model = dshosothamgiathiduacumkhoi_tieuchuan::where('iddoituong', $inputs['iddoituong'])
    //         ->where('mahoso', $inputs['mahoso'])->get();
    //     $model_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])
    //         ->where('phanloaidoituong', $inputs['phanloaidoituong'])->get();

    //     if (isset($model_tieuchuan)) {
    //         $result['message'] = '<div class="row" id="dstieuchuan">';

    //         $result['message'] .= '<div class="col-md-12">';
    //         $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
    //         $result['message'] .= '<thead>';
    //         $result['message'] .= '<tr>';
    //         $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
    //         $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
    //         $result['message'] .= '<th style="text-align: center" width="12%">Bắt buộc</th>';
    //         $result['message'] .= '<th style="text-align: center" width="12%">Đạt điều kiên</th>';
    //         $result['message'] .= '<th style="text-align: center" width="5%">Thao tác</th>';
    //         $result['message'] .= '</tr>';
    //         $result['message'] .= '</thead>';

    //         $result['message'] .= '<tbody>';
    //         $key = 1;
    //         foreach ($model_tieuchuan as $ct) {
    //             $tieuchuan = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first();

    //             $result['message'] .= '<tr>';
    //             $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
    //             $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
    //             $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
    //             $result['message'] .= '<td style="text-align: center">' . ($tieuchuan->dieukien ?? 0) . '</td>';
    //             $result['message'] .= '<td>' .
    //                 '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . ($tieuchuan->id ?? -1) . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
    //                 . '</td>';

    //             $result['message'] .= '</tr>';
    //         }
    //         $result['message'] .= '</tbody>';
    //         $result['message'] .= '</table>';
    //         $result['message'] .= '</div>';
    //         $result['message'] .= '</div>';
    //         $result['status'] = 'success';
    //     }
    //     die(json_encode($result));
    // }

    // public function LuuTieuChuan(Request $request)
    // {
    //     $result = array(
    //         'status' => 'fail',
    //         'message' => 'error',
    //     );
    //     if (!Session::has('admin')) {
    //         $result = array(
    //             'status' => 'fail',
    //             'message' => 'permission denied',
    //         );
    //         die(json_encode($result));
    //     }
    //     //dd($request);
    //     $inputs = $request->all();
    //     $model = dshosothamgiathiduacumkhoi_tieuchuan::where('id', $inputs['id'])->first();

    //     //chưa lấy biến điều kiện đang dùng tạm để demo
    //     if ($model == null) {
    //         $m_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])
    //             ->where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();
    //         $model = new dshosothamgiathiduacumkhoi_tieuchuan();
    //         $model->iddoituong = $inputs['iddoituong'];
    //         $model->matieuchuandhtd = $m_tieuchuan->matieuchuandhtd;
    //         $model->tentieuchuandhtd = $m_tieuchuan->tentieuchuandhtd;
    //         $model->batbuoc = $m_tieuchuan->batbuoc;
    //         //$model->madonvi = $inputs['madonvi'];
    //         $model->mahoso = $inputs['mahoso'];
    //         $model->dieukien = 1;
    //         $model->save();
    //     } else {
    //         $model->dieukien = 1;
    //         $model->save();
    //     }
    //     //
    //     $model = dshosothamgiathiduacumkhoi_tieuchuan::where('iddoituong', $inputs['iddoituong'])
    //         ->where('mahoso', $inputs['mahoso'])->get();
    //     $model_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])
    //         ->where('phanloaidoituong', $inputs['phanloaidoituong'])->get();

    //     if (isset($model_tieuchuan)) {
    //         $result['message'] = '<div class="row" id="dstieuchuan">';

    //         $result['message'] .= '<div class="col-md-12">';
    //         $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
    //         $result['message'] .= '<thead>';
    //         $result['message'] .= '<tr>';
    //         $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
    //         $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
    //         $result['message'] .= '<th style="text-align: center" width="12%">Bắt buộc</th>';
    //         $result['message'] .= '<th style="text-align: center" width="12%">Đạt điều kiên</th>';
    //         $result['message'] .= '<th style="text-align: center" width="5%">Thao tác</th>';
    //         $result['message'] .= '</tr>';
    //         $result['message'] .= '</thead>';

    //         $result['message'] .= '<tbody>';
    //         $key = 1;
    //         foreach ($model_tieuchuan as $ct) {
    //             $tieuchuan = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first();

    //             $result['message'] .= '<tr>';
    //             $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
    //             $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
    //             $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
    //             $result['message'] .= '<td style="text-align: center">' . ($tieuchuan->dieukien ?? 0) . '</td>';
    //             $result['message'] .= '<td>' .
    //                 '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . ($tieuchuan->id ?? -1) . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
    //                 . '</td>';

    //             $result['message'] .= '</tr>';
    //         }
    //         $result['message'] .= '</tbody>';
    //         $result['message'] .= '</table>';
    //         $result['message'] .= '</div>';
    //         $result['message'] .= '</div>';
    //         $result['status'] = 'success';
    //     }
    //     die(json_encode($result));
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
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahosotdkt'])->first();

        $result['message'] = '<div class="col-md-12" id="showlido">';
        $result['message'] .= $model->lydo;

        $result['message'] .= '</div>';
        $result['status'] = 'success';


        die(json_encode($result));
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahs'])->first();
        $result['message'] .= '<h5>Tài liệu hồ sơ đề nghị khen thưởng</h5>';
        if (isset($model->totrinh)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if (isset($model->qdkt)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if (isset($model->bienban)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if (isset($model->tailieukhac)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '<hr><h5>Tài liệu phong trào thi đua</h5>';
        $model_pt = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first();
        if (isset($model_pt->qdkt)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model_pt->qdkt) . '">' . $model_pt->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }

        if (isset($model_pt->tailieukhac)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model_pt->tailieukhac) . '">' . $model_pt->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
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
        $model = dshosothamgiathiduacumkhoi_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothamgiathiduacumkhoi_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $model = dshosothamgiathiduacumkhoi_canhan::where('mahoso', $inputs['mahoso'])->get();

        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $model, static::$url, true, $inputs['maloaihinhkt']);

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
        $model = dshosothamgiathiduacumkhoi_canhan::findorfail($inputs['id']);
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
        $model = dshosothamgiathiduacumkhoi_canhan::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosothamgiathiduacumkhoi_canhan::where('mahoso', $model->mahoso)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function NhanExcelCaNhan(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduacumkhoikhenthuong::where('mahoso', $inputs['mahoso'])->first();
        $filename = $inputs['mahoso'] . '_' . getdate()[0];
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
                'mahoso' => $inputs['mahoso'],
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

        dshosothamgiathiduacumkhoi_canhan::insert($a_dm);
        File::Delete($path);

        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        return redirect(static::$url . 'Them?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $model->madonvi);
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
        $model = dshosothamgiathiduacumkhoi_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothamgiathiduacumkhoi_tapthe::create($inputs);
        } else
            $model->update($inputs);

        $model = dshosothamgiathiduacumkhoi_tapthe::where('mahoso', $inputs['mahoso'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $model, static::$url, true, $inputs['maloaihinhkt']);

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
        $model = dshosothamgiathiduacumkhoi_tapthe::findorfail($inputs['id']);
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

        $model = dshosothamgiathiduacumkhoi_tapthe::where('id', $inputs['id'])->first();
        $model->delete();
        //$m_hoso = dshosothamgiathiduacumkhoi::where('mahoso', $model->mahoso)->first();
        //dd($model);

        $danhsach = dshosothamgiathiduacumkhoi_tapthe::where('mahoso', $model->mahoso)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function NhanExcelTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduacumkhoikhenthuong::where('mahoso', $inputs['mahoso'])->first();
        $filename = $inputs['mahoso'] . '_' . getdate()[0];
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
                'mahoso' => $inputs['mahoso'],
                'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
            );
        }
        dshosothamgiathiduacumkhoi_tapthe::insert($a_dm);
        File::Delete($path);
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        return redirect(static::$url . 'Them?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $model->madonvi);
    }

    public function ToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothamgiathiduacumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhHoSo($model, $inputs['maduthao']);
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
        $model = dshosothamgiathiduacumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothamgiathiduacumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhHoSo($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhhoso;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
    }

    public function NhanExcel(Request $request)
    {
        $inputs=$request->all();
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelThamGiaCumKhoi($request);
        return redirect(static::$url . 'Sua?mahoso=' . $inputs['mahoso'].'&madonvi='.$inputs['madonvi']);
    }
}
