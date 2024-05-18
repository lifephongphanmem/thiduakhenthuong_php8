<?php

namespace App\Http\Controllers\NghiepVu\KhenCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao_canhan;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao_tapthe;
use App\Models\NghiepVu\KhenCao\dshosokhencao;
use App\Models\NghiepVu\KhenCao\dshosokhencao_canhan;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class tnhosodenghikhencaoController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenCao/TiepNhanDeNghi/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhencao', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhencao')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenCao/HoSoDeNghi/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/KhenCao/PheDuyetDeNghi/';
        $inputs['phanquyen'] = 'tnhosodenghikhencao';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosokhencao';
        $inputs['url_tailieudinhkem']='/DungChung/DinhKemHoSoKhenThuong';

        // $m_donvi = getDonVi(session('admin')->capdo, 'tnhosodenghikhencao');
        $m_donvi = getDonVi(session('admin')->capdo);
        if (count($m_donvi) == 0) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhencao')->with('tenphanquyen', 'danhsach');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['tnhosodenghikhencao']['maloaihinhkt'] ?? 'ALL';
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();

        $model = dshosokhencao::where('madonvi_xd', $inputs['madonvi'])
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH','KHENCAOTHUTUONG' ,'KHENCAOCHUTICHNUOC',])
            ->wherenotin('trangthai_xd', ['BTL']);
             //->orderby('ngayhoso')->get();

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
        $m_khencanhan = dshosokhencao_canhan::where('ketqua', '1')->wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        $m_khentapthe = dshosokhencao_tapthe::where('ketqua', '1')->wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->get();
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        $a_taikhoanchuyenvien = array_column(dstaikhoan::where('madonvi', $inputs['madonvi'])->where('phanloai', '<>', 'QUANLY')->get()->toarray(), 'tentaikhoan', 'tendangnhap');
        foreach ($model as $key => $hoso) {
            //Gán để lấy các hàm dùng chung
            $hoso->mahosotdkttdkt = $hoso->mahosotdkt;
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
            if (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->madonvi, $a_donvilocdulieu))
                    $model->forget($key);
            }
        }
        $inputs['trangthai'] = session('chucnang')['tnhosodenghikhencao']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        //dd($model->where('trangthai','CXKT')->where('madonvi_kt',''));
        //dd( $inputs);
        return view('NghiepVu.KhenCao.TiepNhanDeNghi.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_taikhoanchuyenvien', $a_taikhoanchuyenvien)
            ->with('a_donviql', getDonViQuanLyDiaBan($donvi))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhencao', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhencao')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiXD($model, $inputs);
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
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->lydo = $model->lydo_xd;
        die(json_encode($model));
    }
    
    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhencao', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhencao')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DD';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->save();

        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosodenghikhencao',
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
        if (!chkPhanQuyen('tnhosodenghikhencao', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhencao')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DTN';
        $model->trangthai_xd = 'DTN';
        $model->thoigian_xd = $thoigian;
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosodenghikhencao',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Tiếp nhận hồ sơ đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }

    public function ChuyenChuyenVien(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhencao', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhencao')->with('tenphanquyen', 'xuly');
        }
        $inputs = $request->all();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'DCCVXD';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahoso'])->first();
        //    dd($inputs);
        //gán thông tin vào bảng xử lý hồ sơ

        setChuyenChuyenVienXD($model, $inputs, 'dshosokhencao');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function XuLyHoSo(Request $request)
    {
        if (!chkPhanQuyen('tnhosodenghikhencao', 'xuly')) {
            return view('errors.noperm')->with('machucnang', 'tnhosodenghikhencao')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahoso'])->first();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        // dd($inputs);

        setXuLyHoSo($model, $inputs, 'dshosokhencao');
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi'] );
    }

    public function QuaTrinhXuLyHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $a_canbo = array_column(dstaikhoan::all()->toArray(), 'tentaikhoan', 'tendangnhap');
        return view('NghiepVu._DungChung.InQuaTrinhXuLy')
            ->with('model', $model)
            ->with('a_canbo', $a_canbo)
            ->with('a_trangthaihs', getTrangThaiHoSo())
            ->with('pageTitle', 'Thông tin quá trình xử lý hồ sơ đề nghị khen thưởng');
    }
    
}
