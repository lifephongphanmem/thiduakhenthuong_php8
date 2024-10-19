<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Models\View\viewdiabandonvi;
use App\Models\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhenthuongthiduaController extends Controller
{
    public static $url = '/HoSoDeNghiKhenThuongThiDua/';
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
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_dk'] = '/HoSoThiDua/';
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem'] = '/DungChung/DinhKemHoSoKhenThuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongthidua', null, 'MODEL');
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
                    $a_phamvi = getPhamViPhongTrao('H');
                    break;
                }
            case 'H': {
                    //Huyện: Đơn vị + Tỉnh
                    $model = viewdonvi_dsphongtrao::where('madiaban', $donvi->madiaban)
                        ->orwherein('phamviapdung', ['T', 'TW'])
                        ->orderby('tungay')->get();
                    $a_phamvi = getPhamViPhongTrao('T');
                    break;
                }
            case 'T': {
                    //Sở ban nganh: Đơn vị + Tỉnh
                    $model = viewdonvi_dsphongtrao::where('madonvi', $inputs['madonvi'])
                        ->orwherein('phamviapdung', ['T', 'TW'])
                        ->orderby('tungay')->get();
                    $a_phamvi = getPhamViPhongTrao('T');
                    break;
                }
        }
        // dd($model);    
        //kết quả        
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        if ($inputs['phamviapdung'] != 'ALL') {
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        }
        $ngayhientai = date('Y-m-d');
        $m_hosothamgia = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])
            ->wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))
            ->where('madonvi_nhan', $inputs['madonvi'])->get();
        $m_hoso = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])
            ->wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->get();
        $m_hoso_dvthammuu = dshosothiduakhenthuong::where('madonvi_nhan', $inputs['madonvi'])->wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->wherein('trangthai', ['CD', 'CTH', 'DTH'])->get();
        // dd($m_hoso_dvthammuu);
        $a_trangthai = array_unique(array_column($m_hoso->toarray(), 'trangthai'));

        $a_HeThongChung = getHeThongChung();
        //Xét theo tỉnh để cho chức năng đơn vị tham mưu chạy
        $diadanh = strtoupper(trim(str_replace(' ', '', chuyenkhongdau($a_HeThongChung['diadanh']))));


        foreach ($model as $key => $ct) {
            KiemTraPhongTrao($ct, $ngayhientai);
            // if ($donvi->capdo == 'X' && $ct->phamviapdung == 'T') {
            //     $model->forget($key);
            // }
            $khenthuong = $m_hoso->where('maphongtraotd', $ct->maphongtraotd);
            foreach ($a_trangthai as $trangthai) {
                $ct->$trangthai = $khenthuong->where('trangthai', $trangthai)->count();
            }
            $ct->sohosodenghi = $khenthuong->count();
            switch ($diadanh) {
                case 'KHANHHOA': {
                        $ct->sohosothamgia = $m_hosothamgia->where('maphongtraotd', $ct->maphongtraotd)->count();
                        break;
                    }
                case 'TUYENQUANG': {
                        $ct->sohosothamgia = $m_hoso_dvthammuu->where('maphongtraotd', $ct->maphongtraotd)->count();
                        break;
                    }
            }
        }

        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] == 'ALL' ? 'CC' : $inputs['trangthai'];
        $a_donviql = getDonViXetDuyetDiaBan($donvi);

        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('a_phongtraotd', array_column($model->toarray(), 'noidung', 'maphongtraotd'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthai_hoso', $a_trangthai)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_trangthai', getTrangThaiHoSo())
            // ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phamvi', $a_phamvi)
            // ->with('a_donviql', $a_donviql)
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Hồ sơ đề nghị khen thưởng thi đua');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        // dd($inputs);
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem'] = '/DungChung/DinhKemHoSoKhenThuong';

        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $ngayhientai = date('Y-m-d');
        //Kiểm tra phong trào        
        KiemTraPhongTrao($m_phongtrao, $ngayhientai);

        $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        //Lấy đơn vị quản lý địa bàn
        $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('madonvi', $inputs['madonvi'])
            ->get();


        // dd($inputs['madonvi']);
        //   dd($model);  
        switch (getDiaDanh()) {
            case 'KHANHHOA': {
                    $model_hoso = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])
                        ->where('maphongtraotd', $inputs['maphongtraotd'])
                        ->where('madonvi_nhan', $inputs['madonvi'])->get();
                    break;
                }
            case 'TUYENQUANG': {
                    if ($m_phongtrao->donvi_thammuu == $inputs['madonvi']) {
                        // dd(12323);
                        $model_hoso = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])->where('madonvi_nhan', $inputs['madonvi'])->where('trangthai', 'CTH')->get();
                    } else {
                        $model_hoso = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])
                            ->where('maphongtraotd', $inputs['maphongtraotd'])
                            ->where('madonvi_nhan', $inputs['madonvi'])->get();
                    }
                    break;
                }
        }

        foreach ($model_hoso as $ct) {
            $ct->mahoso = $ct->mahosothamgiapt ?? $ct->mahosotdkt;
        }
        // //trường hợp phạm vi phong trào của tỉnh
        // if($m_phongtrao->phamviapdung == 'T')
        // {
        //     $phongtraotinh=dsphongtraothidua::where('maphongtraotd_coso',$inputs['maphongtraotd'])->get();
        //     $a_phongtraocoso=array_column($phongtraotinh->toarray(),'maphongtraotd');
        //     $m_hoso_coso=dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])
        //     ->wherein('maphongtraotd',$a_phongtraocoso)
        //     ->where('madonvi_nhan', $inputs['madonvi'])->get();
        //     $colection=collect([$model_hoso,$m_hoso_coso]);
        //     // dd($colection);
        //     $model_hoso=$colection->collapse();

        // }
        // dd($model_hoso);
        foreach ($model as $key => $hoso) {
            $hoso->soluongkhenthuong = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->count()
                + dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->count();
            //Gán lại trạng thái hồ sơ
            // $hoso->madonvi_hoso = $hoso->madonvi_xd;
            // $hoso->trangthai_hoso = $hoso->trangthai_xd;
            // $hoso->thoigian_hoso = $hoso->thoigian_xd;
            // $hoso->lydo_hoso = $hoso->lydo_xd;
            // $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_xd;
            // //Lấy phạm vi áp dụng của hồ sơ để gửi xét duyệt ở huyện hoặc gửi lên trên 
            // $phamviapdung = dsphongtraothidua::where('maphongtraotd', $hoso->maphongtraotd)->first();
            // $hoso->phamviapdung = $phamviapdung->phamviapdung;
        }
        $inputs['url_return'] = static::$url . 'DanhSach?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $inputs['maphongtraotd'];
        // dd($m_phongtrao);
        // dd($inputs);
        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('model_hoso', $model_hoso)
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('m_phongtrao', $m_phongtrao)
            // ->with('a_donviql', getDonViXetDuyetPhongTrao($donvi, $m_phongtrao))
            ->with('a_donviql', getDonViXetDuyetDiaBan_PhongTrao($donvi, 'ARRAY', $m_phongtrao->donvi_thammuu))
            // ->with('a_donviql', getDonViXetDuyetDiaBan($donvi))
            // ->with('a_donviql', getDonViXDDiaBan($donvi))
            ->with('a_donvinganh', getDonViQuanLyNganh($donvi))
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function ThemKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        // dd($inputs);
        //Lấy danh sách hồ sơ theo phong trào; theo địa bàn,; theo đơn vi nhận
        $a_hoso = array_keys($inputs['hoso'] ?? []);
        // dd($inputs);
        if ($m_phongtrao->donvi_thammuu == $inputs['madonvi']) {
            $m_hosokt = dshosothiduakhenthuong::wherein('mahosotdkt', $a_hoso)->where('trangthai', 'CTH')->get();
        } else {
            $m_hosokt = dshosothamgiaphongtraotd::wherein('mahosothamgiapt', $a_hoso)->get();
        }

        // dd($m_hosokt);
        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;

        $a_canhan = [];
        $a_tapthe = [];
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        setThongTinHoSo($inputs);
        $inputs['phanloai'] = 'KHENTHUONG';
        switch (getDiaDanh()) {
            case 'KHANHHOA': {
                    foreach ($m_hosokt as $hoso) {
                        //Khen thưởng cá nhân
                        foreach (dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $hoso->mahosothamgiapt)->get() as $canhan) {
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
                                'madanhhieukhenthuong' => $canhan->madanhhieukhenthuong,
                                'ketqua' => '1',
                            ];
                        }

                        //Khen thưởng tập thể
                        foreach (dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $hoso->mahosothamgiapt)->get() as $tapthe) {
                            $a_tapthe[] = [
                                'mahosotdkt' => $inputs['mahosotdkt'],
                                'maphanloaitapthe' => $tapthe->maphanloaitapthe,
                                'tentapthe' => $tapthe->tentapthe,
                                'ghichu' => $tapthe->ghichu,
                                'madanhhieukhenthuong' => $tapthe->madanhhieukhenthuong,
                                'ketqua' => '1',
                            ];
                        }
                        //Lưu trạng thái
                        $hoso->mahosotdkt = $inputs['mahosotdkt'];
                        $thoigian = date('Y-m-d H:i:s');
                        setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => $inputs['trangthai']]);
                        // setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => $inputs['trangthai']]);
                        $hoso->save();

                        // dshosothiduakhenthuong::create($inputs);
                        // foreach (array_chunk($a_canhan, 100) as $data) {
                        //     dshosothiduakhenthuong_canhan::insert($data);
                        // }
                        // foreach (array_chunk($a_tapthe, 100) as $data) {
                        //     dshosothiduakhenthuong_tapthe::insert($data);
                        // }
                    }
                    dshosothiduakhenthuong::create($inputs);
                    foreach (array_chunk($a_canhan, 100) as $data) {
                        dshosothiduakhenthuong_canhan::insert($data);
                    }
                    foreach (array_chunk($a_tapthe, 100) as $data) {
                        dshosothiduakhenthuong_tapthe::insert($data);
                    }
                    break;
                }
            case 'TUYENQUANG': {
                    foreach ($m_hosokt as $hoso) {
                        // dd(dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->get());
                        if ($m_phongtrao->donvi_thammuu == $inputs['madonvi']) {
                            //Lấy tất cả những hồ sơ cá nhân và tập thể đã được tiếp nhận để làm hồ sơ gửi lên ban thi đua 
                            //Khen thưởng cá nhân
                            foreach (dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->get() as $canhan) {
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
                                    'madanhhieukhenthuong' => $canhan->madanhhieukhenthuong,
                                    'ketqua' => '1',
                                    'tonghop_dvthammuu' => 1,
                                    'mahstonghop'=>$inputs['mahosotdkt'].'_'.$canhan->id
                                ];
                                // $canhan->mahstonghop=$inputs['mahosotdkt'].'_'.$canhan->id;
                                $canhan->update(['mahstonghop'=>$inputs['mahosotdkt'].'_'.$canhan->id]);
                            }
                            //Khen thưởng tập thể
                            foreach (dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->get() as $tapthe) {
                                $a_tapthe[] = [
                                    'mahosotdkt' => $inputs['mahosotdkt'],
                                    'maphanloaitapthe' => $tapthe->maphanloaitapthe,
                                    'tentapthe' => $tapthe->tentapthe,
                                    'ghichu' => $tapthe->ghichu,
                                    'madanhhieukhenthuong' => $tapthe->madanhhieukhenthuong,
                                    'ketqua' => '1',
                                    'tonghop_dvthammuu' => 1,
                                    'mahstonghop'=>$inputs['mahosotdkt'].'_'.$tapthe->id
                                ];
                                $tapthe->update(['mahstonghop'=>$inputs['mahosotdkt'].'_'.$tapthe->id]);
                            }
                            // dshosothiduakhenthuong::create($inputs);
                            // foreach (array_chunk($a_canhan, 100) as $data) {
                            //     dshosothiduakhenthuong_canhan::insert($data);
                            // }
                            // foreach (array_chunk($a_tapthe, 100) as $data) {
                            //     dshosothiduakhenthuong_tapthe::insert($data);
                            // }
                            $hoso->mahosotdkt_dvthammuu = $inputs['mahosotdkt'];
                            $hoso->save();
                        } else {

                            //Khen thưởng cá nhân
                            foreach (dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $hoso->mahosothamgiapt)->get() as $canhan) {
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
                                    'madanhhieukhenthuong' => $canhan->madanhhieukhenthuong,
                                    'ketqua' => '1',
                                ];
                            }

                            //Khen thưởng tập thể
                            foreach (dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $hoso->mahosothamgiapt)->get() as $tapthe) {
                                $a_tapthe[] = [
                                    'mahosotdkt' => $inputs['mahosotdkt'],
                                    'maphanloaitapthe' => $tapthe->maphanloaitapthe,
                                    'tentapthe' => $tapthe->tentapthe,
                                    'ghichu' => $tapthe->ghichu,
                                    'madanhhieukhenthuong' => $tapthe->madanhhieukhenthuong,
                                    'ketqua' => '1',
                                ];
                            }

                            // dshosothiduakhenthuong::create($inputs);
                            // foreach (array_chunk($a_canhan, 100) as $data) {
                            //     dshosothiduakhenthuong_canhan::insert($data);
                            // }
                            // foreach (array_chunk($a_tapthe, 100) as $data) {
                            //     dshosothiduakhenthuong_tapthe::insert($data);
                            // }

                            //Lưu trạng thái
                            $hoso->mahosotdkt = $inputs['mahosotdkt'];
                            $thoigian = date('Y-m-d H:i:s');
                            setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => $inputs['trangthai']]);
                            // setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => $inputs['trangthai']]);
                            $hoso->save();
                        }
                        //Lưu trạng thái
                        // $hoso->mahosotdkt = $inputs['mahosotdkt'];
                        // $thoigian = date('Y-m-d H:i:s');
                        // setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => $inputs['trangthai']]);
                        // // setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => $inputs['trangthai']]);
                        // $hoso->save();
                    }
                    dshosothiduakhenthuong::create($inputs);
                    foreach (array_chunk($a_canhan, 100) as $data) {
                        dshosothiduakhenthuong_canhan::insert($data);
                    }
                    foreach (array_chunk($a_tapthe, 100) as $data) {
                        dshosothiduakhenthuong_tapthe::insert($data);
                    }
                    break;

                }

        }



        // dshosothiduakhenthuong::create($inputs);
        // foreach (array_chunk($a_canhan, 100) as $data) {
        //     dshosothiduakhenthuong_canhan::insert($data);
        // }
        // foreach (array_chunk($a_tapthe, 100) as $data) {
        //     dshosothiduakhenthuong_tapthe::insert($data);
        // }

        //Lưu trạng thái
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $inputs['trangthai'],
            'thoigian' => $inputs['ngayhoso'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Tạo mới hồ sơ đề nghị khen thưởng.',
            'tendangnhap' => session('admin')->tendangnhap,
        ]);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt'] . '&madonvi=' . $inputs['madonvi']);
    }

    public function LuuKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        // if (isset($inputs['totrinh'])) {
        //     $filedk = $request->file('totrinh');
        //     $inputs['totrinh'] = $model->mahosotdkt . '_totrinh' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        // }
        // if (isset($inputs['baocao'])) {
        //     $filedk = $request->file('baocao');
        //     $inputs['baocao'] = $model->mahosotdkt . '_baocao' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        // }
        // if (isset($inputs['bienban'])) {
        //     $filedk = $request->file('bienban');
        //     $inputs['bienban'] = $model->mahosotdkt . '_bienban' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        // }
        // if (isset($inputs['tailieukhac'])) {
        //     $filedk = $request->file('tailieukhac');
        //     $inputs['tailieukhac'] = $model->mahosotdkt . '_tailieukhac' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        // }
        $model->update($inputs);
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function Sua(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        // dd($inputs);
        $inputs['url'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['maloaihinhkt'] = session('chucnang')['dshosothidua']['maloaihinhkt'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        switch (getDiaDanh()) {
            case 'KHANHHOA': {
                    $model_tapthe =  dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
                    $model_canhan =  dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
                    $model_hogiadinh =  dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
                    $model_tailieu =  dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    break;
                }
            case 'TUYENQUANG': {
                    if ($m_phongtrao->donvi_thammuu == $inputs['madonvi']) {
                        // $m_model = dshosothiduakhenthuong::where('maphongtraotd', $model->maphongtraotd)->where('madonvi_nhan', $model->madonvi)->where('trangthai', 'CTH')->get();
                        // $a_mahoso = array_column($m_model->toarray(), 'mahosotdkt');
                        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('tonghop_dvthammuu', 1)->get();
                        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->where('tonghop_dvthammuu', 1)->get();
                        // $model_hogiadinh =  dshosothiduakhenthuong_hogiadinh::wherein('mahosotdkt', $a_mahoso)->where('tonghop_dvthammuu',1)->get();
                        // $model_tailieu =  dshosothiduakhenthuong_tailieu::wherein('mahosotdkt', $a_mahoso)->where('tonghop_dvthammuu',1)->get();
                        $model_hogiadinh =  dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
                        $model_tailieu =  dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    } else {
                        $model_tapthe =  dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
                        $model_canhan =  dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
                        $model_hogiadinh =  dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
                        $model_tailieu =  dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    }
                    break;
                }
        }

        // $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        // $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        // $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        // $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $a_dhkt_canhan = getDanhHieuKhenThuong('ALL', 'CANHAN');
        $a_dhkt_tapthe = getDanhHieuKhenThuong('ALL', 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong('ALL', 'HOGIADINH');

        // $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        $model->tenphongtrao = $m_phongtrao->noidung;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_dhkt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
        foreach ($model_canhan as $ct) {
            $danhhieu = explode(';', $ct->madanhhieukhenthuong);
            $ct->madanhhieukhenthuong = '';
            foreach ($danhhieu as $item) {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] . '; ';
            }
        }

        foreach ($model_tapthe as $ct) {
            $danhhieu = explode(';', $ct->madanhhieukhenthuong);
            $ct->madanhhieukhenthuong = '';
            foreach ($danhhieu as $item) {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] . '; ';
            }
        }
        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.XetKT')
            ->with('model', $model)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_canhan', $model_canhan)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('m_tieuchuan', $m_tieuchuan)
            ->with('a_dhkt_canhan',  $a_dhkt_canhan)
            ->with('a_dhkt_tapthe',  $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Hồ sơ đề nghị khen thưởng phong trào thi đua');
    }

    public function XoaHoSoKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothamgiaphongtraotd::where('mahosotdkt', $model->mahosotdkt)->update(['trangthai' => 'DD', 'mahosotdkt' => null]);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function XemHoSoKT(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();

        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.XemKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', getDanhHieuKhenThuong('ALL', 'ALL'))
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function DanhSachHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        $ngayhientai = date('Y-m-d');
        KiemTraPhongTrao($m_phongtrao, $ngayhientai);

        // dd(getDiaDanh());
        switch (getDiaDanh()) {
            case 'KHANHHOA': {
                    $model = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
                        ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
                            $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                                ->where('madonvi_nhan', $inputs['madonvi'])
                                ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                                ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
                        })->wherenotin('trangthai', ['BTL'])->get();
                    break;
                }
            case 'TUYENQUANG': {
                    if ($m_phongtrao->donvi_thammuu == $inputs['madonvi']) {
                        $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
                            ->where('madonvi_nhan', $inputs['madonvi'])
                            ->wherenotin('trangthai', ['BTL'])
                            ->get();
                    } else {
                        $model = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
                            ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
                                $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                                    ->where('madonvi_nhan', $inputs['madonvi'])
                                    ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                                    ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
                            })->wherenotin('trangthai', ['BTL'])->get();
                    }
                    break;
                }
        }
        // dd();
        // if ($m_phongtrao->donvi_thammuu == $inputs['madonvi']) {
        //     $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
        //         ->where('madonvi_nhan', $inputs['madonvi'])
        //         ->wherenotin('trangthai', ['BTL'])
        //         ->get();
        // } else {
        //     $model = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
        //         ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
        //             $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
        //                 ->where('madonvi_nhan', $inputs['madonvi'])
        //                 ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
        //                 ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
        //         })->wherenotin('trangthai', ['BTL'])->get();
        // }

        // dd($model);
        $m_hoso_dangky = dshosodangkyphongtraothidua::all();
        //Kiểm tra phong trào => nếu đã hết hạn thì ko cho thao tác nhận, trả hồ sơ
        //Chỉ có thể trả lại và tiếp nhận hồ sơ do cấp nào khen thưởng cấp đó nên ko để chuyển vượt cấp
        // dd($model);
        foreach ($model as $chitiet) {
            if ($m_phongtrao->donvi_thammuu == $inputs['madonvi']) {
                $chitiet->url = '/HoSoDeNghiKhenThuongThiDua/InHoSo?mahosotdkt=' . $chitiet->mahosotdkt;
            } else {
                $chitiet->url = '/HoSoThiDua/Xem?mahosothamgiapt=' . $chitiet->mahosothamgiapt;
            }
            $chitiet->nhanhoso = $m_phongtrao->nhanhoso;
            $chitiet->mahosodk = $m_hoso_dangky->where('madonvi', $chitiet->madonvi)->first()->mahosodk ?? null;
            getDonViChuyen($inputs['madonvi'], $chitiet);
        }
        // dd($model);
        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.DanhSachHoSoThamGia')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }


    public function XemDanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_dangky = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        // $model = dshosothamgiaphongtraotd::where('maphongtraotd',$inputs['maphongtraotd'])
        // ->wherein('mahosothamgiapt',function($qr){
        //     $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai',['CD','DD'])->where('phanloai','dshosothamgiaphongtraotd')->get();
        // })->get();
        //$m_trangthai = trangthaihoso::wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothamgiaphongtraotd')->orderby('thoigian', 'desc')->get();
        $model = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
                $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
            })->get();
        foreach ($model as $chitiet) {
            $chitiet->chuyentiephoso = false;
            if ($m_dangky->phamviapdung == 'TOANTINH' && $donvi->capdo == 'H')
                $chitiet->chuyentiephoso = true;
            getDonViChuyen($inputs['madonvi'], $chitiet);
            //$chitiet->trangthai = $donvi->capdo == 'H' ? $chitiet->trangthai_h : $chitiet->trangthai_t;
        }
        //dd($model);
        $m_donvi = getDonVi(session('admin')->capdo);

        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.Xem')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_dangky', $m_dangky)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViQuanLyTinh()) //chưa lọc hết (chỉ chuyển lên cấp Tỉnh)
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //Kiểm tra phong trào xem đơn vị tiếp nhận có quản lý không (phong trào cấp H thì đơn vị cấp Tỉnh ko nhìn thấy)
        $m_phongtrao =  dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        $phamviapdung = $m_phongtrao->phamviapdung ?? 'PHAMVI';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $capdo = $donvi->capdo ?? 'CAPDO';
        if ($m_phongtrao->donvi_thammuu == null) {
            switch ($phamviapdung) {
                case 'X': {
                        if ($phamviapdung != $capdo) {
                            return view('errors.404')
                                ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . '</b> không thể nhận đề nghị xét khen thưởng.')
                                ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                        }
                        break;
                    }
                case 'H': {
                        if (!in_array($capdo, ['X', 'H'])) {
                            return view('errors.404')
                                ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . '</b> không thể nhận đề nghị xét khen thưởng.')
                                ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                        }
                        break;
                    }
                case 'SBN': {
                        if (!in_array($capdo, ['T'])) {
                            return view('errors.404')
                                ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . ' </b>không thể nhận đề nghị xét khen thưởng.')
                                ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                        }
                        break;
                    }
                case 'T': {
                        if (!in_array($capdo, ['T'])) {
                            return view('errors.404')
                                ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . '</b> không thể nhận đề nghị xét khen thưởng.')
                                ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                        }
                        break;
                    }
                default: {
                        // return view('errors.404')
                        //     ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
                        //     ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
            }
        }
        // dd($phamviapdung);
        // dd(session('chucnang')['dshosodenghikhenthuongthidua']['trangthai']);
        $inputs['trangthai'] = getTrangThaiChuyenHS(session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC');
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['lydo'] = ''; //Xóa lý do trả lại
        $tendangnhap = dstaikhoan::where('madonvi', $inputs['madonvi_nhan'])->first();
        // dd($tendangnhap);
        $model->tendangnhap_xl = $tendangnhap->tendangnhap ?? '';
        setChuyenDV($model, $inputs);
        // setChuyenDV_Huyen($model, $inputs);
        // $inputs['tendangnhap_xl']=$model->madonvi;
        // $inputs['tendangnhap_tn']=$inputs['madonvi_nhan'];
        // $inputs['noidungxuly_xl']='';
        // setXuLyHoSo($model, $inputs, 'dshosothiduakhenthuong');
        //Thêm dữ liệu vào bảng thông báo
        $url = '/TiepNhanHoSoThiDua/TiepNhan/DanhSach?madonvi =' . $model->madonvi_nhan . '&maphongtraotd=' . $model->maphongtraotd;
        $a_taikhoan = array_column(dstaikhoan::select('tentaikhoan', 'tendangnhap')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        $noidung = $a_taikhoan[session('admin')->tendangnhap] . ' chuyển hồ sơ đề nghị khen thưởng ';
        $chucnang = 'khenthuongphongtrao';
        storeThongBao($url, $noidung, $chucnang, $inputs['mahoso'], null, $model->madonvi, $inputs['madonvi_nhan'], 'phongtraothidua', null, 'tnhosodenghikhenthuongthidua');
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&maphongtraotd=' . $model->maphongtraotd);
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
        $model->lydo = $model->lydo;
        die(json_encode($model));
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
        $inputs['madanhhieukhenthuong'] = implode(';', $inputs['madanhhieukhenthuong']);
        //$id =  $inputs['id'];       
        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothiduakhenthuong_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
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
        $model = dshosothiduakhenthuong_canhan::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
        return response()->json($result);
    }

    // public function NhanExcelCaNhan(Request $request)
    // {
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
    //     $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
    //     $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
    //     $data = [];

    //     Excel::load($path, function ($reader) use (&$data, $inputs) {
    //         $obj = $reader->getExcel();
    //         $sheet = $obj->getSheet(0);
    //         $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
    //     });
    //     $a_dm = array();

    //     for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
    //         if (!isset($data[$i][$inputs['tendoituong']])) {
    //             continue;
    //         }
    //         $a_dm[] = array(
    //             'mahosotdkt' => $inputs['mahosotdkt'],
    //             'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
    //             'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
    //             'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
    //             // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
    //             'gioitinh' => $data[$i][$inputs['gioitinh']] ?? 'NAM',
    //             'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
    //             'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
    //             'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
    //             'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
    //             'ketqua' => '1',
    //         );
    //     }

    //     dshosothiduakhenthuong_canhan::insert($a_dm);
    //     File::Delete($path);

    //     return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    // }

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
        $inputs['madanhhieukhenthuong'] = implode(';', $inputs['madanhhieukhenthuong']);
        //$id =  $inputs['id'];       
        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothiduakhenthuong_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
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
        $model = dshosothiduakhenthuong_tapthe::findorfail($inputs['id']);
        //Xóa mahstonghop của đơn vị cấp dưới
        $m_tapthe=dshosothiduakhenthuong_tapthe::where($model->mahstonghop)->first();
        $m_tapthe->mahstonghop=null;
        $m_tapthe->save();
        $model->delete();

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    // public function NhanExcelTapThe(Request $request)
    // {
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
    //     $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
    //     $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
    //     $data = [];

    //     Excel::load($path, function ($reader) use (&$data, $inputs) {
    //         $obj = $reader->getExcel();
    //         $sheet = $obj->getSheet(0);
    //         $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
    //     });
    //     $a_dm = array();

    //     for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
    //         if (!isset($data[$i][$inputs['tentapthe']])) {
    //             continue;
    //         }
    //         $a_dm[] = array(
    //             'mahosotdkt' => $inputs['mahosotdkt'],
    //             'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
    //             // 'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
    //             'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
    //             'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
    //             'ketqua' => '1',
    //         );
    //     }
    //     dshosothiduakhenthuong_tapthe::insert($a_dm);
    //     File::Delete($path);

    //     return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    // }

    // public function TaiLieuDinhKem(Request $request)
    // {
    //     $result = array(
    //         'status' => 'fail',
    //         'message' => 'error',
    //     );

    //     $inputs = $request->all();
    //     $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahs'])->first();
    //     $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
    //     if ($model->totrinh != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->baocao != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->bienban != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->tailieukhac != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     $result['message'] .= '</div>';
    //     $result['status'] = 'success';

    //     die(json_encode($result));
    // }

    // public function GanKhenThuong(Request $request)
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
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     if ($inputs['phanloai'] == 'TAPTHE') {
    //         dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
    //         $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
    //         $dungchung = new dungchung_nghiepvuController();
    //         $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
    //     } else {
    //         dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
    //         $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
    //         $dungchung = new dungchung_nghiepvuController();
    //         $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
    //     }

    //     return response()->json($result);
    // }

    public function NhanExcel(Request $request)
    {
        // $dungchung = new dungchung_nhanexcelController();
        // $dungchung->NhanExcelKhenThuong($request);
        // return redirect(static::$url . 'XetKT?mahosotdkt=' . $request->all()['mahoso']);
        $inputs = $request->all();
        // dd($inputs);
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelKhenThuong($request);
        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahoso'] . '&madonvi=' . $inputs['madonvi']);
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
        dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->delete();
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function DSHoSo_DvThamMuu(Request $request) //Chức năng sử dụng cho đơn vị tham mưu của tỉnh Tuyên Quang
    {
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahs'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahs'])->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahs'])->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahs'])->get();

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_dhkt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');

        $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
        foreach ($model_canhan as $ct) {
            $danhhieu = explode(';', $ct->madanhhieukhenthuong);

            $ct->madanhhieukhenthuong = '';
            foreach ($danhhieu as $item) {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] . '; ';
            }

            //Lấy mã đơn vị của hồ sơ
            $hoso=dshosothiduakhenthuong::where('mahosotdkt',$ct->mahosotdkt)->first();
            $donvi = dshosothamgiaphongtraotd::where('mahosotdkt', $ct->mahosotdkt)->first();
            $ct->madonvi_thamgia = $donvi->madonvi ?? $hoso->madonvi;
        }

        foreach ($model_tapthe as $ct) {
            $danhhieu = explode(';', $ct->madanhhieukhenthuong);
            $ct->madanhhieukhenthuong = '';
            foreach ($danhhieu as $item) {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] . '; ';
            }
            $hoso=dshosothiduakhenthuong::where('mahosotdkt',$ct->mahosotdkt)->first();
            $donvi = dshosothamgiaphongtraotd::where('mahosotdkt', $ct->mahosotdkt)->first();
            $ct->madonvi_thamgia = $donvi->madonvi ?? $hoso->madonvi;
        }
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $result['message'] = '<div class="row" id="hsthamgia">';
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
        // $result['message'] .= '<li class="nav-item">';
        // $result['message'] .= '<a class="nav-link" data-toggle="tab" href="#kt_hogiadinh">';
        // $result['message'] .= '<span class="nav-icon">';
        // $result['message'] .= '<i class="fas fa-users"></i>';
        // $result['message'] .= ' </span>';
        // $result['message'] .= '<span class="nav-text">Hộ gia đình</span>';
        // $result['message'] .= '</a>';
        // $result['message'] .= '</li>';
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
        $result['message'] .= ' <th width="15%">Đơn vị tham gia</th>';
        $result['message'] .= ' <th width="15%">Tên tập thể</th>';
        $result['message'] .= '<th width="10%">Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
        $result['message'] .= ' <th width="5%">Thao tác</th>';
        $result['message'] .= ' </tr>';
        $result['message'] .= '</thead>';

        $i = 1;
        foreach ($model_tapthe as $key => $tt) {

            $result['message'] .= '<tr>';
            $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
            $result['message'] .= '<td>' . ($a_donvi[$tt->madonvi_thamgia]??'') . '</td>';
            $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
            $result['message'] .= '<td class="text-center">' . $tt->madanhhieukhenthuong . '</td>';
            $result['message'] .= '<td class="text-center"><input type="checkbox" name="hoso_tapthe[' . $tt->id . ']" checked />';
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
        $result['message'] .= ' <th width="8%">Đơn vị tham gia</th>';
        $result['message'] .= ' <th width="20%">Tên đối tượng</th>';
        $result['message'] .= ' <th>Giới tính</th>';
        $result['message'] .= '<th width="8%">Phân loại cán bộ</th>';
        $result['message'] .= '<th width="8%">Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
        $result['message'] .= ' <th width="5%">Thao tác</th>';
        $result['message'] .= ' </tr>';
        $result['message'] .= '</thead>';

        $j = 1;
        foreach ($model_canhan as $key => $tt) {

            $result['message'] .= '<tr>';
            $result['message'] .= '<td class="text-center">' . $j++ . '</td>';
            $result['message'] .= '<td class="text-center">' . $a_donvi[$tt->madonvi_thamgia] . '</td>';
            $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
            $result['message'] .= '<td>' . $tt->gioitinh . '</td>';
            $result['message'] .= '<td class="text-center">' . ($a_canhan[$tt->maphanloaicanbo] ?? '') . '</td>';
            $result['message'] .= '<td class="text-center">' . $tt->madanhhieukhenthuong . '</td>';
            $result['message'] .= '<td class="text-center"><input type="checkbox" name="hoso_canhan[' . $tt->id . ']" checked />';
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

    public function NhanHoSo(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        //Chuyển hồ sơ đề nghị khen thưởng sang CTH
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        if (isset($model)) {
            $model->trangthai = 'CTH';
            $model->save();

            //Chuyển trạng thái của những hồ sơ được chọn sang trạng thái chờ tổng hợp ở đơn vị tham mưu
            if (isset($inputs['hoso_canhan'])) {
                $a_hoso = array_keys($inputs['hoso_canhan'] ?? []);
                $model_canhan = dshosothiduakhenthuong_canhan::wherein('id', $a_hoso)->update(['tonghop_dvthammuu' => 1]);
            }
            if (isset($inputs['hoso_tapthe'])) {
                $a_hoso = array_keys($inputs['hoso_tapthe'] ?? []);
                $model_tapthe = dshosothiduakhenthuong_tapthe::wherein('id', $a_hoso)->update(['tonghop_dvthammuu' => 1]);
            }
        }
        return redirect('HoSoDeNghiKhenThuongThiDua/DSHoSoThamGia?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $inputs['maphongtraotd']);
    }
}
