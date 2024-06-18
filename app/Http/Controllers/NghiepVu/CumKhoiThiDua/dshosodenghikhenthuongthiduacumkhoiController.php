<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
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
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_tapthe;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi_tieuchuan;
use App\Models\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Models\View\view_dscumkhoi;
use App\Models\View\view_dsphongtrao_cumkhoi;
use App\Models\View\viewdiabandonvi;
use App\Models\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhenthuongthiduacumkhoiController extends Controller
{
    public static $url = '/CumKhoiThiDua/DeNghiThiDua/';
    public function __construct()
    {
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
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = static::$url;
        $inputs['url_xd'] = '/CumKhoiThiDua/DeNghiThiDua/';
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthiduacumkhoi']['trangthai'] ?? 'CC';
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhenthuongthiduacumkhoi']['maloaihinhkt'] ?? 'ALL';
        //$m_donvi = getDonViCK(session('admin')->capdo, null, 'MODEL');
        $model_donvi = getDonViCK(session('admin')->capdo, 'dshosodenghikhenthuongthiduacumkhoi');
        //Lấy thêm đơn vị tiếp nhận để tổng hợp hồ sơ của các trưởng cụm
        $model_donvi_tn = viewdiabandonvi::wherein('madonvi',array_column(getTKTiepNhan([session('admin')->capdo])->toarray(),'madonvi') )->get();
        $m_donvi=$model_donvi_tn->concat($model_donvi);

        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
       

        // dd($m_donvi);
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $m_cumkhoi_chitiet = dscumkhoi_chitiet::where('madonvi', $inputs['madonvi'])->get();
        $model = dscumkhoi::wherein('macumkhoi', array_column($m_cumkhoi_chitiet->toarray(), 'macumkhoi'))->get();
        $m_hoso = dshosotdktcumkhoi::where('madonvi', $inputs['madonvi'])->get();

        $firstDayOfYear = Carbon::now()->startOfYear();
        $lastDayOfYear = Carbon::now()->endOfYear();
        $tungay = $firstDayOfYear->toDateString();
        $denngay = $lastDayOfYear->toDateString();
        $dsphantruongcumkhoi = dstruongcumkhoi::where('ngaytu', '>=', $tungay)->where('ngayden', '<=', $denngay)->first();
        // $a_truongcumkhoi = array_column(dstruongcumkhoi_chitiet::where('madanhsach', $dsphantruongcumkhoi->madanhsach)->get()->toarray(), 'madonvi', 'macumkhoi');
        foreach ($model as $ct) {
            // $ct->sohoso = $m_hoso->where('macumkhoi', $ct->macumkhoi)->count();
            $model_cumkhoi = view_dsphongtrao_cumkhoi::where('macumkhoi', $ct->macumkhoi)->orderby('tungay')->get();
            $ct->sohoso = dshosotdktcumkhoi::wherein('maphongtraotd', array_column($model_cumkhoi->toarray(), 'maphongtraotd'))
                ->where('macumkhoi', $ct->macumkhoi)->wherein('trangthai', ['CD', 'DD', 'CNXKT', 'DXKT', 'CXKT', 'DKT'])->get()->count();
            $ct->madonviql = $a_truongcumkhoi[$ct->macumkhoi] ?? '';
        }

        // dd($inputs);
        // dd($model);
        $model_hoso = dshosotdktcumkhoi::where('maloaihinhkt', $inputs['maloaihinhkt'])
        ->where('trangthai', 'DTN')
        ->where(function ($qr) use ($inputs) {
            $qr->where('madonvi_xd', $inputs['madonvi'])->orwhere('madonvi_kt', $inputs['madonvi']);
        })->get();
        // dd($model_hoso);
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();       
        $a_donviql = getDonViXetDuyetDiaBan_Tam($donvi);
        
        if(in_array($inputs['madonvi'],array_column(getTKTiepNhan([session('admin')->capdo])->toarray(),'madonvi'))){
            $view='NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoDeNghi.ThongTinTongHop';
            $model=dshosotdktcumkhoi::where('madonvi',$inputs['madonvi'])->get();


            $m_khenthuong = dshosotdktcumkhoi::where('madonvi', $inputs['madonvi'])->get();

            $m_khenthuong_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($m_khenthuong->toarray(), 'mahosotdkt'))->get();
            $m_khenthuong_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($m_khenthuong->toarray(), 'mahosotdkt'))->get();

            foreach($model as $ct){
                $ct->soluongkhenthuong = $m_khenthuong_canhan->where('mahosotdkt', $ct->mahosotdkt)->count()
                + $m_khenthuong_tapthe->where('mahosotdkt', $ct->mahosotdkt)->count();
            }
        }else{
            $view='NghiepVu.CumKhoiThiDua.HoSoKhenThuong.ThongTin';
        }
        // dd($model);
        return view($view)
            ->with('model', $model)
            ->with('model_hoso', $model_hoso)
            ->with('m_donvi', $m_donvi)
            // ->with('a_phongtraotd', array_column($model_phongtrao->toarray(), 'noidung', 'maphongtraotd'))
            ->with('m_diaban', $m_diaban)
            // ->with('a_truongcumkhoi', $a_truongcumkhoi)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', $a_donviql)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng cụm, khối thi đua');
    }

    public function DanhSach(Request $request)
    {
        //Chưa xử lý theo cụm khối mới xử lý theo phong trào, do trưởng cụm khối phát động rồi nhập hs đề nghị => chưa tính hết trường hợp
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = static::$url;
        // $inputs['url_hs'] = '/CumKhoiThiDua/ThamGiaThiDua/';
        $inputs['url_xd'] = '/CumKhoiThiDua/XetDuyetThiDua/';
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $inputs['phanloaikhenthuong'] = 'CUMKHOI';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        // $m_donvi = getDonVi(session('admin')->capdo);
        $model_donvi = getDonViCK(session('admin')->capdo, 'dshosodenghikhenthuongthiduacumkhoi');
        //Lấy thêm đơn vị tiếp nhận để tổng hợp hồ sơ của các trưởng cụm
        $model_donvi_tn = viewdiabandonvi::wherein('madonvi',array_column(getTKTiepNhan([session('admin')->capdo])->toarray(),'madonvi') )->get();
        $m_donvi=$model_donvi_tn->concat($model_donvi);
        // $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongthiduacumkhoi', null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_cumkhoi = view_dscumkhoi::where('madonvi', $inputs['madonvi'])->get();
        $a_cumkhoi = array_unique(array_column($m_cumkhoi->toarray(), 'macumkhoi'));
        //lấy hết phong trào cấp tỉnh
        // $model = view_dsphongtrao_cumkhoi::orderby('tungay')->get();
        
        $model = view_dsphongtrao_cumkhoi::orderby('tungay')->wherein('macumkhoi', $a_cumkhoi)->get();

        $ngayhientai = date('Y-m-d');
        $m_hoso = dshosothamgiathiduacumkhoi::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])->where('madonvi_nhan', $inputs['madonvi'])->get();
        $m_khenthuong = dshosotdktcumkhoi::where('madonvi', $inputs['madonvi'])->get();

        $m_khenthuong_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($m_khenthuong->toarray(), 'mahosotdkt'))->get();
        $m_khenthuong_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($m_khenthuong->toarray(), 'mahosotdkt'))->get();
        foreach ($model as $ct) {
            KiemTraPhongTrao($ct, $ngayhientai);
            $hoso = $m_hoso->where('maphongtraotd', $ct->maphongtraotd);
            $ct->sohoso = $hoso == null ? 0 : $hoso->count();

            $khenthuong = $m_khenthuong->where('maphongtraotd', $ct->maphongtraotd)->first();
            $ct->mahosotdkt = $khenthuong->mahosotdkt ?? '-1';
            $ct->trangthaikt = $khenthuong->trangthai ?? 'CXD';
            $ct->noidungkt = $khenthuong->noidung ?? '';
            $ct->madonvinhankt = $khenthuong->madonvi_xd ?? '';

            $ct->soluongkhenthuong = $m_khenthuong_canhan->where('mahosotdkt', $ct->mahosotdkt)->count()
                + $m_khenthuong_tapthe->where('mahosotdkt', $ct->mahosotdkt)->count();

            //gán để ko in hồ sơ mahosothamgiapt
            $ct->mahosothamgiapt = '-1';
        }
        // dd($model);
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthiduacumkhoi']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] == 'ALL' ? 'CC' : $inputs['trangthai'];

        $a_donviql = getDonViXetDuyetDiaBan_Tam($donvi);
        // dd($a_donviql);  
        // dd($model);  

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoDeNghi.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('a_phongtraotd', array_column($model->toarray(), 'noidung', 'maphongtraotd'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_donviql', $a_donviql)
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Hồ sơ đề nghị khen thưởng thi đua');
    }



    public function ThemKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $chk = dshosotdktcumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('phanloai', 'KHENTHUONG')
            ->where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        //Lấy danh sách cán bộ đề nghị khen thưởng rồi thêm vào hosothiduakhenthuong
        //Chuyển trạng thái hồ sơ tham gia
        //chuyển trang thái phong trào
        //dd($chk);
        if ($chk == null) {
            //Lấy danh sách hồ sơ theo phong trào; theo địa bàn,; theo đơn vi nhận
            $m_hosokt = dshosothamgiathiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
                ->wherein('mahoso', function ($qr) use ($inputs) {
                    $qr->select('mahoso')->from('dshosothamgiathiduacumkhoi')
                        ->wherein('trangthai', ['DD', 'CXKT'])
                        ->where('madonvi_nhan', $inputs['madonvi'])->get();
                })->get();
            //dd($m_hosokt);
            $inputs['mahosotdkt'] = (string)getdate()[0];
            $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;

            $a_canhan = [];
            $a_tapthe = [];
            $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthiduacumkhoi']['trangthai'] ?? 'DD';
            setThongTinHoSo($inputs);
            $inputs['phanloai'] = 'KHENTHUONG';
            foreach ($m_hosokt as $hoso) {
                //Khen thưởng cá nhân
                foreach (dshosothamgiathiduacumkhoi_canhan::where('mahoso', $hoso->mahoso)->get() as $canhan) {
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
                foreach (dshosothamgiathiduacumkhoi_tapthe::where('mahoso', $hoso->mahoso)->get() as $tapthe) {
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
                //$hoso->mahosotdkt = $inputs['mahosotdkt'];
                $thoigian = date('Y-m-d H:i:s');
                setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => $inputs['trangthai']]);
                setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => $inputs['trangthai']]);
                $hoso->save();
            }
            // if (isset($inputs['totrinh'])) {
            //     $filedk = $request->file('totrinh');
            //     $inputs['totrinh'] = $inputs['mahosotdkt'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            //     $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
            // }

            dshosotdktcumkhoi::create($inputs);
            foreach (array_chunk($a_canhan, 100) as $data) {
                dshosotdktcumkhoi_canhan::insert($data);
            }
            foreach (array_chunk($a_tapthe, 100) as $data) {
                dshosotdktcumkhoi_tapthe::insert($data);
            }
            //$m_phongtrao->trangthai = 'DXKT';
            //$m_phongtrao->save();
        }
        return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt'] . '&madonvi=' . $inputs['madonvi']);
    }

    public function LuuKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $madonvi=$model->madonvi;
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $model->mahosotdkt . '_totrinh' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['baocao'])) {
            $filedk = $request->file('baocao');
            $inputs['baocao'] = $model->mahosotdkt . '_baocao' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $model->mahosotdkt . '_bienban' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $model->mahosotdkt . '_tailieukhac' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        $model->update($inputs);
        // return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);

        // return redirect(static::$url . 'DanhSach?macumkhoi=' . $model->macumkhoi . '&madonvi=' . $model->madonvi);
        if(chkTkTiepNhan($madonvi,[session('admin')->capdo])){
            return redirect(static::$url . 'ThongTin?madonvi=' . $madonvi);
        }else{
            return redirect(static::$url . 'DanhSach?macumkhoi=' . $model->macumkhoi . '&madonvi=' . $model->madonvi);
        }
    }

    public function XetKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['url_hs'] = '/CumKhoiThiDua/ThamGiaThiDua/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $inputs['maloaihinhkt'] = session('chucnang')['dshosothidua']['maloaihinhkt'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $model =  dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->mahoso=$model->mahosotdkt;
        $model_tapthe =  dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_canhan =  dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();

        $model_tailieu =  dshosotdktcumkhoi_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first();
        $m_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        $model->tenphongtrao = $m_phongtrao->noidung??'Tổng hợp hồ sơ cụm khối';
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        //dd($inputs);
        // dd($model);
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoDeNghi.XetKT')
            ->with('model', $model)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_canhan', $model_canhan)
            // ->with('model_hogiadinh', $model_hogiadinh)
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

    public function ThemTongHop(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcongtrang')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();

        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['phanloai'] = 'KHENTHUONG';
        //lấy danh sách chi tiết
        if (isset($inputs['hoso'])) {
            $a_hoso = array_keys($inputs['hoso']);
            //Cá nhân
            $m_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', $a_hoso)->where('ketqua', 1)->get();
            $a_canhan = [];
            foreach ($m_canhan as $canhan) {
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
                    'ketqua' => 1,
                    'madanhhieukhenthuong' => $canhan->madanhhieukhenthuong,
                ];
            }
            dshosotdktcumkhoi_canhan::insert($a_canhan);
            //Tập thể
            $m_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', $a_hoso)->where('ketqua', 1)->get();
            $a_tapthe = [];
            foreach ($m_tapthe as $tapthe) {
                $a_tapthe[] = [
                    'mahosotdkt' => $inputs['mahosotdkt'],
                    'ketqua' => 1,
                    'madanhhieukhenthuong' => $tapthe->madanhhieukhenthuong,
                    'linhvuchoatdong' => $tapthe->linhvuchoatdong,
                    'maphanloaitapthe' => $tapthe->maphanloaitapthe,
                    'tentapthe' => $tapthe->tentapthe,
                ];
            }

            //Cập nhật trạng thái hồ sơ
            dshosotdktcumkhoi::wherein('mahosotdkt', $a_hoso)->update(['trangthai' => 'DTH', 'trangthai_xd' => 'DTH']);
        }

        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSo($inputs);
        //Lưu nhật ký
        dshosotdktcumkhoi::create($inputs);
        $trangthai = new trangthaihoso();
        $trangthai->trangthai = $inputs['trangthai'];
        $trangthai->madonvi = $inputs['madonvi'];
        $trangthai->thongtin = "Thêm mới hồ sơ đề nghị khen thưởng";
        $trangthai->phanloai = 'dshosothiduakhenthuong';
        $trangthai->mahoso = $inputs['mahosotdkt'];
        $trangthai->thoigian = $inputs['ngayhoso'];
        $trangthai->save();

        return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt'].'&madonvi='.$inputs['madonvi']);
    }

    public function XoaHoSoKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $madonvi=$model->madonvi;
        dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothamgiathiduacumkhoi::where('mahoso', $model->mahosotdkt)->update(['trangthai' => 'DD', 'mahoso' => null]);
        $model->delete();
        if(chkTkTiepNhan($madonvi,[session('admin')->capdo])){
            return redirect(static::$url . 'ThongTin?madonvi=' . $madonvi);
        }else{
            return redirect(static::$url . 'DanhSach?macumkhoi=' . $model->macumkhoi . '&madonvi=' . $model->madonvi);
        }

    }

    public function XemHoSoKT(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoDeNghi.XemKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', getDanhHieuKhenThuong('ALL'))
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('a_coquan',getDsCoQuan())
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function DanhSachChiTiet(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/ThamGiaThiDua/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        $ngayhientai = date('Y-m-d');
        KiemTraPhongTrao($m_phongtrao, $ngayhientai);
        $model = dshosothamgiathiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahoso', function ($qr) use ($inputs) {
                $qr->select('mahoso')->from('dshosothamgiathiduacumkhoi')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_xd', $inputs['madonvi'])
                    ->orwhere('madonvi_kt', $inputs['madonvi'])->get();
            })->get();
        $m_hoso_dangky = dshosodangkyphongtraothidua::all();
        //Kiểm tra phong trào => nếu đã hết hạn thì ko cho thao tác nhận, trả hồ sơ
        //Chỉ có thể trả lại và tiếp nhận hồ sơ do cấp nào khen thưởng cấp đó nên ko để chuyển vượt cấp
        //dd($model);
        foreach ($model as $chitiet) {
            $chitiet->nhanhoso = $m_phongtrao->nhanhoso;
            $chitiet->mahosodk = $m_hoso_dangky->where('madonvi', $chitiet->madonvi)->first()->mahosodk ?? null;
            getDonViChuyen($inputs['madonvi'], $chitiet);
        }

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoDeNghi.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function XemDanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_dangky = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        // $model = dshosothamgiathiduacumkhoi::where('maphongtraotd',$inputs['maphongtraotd'])
        // ->wherein('mahosothamgiapt',function($qr){
        //     $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai',['CD','DD'])->where('phanloai','dshosothamgiathiduacumkhoi')->get();
        // })->get();
        //$m_trangthai = trangthaihoso::wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothamgiathiduacumkhoi')->orderby('thoigian', 'desc')->get();
        $model = dshosothamgiathiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahoso', function ($qr) use ($inputs) {
                $qr->select('mahoso')->from('dshosothamgiathiduacumkhoi')
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

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.HoSoDeNghi.Xem')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_dangky', $m_dangky)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViQuanLyTinh()) //chưa lọc hết (chỉ chuyển lên cấp Tỉnh)
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        $m_nhatky = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        //lấy thông tin lưu nhật ký
        getDonViChuyen($inputs['madonvi'], $m_nhatky);
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'], 'trangthai' => 'BTL',
            'thoigian' => $thoigian, 'lydo' => $inputs['lydo'],
            'madonvi_nhan' => $m_nhatky->madonvi_hoso, 'madonvi' => $m_nhatky->madonvi_nhan_hoso
        ]);

        $model->lydo = $inputs['lydo'];
        $model->trangthai = 'BTL';
        $model->trangthai_xd = null;
        $model->thoigian_xd = null;
        $model->madonvi_xd = null;
        $model->save();

        $m_hoso = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();

        return redirect(static::$url . 'DanhSach?maphongtraotd=' . $m_hoso->maphongtraotd . '&madonvi=' . $inputs['madonvi']);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        //$m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $model->trangthai = 'DD';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;

        //setNhanHoSo($inputs['madonvi_nhan'], $model, ['trangthai' => $model->trangthai]);
        //dd($model);
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        $model->save();

        return redirect('/CumKhoiThiDua/DeNghiThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $inputs['madonvi_nhan']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //Kiểm tra phong trào xem đơn vị tiếp nhận có quản lý không (phong trào cấp H thì đơn vị cấp Tỉnh ko nhìn thấy)        
        $phamviapdung = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first()->phamviapdung ?? 'PHAMVI';
        $capdo = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first()->capdo ?? 'CAPDO';
        switch ($phamviapdung) {
            case 'X': {
                    if ($phamviapdung != $capdo) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            case 'H': {
                    if (!in_array($capdo, ['X', 'H'])) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            case 'SBN': {
                    if (!in_array($capdo, ['T'])) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
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

        //gán lại trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = getTrangThaiChuyenHS(session('chucnang')['dshosodenghikhenthuongthiduacumkhoi']['trangthai'] ?? 'CC');

        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['lydo'] = ''; //Xóa lý do trả lại        
        setChuyenDV_CumKhoi($model, $inputs);

        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //dd($model);

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
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->lydo = $model->lydo_xd;
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
        //$id =  $inputs['id'];       
        $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = '1';
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

        $m_tapthe = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
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
        //return response()->json($inputs);     
        $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = '1';
            dshosotdktcumkhoi_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
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
        $model = dshosotdktcumkhoi_tapthe::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function ToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        $dungchung->NhanExcelCumKhoi($request);
        return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahoso'].'&madonvi='.$inputs['madonvi']);
    }

    public function InHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->tenphongtraotd = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();


        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('NghiepVu.KhenThuongCongTrang.HoSoKhenThuong.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            // ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }
}
