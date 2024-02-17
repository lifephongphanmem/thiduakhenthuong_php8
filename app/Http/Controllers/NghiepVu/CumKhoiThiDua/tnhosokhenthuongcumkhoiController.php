<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\View\view_dscumkhoi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class tnhosokhenthuongcumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/KTCumKhoi/TiepNhan/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('tnhosokhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'tnhosokhenthuongcumkhoi');
        if ($m_donvi->count() == 0) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;

        // $model = dscumkhoi::where('madonvikt', $inputs['madonvi'])->get();
        $model = dscumkhoi::all();
        $m_hoso = dshosotdktcumkhoi::wherein('macumkhoi', array_column($model->toarray(), 'macumkhoi'))
            ->where('madonvi_xd', $inputs['madonvi'])->get();
        $a_trangthai = array_unique(array_column($m_hoso->toarray(), 'trangthai'));
        foreach ($model as $chitiet) {
            $hoso = $m_hoso->where('macumkhoi', $chitiet->macumkhoi);
            foreach ($a_trangthai as $trangthai) {
                $chitiet->$trangthai = $hoso->where('trangthai', $trangthai)->count();
            }
        }
        //dd($model);
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';
        return view('NghiepVu.CumKhoiThiDua.TiepNhan.ThongTin')
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
        if (!chkPhanQuyen('tnhosokhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();

        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/TiepNhan/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $m_donvi = getDonViXetDuyetHoSoCumKhoi(session('admin')->capdo, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        //dd($m_donvi);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';

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
        return view('NghiepVu.CumKhoiThiDua.TiepNhan.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViXetDuyetCumKhoi($inputs['macumkhoi']))
            // ->with('a_donviql', getDonViQuanLyCumKhoi($inputs['macumkhoi']))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Danh sách hồ sơ đề nghị khen thưởng');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('tnhosokhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiXD($model, $inputs);
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosokhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DD';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->save();

        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosotdktcumkhoi',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi_nhan' =>  $model->madonvi_xd,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Trình đề nghị khen thưởng.',
        ]);
        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //dd($model);

        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosokhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DTN';
        $model->trangthai_xd = 'DTN';
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
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi);
    }

    public function ChuyenChuyenVien(Request $request)
    {
        if (!chkPhanQuyen('tnhosokhenthuongcumkhoi', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'xuly');
        }
        $inputs = $request->all();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'DCCVXD';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //    dd($inputs);
        //gán thông tin vào bảng xử lý hồ sơ

        setChuyenChuyenVienXD($model, $inputs, 'dshosotdktcumkhoi');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']. '&macumkhoi=' . $model->macumkhoi);
    }

    public function XuLyHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosokhenthuongcumkhoi', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosokhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        // dd($inputs);

        setXuLyHoSo($model, $inputs, 'dshosotdktcumkhoi');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi'] . '&macumkhoi=' . $model->macumkhoi);
    }

    public function QuaTrinhXuLyHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $a_canbo = array_column(dstaikhoan::all()->toArray(), 'tentaikhoan', 'tendangnhap');
        return view('NghiepVu._DungChung.InQuaTrinhXuLy')
            ->with('model', $model)
            ->with('a_canbo', $a_canbo)
            ->with('a_trangthaihs', getTrangThaiHoSo())
            ->with('pageTitle', 'Thông tin quá trình xử lý hồ sơ đề nghị khen thưởng');
    }
}
