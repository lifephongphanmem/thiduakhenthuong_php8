<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvu_tailieuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\View\viewdiabandonvi;
use App\Models\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class qdhosodenghikhenthuongthiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongHoSoThiDua/';
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
        if (!chkPhanQuyen('qdhosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/HoSoThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem']='/DungChung/DinhKemHoSoKhenThuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'qdhosodenghikhenthuongthidua', null, 'MODEL');
        if (count($m_donvi) == 0) {
            return view('errors.noperm')->with('machucnang', 'xdhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
       
        /*Lọc danh sách phong trao
            Đơn vị chỉ lấy các phong trào do đơn vị phát động
        */
        $model = viewdonvi_dsphongtrao::where('madonvi', $inputs['madonvi'])->orderby('tungay')->get();            
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        if ($inputs['phamviapdung'] != 'ALL') {
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        }
        $ngayhientai = date('Y-m-d');

        // $m_hoso = dshosothiduakhenthuong::where('madonvi_xd', $inputs['madonvi'])
        //     ->wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->get();
            $m_hoso = dshosothiduakhenthuong::where('madonvi_kt', $inputs['madonvi'])
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
        // dd($a_trangthai);
        $inputs['trangthai'] = session('chucnang')['qdhosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] == 'ALL' ? 'CC' : $inputs['trangthai'];
        //dd($model);
        return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthai_hoso', $a_trangthai)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_trangthai', getTrangThaiHoSo())
            ->with('a_phamvi', getPhamViPhongTrao())
            // ->with('a_donviql', $a_donviql)
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Khen thưởng hồ sơ thi đua');
    }

    public function KhenThuong(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongthidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $chk = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        //Lấy danh sách cán bộ đề nghị khen thưởng rồi thêm vào hosothiduakhenthuong
        //Chuyển trạng thái hồ sơ tham gia
        //chuyển trang thái phong trào

        if ($chk == null) {
            //Lấy danh sách hồ sơ theo phong trào; theo địa bàn,; theo đơn vi nhận
            $m_hosokt = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
                ->wherein('mahosothamgiapt', function ($qr) {
                    $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                        ->where('trangthai_t', 'CXKT')
                        ->orwhere('trangthai_h', 'CXKT')->get();
                })->get();
            $inputs['mahosotdkt'] = (string)getdate()[0];
            $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;

            $a_canhan = [];
            $a_tapthe = [];
            $inputs['trangthai'] = 'DXKT';
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
                        'mahinhthuckt' => $canhan->mahinhthuckt,
                        'madanhhieutd' => $canhan->madanhhieutd,
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
                        'madanhhieutd' => $tapthe->madanhhieutd,
                        'mahinhthuckt' => $tapthe->mahinhthuckt,
                        'ketqua' => '1',
                    ];
                }

                //Lưu trạng thái
                $hoso->mahosotdkt = $inputs['mahosotdkt'];
                $thoigian = date('Y-m-d H:i:s');
                setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => $inputs['trangthai']]);
                setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => $inputs['trangthai']]);
                $hoso->save();
            }

            dshosothiduakhenthuong::create($inputs);
            foreach (array_chunk($a_canhan, 100) as $data) {
                dshosothiduakhenthuong_canhan::insert($data);
            }
            foreach (array_chunk($a_tapthe, 100) as $data) {
                dshosothiduakhenthuong_tapthe::insert($data);
            }
            $m_phongtrao->trangthai = 'DXKT';
            $m_phongtrao->save();
        }
        return redirect('KhenThuongHoSoThiDua/DanhSach?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['trangthai'] = session('chucnang')['qdhosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['url_tailieudinhkem']='/DungChung/DinhKemHoSoKhenThuong';

        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $ngayhientai = date('Y-m-d');
        KiemTraPhongTrao($m_phongtrao, $ngayhientai);
        // $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('madonvi_kt', $inputs['madonvi'])->get();

        foreach ($model as $key => $hoso) {
            $hoso->soluongkhenthuong = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->count()
                + dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->count();
            //Gán lại trạng thái hồ sơ
            $hoso->madonvi_hoso = $hoso->madonvi_xd;
            $hoso->trangthai_hoso = $hoso->trangthai_xd;
            $hoso->thoigian_hoso = $hoso->thoigian_xd;
            $hoso->lydo_hoso = $hoso->lydo_xd;
            $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_xd;
        }

        return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('m_phongtrao', $m_phongtrao)
            // ->with('a_donviql', getDonViPheDuyetPhongTrao($donvi, $m_phongtrao))
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đề nghị khen thưởng');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd ?? null)->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi ?? null)->first();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');

        $a_dhkt= array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
        foreach($model_canhan as $ct)
        {
            $danhhieu=explode(';',$ct->madanhhieukhenthuong);
            $ct->madanhhieukhenthuong='';
            foreach($danhhieu as $item)
            {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] .'; ';
            }
        }

        foreach($model_tapthe as $ct)
        {
            $danhhieu=explode(';',$ct->madanhhieukhenthuong);
            $ct->madanhhieukhenthuong='';
            foreach($danhhieu as $item)
            {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] .'; ';
            }
        }

        return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.Xem')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', getDanhHieuKhenThuong('ALL','ALL'))
            //->with('a_danhhieutd', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Kết quả phong trào thi đua');
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongthidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['trangthai'] = 'CXKT';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        //Xoá tài liệu đính kèm quyết định khen thưởng
        $model_tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', 'QDKT')->first();
        if ($model_tailieu != null) {
            $rq = new Request([
                'phanloaihoso'   => 'dshosothiduakhenthuong',
                'id' => $model_tailieu->id,
                'madonvi' => $model->madonvi_kt,
            ]);
            //$rq->request->add(['phanloaihoso' => 'dshosothiduakhenthuong', 'id'=>'10']);        
            $dinhkem = new dungchung_nghiepvu_tailieuController();
            $dinhkem->XoaTaiLieu($rq);
        }
        setHuyKhenThuong($model, $inputs);
        dshosothamgiaphongtraotd::where('mahosotdkt', $model->mahosotdkt)->update(['trangthai' => $model->trangthai]);
        //dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->update(['trangthai' => $model->trangthai]);

        return redirect('/KhenThuongHoSoThiDua/DanhSach?madonvi=' . $model->madonvi_kt . '&maphongtraotd=' . $model->maphongtraotd);
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

        $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetCaNhan($result, $danhsach);
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
        $model->update($inputs);
        $danhsach = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetHoGiaDinh($result, $danhsach);
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

    public function NhanExcelCaNhan(Request $request)
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
            if (!isset($data[$i][$inputs['tendoituong']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                "gioitinh" => $data[$i][$inputs['madanhhieutd']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                'ketqua' => '1',
            );
        }

        dshosothiduakhenthuong_canhan::insert($a_dm);
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
        //$id =  $inputs['id'];       
        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
        $model->update($inputs);
        // return response()->json($inputs['id']);
        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetTapThe($result, $danhsach);
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
        $model->delete();

        $m_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlTapThe($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelTapThe(Request $request)
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
            if (!isset($data[$i][$inputs['tentapthe']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                'ketqua' => '1',
            );
        }
        dshosothiduakhenthuong_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
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
            $model = array_column(dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get()->toarray(), 'tentapthe', 'id');
        } else {
            $model = array_column(dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get()->toarray(), 'tendoituong', 'id');
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

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongdotxuat', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhenthuongdotxuat')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['trangthai'] = 'BTLXD';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $madonvi = $model->madonvi_kt;
        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $trangthai, 'lydo' => $inputs['lydo']]);
        // $model->trangthai = $trangthai; //gán trạng thái hồ sơ để theo dõi           
        // //dd($model);
        // $model->trangthai_xd = $trangthai;
        // $model->thoigian_xd = $thoigian;
        // $model->lydo_xd = $inputs['lydo'];

        // $model->madonvi_nhan_xd = null;

        // $model->madonvi_kt = null;
        // $model->trangthai_kt = null;
        // $model->thoigian_kt = null;
        setTraLaiPD($model, $inputs);
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $inputs['thoigian'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Trả lại hồ sơ trình đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $madonvi);
    }

    public function PheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/KhenThuongHoSoThiDua/';
        $inputs['url_hs'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        $inputs['mahinhthuckt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['mahinhthuckt'] ?? 'ALL';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['phanloai']=$model->phanloai;
        // dd($model);
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        // $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        // $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        // $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');
        $a_dhkt_canhan = getDanhHieuKhenThuong('ALL','ALL');
        $a_dhkt_tapthe = getDanhHieuKhenThuong('ALL', 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong('ALL', 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        //Gán thông tin đơn vị khen thưởng
        $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();

        $model->capkhenthuong =  $donvi_kt->capdo;
        $model->donvikhenthuong =  $donvi_kt->tendonvi;
        $a_donvikt = array_unique(array_merge([$model->donvikhenthuong], getDonViKhenThuong()));
        // dd($inputs);
        return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.PheDuyetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_donvikt', $a_donvikt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongthidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        //Gán mặc định quyết định
        getTaoQuyetDinhKT($model);
        //Gán thông tin quyết định
        getTaoDuThaoKT($model);
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        dshosothamgiaphongtraotd::where('mahosotdkt', $model->mahosotdkt)->update(['trangthai' => $model->trangthai]);
        //dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->update(['trangthai' => $model->trangthai]);

        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_kt . '&maphongtraotd=' . $model->maphongtraotd);
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
        //return response()->json($inputs);
        if ($inputs['phanloai'] == 'TAPTHE') {
            dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetTapThe($result, $danhsach);
        }
        if ($inputs['phanloai'] == 'CANHAN') {
            dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetCaNhan($result, $danhsach);
        }
        if ($inputs['phanloai'] == 'HOGIADINH') {
            dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetHoGiaDinh($result, $danhsach);
        }
        return response()->json($result);
    }
}
