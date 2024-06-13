<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use App\Models\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaodonviController extends Controller
{
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
        if (!chkPhanQuyen('baocaodonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'baocaodonvi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongchuyende');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        
        $m_canhan = view_tdkt_canhan::where('trangthai', 'DKT')->get();
        $m_tapthe = view_tdkt_tapthe::where('trangthai', 'DKT')->get();        
        //lấy hết phong trào cấp tỉnh
        $m_phongtrao = getDSPhongTrao($m_donvi->where('madonvi', $inputs['madonvi'])->first());

        return view('BaoCao.DonVi.ThongTin')
            ->with('m_canhan', $m_canhan)
            ->with('m_tapthe', $m_tapthe)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo theo đơn vị');
    }

    public function CaNhan(Request $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['tendoituong'])) {
            return view('errors.403')
                ->with('message', 'Đối tượng tìm kiếm không được bỏ trống.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }
        $m_khenthuong = view_tdkt_canhan::where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%')
            ->where('ngayqd', '>=', $inputs['ngaytu'])
            ->where('ngayqd', '<=', $inputs['ngayden'])
            ->get();

        if (count($m_khenthuong) == 0) {
            return view('errors.403')
                ->with('message', 'Không tìm thấy đối tượng phù hợp với yêu cầu.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }

        $m_donvi = dsdonvi::where('madonvi', $m_khenthuong->first()->madonvi)->first();
		$a_dhkt = getDanhHieuKhenThuong('ALL');
		
        return view('BaoCao.DonVi.MauChung.CaNhan')
		->with('a_dhkt', $a_dhkt)
            ->with('inputs', $inputs)
            ->with('model', $m_khenthuong->first())
            ->with('model_khenthuong', $m_khenthuong)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Báo cáo theo cá nhân');
    }

    public function TapThe(Request $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['tentapthe'])) {
            return view('errors.403')
                ->with('message', 'Đối tượng tìm kiếm không được bỏ trống.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }
        $m_khenthuong = view_tdkt_tapthe::where('tentapthe', 'Like', '%' . $inputs['tentapthe'] . '%')
            ->where('ngayqd', '>=', $inputs['ngaytu'])
            ->where('ngayqd', '<=', $inputs['ngayden'])
            ->get();

        if (count($m_khenthuong) == 0) {
            return view('errors.403')
                ->with('message', 'Không tìm thấy đối tượng phù hợp với yêu cầu.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }
        $m_donvi = dsdonvi::where('madonvi', $m_khenthuong->first()->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
		
        return view('BaoCao.DonVi.MauChung.TapThe')
		->with('a_dhkt', $a_dhkt)
            ->with('inputs', $inputs)
            ->with('model', $m_khenthuong->first())
            ->with('model_khenthuong', $m_khenthuong)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Báo cáo theo tập thể');
    }

    public function PhongTrao(Request $request)
    {
        $inputs = $request->all();        
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = getDSPhongTrao($m_donvi);       
        return view('BaoCao.DonVi.MauChung.PhongTrao')
            ->with('inputs', $inputs)
            ->with('m_donvi', $m_donvi)
            ->with('model', $model)
            ->with('a_phamvi', setArrayAll(getPhamViPhongTrao()))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))           
            ->with('pageTitle', 'Báo cáo theo phong trào');
    }
}
