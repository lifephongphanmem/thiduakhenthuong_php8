<?php

namespace App\Http\Controllers\TraCuu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdonvi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_detai;
use App\Models\View\view_tdktcumkhoi_canhan;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class tracuucanhanController extends Controller
{
    public static $url = '/TraCuu/CaNhan/';
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
        if (!chkPhanQuyen('timkiemcanhan', 'danhsach')) {
            return view('errors.noperm')
                ->with('machucnang', 'timkiemcanhan')
                ->with('tenphanquyen', 'danhsach');
        }
        //B1: xác định đơn vị
        // Nhập liệu => chỉ load địa bàn theo đơn
        //Xét duyêt; Khen thương => load địa bàn và địa bàn trực thuộc
        //B2:
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanTraCuu($donvi);
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        // dd($m_diaban);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        //lấy danh sách đơn vị theo địa bàn

        return view('TraCuu.CaNhan.ThongTin')
            ->with('inputs', $inputs)
            ->with('a_canhan', $a_canhan)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_diaban', array_column($m_diaban->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Tìm kiếm thông tin theo cá nhân');
    }

    public function KetQua(Request $request)
    {
        $inputs = $request->all();
        //Chưa tính trường hợp đơn vị
       
        //Nếu đơn vị quản lý địa bàn => xem đc tất cả
        //Nếu đơn vị nhập liệu => chỉ xem hồ sơ đơn vị gửi
        $model_khenthuong = view_tdkt_canhan::where('trangthai', 'DKT');
        $model_cumkhoi=view_tdktcumkhoi_canhan::where('trangthai','DKT');

        $model_detai = view_tdkt_detai::query();
        $this->TimKiem($model_khenthuong,$model_cumkhoi, $model_detai, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        foreach($model_khenthuong as $ct)
        {
            if(isset($ct->mahoso)){
                $ct->mahosotdkt=$ct->mahoso;

            }
        }
        // dd($model_khenthuong);
        //dd( $model_khenthuong->toarray());
        return view('TraCuu.CaNhan.KetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('model_detai', $model_detai)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('a_cumkhoi', array_column(dscumkhoi::all()->toarray(),'tencumkhoi','macumkhoi'))
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }

    public function InKetQua(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $model_khenthuong = view_tdkt_canhan::where('trangthai', 'DKT');
        $model_cumkhoi=view_tdktcumkhoi_canhan::where('trangthai','DKT');
        $model_detai = view_tdkt_detai::query();
        $this->TimKiem($model_khenthuong,$model_cumkhoi, $model_detai, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('TraCuu.CaNhan.InKetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('model_detai', $model_detai)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }

    function TimKiem(&$model_khenthuong, &$model_cumkhoi, &$model_detai, $inputs)
    {
        if ($inputs['tendoituong'] != '') {
            $model_khenthuong = $model_khenthuong->where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%');
            $model_cumkhoi = $model_cumkhoi->where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%');
        }

        if ($inputs['tenphongban'] != '') {
            $model_khenthuong = $model_khenthuong->where('tenphongban', 'Like', '%' . $inputs['tenphongban'] . '%');
            $model_cumkhoi = $model_cumkhoi->where('tenphongban', 'Like', '%' . $inputs['tenphongban'] . '%');
        }

        if ($inputs['tencoquan'] != null && $inputs['tencoquan'] != ''){
            $model_khenthuong = $model_khenthuong->where('tencoquan', 'Like', '%' . $inputs['tencoquan'] . '%');
            $model_cumkhoi = $model_cumkhoi->where('tencoquan', 'Like', '%' . $inputs['tencoquan'] . '%');
        }
        if ($inputs['ngaytu'] != null){
            $model_khenthuong = $model_khenthuong->where('ngayqd', '>=', $inputs['ngaytu']);
            $model_cumkhoi = $model_cumkhoi->where('ngayqd', '>=', $inputs['ngaytu']);
        }
        if ($inputs['ngayden'] != null){
            $model_khenthuong = $model_khenthuong->where('ngayqd', '<=', $inputs['ngayden']);
            $model_cumkhoi = $model_cumkhoi->where('ngayqd', '<=', $inputs['ngayden']);
        }
        if ($inputs['gioitinh'] != 'ALL'){
            $model_khenthuong = $model_khenthuong->where('gioitinh', $inputs['gioitinh']);
            $model_cumkhoi = $model_cumkhoi->where('gioitinh', $inputs['gioitinh']);
        }
        if ($inputs['maphanloaicanbo'] != 'ALL'){
            $model_khenthuong = $model_khenthuong->where('maphanloaicanbo', $inputs['maphanloaicanbo']);
            $model_cumkhoi = $model_cumkhoi->where('maphanloaicanbo', $inputs['maphanloaicanbo']);
        }
        if ($inputs['maloaihinhkt'] != 'ALL'){
            $model_khenthuong = $model_khenthuong->where('maloaihinhkt', $inputs['maloaihinhkt']);
            $model_cumkhoi = $model_cumkhoi->where('maloaihinhkt', $inputs['maloaihinhkt']);
        }
        if ($inputs['mahinhthuckt'] != 'ALL'){
            $model_khenthuong = $model_khenthuong->where('madanhhieukhenthuong', $inputs['mahinhthuckt']);
            $model_cumkhoi = $model_cumkhoi->where('madanhhieukhenthuong', $inputs['mahinhthuckt']);
        }
        if ($inputs['madanhhieuthidua'] != 'ALL'){
            $model_khenthuong = $model_khenthuong->where('madanhhieukhenthuong', $inputs['madanhhieuthidua']);
            $model_cumkhoi = $model_cumkhoi->where('madanhhieukhenthuong', $inputs['madanhhieuthidua']);
        }
        //Lọc các kết quả khen thưởng trên địa bàn
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();

        //đơn vị Phê duyệt xem đc tất cả dữ liệu
        if($donvi->madonvi == $donvi->madonviQL){
            $a_diaban = array_column(getDiaBanTraCuu($donvi)->toarray(), 'madiaban');
            // dd($m_diaban);
            if ($inputs['madiaban'] == 'ALL'){
                $model_khenthuong = $model_khenthuong->wherein('madiaban', $a_diaban);
                $model_cumkhoi = $model_cumkhoi->wherein('madiaban', $a_diaban);
            }else{
                $model_khenthuong = $model_khenthuong->where('madiaban', $inputs['madiaban']);
                $model_cumkhoi = $model_cumkhoi->where('madiaban', $inputs['madiaban']);
            }
        }else{
            $model_khenthuong = $model_khenthuong->where('madonvi', $inputs['madonvi']);
            $model_cumkhoi = $model_cumkhoi->where('madonvi', $inputs['madonvi']);
        }
        //dd($donvi);        

        //Lấy kết quả khen thưởng
        $model_khenthuong = $model_khenthuong->get()->keyby('mahosotdkt');
        $model_cumkhoi = $model_cumkhoi->get()->keyby('mahoso');
        if(count($model_khenthuong)>0){
            if(count($model_cumkhoi)>0)
            {
                $model_khenthuong=$model_khenthuong->union($model_cumkhoi);
            }
        }
        //dd($a_diaban);

        //Đề tài
        $model_detai = $model_detai->wherein('mahosotdkt', array_unique(array_column($model_khenthuong->toarray(), 'mahosotdkt')));
        if ($inputs['tendoituong'] != null && $inputs['tendoituong'] != '')
            $model_detai = $model_detai->where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%');
        //Lấy kết quả đề tài
        $model_detai = $model_detai->get();
    }

    public function ThongTinHoSo06052024(Request $request)
    {
        // $inputs=$request->all();
        // // dd($inputs);

        // $model=dshosothiduakhenthuong::where('mahosotdkt',$inputs['mahoso'])->first();
        // $model_canhan=dshosothiduakhenthuong_canhan::where('mahosotdkt',$inputs['mahoso'])->first();
        // dd($model);
        $inputs = $request->all();
        // dd($inputs);
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if(!isset($model)){
            $model=dshosothamgiathiduacumkhoi::where('mahoso',$inputs['mahosotdkt'])->first();
            $model->tenphongtraotd = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
            $model_canhan = dshosothamgiathiduacumkhoi_canhan::where('mahoso', $model->mahoso)->get();
        }else{
            $model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
            $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        }
        // dd($model);

        // $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        // $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        // $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('TraCuu.CaNhan.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            // ->with('model_tapthe', $model_tapthe)
            // ->with('model_detai', $model_detai)
            // ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            // ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }
    public function ThongTinHoSo(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if(!isset($model)){
            $model=dshosotdktcumkhoi::where('mahosotdkt',$inputs['mahosotdkt'])->first();
            // dd($model);
            $model->tenphongtraotd = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
            $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        }else{
            $model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
            $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        }

        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('TraCuu.CaNhan.Xem')
        ->with('model', $model)
        ->with('model_canhan', $model_canhan)
        // ->with('model_tapthe', $model_tapthe)
        // ->with('model_detai', $model_detai)
        // ->with('model_hogiadinh', $model_hogiadinh)
        ->with('m_donvi', $m_donvi)
        ->with('a_phanloaidt', $a_phanloaidt)
        ->with('a_dhkt', $a_dhkt)
        ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
        // ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
        ->with('inputs', $inputs)
        ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }
}
