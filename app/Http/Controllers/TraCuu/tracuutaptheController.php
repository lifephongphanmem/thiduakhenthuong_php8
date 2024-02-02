<?php

namespace App\Http\Controllers\TraCuu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\View\view_cumkhoi_canhan;
use App\Models\View\view_cumkhoi_tapthe;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_detai;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class tracuutaptheController extends Controller
{
    public static $url = '/TraCuu/TapThe/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('timkiemphongtrao', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'timkiemphongtrao')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $m_tapthe = view_tdkt_tapthe::all();
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        return view('TraCuu.TapThe.ThongTin')
            ->with('m_tapthe', $m_tapthe)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Tìm kiếm thông tin theo tập thể');
    }

    public function KetQua(Request $request)
    {
        $inputs = $request->all();
        //Chưa tính trường hợp đơn vị
        $model_khenthuong = view_tdkt_tapthe::where('trangthai', 'DKT');
        $this->TimKiem($model_khenthuong, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('TraCuu.TapThe.KetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('a_dhkt', $a_dhkt)
            ->with('inputs', $inputs)
            ->with('phamvi', getPhamViApDung())
            ->with('a_linhvuc', getLinhVucHoatDong())
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm tập thể');
    }

    public function InKetQua(Request $request)
    {
        $inputs = $request->all();
        $model_khenthuong = view_tdkt_tapthe::where('trangthai', 'DKT');
        $this->TimKiem($model_khenthuong, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('TraCuu.TapThe.InKetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm tập thể');
    }

    function TimKiem(&$model_khenthuong, $inputs)
    {
        if ($inputs['tentapthe'] != '') {
            $model_khenthuong = $model_khenthuong->where('tentapthe', 'Like', '%' . $inputs['tentapthe'] . '%');
        }

        if ($inputs['ngaytu'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '>=', $inputs['ngaytu']);

        if ($inputs['ngayden'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '<=', $inputs['ngayden']);

        if ($inputs['maphanloaitapthe'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maphanloaitapthe', $inputs['maphanloaitapthe']);

        if ($inputs['linhvuchoatdong'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('linhvuchoatdong', $inputs['linhvuchoatdong']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maloaihinhkt', $inputs['maloaihinhkt']);

        //Lọc các kết quả khen thưởng trên địa bàn
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();

        //đơn vị Phê duyệt xem đc tất cả dữ liệu
        if ($donvi->madonvi == $donvi->madonviQL) {
            $a_diaban = array_column(getDiaBanTraCuu($donvi)->toarray(), 'madiaban');
            $model_khenthuong = $model_khenthuong->wherein('madiaban', $a_diaban);
        } else {
            $model_khenthuong = $model_khenthuong->where('madonvi', $inputs['madonvi']);
        }
        //Lọc các kết quả khen thưởng trên địa bàn
        // $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        // $a_diaban = array_column(getDiaBanTraCuu($donvi)->toarray(), 'madiaban');
        // // dd($m_diaban);
        // if ($inputs['madiaban'] == 'ALL')
        //     $model_khenthuong = $model_khenthuong->wherein('madiaban', $a_diaban);
        // else
        //     $model_khenthuong = $model_khenthuong->where('madiaban', $inputs['madiaban']);

        //Lấy kết quả khen thưởng
        $model_khenthuong = $model_khenthuong->get();
    }
}
