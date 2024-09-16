<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongNienHan;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class tnhosodenghikhenthuongnienhanController extends Controller
{
    public static $url = '/KhenThuongNienHan/TiepNhan/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            if (!chkaction()) {
                Session::flush();
                return response()->view('errors.error_login');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongnienhan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongnienhan')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongNienHan/HoSo/';
        $inputs['url_xd'] = '/KhenThuongNienHan/TiepNhan/';
        $inputs['url_qd'] = '/KhenThuongNienHan/KhenThuong/';
        $inputs['phanquyen'] = 'tnhosodenghikhenthuongnienhan';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem'] = '/DungChung/DinhKemHoSoKhenThuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'tnhosodenghikhenthuongnienhan');
        // $m_donvi = getDonVi(session('admin')->capdo);
        if (count($m_donvi) == 0) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongnienhan')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhenthuongnienhan']['maloaihinhkt'] ?? 'ALL';
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();

        $model = dshosothiduakhenthuong::where('madonvi_xd', $inputs['madonvi'])
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH', 'KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC',])
            ->where('maloaihinhkt', $inputs['maloaihinhkt']) //->orderby('ngayhoso')->get();
            ->wherenotin('trangthai_xd', ['BTL']);

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
        $m_khencanhan = dshosothiduakhenthuong_canhan::where('ketqua', '1')->wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        $m_khentapthe = dshosothiduakhenthuong_tapthe::where('ketqua', '1')->wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();

        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        if (!in_array(session('admin')->sadmin, ['SSA'])) {
            $a_taikhoanchuyenvien_tn = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('tendangnhap', '!=', session('admin')->tendangnhap)->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        } else {
            $a_taikhoanchuyenvien_tn = $a_taikhoanchuyenvien;
        }
        // $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('phanloai', '<>', 'QUANLY')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        // $a_hosoxuly = getHoSoXuLy(array_column($model->toarray(), 'mahosotdkt'), session('admin')->tendangnhap, 'dshosothiduakhenthuong');
        $a_trangthai_taikhoan = ['DCCVXD', 'DCCVKT', 'DTN', 'DDK', 'KDD', 'BTL', 'BTLXD'];
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
            $hoso->thaotac = true;
            // dd(getPhanLoaiTaiKhoanTiepNhan());

            if (session('admin')->opt_quytrinhkhenthuong == 'TAIKHOAN') {
                //Nghiên cứu xây dựng lọc hồ sơ theo phân loại tài khoản getPhanLoaiTaiKhoan()             
                //Nếu trạng thái thì mới mở các chức năng theo phân quyền lấy theo tendangnhap_xl
                if (!in_array($hoso->trangthai_xd, $a_trangthai_taikhoan) && !in_array(session('admin')->tendangnhap, ['SSA', $hoso->tendangnhap_xl]))
                    $hoso->thaotac = false;
                //lấy thông tin cán bộ xử lý cuối cùng
                $m_canbo_xl = dshosothiduakhenthuong_xuly::where('mahosotdkt', $hoso->mahosotdkt)->orderby('created_at', 'desc')->get();
                $hoso->trangthai_chuyenchuyenvien = true;
                if (count($m_canbo_xl) > 0) {
                    //lấy danh sách tài khoản trong xử lý hồ sơ để hiển thị hồ sơ
                    $a_taikhoan_xl = array_column($m_canbo_xl->toarray(), 'tendangnhap_tn');
                    // dd($a_taikhoan_xl);
                    if (!in_array(session('admin')->tendangnhap, $a_taikhoan_xl) && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                        $model->forget($key);
                    }
                    $canbo_xl = $m_canbo_xl->first();
                    if ($canbo_xl->tendangnhap_tn != session('admin')->tendangnhap) {
                        $hoso->thaotac = false;
                    }
                    if ($hoso->trangthai_xd == 'BTLTN') {
                        $hoso->tendangnhap_xl = $canbo_xl->tendangnhap_tn;
                    }
                    if ($canbo_xl->tendangnhap_tn == session('admin')->tendangnhap && $hoso->trangthai_xd == 'BTLTN') {
                        $hoso->thaotac = true;
                        // $hoso->tendangnhap_xl=session('admin')->tendangnhap;
                        $hoso->trangthai_xl = 'KDK';
                    }
                    $thongtincanbo = dstaikhoan::where('tendangnhap', $canbo_xl->tendangnhap_xl)->first();
                    // if ($thongtincanbo->phanloai == "VANTHU") {
                    if ($canbo_xl->tendangnhap_tn == getPhanLoaiTKTiepNhan(session('admin')->madonvi)) {
                        $hoso->dieukien_hs = false;
                        // $hoso->trangthai = 'DCXL';
                        $hoso->trangthai = 'DCCVXD';
                        if ($hoso->trangthai_xl == 'KDK') {
                            $hoso->trangthai_hoso = "KDK";
                        }
                        $hoso->trangthai_chuyenchuyenvien = true;
                    } else {
                        $hoso->dieukien_hs = true;
                    }
                    if (session('admin')->capdo == 'SSA' && $hoso->trangthai_xl == "KDK") {
                        $hoso->trangthai_hoso = "KDK";
                    }
                    //lấy thông tin cán bộ tiếp nhận để set trạng thái hồ sơ khi trưởng ban trả về văn thư
                    $thongtin_canbonhan = dstaikhoan::where('tendangnhap', $canbo_xl->tendangnhap_tn)->first();
                    if ($thongtin_canbonhan->tendangnhap_tn == getPhanLoaiTKTiepNhan(session('admin')->madonvi) && $hoso->trangthai_xl == "KDK") {
                        $hoso->trangthai_hoso = "KDK";
                    }
                    // if (session('admin')->phanloai == 'VANTHU') {
                    if ($canbo_xl->tendangnhap_tn == getPhanLoaiTKTiepNhan(session('admin')->madonvi)) {
                        $a_trangthai_hoso = array_column(trangthaihoso::where('mahoso', $hoso->mahosotdkt)->get()->toArray(), 'trangthai');
                        if (in_array('BTL', $a_trangthai_hoso)) {
                            $hoso->trangthai_chuyenchuyenvien = true;
                        }
                    }
                } else {
                    // if (session('admin')->phanloai == 'VANTHU') {
                    if (session('admin')->tendangnhap == getPhanLoaiTKTiepNhan(session('admin')->madonvi)) {
                        $hoso->trangthai_chuyenchuyenvien = true;
                    } else {
                        $model->forget($key);
                    }
                }

                if (session('admin')->tendangnhap == getPhanLoaiTKTiepNhan(session('admin')->madonvi)) {
                    $hoso->taikhoantiepnhan = true;
                }
                if (session('admin')->phanloai == 'LANHDAO') {
                    $inputs['taikhoanlanhdao'] = true;
                }
            } elseif (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->madonvi, $a_donvilocdulieu))
                    $model->forget($key);
            }
        }
        $inputs['trangthai'] = session('chucnang')['tnhosodenghikhenthuongnienhan']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        //dd($model->where('trangthai','CXKT')->where('madonvi_kt',''));
        //    dd( $model);
        return view('NghiepVu.KhenThuongNienHan.TiepNhan.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_taikhoan', array_column(dstaikhoan::all()->toArray(), 'tentaikhoan', 'tendangnhap'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViQuanLyDiaBan($donvi))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('a_taikhoanchuyenvien', $a_taikhoanchuyenvien)
            ->with('a_taikhoanchuyenvien_tn', $a_taikhoanchuyenvien_tn)
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongnienhan', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiXD($model, $inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongnienhan', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DD';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->save();

        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi_nhan' =>  $model->madonvi_xd,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Trình đề nghị khen thưởng.',
        ]);
        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //dd($model);

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongnienhan', 'tiepnhan')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DTN';
        $model->trangthai_xd = 'DTN';
        $model->thoigian_xd = $thoigian;
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Tiếp nhận hồ sơ đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }

    public function ChuyenChuyenVien(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongnienhan', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongnienhan')->with('tenphanquyen', 'xuly');
        }
        $inputs = $request->all();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'DCCVXD';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //    dd($inputs);
        //gán thông tin vào bảng xử lý hồ sơ

        setChuyenChuyenVienXD($model, $inputs, 'dshosothiduakhenthuong');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function XuLyHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongnienhan', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $model->trangthai='DCCVXD';
        $model->save();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        // dd($inputs);

        setXuLyHoSo($model, $inputs, 'dshosothiduakhenthuong');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function QuaTrinhXuLyHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong_xuly::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $a_canbo = array_column(dstaikhoan::all()->toArray(), 'tentaikhoan', 'tendangnhap');
        return view('NghiepVu._DungChung.InQuaTrinhXuLy')
            ->with('model', $model)
            ->with('a_canbo', $a_canbo)
            ->with('a_trangthaihs', getTrangThaiHoSo())
            ->with('pageTitle', 'Thông tin quá trình xử lý hồ sơ đề nghị khen thưởng');
    }
}
