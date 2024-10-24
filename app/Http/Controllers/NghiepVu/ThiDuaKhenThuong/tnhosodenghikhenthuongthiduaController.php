<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\Session;

class tnhosodenghikhenthuongthiduaController extends Controller
{
    public static $url = '/TiepNhanHoSoThiDua/';
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
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/TiepNhanHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanquyen'] = 'tnhosodenghikhenthuongthidua';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem'] = '/DungChung/DinhKemHoSoKhenThuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'tnhosodenghikhenthuongthidua', null, 'MODEL');
        if (count($m_donvi) == 0) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //Lọc danh sách phong trao
        /*
        1. Xã: Đơn vị + Huyện quản lý
        2. Huyện: Đơn vị + Tỉnh
        3. Sở ban nganh: Đơn vị + Tỉnh
        4. Tỉnh: Tỉnh
        */

        switch ($donvi->capdo) {
            case 'X': {
                    //Xã: Đơn vị + Huyện quản lý
                    $model = viewdonvi_dsphongtrao::wherein('madiaban', [$donvi->madiaban, $donvi->madiabanQL])->orderby('tungay')->get();
                    break;
                }
            case 'H': {
                    //Huyện: Đơn vị + Tỉnh
                    $model = viewdonvi_dsphongtrao::where('madiaban', $donvi->madiaban)
                        ->orwherein('phamviapdung', ['T', 'TW'])
                        ->orderby('tungay')->get();
                    break;
                }
            case 'T': {
                    //Sở ban nganh: Đơn vị + Tỉnh
                    $model = viewdonvi_dsphongtrao::where('madonvi', $inputs['madonvi'])
                        ->orwherein('phamviapdung', ['T', 'TW'])
                        ->orderby('tungay')->get();
                    break;
                }
        }

        //kết quả        
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        if ($inputs['phamviapdung'] != 'ALL') {
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        }
        $ngayhientai = date('Y-m-d');

        $m_hoso = dshosothiduakhenthuong::where('madonvi_xd', $inputs['madonvi'])
            ->wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->get();

        //dd($ngayhientai);
        $a_trangthai = array_unique(array_column($m_hoso->toarray(), 'trangthai'));

        foreach ($model as $ct) {
            KiemTraPhongTrao($ct, $ngayhientai);
            $khenthuong = $m_hoso->where('maphongtraotd', $ct->maphongtraotd);

            foreach ($a_trangthai as $trangthai) {
                $ct->$trangthai = $khenthuong->where('trangthai', $trangthai)->count();
            }
        }

        $inputs['trangthai'] = session('chucnang')['tnhosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] == 'ALL' ? 'CC' : $inputs['trangthai'];

        return view('NghiepVu.ThiDuaKhenThuong.TiepNhanHoSo.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('a_phongtraotd', array_column($model->toarray(), 'noidung', 'maphongtraotd'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthai_hoso', $a_trangthai)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_trangthai', getTrangThaiHoSo())
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Xét duyệt hồ sơ đề nghị khen thưởng thi đua');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/TiepNhanHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanquyen'] = 'tnhosodenghikhenthuongthidua';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem'] = '/DungChung/DinhKemHoSoKhenThuong';
        $inputs['url_thamdinh'] = '/TiepNhanHoSoThiDua/DsHoSoThamDinh';

        $m_donvi = getDonVi(session('admin')->capdo, 'tnhosodenghikhenthuongthidua');
        // $m_donvi = getDonVi(session('admin')->capdo);
        if (count($m_donvi) == 0) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['maloaihinhkt'] ?? 'ALL';
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model = dshosothiduakhenthuong::where('madonvi_xd', $inputs['madonvi'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherenotin('trangthai', ['BTL']);
        //->wherein('phanloai', ['KHENTHUONG', 'KTNGANH', 'KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC',])
        //->where('maloaihinhkt', $inputs['maloaihinhkt']); //->orderby('ngayhoso')->get();

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
        // dd($model);
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        // dd($a_donvilocdulieu);
        $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        if (!in_array(session('admin')->sadmin, ['SSA'])) {
            $a_taikhoanchuyenvien_tn = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('tendangnhap', '!=', session('admin')->tendangnhap)->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        } else {
            $a_taikhoanchuyenvien_tn = $a_taikhoanchuyenvien;
        }

        // dd($a_taikhoanchuyenvien);
        // $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('phanloai', '<>', 'QUANLY')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $a_hosoxuly = getHoSoXuLy(array_column($model->toarray(), 'mahosotdkt'), session('admin')->tendangnhap, 'dshosothiduakhenthuong');
        $a_trangthai_taikhoan = ['DCCVXD', 'DCCVKT', 'DTN', 'DDK', 'KDD', 'BTL'];
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
                if (in_array($hoso->trangthai_xd, $a_trangthai_taikhoan) && !in_array(session('admin')->tendangnhap, ['SSA', $hoso->tendangnhap_xl]))
                    $hoso->thaotac = false;

                $m_canbo_xl = dshosothiduakhenthuong_xuly::where('mahosotdkt', $hoso->mahosotdkt)->orderby('created_at', 'desc')->get();
                $hoso->trangthai_chuyenchuyenvien = true;
                if (count($m_canbo_xl) > 0) {
                    $canbo_xl = $m_canbo_xl->first();
                    if ($canbo_xl->tendangnhap_xl == session('admin')->tendangnhap) {
                        $hoso->thaotac = false;
                    }
                    $thongtincanbo = dstaikhoan::where('tendangnhap', $canbo_xl->tendangnhap_tn)->first();
                    // dd($thongtincanbo);
                    // if ($thongtincanbo->phanloai == "VANTHU") {
                    if ($canbo_xl->tendangnhap_tn == getPhanLoaiTKTiepNhan(session('admin')->madonvi)) {
                        $hoso->dieukien_hs = false;
                        $hoso->trangthai = 'DCXL';
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
                        // $hoso->trangthai="KDK";
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
        $inputs['trangthai'] = session('chucnang')['tnhosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        //dd($model->where('trangthai','CXKT')->where('madonvi_kt',''));
        // dd($model);

        return view('NghiepVu.ThiDuaKhenThuong.TiepNhanHoSo.DanhSach')
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
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
    public function DanhSach_LOAI12042024(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/TiepNhanHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanquyen'] = 'tnhosodenghikhenthuongthidua';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'tnhosodenghikhenthuongthidua');
        // $m_donvi = getDonVi(session('admin')->capdo);
        if (count($m_donvi) == 0) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['maloaihinhkt'] ?? 'ALL';
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        // $model = dshosothiduakhenthuong::where('madonvi_xd', $inputs['madonvi'])
        //     ->where('maphongtraotd', $inputs['maphongtraotd']);
        //->wherein('phanloai', ['KHENTHUONG', 'KTNGANH', 'KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC',])
        //->where('maloaihinhkt', $inputs['maloaihinhkt']); //->orderby('ngayhoso')->get();
        //Lấy hết tất cả các hồ sơ thuộc phong trào tham gia, xử lý hiển thị danh sách theo đơn vị qua bảng xử lý
        $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
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
        // dd($model);
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        // dd($a_donvilocdulieu);
        // dd($donvi);

        // $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $a_taikhoanchuyenvien = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        // dd($donvi);
        //Lấy đơn vị cấp trên để chuyển hồ sơ
        if ($donvi->capdo == 'T') {
            // $madiaban = $donvi->madiaban;
            $madiaban = $donvi->madonviQL;
        } else {
            // $madiaban = $donvi->madiabanQL;
            $madiaban = $donvi->madonviQL;
        }
        // dd($madiaban);
        $a_donvi_QL = array_column(dsdonvi::where('madonvi', $madiaban)->get()->toarray(), 'tendonvi', 'madonvi');
        // dd($a_donvi_QL);
        // $a_taikhoanchuyenvien = array_merge($a_donvi, $a_donvi_QL);
        foreach ($a_donvi_QL as $key => $ct) {
            $a_taikhoanchuyenvien[$key] = $ct;
        }
        // dd($a_taikhoanchuyenvien);
        //Lấy đơn vị thay vì lấy tài khoản


        // dd($a_taikhoanchuyenvien);
        // $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('phanloai', '<>', 'QUANLY')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $a_hosoxuly = getHoSoXuLy(array_column($model->toarray(), 'mahosotdkt'), session('admin')->tendangnhap, 'dshosothiduakhenthuong');
        $a_trangthai_taikhoan = ['DCCVXD', 'DCCVKT', 'DTN', 'DDK', 'KDD', 'BTL', 'BTLXD'];
        foreach ($model as $key => $hoso) {
            // dd($hoso);
            //xét hồ sơ xử lý để hiển thị hồ sơ theo đơn vị
            $hs_xuly = dshosothiduakhenthuong_xuly::where('mahosotdkt', $hoso->mahosotdkt)->orderby('created_at', 'desc')->get();
            $a_tendangnhap_tn = array_column($hs_xuly->toarray(), 'tendangnhap_tn');
            if (!in_array($inputs['madonvi'], $a_tendangnhap_tn)) {
                $model->forget($key);
                continue;
            }
            $hs_kdk = $hs_xuly->where('tendangnhap_xl', $inputs['madonvi'])->first();
            if (isset($hs_kdk)) {
                if ($hs_kdk->trangthai_xl == 'KDK') {
                    $model->forget($key);
                    continue;
                }
            }
            $hoso->soluongkhenthuong = $m_khencanhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $m_khentapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
            //$hoso->soluongkhenthuong = 1;
            //Gán lại trạng thái hồ sơ
            $hoso->madonvi_hoso = $hoso->madonvi_xd;
            // $hoso->trangthai_hoso = $hoso->trangthai_xd;
            $hoso->trangthai_hoso = $hoso->trangthai;
            $hoso->thoigian_hoso = $hoso->thoigian_xd;
            $hoso->lydo_hoso = $hoso->lydo_xd;
            $hoso->madonvi_nhan_hoso = $hoso->madonvi_kt;



            //xử lý ẩn hiện nút trình xét duyệt hồ sơ
            $hs_phongtrao = dsphongtraothidua::where('maphongtraotd', $hoso->maphongtraotd)->first();

            //xử lý ẩn hiện nút xử lý hồ sơ
            if (count($hs_xuly) > 0) {
                $dv_xl = $hs_xuly->first()->tendangnhap_tn;
                $trangthai_xl = $hs_xuly->first()->trangthai_xl;
                // dd($hs_xuly->where('tendangnhap_xl',$inputs['madonvi'])->first());
                $hoso->madonvi_nhan_hoso = $hs_xuly->where('tendangnhap_xl', $inputs['madonvi'])->first()->tendangnhap_tn ?? '';
                if ($dv_xl == $inputs['madonvi']) {
                    $hoso->thaotac = true;
                }
                //xử lý nút trả lại
                if ($dv_xl == $inputs['madonvi'] && $dv_xl == $hoso->madonvi_nhan_h && in_array($trangthai_xl, ['DTN', 'KDK', 'CD'])) {
                    $hoso->thaotac_tralai = true;
                }

                if (isset($hs_phongtrao)) {
                    if ($donvi->capdo == $hs_phongtrao->phamviapdung) {
                        $hoso->thaotac_xd = true;
                        $hoso->thaotac = false;
                    }
                }
            } else {
                $hoso->thaotac_tralai = true;
            }
            // dd(getPhanLoaiTaiKhoanTiepNhan());

            if (session('admin')->opt_quytrinhkhenthuong == 'TAIKHOAN') {
                //Nghiên cứu xây dựng lọc hồ sơ theo phân loại tài khoản getPhanLoaiTaiKhoan()             
                //Nếu trạng thái thì mới mở các chức năng theo phân quyền lấy theo tendangnhap_xl
                if (!in_array($hoso->trangthai_xd, $a_trangthai_taikhoan) && !in_array(session('admin')->tendangnhap, ['SSA', $hoso->tendangnhap_xl]))
                    $hoso->thaotac = false;
            } elseif (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->madonvi, $a_donvilocdulieu))
                    $model->forget($key);
            }
        }

        $inputs['trangthai'] = session('chucnang')['tnhosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        //dd($model->where('trangthai','CXKT')->where('madonvi_kt',''));
        // dd($model);

        return view('NghiepVu.ThiDuaKhenThuong.TiepNhanHoSo.DanhSach')
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            // ->with('a_donviql', getDonViQuanLyDiaBan($donvi))
            ->with('a_donviql', $a_donvi_QL)
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('a_taikhoanchuyenvien', $a_taikhoanchuyenvien)
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
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
        $url_tl = '/HoSoDeNghiKhenThuongThiDua/DanhSach?madonvi=' . $model->madonvi . '&maphongtraotd=' . $model->maphongtrao;
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' trả lại hồ sơ hồ sơ đề nghị khen thưởng ';
        $chucnang = 'khenthuongphongtrao';
        //Lấy tên tài khoản tiếp nhận để hiển thị thông báo
        $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $model->mahosotdkt)->orderby('created_at', 'desc')->first();
        $tk_dn = isset($hoso) ? $hoso->tendangnhap_tn : null;
        storeThongBao($url_tl, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, $model->madonvi_xd, 'phongtraothidua', $tk_dn, 'dshosodenghikhenthuongthidua');
        return redirect(static::$url . 'DanhSach?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DD';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        // $model->madonvi_xd = $inputs['madonvi_nhan'];
        $model->save();

        $url = '/XetDuyetHoSoThiDua/DanhSach/?madonvi =' . $model->madonvi_nhan . '&maphongtraotd=' . $model->maphongtraotd;
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' chuyển hồ sơ xét duyệt ';
        $chucnang = 'khenthuongphongtrao';
        storeThongBao($url, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, $inputs['madonvi'], 'phongtraothidua', null, 'xdhosodenghikhenthuongthidua');
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

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'tiepnhan')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DTN';
        $model->trangthai_xd = 'DTN';
        $model->thoigian_xd = $thoigian;
        $model->save();
        // $inputs['trangthai'] = 'DTN';
        // $inputs['thoigian'] = $thoigian;
        // $inputs['tendangnhap_xl'] = $inputs['madonvi_nhan'];
        // $inputs['tendangnhap_tn'] = $inputs['madonvi_nhan'];
        // $inputs['noidungxuly_xl'] = '';
        // setXuLyHoSo($model, $inputs, 'dshosothiduakhenthuong');
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Tiếp nhận hồ sơ đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function ChuyenChuyenVien(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'xuly');
        }
        $inputs = $request->all();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'DCCVXD';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //    dd($inputs);
        //gán thông tin vào bảng xử lý hồ sơ

        setChuyenChuyenVienXD($model, $inputs, 'dshosothiduakhenthuong');
        $url = '/TiepNhanHoSoThiDua/TiepNhan/DanhSach?madonvi =' . $model->madonvi_nhan . '&maphongtraotd=' . $model->maphongtraotd;
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' chuyển hồ sơ cho ' . $a_taikhoan[$inputs['tendangnhap_tn']];
        $chucnang = 'khenthuongphongtrao';
        storeThongBao($url, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, session('admin')->madonvi, 'phongtraothidua', $inputs['tendangnhap_tn'], 'tnhosodenghikhenthuongthidua');
        return redirect(static::$url . 'DanhSach?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function XuLyHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $model->trangthai = 'DCCVXD';
        $model->save();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        // dd($inputs);
        setXuLyHoSo($model, $inputs, 'dshosothiduakhenthuong');
        // dd($inputs);
        $url = '/TiepNhanHoSoThiDua/TiepNhan/DanhSach?madonvi =' . $model->madonvi_nhan . '&maphongtraotd=' . $model->maphongtraotd;
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' chuyển hồ sơ cho ' . $a_taikhoan[$inputs['tendangnhap_tn']];
        $chucnang = 'khenthuongphongtrao';
        storeThongBao($url, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, session('admin')->madonvi, 'phongtraothidua', $inputs['tendangnhap_tn'], 'tnhosodenghikhenthuongthidua');
        // $model->save();
        return redirect(static::$url . 'DanhSach?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $model->maphongtraotd);
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
    public function HoSoThamDinh(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongcongtrang', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongcongtrang')->with('tenphanquyen', 'xuly');
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
            $result['message'] .= '<td class="text-center"><input type="checkbox" name="hoso_tapthe[' . $tt->id . ']"'.($tt->ketqua == 1?"checked":'').' />';
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
            $result['message'] .= '<td class="text-center"><input type="checkbox" name="hoso_canhan[' . $tt->id . ']"'.($tt->ketqua == 1?"checked":'').' />';
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
