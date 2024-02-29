<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\View\view_dscumkhoi;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class xdhosodenghikhenthuongthiduacumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/XetDuyetThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('xdhosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/HoSoThiDua/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/KhenThuongThiDua/';
        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $m_donvi = getDonVi(session('admin')->capdo, 'xdhosodenghikhenthuongthiduacumkhoi');
        if(count($m_donvi) <= 0)
        {
            return view('errors.noperm')->with('machucnang', 'xdhosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');   
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['maloaihinhkt'] ?? 'ALL';
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();

        $model = dshosotdktcumkhoi::where('madonvi_xd', $inputs['madonvi'])
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH', 'KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC',])
            ->where('maloaihinhkt', $inputs['maloaihinhkt']); //->orderby('ngayhoso')->get();

        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);

        //Lọc trạng thái
        if ($inputs['trangthaihoso'] != 'ALL')
            $model = $model->where('trangthai_xd', $inputs['trangthaihoso']);

        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();
        $m_khencanhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        $m_khentapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        
        foreach ($model as $key => $hoso) {
            $hoso->soluongkhenthuong = $m_khencanhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $m_khentapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
            //$hoso->soluongkhenthuong = 1;
            //Gán lại trạng thái hồ sơ
            $hoso->madonvi_hoso = $hoso->madonvi_xd;
            $hoso->trangthai_hoso = $hoso->trangthai_xd;
            $hoso->thoigian_hoso = $hoso->thoigian_xd;
            $hoso->lydo_hoso = $hoso->lydo_xd;
            $hoso->madonvi_nhan_hoso = $hoso->madonvi_kt;
            if (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->madonvi, $a_donvilocdulieu))
                    $model->forget($key);
            }
        }
        $inputs['trangthai'] = session('chucnang')['xdhosodenghikhenthuongthiduacumkhoi']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        //dd($model->where('trangthai','CXKT')->where('madonvi_kt',''));
        //dd( $inputs);
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetDeNghi.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViQuanLyDiaBan($donvi))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('xdhosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiXD($model, $inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }


    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
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
        //Gán mặc định quyết định
        getTaoDuThaoKTCumKhoi($model);
        //dd($model);
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
        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //dd($model);

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
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
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }

    public function XetKT(Request $request)
    {
        if (!chkPhanQuyen('xdhosodenghikhenthuongthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')
                ->with('machucnang', 'xdhosodenghikhenthuongthiduacumkhoi')
                ->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongCongTrang/HoSo/';
        $inputs['url_xd'] = '/KhenThuongCongTrang/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongCongTrang/KhenThuong/';
        $inputs['mahinhthuckt'] = session('chucnang')['xdhosodenghikhenthuongthiduacumkhoi']['mahinhthuckt'] ?? 'ALL';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        // $model_detai = dshosotdktcumkhoi_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $model->tendonvi = $donvi->tendonvi;

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        return view('NghiepVu.KhenThuongCongTrang.XetDuyetHoSo.XetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            // ->with('model_detai', $model_detai)           
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
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
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }

    public function InToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhPheDuyet($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhdenghi;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
    }

    public function TrinhKetQua(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/HoSoThiDua/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/KhenThuongThiDua/';
        $inputs['url'] =  static::$url;
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $inputs['mahinhthuckt'] = session('chucnang')['xdhosodenghikhenthuongthiduacumkhoi']['mahinhthuckt'] ?? 'ALL';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_tailieu = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        //$inputs['madonvi'] = $model->madonvi_xd;//Gán đơn vị tải tài liệu đính kèm
        //dd($model_tailieu);
        return view('NghiepVu.KhenThuongCongTrang.XetDuyetHoSo.TrinhKetQua')
            ->with('model', $model)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin tờ trình đề nghị khen thưởng');
    }

    public function LuuTrinhKetQua(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        // if (isset($inputs['totrinhdenghi'])) {
        //     $dinhkem = new dungchung_nghiepvu_tailieuController();
        //     $dinhkem->ThemTaiLieuDK($request, 'dshosotdktcumkhoi', 'totrinhdenghi', $model->madonvi_xd);
        // }
        // dd($inputs);
        $maduthao = duthaoquyetdinh::where('phanloai', 'TOTRINHPHEDUYET')->first()->maduthao ?? '';
        if ($maduthao != '')
            getTaoDuThaoToTrinhPheDuyetCumKhoi($model, $maduthao);
        $model->update($inputs);

        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }
}
