<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongNienHan;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_detai;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosokhenthuongnnienhanController extends Controller
{
    public static $url = '/KhenThuongNienHan/HoSoKT/';
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
        if (!chkPhanQuyen('dshosokhenthuongnienhan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongnienhan')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongNienHan/HoSoKT/';
        $inputs['url_qd'] = '/KhenThuongNienHan/HoSoKT/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'dshosokhenthuongnienhan');
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');

        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $inputs['maloaihinhkt'] = session('chucnang')['dshosokhenthuongnienhan']['maloaihinhkt'] ?? 'ALL';
        $inputs['trangthai'] = session('chucnang')['dshosokhenthuongnienhan']['trangthai'] ?? 'CC';

        //Các đơn vi xét duyệt cấp H, T => có tờ trình
        $inputs['taototrinh'] = session('admin')->hskhenthuong_totrinh;
        // if ($inputs['taototrinh']) {
        //     $a_donvi_xd = array_column(dsdiaban::wherein('capdo', ['H', 'T'])->get()->toarray(), 'madonviKT');
        //     $inputs['taototrinh'] = in_array($inputs['madonvi'], $a_donvi_xd);
        // }

        $model = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])
            // ->where('phanloai', 'KTDONVI')
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH', 'KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC','KTDONVI'])
            ->where('maloaihinhkt', $inputs['maloaihinhkt']);
        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);
        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();
        $model_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        foreach ($model as $hoso) {
            $hoso->soluongkhenthuong = $model_canhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $model_tapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
        }
        //dd($inputs);
        return view('NghiepVu.KhenThuongNienHan.HoSoKT.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('a_donviql', getDonViXetDuyetDiaBan($donvi))
            ->with('a_donvinganh', getDonViQuanLyNganh($donvi))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng theo niên hạn');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongnienhan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongnienhan')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = '/KhenThuongNienHan/HoSoKT/';
        $inputs['url_hs'] = '/KhenThuongNienHan/HoSoKT/';
        $inputs['url_qd'] = '/KhenThuongNienHan/HoSoKT/';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';

        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        //Các đơn vị cấp Tỉnh chỉ đc khen thưởng tương đương Huyện (trừ UBND)
        if ($donvi->capdo == 'T' && $donvi->madonvi != $donvi->madonviQL) {
            $donvi->capdo = 'H';
        }
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        //$m_donvi = getDonVi(session('admin')->capdo);
        //$m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $inputs['mahinhthuckt'] = $model->mahinhthuckt;
        $m_donvi = dsdonvi::all();
        $khenthuong = $m_donvi->where('madonvi', $model->madonvi)->first();
        if ($model->donvikhenthuong == '') {
            $model->donvikhenthuong = $khenthuong->tendonvi;
        }
        $a_donvikt = array_unique(array_merge([$model->donvikhenthuong => $model->donvikhenthuong], getDonViKhenThuong()));
        return view('NghiepVu.KhenThuongNienHan.HoSoKT.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('model_detai', $model_detai)
            ->with('a_donvikt', $a_donvikt)
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
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('NghiepVu.KhenThuongNienHan.HoSoKT.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            // ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function InHoSoKT(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('NghiepVu.KhenThuongNienHan.HoSoKT.InHoSoKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            // ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongnienhan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongnienhan')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();

        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['phanloai'] = $inputs['phanloai']??'KTDONVI';

        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSoKT($inputs);
        dshosothiduakhenthuong::create($inputs);

        //Lưu nhật ký
        $trangthai = new trangthaihoso();
        $trangthai->trangthai = $inputs['trangthai'];
        $trangthai->madonvi = $inputs['madonvi'];
        $trangthai->thongtin = "Thêm mới hồ sơ khen thưởng";
        $trangthai->phanloai = 'dshosothiduakhenthuong';
        $trangthai->mahoso = $inputs['mahosotdkt'];
        $trangthai->thoigian = $inputs['ngayhoso'];

        $trangthai->save();

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt'].'&phanloai='.$inputs['phanloai']);
    }

    public function LuuHoSo(Request $request)
    {

        if (!chkPhanQuyen('dshosokhenthuongnienhan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongnienhan')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($request->file('totrinh')->getClientOriginalName());    
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $inputs['mahosotdkt'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['baocao'])) {
            $filedk = $request->file('baocao');
            $inputs['baocao'] = $inputs['mahosotdkt'] . '_baocao.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $inputs['mahosotdkt'] . '_bienban.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['mahosotdkt'] . 'tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        if (isset($inputs['quyetdinh'])) {
            $filedk = $request->file('quyetdinh');
            $inputs['quyetdinh'] = $inputs['mahosotdkt'] . 'quyetdinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['quyetdinh']);
        }
        dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first()->update($inputs);

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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        die(json_encode($model));
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongnienhan', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();

        $model->trangthai = 'CD';
        $model->madonvi_nhan = $inputs['madonvi_nhan'];
        $model->thoigian = date('Y-m-d H:i:s');
        $model->madonvi_xd = $model->madonvi_nhan;
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian = $model->thoigian;
        //dd($model);
        $model->save();

        $trangthai = new trangthaihoso();
        $trangthai->trangthai = 'CD';
        $trangthai->madonvi = $model->madonvi;
        $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
        $trangthai->phanloai = 'dshosothiduakhenthuong';
        $trangthai->mahoso = $model->mahosotdkt;
        $trangthai->thoigian = $model->thoigian;
        $trangthai->save();

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
        $model = dshosothiduakhenthuong::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosothiduakhenthuong_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();

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
        $model = dshosothiduakhenthuong_canhan::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_canhan::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
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
        $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosothiduakhenthuong_hogiadinh::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();

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
        $model = dshosothiduakhenthuong_hogiadinh::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_hogiadinh::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlHoGiaDinh($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
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
        //$id =  $inputs['id'];       
        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosothiduakhenthuong_tapthe::create($inputs);
        } else
            $model->update($inputs);

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
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
        $model = dshosothiduakhenthuong_tapthe::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_tapthe::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
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
        $model = dshosothiduakhenthuong_detai::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothiduakhenthuong_detai::create($inputs);
        } else
            $model->update($inputs);

        $model = dshosothiduakhenthuong_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();

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
        $model = dshosothiduakhenthuong_detai::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_detai::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlDeTai($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelDeTai(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        dshosothiduakhenthuong_detai::insert($a_dm);
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

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if ($model->totrinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->qdkt != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->bienban != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->tailieukhac != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        getTaoDuThaoKT($model);
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    }

    public function DuThaoQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = '';
        $inputs['madonvi'] = $model->madonvi_xd;
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        getTaoDuThaoKT($model, $inputs['maduthao']);

        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    }

    public function LuuQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }

    public function PheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/KhenThuongNienHan/KhenThuong/';
        $inputs['url_hs'] = '/KhenThuongNienHan/HoSoKT/';
        $inputs['url_xd'] = '/KhenThuongNienHan/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongNienHan/KhenThuong/';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['mahinhthuckt'] = session('chucnang')['dshosokhenthuongnienhan']['mahinhthuckt'] ?? 'ALL';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        //Gán thông tin đơn vị khen thưởng
        $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();

        $model->capkhenthuong =  $donvi_kt->capdo;
        $model->donvikhenthuong =  $donvi_kt->tendonvi;
        $a_donvikt = array_unique(array_merge([$model->donvikhenthuong], getDonViKhenThuong()));

        return view('NghiepVu.KhenThuongNienHan.HoSoKT.PheDuyetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_detai', $model_detai)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donvikt', $a_donvikt)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuPheDuyet(Request $request)
    {
        $inputs = $request->all();

        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        //kiểm tra các thông tin chi tiết có hợp lệ không
        //Cá nhân: maphanloaicanbo; madanhhieukhenthuong
        //Tập thể: maphanloaitapthe; linhvuchoatdong; madanhhieukhenthuong
        //Hộ gia đình: maphanloaitapthe; madanhhieukhenthuong

        $model->trangthai = 'DKT';
        //gán trạng thái hồ sơ để theo dõi
        $model->trangthai_xd = $model->trangthai;
        $model->trangthai_kt = $model->trangthai;
        $model->thoigian_kt = $thoigian;

        $model->donvikhenthuong = $inputs['donvikhenthuong'];
        $model->capkhenthuong = $inputs['capkhenthuong'];
        $model->soqd = $inputs['soqd'];
        $model->ngayqd = $inputs['ngayqd'];
        $model->chucvunguoikyqd = $inputs['chucvunguoikyqd'];
        $model->hotennguoikyqd = $inputs['hotennguoikyqd'];
        //dd($model);
        getTaoQuyetDinhKT($model);

        if (isset($inputs['quyetdinh'])) {
            $filedk = $request->file('quyetdinh');
            $inputs['quyetdinh'] = $inputs['mahosotdkt'] . '_quyetdinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['quyetdinh']);
            $model->quyetdinh = $inputs['quyetdinh'];
        }
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function HuyPheDuyet(Request $request)
    {
        // $inputs = $request->all();
        // $thoigian = date('Y-m-d H:i:s');
        // $trangthai = 'CXKT';
        // $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        // $model->trangthai = $trangthai;
        // $model->trangthai_xd = $model->trangthai;
        // $model->trangthai_kt = $model->trangthai;
        // $model->thoigian_kt = null;

        // $model->donvikhenthuong = null;
        // $model->capkhenthuong = null;
        // $model->soqd = null;
        // $model->ngayqd = null;
        // $model->chucvunguoikyqd = null;
        // $model->hotennguoikyqd = null;
        // //dd($model);
        // $model->save();
        // trangthaihoso::create([
        //     'mahoso' => $inputs['mahosotdkt'],
        //     'phanloai' => 'dshosothiduakhenthuong',
        //     'trangthai' => $model->trangthai,
        //     'thoigian' => $thoigian,
        //     'madonvi' => $inputs['madonvi'],
        //     'thongtin' => 'Hủy phê duyệt đề nghị khen thưởng.',
        // ]);
        $inputs = $request->all();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['trangthai'] = 'CXKT';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        setHuyKhenThuong($model, $inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoQuyetDinhKT($model);
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function ToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhHoSo($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhhoso;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
    }

    public function ToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhPheDuyet($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhdenghi;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
    }

    public function NhanExcel(Request $request)
    {

        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelKhenThuong($request);
        //dd($request);
        return redirect(static::$url . 'Sua?mahosotdkt=' . $request->all()['mahoso']);
    }
}
