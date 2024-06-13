<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\NghiepVu\KhenCao\dshosokhencao;
use App\Models\NghiepVu\KhenCao\dshosokhencao_canhan;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tapthe;
use App\Models\QuyKhenThuong\dsquanlyquykhenthuong;
use App\Models\QuyKhenThuong\dsquanlyquykhenthuong_chitiet;
use App\Models\View\view_dscumkhoi;
use App\Models\View\view_khencao_canhan;
use App\Models\View\view_khencao_tapthe;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaocumkhoiController extends Controller
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
        if (!chkPhanQuyen('baocaocumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'baocaocumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = '/BaoCao/CumKhoi/';
        $m_donvi = getDonVi(session('admin')->capdo, 'baocaocumkhoi');
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        // $m_diaban = getDiaBanBaoCaoTongHop($donvi);        //dd($m_diaban->toArray());

        return view('BaoCao.CumKhoi.ThongTin')
            // ->with('m_diaban', $m_diaban)
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            // ->with('a_diaban', array_column($m_diaban->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            // ->with('a_donvi_ql', getDonViQL_BaoCao(array_column($m_diaban->toArray(), 'madonviQL')))
            ->with('a_phamvithongke', getPhamViThongKe($donvi->capdo))
            ->with('pageTitle', 'Báo cáo tổng hợp theo cụm, khối');
    }

    public function PhongTraoThiDua(Request $request)
    {
        $inputs = $request->all();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        // $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        // if ($inputs['madiaban'] != 'ALL') {
        //     $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        // }
        // $a_donvi = dsdonvi::wherein('madiaban', array_column($m_diaban->toarray(), 'madiaban'))->get('madonvi');
        $model = getDSPhongTraoCumKhoi($donvi);
        // dd($model);
        //Lọc thời gian khen thưởng
        //ngayqd
        $m_hoso = dshosotdktcumkhoi::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))
            //->wherein('madonvi',$a_donvi) //bỏ thống theo từng địa bàn
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->where('trangthai', 'DKT')->get();

        // dd($m_hoso);
        //hình thức khen thưởng cấp xã
        $m_hoso_xa = $m_hoso->where('capkhenthuong', 'X');
        $m_chitiet_xa_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($m_hoso_xa->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_xa_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($m_hoso_xa->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_xa = array_unique(
            array_merge(
                array_column($m_chitiet_xa_canhan->toarray(), 'madanhhieukhenthuong'),
                array_column($m_chitiet_xa_tapthe->toarray(), 'madanhhieukhenthuong')
            )
        );
        //Hình thức khent thưởng cấp Huyện
        $m_hoso_huyen = $m_hoso->where('capkhenthuong', 'H');
        $m_chitiet_huyen_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($m_hoso_huyen->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_huyen_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($m_hoso_huyen->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_huyen = array_unique(
            array_merge(
                array_column($m_chitiet_huyen_canhan->toarray(), 'madanhhieukhenthuong'),
                array_column($m_chitiet_huyen_tapthe->toarray(), 'madanhhieukhenthuong')
            )
        );
        //Hình thức khen thưởng cấp Tỉnh
        $m_hoso_tinh = $m_hoso->where('capkhenthuong', 'T');
        $m_chitiet_tinh_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($m_hoso_tinh->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_tinh_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($m_hoso_tinh->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $a_hinhthuckt_tinh = array_unique(
            array_merge(
                array_column($m_chitiet_tinh_canhan->toarray(), 'madanhhieukhenthuong'),
                array_column($m_chitiet_tinh_tapthe->toarray(), 'madanhhieukhenthuong')
            )
        );
        // dd($a_hinhthuckt_tinh);
        foreach ($model as $ct) {

            $ct->tongcong = 0;
            //Thống kê khen thưởng cấp Xã
            $mahskt_xa=array_column($m_hoso_xa->where('macumkhoi',$ct->macumkhoi)->toarray(),'mahosotdkt');
            foreach ($a_hinhthuckt_xa as $ma) {
                $ct->$ma = $m_chitiet_xa_canhan->wherein('mahosotdkt',$mahskt_xa)->where('madanhhieukhenthuong', $ma)->count()
                    + $m_chitiet_xa_tapthe->wherein('mahosotdkt',$mahskt_xa)->where('madanhhieukhenthuong', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
            //Thống kê khen thưởng cấp Huyện
            $mahskt_huyen=array_column($m_hoso_huyen->where('macumkhoi',$ct->macumkhoi)->toarray(),'mahosotdkt');
            foreach ($a_hinhthuckt_huyen as $ma) {
                $ct->$ma = $m_chitiet_huyen_canhan->wherein('mahosotdkt',$mahskt_huyen)->where('madanhhieukhenthuong', $ma)->count()
                    + $m_chitiet_huyen_tapthe->wherein('mahosotdkt',$mahskt_huyen)->where('madanhhieukhenthuong', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
            //Thống kê khen thưởng cấp Tỉnh
            $mahskt_tinh=array_column($m_hoso_tinh->where('macumkhoi',$ct->macumkhoi)->toarray(),'mahosotdkt');
            foreach ($a_hinhthuckt_tinh as $ma) {
                $ct->$ma = $m_chitiet_tinh_canhan->wherein('mahosotdkt',$mahskt_tinh)->where('madanhhieukhenthuong', $ma)->count()
                    + $m_chitiet_tinh_tapthe->wherein('mahosotdkt',$mahskt_tinh)->where('madanhhieukhenthuong', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
        }
        // dd($a_hinhthuckt_tinh);
        //Thông tin đơn vị
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        // dd($model);
        return view('BaoCao.CumKhoi.PhongTrao')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('a_cumkhoi', array_column(dscumkhoi::all()->toarray(), 'tencumkhoi', 'macumkhoi'))
            ->with('a_hinhthuckt_xa', $a_hinhthuckt_xa)
            ->with('a_hinhthuckt_huyen', $a_hinhthuckt_huyen)
            ->with('a_hinhthuckt_tinh', $a_hinhthuckt_tinh)
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua tại cụm, khối thi đua');
    }

    public function HoSoKhenThuong(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $model = view_dscumkhoi::all();

        $m_hoso = dshosotdktcumkhoi::where('trangthai', 'DKT')
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('madonvi', array_column($model->toArray(), 'madonvi'))
            ->wherein('phanloai', $inputs['phanloai']);
        //dd($m_hoso->toSql());
        $m_hoso =  $m_hoso->get();
        $m_loaihinhkt = getLoaiHinhKhenThuong();
        $a_cumkhoi = array_column($model->toArray(), 'tencumkhoi', 'macumkhoi');
        // dd($a_cumkhoi);
        foreach ($model as $ct) {
            $ct->tongso = 0;
            foreach ($m_loaihinhkt as $loaihinh) {
                $maloaihinhkt = $loaihinh->maloaihinhkt;
                $ct->$maloaihinhkt = $m_hoso->where('madonvi', $ct->madonvi)->where('maloaihinhkt', $maloaihinhkt)->count();
                $ct->tongso += $ct->$maloaihinhkt;
            }
        }
        $inputs['phanloaihoso'] = '';
        foreach ($inputs['phanloai'] as $phanloai) {
            $inputs['phanloaihoso'] .= (getPhanLoaiHoSo()[$phanloai] . '; ');
        }
        //Thông tin đơn vị
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.CumKhoi.HoSoKhenThuong')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('a_cumkhoi', $a_cumkhoi)
            ->with('a_loaihinhkt', array_column($m_loaihinhkt->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hồ sơ thi đua khen thưởng tại cụm, khối thi đua');
    }

    public function HinhThucKhenThuong(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();

        $m_hoso = dshosotdktcumkhoi::where('trangthai', 'DKT')
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310'])
            ->wherein('phanloai', $inputs['phanloai']);
        // if ($inputs['madonvi_kt'] != 'ALL') {
        //     $m_hoso = $m_hoso->where('madonvi_kt', $inputs['madonvi_kt']);
        // }
        $m_hoso =  $m_hoso->get();

        $m_hoso_canhan = dshosotdktcumkhoi_canhan::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();
        $m_hoso_tapthe = dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();
        $a_dhkt = array_merge(array_unique(array_column($m_hoso_canhan->toarray(), 'madanhhieukhenthuong')), array_unique(array_column($m_hoso_tapthe->toarray(), 'madanhhieukhenthuong')));
        $model = DHKT_BaoCao($a_dhkt);
        //dd($model);
        //$m_loaihinhkt = dmloaihinhkhenthuong::wherein('maloaihinhkt', array_unique(array_column($m_hoso->toarray(), 'maloaihinhkt')))->get();

        //tạm thời fix cứng sau làm lại để tự động
        //Loại hình khen thưởng -- maloaihinhkt
        // 1650358223	Khen thưởng theo công trạng và thành tích
        // 1650358255	Khen thưởng theo đợt (hoặc chuyên đề)
        // 1650358265	Khen thưởng đột xuất
        // 1650358282	Khen thưởng theo quá trình cống hiến
        // 1650358297	Khen thưởng theo niên hạn
        // 1650358310	Khen thưởng đối ngoại

        //Phân loại cán bộ
        // manhomphanloai	tennhomphanloai
        // TAPTHE	Tập thể
        // HOGIADINH	Hộ gia đình
        // CANHAN	Cá nhân


        //manhomphanloai	maphanloai	tenphanloai
        // TAPTHE	1660638226	Cơ quan hành chính, sự nghiệp
        // TAPTHE	1660638247	Doanh nghiệp
        // HOGIADINH	1660638538	Hộ gia đình
        // CANHAN	1660638808	Lãnh đạo cấp bộ, cấp tỉnh và tương đương trở lên
        // CANHAN	1660638843	Lãnh đạo cấp vụ, sở, ngành và tương đương
        // CANHAN	1660638864	Doanh nhân
        // CANHAN	1660638930	Các cấp lãnh đạo từ phó phòng trở lên
        // CANHAN	1660638976	Người trực tiếp công tác, lao động, học tập, chiến đấu và phục vụ chiến đấu

        foreach ($model as $ct) {
            //Nhóm công trạng
            $hoso_congtrang = $m_hoso->wherein('maloaihinhkt', ['1650358223']);
            $canhan_congtrang = $m_hoso_canhan->wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_congtrang = $m_hoso_tapthe->wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_cotr = $canhan_congtrang->count() + $tapthe_congtrang->count();
            $ct->canhan_lada_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->count();
            $ct->canhan_lado_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638976'])->count();

            //Nhóm chuyên đề, đột xuất
            $hoso_chuyende = $m_hoso->wherein('maloaihinhkt', ['1650358255', '1650358265']);
            $canhan_chuyende = $m_hoso_canhan->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_chuyende = $m_hoso_tapthe->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_chde = $canhan_chuyende->count() + $tapthe_chuyende->count();
            $ct->canhan_lada_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->count();
            $ct->canhan_lado_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638976'])->count();

            //Nhóm đối ngoại
            $hoso_dongo = $m_hoso->wherein('maloaihinhkt', ['1650358297']);
            $canhan_dongo = $m_hoso_canhan->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_dongo = $m_hoso_tapthe->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_dongo = $canhan_dongo->count() + $tapthe_dongo->count();

            //Gán tổng cộng
            $ct->tongso =  $ct->tongso_cotr +  $ct->tongso_chde +  $ct->tongso_dongo;
            $ct->tongdn = $tapthe_congtrang->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_chuyende->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_dongo->where('maphanloaitapthe', '1660638247')->count();
            $ct->tongcn = $canhan_congtrang->count() + $canhan_chuyende->count() +  $canhan_dongo->count();
        }

        foreach ($model as $key => $val) {
            if ($val->tongso == 0)
                $model->forget($key);
        }

        //dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.CumKhoi.HinhThucKhenThuong')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            //->with('a_diaban', $a_diaban)
            //->with('a_danhhieutd', array_column($m_hinhthuc->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hình thức khen thưởng tại cụm, khối thi đua');
    }

    public function getHsPheDuyetCumKhoi(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
            //->wherein('madonvi',$a_donvi) //bỏ thống theo từng địa bàn
            ->where('macumkhoi', $inputs['macumkhoi'])
            ->where('trangthai', 'DKT')->first();

        if (!isset($model)) {
            return view('errors.503')
                ->with('message', 'Không có thông tin hồ sơ phê duyệt');
        }
        $model->tenphongtraotd = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        // dd($model);
        return view('NghiepVu.KhenThuongCongTrang.QuyetDinhKhenThuong.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            // ->with('model_detai', $model_detai)
            // ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }
}
