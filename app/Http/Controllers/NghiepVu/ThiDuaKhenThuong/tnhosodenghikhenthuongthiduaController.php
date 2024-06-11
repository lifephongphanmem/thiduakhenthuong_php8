<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


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
            chkaction();
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
                        $hoso->trangthai_chuyenchuyenvien = true;
                    } else {
                        $hoso->dieukien_hs = true;
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
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $model->maphongtraotd);
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
        return redirect(static::$url . 'DanhSach?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function XuLyHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhenthuongthidua', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        // dd($inputs);
        setXuLyHoSo($model, $inputs, 'dshosothiduakhenthuong');
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
}
