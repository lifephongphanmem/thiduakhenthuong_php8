<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvu_tailieuController;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class tnhosodenghikhenthuongdoingoaiController extends Controller
{
    public static $url = '/KhenThuongDoiNgoai/TiepNhan/';
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
        if (!chkPhanQuyen('tnhosodenghikhenthuongdoingoai', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongDoiNgoai/HoSo/';
        $inputs['url_xd'] = '/KhenThuongDoiNgoai/TiepNhan/';
        $inputs['url_qd'] = '/KhenThuongDoiNgoai/KhenThuong/';
        $inputs['phanquyen'] = 'tnhosodenghikhenthuongdoingoai';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem'] = '/DungChung/DinhKemHoSoKhenThuong';
        $inputs['url_thamdinh'] = '/KhenThuongDoiNgoai/TiepNhan/DsHoSoThamDinh';

        $m_donvi = getDonVi(session('admin')->capdo, 'tnhosodenghikhenthuongdoingoai');
        // $m_donvi = getDonVi(session('admin')->capdo);
        if (count($m_donvi) == 0) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['tnhosodenghikhenthuongdoingoai']['maloaihinhkt'] ?? 'ALL';
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
        // $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('phanloai', '<>', 'QUANLY')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        if (!in_array(session('admin')->sadmin, ['SSA'])) {
            $a_taikhoanchuyenvien_tn = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('tendangnhap', '!=', session('admin')->tendangnhap)->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        } else {
            $a_taikhoanchuyenvien_tn = $a_taikhoanchuyenvien;
        }
        $a_trangthai_taikhoan = ['DCCVXD', 'DCCVKT', 'DTN', 'DDK', 'KDD', 'BTL', 'BTLXD'];
        // foreach ($model as $key => $hoso) {
        //     $hoso->soluongkhenthuong = $m_khencanhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
        //         + $m_khentapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
        //     //$hoso->soluongkhenthuong = 1;
        //     //Gán lại trạng thái hồ sơ
        //     $hoso->madonvi_hoso = $hoso->madonvi_xd;
        //     $hoso->trangthai_hoso = $hoso->trangthai_xd;
        //     $hoso->thoigian_hoso = $hoso->thoigian_xd;
        //     $hoso->lydo_hoso = $hoso->lydo_xd;
        //     $hoso->madonvi_nhan_hoso = $hoso->madonvi_kt;
        //     // dd(getPhanLoaiTaiKhoanTiepNhan());
        //     if (session('admin')->opt_quytrinhkhenthuong == 'TAIKHOAN' && !getPhanLoaiTaiKhoanTiepNhan()) {
        //         if (!getLocTaiKhoanXetDuyet($hoso->tendangnhap_xd))
        //             $model->forget($key);
        //     } else
        //     if (count($a_donvilocdulieu) > 0) {
        //         //lọc các hồ sơ theo thiết lập dữ liệu
        //         if (!in_array($hoso->madonvi, $a_donvilocdulieu))
        //             $model->forget($key);
        //     }
        // }
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
                    if ($canbo_xl->tendangnhap_xl == session('admin')->tendangnhap) {
                        $hoso->thaotac = false;
                    }
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
                    // if ($thongtin_canbonhan->phanloai == "VANTHU" && $hoso->trangthai_xl == "KDK") {
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
                //xét phân loại tài khoản để hiển thị lại cho tài khoản phó giám đốc và giám đốc sở
                if (session('admin')->phanloai == 'LANHDAO') {
                    $inputs['taikhoanlanhdao'] = true;
                }
            } elseif (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->madonvi, $a_donvilocdulieu))
                    $model->forget($key);
            }
        }

        $inputs['trangthai'] = session('chucnang')['tnhosodenghikhenthuongdoingoai']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        //dd($model->where('trangthai','CXKT')->where('madonvi_kt',''));
        // dd( $model);

        return view('NghiepVu.KhenThuongDoiNgoai.TiepNhan.ThongTin')
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
        if (!chkPhanQuyen('tnhosodenghikhenthuongdoingoai', 'tiepnhan')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'tiepnhan');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        if (session('admin')->opt_quytrinhkhenthuong == 'TAIKHOAN') {
            setTraLai($model, $inputs);
        } else {
            setTraLaiXD($model, $inputs);
        }

        //add thông tin vào bảng thông báo
        $url_tl = '/KhenThuongDoiNgoai/HoSo/ThongTin';
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' trả lại hồ sơ hồ sơ đề nghị khen thưởng ';
        $chucnang = 'doingoai';
        //Lấy tên tài khoản tiếp nhận để hiển thị thông báo
        $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $model->mahosotdkt)->orderby('created_at', 'desc')->first();
        $tk_dn = isset($hoso) ? $hoso->tendangnhap_tn : null;
        storeThongBao($url_tl, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, $model->madonvi_xd, 'quanly', $tk_dn, 'dshosodenghikhenthuongdoingoai');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongdoingoai', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DD';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->save();
        $url = '/KhenThuongDoiNgoai/XetDuyet/ThongTin';
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' chuyển hồ sơ xét duyệt ';
        $chucnang = 'doingoai';
        storeThongBao($url, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, $inputs['madonvi'], 'quanly', null, 'xdhosodenghikhenthuongdoingoai');
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
        if (!chkPhanQuyen('tnhosodenghikhenthuongdoingoai', 'tiepnhan')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'tiepnhan');
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
        if (!chkPhanQuyen('tnhosodenghikhenthuongdoingoai', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'xuly');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'DCCVXD';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setChuyenChuyenVienXD($model, $inputs, 'dshosothiduakhenthuong');

        //gán thông tin vào bảng xử lý hồ sơ
        $url = '/KhenThuongDoiNgoai/TiepNhan/ThongTin';
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' chuyển hồ sơ cho ' . $a_taikhoan[$inputs['tendangnhap_tn']];
        $chucnang = 'doingoai';
        storeThongBao($url, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, session('admin')->madonvi, 'quanly', $inputs['tendangnhap_tn'], 'tnhosodenghikhenthuongdoingoai');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function XuLyHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongdoingoai', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'xuly');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $model->trangthai = 'DCCVXD';
        $model->save();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setXuLyHoSo($model, $inputs, 'dshosothiduakhenthuong');

        //gán thông tin vào bảng xử lý hồ sơ
        $url = '/KhenThuongDoiNgoai/TiepNhan/ThongTin';
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' chuyển hồ sơ cho ' . $a_taikhoan[$inputs['tendangnhap_tn']];
        $chucnang = 'doingoai';
        storeThongBao($url, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, session('admin')->madonvi, 'quanly', $inputs['tendangnhap_tn'], 'tnhosodenghikhenthuongdoingoai');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }
    public function QuaTrinhXuLyHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong_xuly::where('mahosotdkt', $inputs['mahosotdkt'])->OrderBy('created_at')->get();
        $a_canbo = array_column(dstaikhoan::all()->toArray(), 'tentaikhoan', 'tendangnhap');
        return view('NghiepVu._DungChung.InQuaTrinhXuLy')
            ->with('model', $model)
            ->with('a_canbo', $a_canbo)
            ->with('a_trangthaihs', getTrangThaiHoSo())
            ->with('pageTitle', 'Thông tin quá trình xử lý hồ sơ đề nghị khen thưởng');
    }
    public function HoSoThamDinh(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongdoingoai', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongdoingoai')->with('tenphanquyen', 'xuly');
        }
        $inputs = $request->all();
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahoso'])->get();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahoso'])->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahoso'])->get();

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_dhkt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
        $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
        $a_loaihinhkt = array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt');

        $result['message'] = '<div class="row" id="hsthamdinh">';
        $result['message'] .= '<div class="col-md-12">';
        $result['message'] .= '<div class="card card-custom">';
        $result['message'] .= '<div class="card-header card-header-tabs-line">';
        $result['message'] .= '<div class="card-toolbar">';
        $result['message'] .= '<ul class="nav nav-tabs nav-bold nav-tabs-line">';
        $result['message'] .= '<li class="nav-item">';
        $result['message'] .= '<a class="nav-link active" data-toggle="tab" href="#kt_tapthe">';
        $result['message'] .= '<span class="nav-icon">';
        $result['message'] .= '<i class="fas fa-users"></i>';
        $result['message'] .= '</span>';
        $result['message'] .= '<span class="nav-text">Tập thể</span>';
        $result['message'] .= '</a>';
        $result['message'] .= '</li>';
        $result['message'] .= '<li class="nav-item">';
        $result['message'] .= '<a class="nav-link" data-toggle="tab" href="#kt_canhan">';
        $result['message'] .= '<span class="nav-icon">';
        $result['message'] .= '<i class="fas fa-users"></i>';
        $result['message'] .= '</span>';
        $result['message'] .= '<span class="nav-text">Cá nhân</span>';
        $result['message'] .= '</a>';
        $result['message'] .= '</li>';
        $result['message'] .= '<li class="nav-item">';
        $result['message'] .= '<a class="nav-link" data-toggle="tab" href="#kt_hogiadinh">';
        $result['message'] .= '<span class="nav-icon">';
        $result['message'] .= '<i class="fas fa-users"></i>';
        $result['message'] .= ' </span>';
        $result['message'] .= '<span class="nav-text">Hộ gia đình</span>';
        $result['message'] .= '</a>';
        $result['message'] .= '</li>';
        $result['message'] .= ' </ul>';
        $result['message'] .= '</div>';
        $result['message'] .= ' <div class="card-toolbar"></div>';
        $result['message'] .= '</div>';
        $result['message'] .= '<div class="card-body">';
        $result['message'] .= '<div class="tab-content">';
        //Hồ sơ tham gia tập thể
        $result['message'] .= '<div class="tab-pane fade active show" id="kt_tapthe" role="tabpanel"
                                            aria-labelledby="kt_tapthe">';

        $result['message'] .= '<div class="form-group row">';
        $result['message'] .= ' <div class="col-md-12">';
        $result['message'] .= ' <table class="table table-striped table-bordered table-hover dulieubang" id="sample_4"><thead>';
        $result['message'] .= ' <tr class="text-center">';
        $result['message'] .= ' <th width="2%">STT</th>';
        $result['message'] .= ' <th>Tên tập thể</th>';
        $result['message'] .= '  <th>Phân loại<br>đối tượng</th>';
        $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
        // $result['message'] .= '<th>Loại hình khen thưởng</th>';
        $result['message'] .= ' <th>Thao tác</th>';
        $result['message'] .= ' </tr>';
        $result['message'] .= '</thead>';

        $i = 1;
        foreach ($model_tapthe as $key => $tt) {
            $danhhieu = explode(';', $tt->madanhhieukhenthuong);
            $tt->madanhhieukhenthuong = '';
            foreach ($danhhieu as $item) {
                $tt->madanhhieukhenthuong .= $a_dhkt[$item] . '; ';
            }

            $result['message'] .= '<tr>';
            $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
            $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
            $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
            $result['message'] .= '<td class="text-center">' . $tt->madanhhieukhenthuong . '</td>';
            // $result['message'] .= '<td class="text-center">' . ($a_loaihinhkt[$model->maloaihinhkt] ?? '') . '</td>';
            $result['message'] .= '<td class="text-center"><input type="checkbox" name="hoso_tapthe[' . $tt->id . ']" '.($tt->ketqua == 1?"checked":'').' />';
            $result['message'] .= ' </td>';
            $result['message'] .= ' </tr>';
        }

        $result['message'] .= '</table>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';

        $result['message'] .= '</div>';
        //Hồ sơ tham gia cá nhân
        $result['message'] .= '<div class="tab-pane fade" id="kt_canhan" role="tabpanel" aria-labelledby="kt_canhan">';
        $result['message'] .= '<div class="form-group row">';
        $result['message'] .= ' <div class="col-md-12">';
        $result['message'] .= ' <table class="table table-striped table-bordered table-hover dulieubang"><thead>';
        $result['message'] .= ' <tr class="text-center">';
        $result['message'] .= ' <th width="2%">STT</th>';
        $result['message'] .= ' <th>Tên đối tượng</th>';
        $result['message'] .= ' <th width="5%">Giới</br>tính</th>';
        $result['message'] .= '<th width="15%">Phân loại cán bộ</th>';
        $result['message'] .= '<th>Thông tin công tác</th>';
        $result['message'] .= '<th width="8%">Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
        $result['message'] .= ' <th width="5%">Thao tác</th>';
        $result['message'] .= ' </tr>';
        $result['message'] .= '</thead>';

        $j = 1;
        foreach ($model_canhan as $key => $tt) {
            $danhhieu = explode(';', $tt->madanhhieukhenthuong);

            $tt->madanhhieukhenthuong = '';
            foreach ($danhhieu as $item) {
                $tt->madanhhieukhenthuong .= $a_dhkt[$item] . '; ';
            }
            $result['message'] .= '<tr>';
            $result['message'] .= '<td class="text-center">' . $j++ . '</td>';
            // $result['message'] .= '<td class="text-center">' . $a_donvi[$tt->madonvi] . '</td>';
            $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
            $result['message'] .= '<td>' . $tt->gioitinh . '</td>';
            $result['message'] .= '<td class="text-center">' . ($a_canhan[$tt->maphanloaicanbo] ?? '') . '</td>';
            $result['message'] .= '<td class="text-center">' . ($tt->chucvu . ',' . $tt->tenphongban . ',' . (array_key_exists($tt->tencoquan, getDsCoQuan($model->madonvi)) ? getDsCoQuan($model->madonvi)[$tt->tencoquan] : $tt->tencoquan)) . '</td>';
            $result['message'] .= '<td class="text-center">' . $tt->madanhhieukhenthuong . '</td>';
            $result['message'] .= '<td class="text-center"><input type="checkbox" name="hoso_canhan[' . $tt->id . ']" '.($tt->ketqua == 1?"checked":'').' />';
            $result['message'] .= ' </td>';
            $result['message'] .= ' </tr>';
        }
        $result['message'] .= '</table>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        //Hồ sơ hộ gia đình
        $result['message'] .= '<div class="tab-pane fade" id="kt_hogiadinh" role="tabpanel" aria-labelledby="kt_hogiadinh">';
        $result['message'] .= '<div class="form-group row">';
        $result['message'] .= ' <div class="col-md-12">';
        $result['message'] .= ' <table class="table table-striped table-bordered table-hover dulieubang"><thead>';
        $result['message'] .= ' <tr class="text-center">';
        $result['message'] .= ' <th width="2%">STT</th>';
        $result['message'] .= '  <th>Tên hộ gia đình</th>';
        $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng </th>';
        $result['message'] .= ' <th width="5%">Thao tác</th>';
        $result['message'] .= ' </tr>';
        $result['message'] .= '</thead>';

        $y = 1;
        foreach ($model_hogiadinh as $key => $tt) {
            $danhhieu = explode(';', $tt->madanhhieukhenthuong);

            $tt->madanhhieukhenthuong = '';
            foreach ($danhhieu as $item) {
                $tt->madanhhieukhenthuong .= $a_dhkt[$item] . '; ';
            }
            $result['message'] .= '<tr>';
            $result['message'] .= '<td class="text-center">' . $y++ . '</td>';
            $result['message'] .= '<td class="text-center">' . $tt->tentapthe . '</td>';
            $result['message'] .= '<td class="text-center">' . $tt->madanhhieukhenthuong . '</td>';
            $result['message'] .= '<td class="text-center"><input type="checkbox" name="hoso_hogiadinh[' . $tt->id . ']" '.($tt->ketqua == 1?"checked":'').' />';
            $result['message'] .= ' </td>';
            $result['message'] .= ' </tr>';
        }
        $result['message'] .= '</table>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';
        $result['message'] .= '</div>';

        $result['status'] = 'success';

        return response()->json($result);
    }
}
