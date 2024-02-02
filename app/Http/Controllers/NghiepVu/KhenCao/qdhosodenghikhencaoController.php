<?php

namespace App\Http\Controllers\NghiepVu\KhenCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvu_tailieuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao_canhan;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao_hogiadinh;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tailieu;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao_tapthe;
use App\Models\NghiepVu\KhenCao\dshosokhencao;
use App\Models\NghiepVu\KhenCao\dshosokhencao_canhan;
use App\Models\NghiepVu\KhenCao\dshosokhencao_hogiadinh;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class qdhosodenghikhencaoController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenCao/PheDuyetDeNghi/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhencao', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhencao')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenCao/HoSoDeNghi/';
        $inputs['url_xd'] = '/KhenCao/XetDuyetHoSoDN/';
        $inputs['url_qd'] = static::$url;
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosokhencao';

        $m_donvi = getDonVi(session('admin')->capdo, 'qdhosodenghikhencao');
        if (count($m_donvi) == 0) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhencao')
                ->with('tenphanquyen', 'danhsach');
        }

        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['capdo'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo;
        $inputs['tendvcqhienthi'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->tendvcqhienthi;
        $inputs['maloaihinhkt'] = session('chucnang')['qdhosodenghikhencao']['maloaihinhkt'] ?? 'ALL';

        $model = dshosokhencao::where('madonvi_kt', $inputs['madonvi'])
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH', 'KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC',])
            ->wherein('trangthai', ['CXKT', 'DXKT', 'DKT']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);

        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);

        //Lọc trạng thái (do đã chuyển trạng thái trong quá trình phê duyệt hồ sơ)
        if ($inputs['trangthaihoso'] != 'ALL')
            $model = $model->where('trangthai', $inputs['trangthaihoso']);

        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();
        // $m_khenthuong = dshosokhenthuong::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('trangthai', 'DKT')->get();
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);

        $m_khencanhan = dshosokhencao_canhan::where('ketqua', '1')->wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        $m_khentapthe = dshosokhencao_tapthe::where('ketqua', '1')->wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        //dd($a_donvilocdulieu);
        foreach ($model as $key => $hoso) {
            //Gán để lấy các hàm dùng chung
            $hoso->mahosotdkttdkt = $hoso->mahosotdkt;

            if (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->madonvi, $a_donvilocdulieu))
                    $model->forget($key);
            }

            //nếu hồ sơ của đơn vị thì để chỉnh sửa (cho trường hợp tự nhập quyết định khen thưởng)
            $hoso->chinhsua = $hoso->madonvi == $inputs['madonvi'] ? true : false;
            $hoso->soluongkhenthuong = $m_khencanhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $m_khentapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
            getDonViChuyen($inputs['madonvi'], $hoso);
        }

        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        $inputs['trangthai'] = session('chucnang')['qdhosodenghikhencao']['trangthai'] ?? 'CC';
        //dd($inputs);
        return view('NghiepVu.KhenCao.PheDuyetDeNghi.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            //->with('a_trangthaihoso', getTrangThaiTDKT())
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ trình khen thưởng');
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
            dshosokhencao_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosokhencao_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetTapThe($result, $danhsach);
        }
        if ($inputs['phanloai'] == 'CANHAN') {
            dshosokhencao_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosokhencao_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetCaNhan($result, $danhsach);
        }
        if ($inputs['phanloai'] == 'HOGIADINH') {
            dshosokhencao_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosokhencao_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetHoGiaDinh($result, $danhsach);
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
        $model = dshosokhencao_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosokhencao_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosokhencao_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetCaNhan($result, $danhsach);
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
        $model = dshosokhencao_canhan::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosokhencao_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
        return response()->json($result);
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
        $model = dshosokhencao_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosokhencao_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosokhencao_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetTapThe($result, $danhsach);
        return response()->json($result);
        //return die(json_encode($result));
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
        $model = dshosokhencao_hogiadinh::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosokhencao_hogiadinh::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosokhencao_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetHoGiaDinh($result, $danhsach);
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
        $model = dshosokhencao_tapthe::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosokhencao_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlTapThe($result, $m_tapthe);
        return response()->json($result);
    }

    public function PheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenCao/HoSoDeNghi/';
        $inputs['url_xd'] = '/KhenCao/XetDuyetHoSoDN/';
        $inputs['url_qd'] = static::$url;
        $inputs['url'] = static::$url;
        $inputs['phanloaihoso'] = 'dshosokhencao';

        //$inputs['mahinhthuckt'] = session('chucnang')['qdhosodenghikhencao']['mahinhthuckt'] ?? 'ALL';
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosokhencao_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosokhencao_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_hogiadinh = dshosokhencao_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tailieu = dshosokhencao_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $model->tendonvi = $donvi->tendonvi;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');
        //Xác định loại đề nghị để gán quyết định khen thưởng
        switch ($model->phanloai) {
            case 'KTDONVI':
            case 'KHENTHUONG': {
                    $inputs['phanloai'] = 'KHENTINH';
                    $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();
                    $model->capkhenthuong =  $donvi_kt->capdo;
                    $model->donvikhenthuong =  $donvi_kt->tendonvi;
                    $model->chucvunguoikyqd = 'Chủ tịch';
                    $a_donvikt = array_unique(array_merge([$model->donvikhenthuong], getDonViKhenThuong()));
                    break;
                }

            case 'KHENCAOTHUTUONG': {
                    $inputs['phanloai'] = 'KHENCAO';
                    $model->capkhenthuong =  'TW';
                    $model->donvikhenthuong =  'Chính phủ nước Cộng hòa xã hội chủ nghĩa Việt Nam';
                    $model->chucvunguoikyqd = 'Thủ tướng chính phủ';
                    $a_donvikt = ['Chính phủ nước Cộng hòa xã hội chủ nghĩa Việt Nam' => 'Chính phủ nước Cộng hòa xã hội chủ nghĩa Việt Nam'];
                    break;
                }
            case 'KHENCAOCHUTICHNUOC': {
                    $inputs['phanloai'] = 'KHENCAO';
                    $model->capkhenthuong =  'TW';
                    $model->donvikhenthuong =  'Nhà nước Cộng hòa xã hội chủ nghĩa Việt Nam';
                    $model->chucvunguoikyqd = 'Chủ tịch nước';
                    $a_donvikt = ['Nhà nước Cộng hòa xã hội chủ nghĩa Việt Nam' => 'Nhà nước Cộng hòa xã hội chủ nghĩa Việt Nam'];
                    break;
                }
        }
        //Gán thông tin để thông tin đơn vị đang thao tác
        $inputs['madonvi'] = $model->madonvi_kt;

        return view('NghiepVu.KhenCao.PheDuyetDeNghi.PheDuyetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvikt', $a_donvikt)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            // ->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        getTaoQuyetDinhKT($model);

        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosodenghikhencao',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_kt);
    }
    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhencao', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhencao')
                ->with('tenphanquyen', 'hoanthanh');
        }

        $inputs = $request->all();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['trangthai'] = 'CXKT';
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        setHuyKhenThuong($model, $inputs);

        //Xoá tài liệu đính kèm quyết định khen thưởng
        $model_tailieu = dshosokhencao_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', 'QDKT')->first();
        if ($model_tailieu != null) {
            $rq = new Request([
                'phanloaihoso'   => 'dshosodenghikhencao',
                'id' => $model_tailieu->id,
                'madonvi' => $model->madonvi_kt,
            ]);
            $dinhkem = new dungchung_nghiepvu_tailieuController();
            $dinhkem->XoaTaiLieu($rq);
        }
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhencao', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhencao')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $madonvi = $model->madonvi_kt;
        $inputs['trangthai'] = 'BTLXD';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiPD($model, $inputs);

        return redirect(static::$url . 'ThongTin?madonvi=' . $madonvi);
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
        $model = dshosokhencao::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $model_canhan = dshosokhencao_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosokhencao_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();

        $model_hogiadinh = dshosokhencao_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('NghiepVu.KhenCao.PheDuyetDeNghi.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }
}
