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
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_detai;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\View\view_dstruongcumkhoi;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosokhenthuongcumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
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
        if (!chkPhanQuyen('dshosokhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        //B1 lọc danh sách cụm khối đơn vị theo doi => báo lỗi
        //B2 lọc cụm khối theo đơn vị
        //B3 xem input['macumkhoi] có tồn tại ko => lấy first()

        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $m_donvi = getDonVi(session('admin')->capdo, 'dshosokhenthuongcumkhoi');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['maloaihinhkt'] = $inputs['maloaihinhkt'] ?? 'ALL';
        //Lọc cụm khối theo thiết lập lọc dữ liệu của tài khoản
        $a_diabancumkhoi = getCumKhoiLocDuLieu(session('admin')->tendangnhap);
        if (count($a_diabancumkhoi) > 0)
            $m_cumkhoi = dscumkhoi::wherein('macumkhoi', $a_diabancumkhoi)->get();
        else
            $m_cumkhoi = dscumkhoi::all();

        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? $m_cumkhoi->first()->macumkhoi;
        //Trường hợp chọn lại đơn vị nhưng mã cụm khối vẫn theo đơn vị cũ
        $inputs['macumkhoi'] = $m_cumkhoi->where('macumkhoi', $inputs['macumkhoi'])->first() != null ? $inputs['macumkhoi'] : $m_cumkhoi->first()->macumkhoi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $inputs['tendvcqhienthi'] = $donvi->tendvcqhienthi;
        $inputs['capdo'] = $donvi->capdo;
        //$donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //$capdo = $donvi->capdo ?? '';
        //dd($inputs);
        $model = dshosotdktcumkhoi::where('macumkhoi', $inputs['macumkhoi'])
            //->where('madonvi', $inputs['madonvi'])
            ->where('phanloai', 'KTDONVI');
        if ($inputs['nam'] != 'ALL') {
            $model = $model->whereyear('ngayhoso', $inputs['nam']);
        }
        if ($inputs['maloaihinhkt'] != 'ALL') {
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);
        }
        $model = $model->orderby('ngayhoso')->get();
        foreach ($model as $hoso) {
            getDonViChuyen($inputs['madonvi'], $hoso);
            $hoso->soluongkhenthuong = dshosotdktcumkhoi_canhan::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count()
                + dshosotdktcumkhoi_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count();
            $hoso->chinhsua = $hoso->madonvi == $inputs['madonvi'] ? true : false;
        }
        //Các đơn vi xét duyệt cấp H, T => có tờ trình
        $a_donvi_xd = array_column(dsdiaban::wherein('capdo', ['H', 'T'])->get()->toarray(), 'madonviKT');
        $inputs['taototrinh'] = in_array($inputs['madonvi'], $a_donvi_xd);

        $inputs['trangthai'] = session('chucnang')['dshosokhenthuongcumkhoi']['trangthai'] ?? 'CC';

        //Thiết lập thông tin trưởng cụm khối
        $inputs['ngayhientai'] = date('Y-m-d');
        $inputs['namhientai'] = date('Y');
        $truongcumkhoi = view_dstruongcumkhoi::whereYear('ngaytu', $inputs['namhientai'])
            ->where('macumkhoi', $inputs['macumkhoi'])
            ->where('madonvi', $inputs['madonvi'])->first();
        //nếu trưởng cụm khối == null =>lấy đơn vị quản lý để thêm hồ sơ
        $truongcumkhoi = $truongcumkhoi->madonvi ?? $m_cumkhoi->where('macumkhoi', $inputs['macumkhoi'])->first()->madonviql;
        $inputs['truongcumkhoi'] = $truongcumkhoi == $inputs['madonvi'] ? true : false;
        //dd($inputs);
        return view('NghiepVu.CumKhoiThiDua.HoSoKT.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('a_donviql', getDonViXetDuyetDiaBan($donvi))
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_trangthaihoso', getTrangThaiTDKT())
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng cụm, khối thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongcumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['url_hs'] = static::$url;
        $inputs['url_qd'] = static::$url;
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';

        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tailieu = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();

        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        //$m_donvi = getDonVi(session('admin')->capdo);
        //$m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        $inputs['mahinhthuckt'] = $model->mahinhthuckt;
        $khenthuong = dsdonvi::where('madonvi', $model->madonvi)->first();
        if ($model->donvikhenthuong == '') {
            $model->donvikhenthuong = $khenthuong->tendonvi;
        }
        $a_donvikt = array_unique(array_merge([$model->donvikhenthuong => $model->donvikhenthuong], getDonViKhenThuong()));
        return view('NghiepVu.CumKhoiThiDua.HoSoKT.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donvikt', $a_donvikt)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            //->with('m_donvi', $m_donvi)
            //->with('m_diaban', $m_diaban)
            //->with('a_danhhieutd', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', $a_canhan)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
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
            $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        } else {
            dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        }

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
                'ketqua' => '1',
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
        //return response()->json($inputs['id']);
        $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosotdktcumkhoi_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        //$this->htmlTapThe($result, $model);
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
                'ketqua' => '1',
            );
        }
        dshosotdktcumkhoi_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        getTaoDuThaoKTCumKhoi($model);
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    }

    public function InQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'QUYETDINH')->get()->toArray(), 'noidung', 'maduthao');
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo quyết định khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        getTaoQuyetDinhKTCumKhoi($model, $inputs['maduthao']);
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function DuThaoQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        getTaoDuThaoKTCumKhoi($model, $inputs['maduthao']);

        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function LuuQuyetDinh(Request $request)
    {
        $inputs = $request->all();

        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        //dd($model);
        return redirect(static::$url . 'ThongTin');
    }

    public function LayDoiTuong(Request $request)
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
            $model = array_column(dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get()->toarray(), 'tentapthe', 'id');
        } else {
            $model = array_column(dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get()->toarray(), 'tendoituong', 'id');
        }
        $result['message'] = '<div class="row" id="doituonginphoi">';
        $result['message'] .= '<div class="col-md-12">';
        $result['message'] .= '<label class="form-control-label">Tên đối tượng</label>';
        $result['message'] .= '<select class="form-control select2_modal" name="tendoituong">';
        $result['message'] .= '<option value="ALL">Tất cả</option>';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';
        $result['message'] .= '<div>';

        $result['status'] = 'success';
        return response()->json($result);
    }

    public function InBangKhen(Request $request)
    {
        $inputs = $request->all();
        $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $m_hoso->diadanh = dsdonvi::where('madonvi', $m_hoso->madonvi)->first()->diadanh ?? '';
        if ($inputs['phanloai'] == 'CANHAN') {
            if ($inputs['tendoituong'] == 'ALL') {
                $model = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            } else {
                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['tendoituong'])->get();
            }
        } else {
            if ($inputs['tendoituong'] == 'ALL') {
                $model = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            } else {
                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['tendoituong'])->get();
            }
        }
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhen')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen');
    }

    public function InGiayKhen(Request $request)
    {
        $inputs = $request->all();
        $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $m_hoso->diadanh = dsdonvi::where('madonvi', $m_hoso->madonvi)->first()->diadanh ?? '';
        if ($inputs['phanloai'] == 'CANHAN') {
            if ($inputs['tendoituong'] == 'ALL') {
                $model = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            } else {
                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['tendoituong'])->get();
            }
        } else {
            if ($inputs['tendoituong'] == 'ALL') {
                $model = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            } else {
                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['tendoituong'])->get();
            }
        }

        //$a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhen')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In giấy khen');
    }

    public function PheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
        $inputs['url'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $inputs['mahinhthuckt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['mahinhthuckt'] ?? 'ALL';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $model->tendonvi = $donvi->tendonvi;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        //Gán thông tin đơn vị khen thưởng
        $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();

        $model->capkhenthuong =  $donvi_kt->capdo;
        $model->donvikhenthuong =  $donvi_kt->tendonvi;
        $a_donvikt = array_unique(array_merge([$model->donvikhenthuong], getDonViKhenThuong()));

        return view('NghiepVu.CumKhoiThiDua.KhenThuongHoSoKhenThuong.PheDuyetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('a_donvikt', $a_donvikt)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'QUYETDINH')->get()->toArray(), 'noidung', 'maduthao');
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo quyết định khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);

        getTaoQuyetDinhKTCumKhoi($model, $inputs['maduthao']);
        if (isset($inputs['quyetdinh'])) {
            $filedk = $request->file('quyetdinh');
            $inputs['quyetdinh'] = $model->mahosotdkt . 'quyetdinh' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['quyetdinh']);
            $model->quyetdinh = $inputs['quyetdinh'];
        }
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosotdktcumkhoi',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi . '&macumkhoi=' . $model->macumkhoi);
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'dshosokhenthuongcumkhoi')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $trangthai = 'CXKT';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $trangthai]);
        $model->trangthai = $trangthai; //gán trạng thái hồ sơ để theo dõi
        $model->donvikhenthuong = null;
        $model->capkhenthuong = null;
        $model->soqd = null;
        $model->ngayqd = null;
        $model->chucvunguoikyqd = null;
        $model->hotennguoikyqd = null;
        //dd($model);
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'dshosokhenthuongcumkhoi')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $trangthai = 'BTLXD';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $trangthai, 'lydo' => $inputs['lydo']]);
        $model->trangthai = $trangthai; //gán trạng thái hồ sơ để theo dõi   

        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->lydo_xd = $inputs['lydo'];

        $model->madonvi_nhan_xd = null;

        $model->madonvi_kt = null;
        $model->trangthai_kt = null;
        $model->thoigian_kt = null;

        //dd($inputs);
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')
                ->with('machucnang', 'dshosokhenthuongcumkhoi')
                ->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['phanloai'] = 'KTDONVI';
        $inputs['ngayqd'] = $inputs['ngayhoso'];

        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSoKT($inputs);
        dshosotdktcumkhoi::create($inputs);

        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'trangthai' => 'CXKT',
            'thoigian' => $thoigian,
            'phanloai' => 'dshosotdktcumkhoi',
            'madonvi_nhan' => $inputs['madonvi'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Tạo mới hồ sơ và trình đề nghị khen thưởng.',
        ]);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongcumkhoi', 'thaydoi')) {
            return view('errors.noperm')
                ->with('machucnang', 'dshosokhenthuongcumkhoi')
                ->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->update($inputs);
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
        $model = dshosotdktcumkhoi::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
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

    public function InHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        //$model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model->tencumkhoi = dscumkhoi::where('macumkhoi', $model->macumkhoi)->first()->tencumkhoi ?? '';
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('NghiepVu.CumKhoiThiDua.HoSoKT.InHoSo')
            ->with('model', $model)
            ->with('a_dhkt', $a_dhkt)
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

    public function InHoSoKT(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        //$model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model->tencumkhoi = dscumkhoi::where('macumkhoi', $model->macumkhoi)->first()->tencumkhoi ?? '';
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('NghiepVu.CumKhoiThiDua.HoSoKT.InHoSoKT')
            ->with('model', $model)
            ->with('a_dhkt', $a_dhkt)
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

    public function InPhoi(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/HoSoKT/';
        $model =  dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        $model->tendonvi = $m_donvi->tendonvi;
        return view('NghiepVu._DungChung.InPhoi')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen');
    }

    public function InBangKhenCaNhan(Request $request)
    {
        $inputs = $request->all();

        $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
        $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhenCaNhan')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InBangKhenTapThe(Request $request)
    {
        $inputs = $request->all();

        $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
        $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function InGiayKhenCaNhan(Request $request)
    {
        $inputs = $request->all();

        $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
        $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenCaNhan')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InGiayKhenTapThe(Request $request)
    {
        $inputs = $request->all();

        $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
        $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function NoiDungKhenThuong(Request $request)
    {
        $inputs = $request->all();

        if ($inputs['phanloai'] == 'CANHAN') {
            $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->first();
            $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
            $model->save();
        } else {
            $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->first();
            $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
            $model->save();
        }
        //dd($m_hoso);
        return redirect(static::$url . 'InPhoi?mahosotdkt=' . $model->mahosotdkt);
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

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahs'])->first();
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
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhHoSoCumKhoi($model);
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
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhPheDuyetCumKhoi($model);
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
        $dungchung->NhanExcelCumKhoi($request);
        return redirect(static::$url . 'Sua?mahosotdkt=' . $request->all()['mahoso']);
    }
}
