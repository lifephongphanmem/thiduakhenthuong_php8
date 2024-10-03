<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\NghiepVu\KhenCao\dshosokhencao;
use App\Models\NghiepVu\KhenCao\dshosokhencao_canhan;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\QuyKhenThuong\dsquanlyquykhenthuong;
use App\Models\QuyKhenThuong\dsquanlyquykhenthuong_chitiet;
use App\Models\View\view_khencao_canhan;
use App\Models\View\view_khencao_hogiadinh;
use App\Models\View\view_khencao_tapthe;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaotonghopController extends Controller
{
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
        if (!chkPhanQuyen('baocaotapthe', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'baocaotapthe')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = '/BaoCao/TongHop/';
        $m_donvi = getDonVi(session('admin')->capdo, 'baocaotapthe');
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);        //dd($m_diaban->toArray());
        $a_trangthai = array(
            'DKT' => 'Đã khen thưởng',
            'CXKT' => 'Chưa khen thưởng'
        );
        return view('BaoCao.TongHop.ThongTin')
            ->with('m_diaban', $m_diaban)
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('a_trangthai', $a_trangthai)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_diaban', array_column($m_diaban->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donvi_ql', getDonViQL_BaoCao(array_column($m_diaban->toArray(), 'madonviQL')))
            ->with('a_phamvithongke', getPhamViThongKe($donvi->capdo))
            ->with('pageTitle', 'Báo cáo tổng hợp');
    }

    public function PhongTrao(Request $request)
    {
        $inputs = $request->all();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        // if ($inputs['madiaban'] != 'ALL') {
        //     $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        // }
        $a_donvi = dsdonvi::wherein('madiaban', array_column($m_diaban->toarray(), 'madiaban'))->get('madonvi');
        $model = getDSPhongTrao($donvi);
        //dd($inputs);
        //Lọc thời gian khen thưởng
        //ngayqd
        $m_hoso = dshosothiduakhenthuong::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))
            //->wherein('madonvi',$a_donvi) //bỏ thống theo từng địa bàn
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->where('trangthai', 'DKT')->get();

        //dd($m_hoso);
        //hình thức khen thưởng cấp xã
        $m_hoso_xa = $m_hoso->where('capkhenthuong', 'X');
        $m_chitiet_xa_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso_xa->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_xa_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso_xa->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_xa = array_unique(
            array_merge(
                array_column($m_chitiet_xa_canhan->toarray(), 'madanhhieukhenthuong'),
                array_column($m_chitiet_xa_tapthe->toarray(), 'madanhhieukhenthuong')
            )
        );
        //Hình thức khent thưởng cấp Huyện
        $m_hoso_huyen = $m_hoso->where('capkhenthuong', 'H');
        $m_chitiet_huyen_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso_huyen->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_huyen_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso_huyen->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_huyen = array_unique(
            array_merge(
                array_column($m_chitiet_huyen_canhan->toarray(), 'madanhhieukhenthuong'),
                array_column($m_chitiet_huyen_tapthe->toarray(), 'madanhhieukhenthuong')
            )
        );
        //Hình thức khen thưởng cấp Tỉnh
        $m_hoso_tinh = $m_hoso->where('capkhenthuong', 'T');
        $m_chitiet_tinh_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso_tinh->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $m_chitiet_tinh_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso_tinh->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();

        $a_hinhthuckt_tinh = array_unique(
            array_merge(
                array_column($m_chitiet_tinh_canhan->toarray(), 'madanhhieukhenthuong'),
                array_column($m_chitiet_tinh_tapthe->toarray(), 'madanhhieukhenthuong')
            )
        );
        foreach ($model as $ct) {
            $ct->tongcong = 0;
            //Thống kê khen thưởng cấp Xã
            foreach ($a_hinhthuckt_xa as $ma) {
                $ct->$ma = $m_chitiet_xa_canhan->where('madanhhieukhenthuong', $ma)->count()
                    + $m_chitiet_xa_tapthe->where('madanhhieukhenthuong', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
            //Thống kê khen thưởng cấp Huyện
            foreach ($a_hinhthuckt_huyen as $ma) {
                $ct->$ma = $m_chitiet_huyen_canhan->where('madanhhieukhenthuong', $ma)->count()
                    + $m_chitiet_huyen_tapthe->where('madanhhieukhenthuong', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
            //Thống kê khen thưởng cấp Tỉnh
            foreach ($a_hinhthuckt_tinh as $ma) {
                $ct->$ma = $m_chitiet_tinh_canhan->where('madanhhieukhenthuong', $ma)->count()
                    + $m_chitiet_tinh_tapthe->where('madanhhieukhenthuong', $ma)->count();

                $ct->tongcong += $ct->$ma;
            }
        }
        //Thông tin đơn vị
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('BaoCao.TongHop.PhongTrao')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('a_hinhthuckt_xa', $a_hinhthuckt_xa)
            ->with('a_hinhthuckt_huyen', $a_hinhthuckt_huyen)
            ->with('a_hinhthuckt_tinh', $a_hinhthuckt_tinh)
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function HoSo(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        // if ($inputs['madiaban'] != 'ALL') {
        //     $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        // }
        $model = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        if ($inputs['phamvithongke'] != 'ALL') {
            $model = $model->where('capdo', $inputs['phamvithongke']);
        }
        // $m_hoso = dshosothiduakhenthuong::where('trangthai', 'DKT')
        $m_hoso = dshosothiduakhenthuong::where(function ($q) use ($inputs) {
            if ($inputs['trangthai'] == 'DKT') {
                $q->where('trangthai', 'DKT')
                    ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']]);
            }
            if ($inputs['trangthai'] == 'CXKT') {
                $q->wherein('trangthai', ['DTN', 'DCCVXD', 'DCCVKT', 'DDK', 'KDK', 'CXKT', 'BTLTN', 'BTLXD', 'DD', 'CD'])
                    ->wherebetween('thoigian', [$inputs['ngaytu'], $inputs['ngayden']]);
            }
            if ($inputs['trangthai'] == 'ALL') {
                $q->where(function ($query) use ($inputs) {
                    $query->where('trangthai', 'DKT')
                        ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']]);
                })->orwhere(function ($query) use ($inputs) {
                    $query->wherein('trangthai', ['DTN', 'DCCVXD', 'DCCVKT', 'DDK', 'KDK', 'CXKT', 'BTLTN', 'BTLXD', 'DD', 'CD'])
                        ->wherebetween('thoigian', [$inputs['ngaytu'], $inputs['ngayden']]);
                });
            }
        })
            ->wherein('madonvi', array_column($model->toArray(), 'madonvi'))
            ->wherein('phanloai', $inputs['phanloai']);
        //dd($m_hoso->toSql());
        // dd($m_hoso);
        $m_hoso =  $m_hoso->get();
        $m_loaihinhkt = getLoaiHinhKhenThuong();
        $a_diaban = array_column($model->toArray(), 'tendiaban', 'madiaban');
        // dd($m_hoso);
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
        return view('BaoCao.TongHop.HoSo')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('a_loaihinhkt', array_column($m_loaihinhkt->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hồ sơ thi đua, khen thưởng');
    }

    public function KhenThuong_m1(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        if ($inputs['madiaban'] != 'ALL') {
            $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        }
        //Nếu đơn vị quản lý địa bàn (madonviQL) hoặc đơn vị khen thưởng (madonviKT) thì mới xem đc dữ liệu toàn địa bàn
        if ($donvi->madonvi == $donvi->madonviQL) {
            // if ($donvi->madonvi == $donvi->madonviQL || $donvi->madonvi == $donvi->madonviKT) {
            $model = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'));
        } else {
            $model = viewdiabandonvi::where('madonvi', $inputs['madonvi']);
        }

        if ($inputs['phamvithongke'] != 'ALL') {
            $model = $model->where('capdo', $inputs['phamvithongke'])->get();
        } else {
            $model = $model->get();
        }

        $m_hoso = dshosothiduakhenthuong::where('trangthai', 'DKT')
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('madonvi', array_column($model->toarray(), 'madonvi'))
            ->wherein('phanloai', $inputs['phanloai']);

        if ($inputs['madonvi_kt'] != 'ALL') {
            $m_hoso = $m_hoso->where('madonvi_kt', $inputs['madonvi_kt']);
        }

        $m_hoso =  $m_hoso->get();
        $m_canhan = view_tdkt_canhan::selectraw('madonvi, maloaihinhkt, madanhhieukhenthuong, count(mahosotdkt) as soluong')
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)
            ->groupby('madonvi', 'maloaihinhkt', 'madanhhieukhenthuong')
            ->get();
        $m_tapthe = view_tdkt_tapthe::selectraw('madonvi, maloaihinhkt, madanhhieukhenthuong, count(mahosotdkt) as soluong')
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)
            ->groupby('madonvi', 'maloaihinhkt', 'madanhhieukhenthuong')
            ->get();
        //dd($m_canhan);
        // dd($m_canhan->where('madanhhieukhenthuong','1650360491'));
        $a_danhhieukhenthuong = array_unique(array_merge(
            array_column($m_canhan->toarray(), 'madanhhieukhenthuong'),
            array_column($m_tapthe->toarray(), 'madanhhieukhenthuong')
        ));
        //$a_hinhthuckt = getDanhHieuKhenThuong('ALL');
        $a_hinhthuckt = array_column(dmhinhthuckhenthuong::wherein('mahinhthuckt', $a_danhhieukhenthuong)->get()->toarray(), 'tenhinhthuckt', 'mahinhthuckt');
        $a_diaban = a_unique(a_split($model->toArray(), ['tendiaban', 'madiaban', 'capdo', 'madiabanQL']));

        //dd($a_danhhieukhenthuong);
        foreach ($model as $ct) {
            $canhan = $m_canhan->where('madonvi', $ct->madonvi);
            $tapthe = $m_tapthe->where('madonvi', $ct->madonvi);
            $ct->tongso = $canhan->sum('soluong') + $tapthe->sum('soluong');

            foreach ($a_hinhthuckt as $key => $val) {
                //$mahinhthuckt = $loaihinh->madanhhieukhenthuong;
                $ct->$key = $canhan->where('madanhhieukhenthuong', $key)->sum('soluong')
                    + $tapthe->where('madanhhieukhenthuong', $key)->sum('soluong');
            }
            // if($ct->madonvi == '1668019143')
            // dd($canhan);
        }
        //dd($model);
        //Lọc theo địa bàn để lấy báo cáo phù hợp
        $a_huyen = [];
        switch (getCapDoLonNhat(array_unique(array_column($a_diaban, 'capdo')))) {
            case 'H': {
                    $view = 'BaoCao.TongHop.KhenThuong_CapHuyen';
                    break;
                }
            case 'X': {
                    $view = 'BaoCao.TongHop.KhenThuong_CapXa';
                    //Lấy ds huyện
                    $a_huyen = array_column(dsdiaban::where('capdo', 'H')->get()->toarray(), 'tendiaban', 'madiaban');
                    break;
                }
            default: {
                    $view = 'BaoCao.TongHop.KhenThuong_CapTinh';
                }
        }
        $inputs['phanloaihoso'] = '';
        foreach ($inputs['phanloai'] as $phanloai) {
            $inputs['phanloaihoso'] .= (getPhanLoaiHoSo()[$phanloai] . '; ');
        }
        //  dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        // return view('BaoCao.TongHop.KhenThuong_CapTinh')
        return view($view)
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_diaban', $a_diaban)
            ->with('a_huyen', $a_huyen) //dùng cho xã để lọc theo huyện
            ->with('a_hinhthuckt', $a_hinhthuckt)
            //->with('a_danhhieutd', array_column($m_hinhthuc->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp danh hiệu thi đua');
    }

    public function KhenThuong_m2(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        if ($inputs['madiaban'] != 'ALL') {
            $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        }
        //Nếu đơn vị quản lý địa bàn (madonviQL) hoặc đơn vị khen thưởng (madonviKT) thì mới xem đc dữ liệu toàn địa bàn
        if ($donvi->madonvi == $donvi->madonviQL) {
            // if ($donvi->madonvi == $donvi->madonviQL || $donvi->madonvi == $donvi->madonviKT) {
            $m_donvi = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        } else {
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->get();
        }

        //$m_donvi = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        if ($inputs['phamvithongke'] != 'ALL') {
            $m_donvi = $m_donvi->where('capdo', $inputs['phamvithongke']);
        }
        $m_hoso = dshosothiduakhenthuong::where('trangthai', 'DKT')
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('madonvi', array_column($m_donvi->toArray(), 'madonvi'))
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310'])
            ->wherein('phanloai', $inputs['phanloai']);
        if ($inputs['madonvi_kt'] != 'ALL') {
            $m_hoso = $m_hoso->where('madonvi_kt', $inputs['madonvi_kt']);
        }
        $m_hoso =  $m_hoso->get();
        /*
        $m_hoso_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();
        $m_hoso_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();
        */
        $m_hoso_canhan = view_tdkt_canhan::selectraw('maphanloaicanbo, maloaihinhkt, madanhhieukhenthuong, count(mahosotdkt) as soluong')
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->groupby('maphanloaicanbo', 'maloaihinhkt', 'madanhhieukhenthuong')
            ->where('ketqua', 1)->get();
        $m_hoso_tapthe = view_tdkt_tapthe::selectraw('maphanloaitapthe, maloaihinhkt, madanhhieukhenthuong, count(mahosotdkt) as soluong')
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->groupby('maphanloaitapthe', 'maloaihinhkt', 'madanhhieukhenthuong')
            ->where('ketqua', 1)->get();

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
            // $hoso_congtrang = $m_hoso->wherein('maloaihinhkt', ['1650358223']);
            $canhan_congtrang = $m_hoso_canhan->wherein('maloaihinhkt', ['1650358223'])
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_congtrang = $m_hoso_tapthe->wherein('maloaihinhkt', ['1650358223'])
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_cotr = $canhan_congtrang->sum('soluong') + $tapthe_congtrang->sum('soluong');
            $ct->canhan_lada_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->sum('soluong');
            $ct->canhan_lado_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638976'])->sum('soluong');

            //Nhóm chuyên đề, đột xuất
            // $hoso_chuyende = $m_hoso->wherein('maloaihinhkt', ['1650358255', '1650358265']);
            $canhan_chuyende = $m_hoso_canhan->wherein('maloaihinhkt', ['1650358255', '1650358265'])
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_chuyende = $m_hoso_tapthe->wherein('maloaihinhkt', ['1650358255', '1650358265'])
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_chde = $canhan_chuyende->sum('soluong') + $tapthe_chuyende->sum('soluong');
            $ct->canhan_lada_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->sum('soluong');
            $ct->canhan_lado_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638976'])->sum('soluong');

            //Nhóm đối ngoại
            // $hoso_dongo = $m_hoso->wherein('maloaihinhkt', ['1650358297']);
            $canhan_dongo = $m_hoso_canhan->wherein('maloaihinhkt', ['1650358297'])
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_dongo = $m_hoso_tapthe->wherein('maloaihinhkt', ['1650358297'])
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_dongo = $canhan_dongo->sum('soluong') + $tapthe_dongo->sum('soluong');

            //Gán tổng cộng
            $ct->tongso =  $ct->tongso_cotr +  $ct->tongso_chde +  $ct->tongso_dongo;
            $ct->tongdn = $tapthe_congtrang->where('maphanloaitapthe', '1660638247')->sum('soluong')
                + $tapthe_chuyende->where('maphanloaitapthe', '1660638247')->sum('soluong')
                + $tapthe_dongo->where('maphanloaitapthe', '1660638247')->sum('soluong');
            $ct->tongcn = $canhan_congtrang->sum('soluong') + $canhan_chuyende->sum('soluong') +  $canhan_dongo->sum('soluong');
        }

        foreach ($model as $key => $val) {
            if ($val->tongso == 0)
                $model->forget($key);
        }

        //dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.KhenThuong_m2')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            //->with('a_diaban', $a_diaban)
            //->with('a_danhhieutd', array_column($m_hinhthuc->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hình thức khen thưởng');
    }

    public function KhenThuong_m3(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        if ($inputs['madiaban'] != 'ALL') {
            $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        }
        //Nếu đơn vị quản lý địa bàn (madonviQL) hoặc đơn vị khen thưởng (madonviKT) thì mới xem đc dữ liệu toàn địa bàn
        if ($donvi->madonvi == $donvi->madonviQL) {
            // if ($donvi->madonvi == $donvi->madonviQL || $donvi->madonvi == $donvi->madonviKT) {
            $m_donvi = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        } else {
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->get();
        }

        //$m_donvi = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        if ($inputs['phamvithongke'] != 'ALL') {
            $m_donvi = $m_donvi->where('capdo', $inputs['phamvithongke']);
        }
        $m_hoso = dshosothiduakhenthuong::where('trangthai', 'DKT')
            ->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('madonvi', array_column($m_donvi->toArray(), 'madonvi'))
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310'])
            ->wherein('phanloai', $inputs['phanloai']);
        if ($inputs['madonvi_kt'] != 'ALL') {
            $m_hoso = $m_hoso->where('madonvi_kt', $inputs['madonvi_kt']);
        }
        $m_hoso =  $m_hoso->get();
        $m_hoso_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();
        $m_hoso_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();
        $model = DHKT_BaoCao();
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

            $ct->tongso_tapthe_cotr = $tapthe_congtrang->count();
            $ct->canhan_lada_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638843', '1660638808'])->count();
            $ct->canhan_pp_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638930'])->count();
            $ct->canhan_lado_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638976'])->count();

            //Nhóm chuyên đề
            $hoso_chuyende = $m_hoso->wherein('maloaihinhkt', ['1650358255']);
            $canhan_chuyende = $m_hoso_canhan->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_chuyende = $m_hoso_tapthe->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_tapthe_cd = $tapthe_chuyende->count();
            $ct->canhan_lada_cd = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638843', '1660638808'])->count();
            $ct->canhan_pp_cd = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638930'])->count();
            $ct->canhan_lado_cd = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638976'])->count();

            //Nhóm đột xuất
            $hoso_dotxuat = $m_hoso->wherein('maloaihinhkt', ['1650358265']);
            $canhan_dotxuat = $m_hoso_canhan->wherein('mahosotdkt', array_column($hoso_dotxuat->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_dotxuat = $m_hoso_tapthe->wherein('mahosotdkt', array_column($hoso_dotxuat->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_canhan_dx = $canhan_dotxuat->count();
            $ct->tongso_tapthe_dx = $tapthe_dotxuat->count();

            //Nhóm đối ngoại
            $hoso_dongo = $m_hoso->wherein('maloaihinhkt', ['1650358297']);
            $canhan_dongo = $m_hoso_canhan->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_dongo = $m_hoso_tapthe->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_canhan_dongo = $canhan_dongo->count();
            $ct->tongso_tapthe_dongo = $tapthe_dongo->count();

            //gán
            $ct->tongso_tapthe_dn = $tapthe_congtrang->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_chuyende->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_dotxuat->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_dongo->where('maphanloaitapthe', '1660638247')->count();

            $ct->tongso_canhan_dn = $canhan_congtrang->where('maphanloaicanbo', '1660638864')->count()
                + $canhan_chuyende->where('maphanloaicanbo', '1660638864')->count()
                + $canhan_dotxuat->where('maphanloaicanbo', '1660638864')->count()
                + $canhan_dongo->where('maphanloaicanbo', '1660638864')->count();

            $ct->tongtotrinh =  $hoso_congtrang->count() + $hoso_chuyende->count() + $hoso_dotxuat->count() + $hoso_dongo->count();
            $ct->tongtotrinh_canhan =  $canhan_congtrang->count() + $canhan_chuyende->count() + $canhan_dotxuat->count() + $canhan_dongo->count();
            $ct->tongtotrinh_tapthe =  $tapthe_congtrang->count() + $tapthe_chuyende->count() + $tapthe_dotxuat->count() + $tapthe_dongo->count();

            $ct->tongtotrinh_canhan_kt =  $canhan_congtrang->count() + $canhan_chuyende->count() + $canhan_dotxuat->count() + $canhan_dongo->count();
            $ct->tongtotrinh_tapthe_kt =  $tapthe_congtrang->count() + $tapthe_chuyende->count() + $tapthe_dotxuat->count() + $tapthe_dongo->count();

            $ct->tongso = $ct->tongtotrinh_canhan_kt + $ct->tongtotrinh_tapthe_kt;
        }

        foreach ($model as $key => $val) {
            if ($val->tongso == 0)
                $model->forget($key);
        }

        //dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.KhenThuong_m3')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            //->with('a_diaban', $a_diaban)
            //->with('a_danhhieutd', array_column($m_hinhthuc->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hình thức khen thưởng');
    }

    public function KhenCao_m1(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        //dd($inputs['phanloai']);
        // $m_diaban = getDiaBanBaoCaoTongHop($donvi);
        // if ($inputs['madiaban'] != 'ALL') {
        //     $m_diaban = $m_diaban->where('madiaban', $inputs['madiaban']);
        // }
        // $m_donvi = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toArray(), 'madiaban'))->get();
        // if ($inputs['phamvithongke'] != 'ALL') {
        //     $m_donvi = $m_donvi->where('capdo', $inputs['phamvithongke']);
        // }
        $m_hoso = dshosokhencao::wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            //->wherein('madonvi', array_column($m_donvi->toArray(), 'madonvi'))
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310', '1650358282'])
            //->wherein('phanloai', $inputs['phanloai'])
            ->get();
        //dd($m_hoso);
        $model = DHKT_BaoCao();

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

        $m_dshosokhencao_canhan = dshosokhencao_canhan::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();;
        $m_dshosokhencao_tapthe = dshosokhencao_tapthe::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();;

        foreach ($model as $ct) {
            //Nhóm công trạng
            $hoso_congtrang = $m_hoso->wherein('maloaihinhkt', ['1650358223']);
            $canhan_congtrang = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_congtrang = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_cotr = $canhan_congtrang->count() + $tapthe_congtrang->count();
            $ct->tongso_tapthe_cotr = $tapthe_congtrang->count();
            $ct->canhan_lada_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->count();
            $ct->canhan_lado_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638976'])->count();
            //Nhóm chuyên đề, đột xuất
            $hoso_chuyende = $m_hoso->wherein('maloaihinhkt', ['1650358255', '1650358265']);
            $canhan_chuyende = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_chuyende = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            //Nhóm cống hiến
            $hoso_conghien = $m_hoso->wherein('maloaihinhkt', ['1650358282']);
            $canhan_conghien = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_conghien->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_conghien = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_conghien->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_conghien = $canhan_conghien->count() + $tapthe_conghien->count();
            //Nhóm đối ngoại
            $hoso_dongo = $m_hoso->wherein('maloaihinhkt', ['1650358297']);
            $canhan_dongo = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_dongo = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_dongo = $canhan_dongo->count() + $tapthe_dongo->count();

            //Gán tổng cộng 2023.10.28
            // $ct->tongso =  $ct->tongso_cotr +  $ct->tongso_chde +  $ct->tongso_dongo;
            // $ct->tongdn = $tapthe_congtrang->where('maphanloaitapthe', '1660638247')->count()
            //     + $tapthe_chuyende->where('maphanloaitapthe', '1660638247')->count()
            //     + $tapthe_dongo->where('maphanloaitapthe', '1660638247')->count();
            // $ct->tongcn = $canhan_congtrang->count() + $canhan_chuyende->count() +  $canhan_dongo->count();


            //gán
            $ct->tongso_tapthe_dn = $tapthe_congtrang->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_chuyende->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_dongo->where('maphanloaitapthe', '1660638247')->count();

            $ct->tongso_canhan_dn = $canhan_congtrang->where('maphanloaicanbo', '1660638864')->count()
                + $canhan_chuyende->where('maphanloaicanbo', '1660638864')->count()
                + $canhan_dongo->where('maphanloaicanbo', '1660638864')->count();

            $ct->tongtotrinh =  $hoso_congtrang->count() + $hoso_chuyende->count() + $hoso_dongo->count();
            $ct->tongtotrinh_canhan =  $canhan_congtrang->count() + $canhan_chuyende->count() + $canhan_dongo->count();
            $ct->tongtotrinh_tapthe =  $tapthe_congtrang->count() + $tapthe_chuyende->count() +  $tapthe_dongo->count();

            $ct->tongtotrinh_canhan_kt =  $canhan_congtrang->count() + $canhan_chuyende->count()  + $canhan_dongo->count();
            $ct->tongtotrinh_tapthe_kt =  $tapthe_congtrang->count() + $tapthe_chuyende->count()  + $tapthe_dongo->count();

            $ct->tongso = $ct->tongtotrinh_canhan_kt + $ct->tongtotrinh_tapthe_kt;
        }
        foreach ($model as $key => $val) {
            if ($val->tongso == 0)
                $model->forget($key);
        }
        // dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();

        return view('BaoCao.TongHop.KhenThuong_m3')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            //->with('a_diaban', $a_diaban)
            //->with('a_danhhieutd', array_column($m_hinhthuc->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hình thức khen cao');
    }

    public function KhenCao_m2(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $m_hoso = dshosokhencao::wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310', '1650358282'])
            ->wherein('phanloai', $inputs['phanloai'])
            ->get();
        $model = DHKT_BaoCao();

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

        $m_dshosokhencao_canhan = dshosokhencao_canhan::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();;
        $m_dshosokhencao_tapthe = dshosokhencao_tapthe::wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))->where('ketqua', 1)->get();;
        foreach ($model as $ct) {
            //Nhóm công trạng
            $hoso_congtrang = $m_hoso->wherein('maloaihinhkt', ['1650358223']);
            $canhan_congtrang = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_congtrang = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_congtrang->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_tapthe_cotr = $tapthe_congtrang->count();
            $ct->tongso_canhan_cotr = $canhan_congtrang->count();
            $ct->tongso_cotr = $ct->tongso_tapthe_cotr + $ct->tongso_tapthe_cotr;
            $ct->canhan_lada_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->count();
            $ct->canhan_lado_cotr = $canhan_congtrang->wherein('maphanloaicanbo', ['1660638976'])->count();
            //Nhóm chuyên đề, đột xuất
            $hoso_chuyende = $m_hoso->wherein('maloaihinhkt', ['1650358255', '1650358265']);
            $canhan_chuyende = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_chuyende = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_chuyende->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_tapthe_chde = $tapthe_chuyende->count();
            $ct->tongso_canhan_chde = $canhan_chuyende->count();
            $ct->tongso_chde = $ct->tongso_tapthe_chde + $ct->tongso_tapthe_chde;
            $ct->canhan_lada_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638930', '1660638843', '1660638808'])->count();
            $ct->canhan_lado_chde = $canhan_chuyende->wherein('maphanloaicanbo', ['1660638976'])->count();

            //Nhóm cống hiến
            $hoso_conghien = $m_hoso->wherein('maloaihinhkt', ['1650358282']);
            $canhan_conghien = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_conghien->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_conghien = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_conghien->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_tapthe_cohi = $canhan_conghien->count();
            $ct->tongso_canhan_cohi = $tapthe_conghien->count();
            $ct->tongso_cohi = $ct->tongso_tapthe_cohi + $ct->tongso_canhan_cohi;

            //Nhóm đối ngoại
            $hoso_dongo = $m_hoso->wherein('maloaihinhkt', ['1650358297']);
            $canhan_dongo = $m_dshosokhencao_canhan->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);
            $tapthe_dongo = $m_dshosokhencao_tapthe->wherein('mahosotdkt', array_column($hoso_dongo->toarray(), 'mahosotdkt'))
                ->where('madanhhieukhenthuong', $ct->madanhhieukhenthuong);

            $ct->tongso_tapthe_dongo = $tapthe_dongo->count();
            $ct->tongso_canhan_dongo = $canhan_dongo->count();
            $ct->tongso_dongo = $ct->tongso_tapthe_dongo + $ct->tongso_canhan_dongo;

            //Gán tổng cộng
            $ct->tongso_tapthe_dn = $tapthe_congtrang->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_chuyende->where('maphanloaitapthe', '1660638247')->count()
                + $tapthe_dongo->where('maphanloaitapthe', '1660638247')->count();
            $ct->tongso_canhan_dn = $canhan_congtrang->where('maphanloaicanbo', '1660638864')->count()
                + $canhan_chuyende->where('maphanloaicanbo', '1660638864')->count()
                + $canhan_dongo->where('maphanloaicanbo', '1660638864')->count();

            $ct->tongso_canhan =  $ct->tongso_canhan_cotr +  $ct->tongso_canhan_chde +  $ct->tongso_canhan_cohi + $ct->tongso_canhan_dongo;
            $ct->tongso_tapthe =  $ct->tongso_tapthe_cotr +  $ct->tongso_tapthe_chde +  $ct->tongso_tapthe_cohi + $ct->tongso_tapthe_dongo;
            $ct->tongso =  $ct->tongso_tapthe +  $ct->tongso_canhan;
        }
        foreach ($model as $key => $val) {
            if ($val->tongso == 0)
                $model->forget($key);
        }

        // dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        //dd($m_donvibc);
        return view('BaoCao.TongHop.KhenCao_m2')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hình thức khen thưởng');
    }


    public function Mau0701(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = getDSPhongTrao($donvi);
        $model = $model->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']]);
        $model = $model->wherein('phamviapdung', ['TW', 'T', 'SBN']);
        // dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.Mau0701TT03')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0702(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $m_hoso = dshosokhencao::wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            //->wherein('madonvi', array_column($m_donvi->toArray(), 'madonvi'))
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310', '1650358282'])
            //->wherein('phanloai', $inputs['phanloai'])
            ->get();
        //dd($m_hoso);        

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

        $model = view_khencao_canhan::selectraw("maloaihinhkt, madanhhieukhenthuong, maphanloaicanbo as maphanloai, 'CANHAN' as phanloaidoituong")
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->where('ketqua', 1)->get();

        $model_tapthe = view_khencao_tapthe::selectraw("maloaihinhkt, madanhhieukhenthuong, maphanloaitapthe as maphanloai, 'TAPTHE' as phanloaidoituong")
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->where('ketqua', 1)->get();
        //Gộp khen thưởng tập thể
        foreach ($model_tapthe as $tapthe) {
            $model->add($tapthe);
        }

        $model_hogiadinh = view_khencao_hogiadinh::selectraw("maloaihinhkt, madanhhieukhenthuong, maphanloaitapthe as maphanloai, 'HOGIADINH' as phanloaidoituong")
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->where('ketqua', 1)->get();
        //Gộp khen thưởng hộ gia đình
        foreach ($model_hogiadinh as $tapthe) {
            $model->add($tapthe);
        }

        $a_danhhieukhenthuong = array_unique(array_column($model->toarray(), 'madanhhieukhenthuong'));
        $a_hinhthuckt = array_column(dmhinhthuckhenthuong::wherein('mahinhthuckt', $a_danhhieukhenthuong)->get()->toarray(), 'tenhinhthuckt', 'mahinhthuckt');
        //    dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.Mau0702TT03')
            ->with('model', $model)
            ->with('a_hinhthuckt', $a_hinhthuckt)
            // ->with('model_canhan', $model_canhan)
            // ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvibc)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp số lượng khen thưởng cấp nhà nước');
    }

    public function Mau0703(Request $request)
    {
        /*2024.01.19 Đây là mẫu của bộ nội vụ (theo quảng bình) nên chưa lấy đc dữ liệu
        */
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $m_hoso = dshosokhencao::wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            //->wherein('madonvi', array_column($m_donvi->toArray(), 'madonvi'))
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310', '1650358282'])
            //->wherein('phanloai', $inputs['phanloai'])
            ->get();
        //dd($m_hoso);        

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

        //Lấy nhóm khen thưởng theo danh mục
        $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toarray(), 'phanloai', 'mahinhthuckt');

        $model = view_khencao_canhan::selectraw("maloaihinhkt, madanhhieukhenthuong, maphanloaicanbo as maphanloai, 'CANHAN' as phanloaidoituong")
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->where('ketqua', 1)->get();
        //Gán lại nhóm khen thưởng
        foreach ($model as $khenthuong) {
            $khenthuong->nhomkhenthuong = $a_hinhthuckt[$khenthuong->madanhhieukhenthuong] ?? '';
            //Điều kiện lọc các khen thưởng ko thuộc 
        }

        $model_tapthe = view_khencao_tapthe::selectraw("maloaihinhkt, madanhhieukhenthuong, maphanloaitapthe as maphanloai, 'TAPTHE' as phanloaidoituong")
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->where('ketqua', 1)->get();
        //Gộp khen thưởng tập thể
        foreach ($model_tapthe as $tapthe) {
            $tapthe->nhomkhenthuong = $a_hinhthuckt[$tapthe->madanhhieukhenthuong] ?? '';
            $model->add($tapthe);
        }

        $model_hogiadinh = view_khencao_hogiadinh::selectraw("maloaihinhkt, madanhhieukhenthuong, maphanloaitapthe as maphanloai, 'HOGIADINH' as phanloaidoituong")
            ->wherein('mahosotdkt', array_column($m_hoso->toarray(), 'mahosotdkt'))
            ->where('ketqua', 1)->get();
        //Gộp khen thưởng hộ gia đình
        foreach ($model_hogiadinh as $tapthe) {
            $tapthe->nhomkhenthuong = $a_hinhthuckt[$tapthe->madanhhieukhenthuong] ?? '';
            $model->add($tapthe);
        }

        //    dd($model);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.Mau0703TT03')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function QuyKhenThuong(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $model = dsquanlyquykhenthuong::where('nam', $inputs['nam'])->where('madonvi', $inputs['madonvi'])->get();
        $maso = $model->first()->maso ?? '-life';
        //làm lại do mảng duyệt sai
        $model_chitiet = dsquanlyquykhenthuong_chitiet::where('maso', $maso)->get();
        $model_thu = $model_chitiet->where('phanloai', 'THU');
        $model_chikt = $model_chitiet->where('phanloai', 'CHI')->where('phannhom', 'KHENTHUONG');
        $model_chikhac = $model_chitiet->where('phanloai', 'CHI')->where('phannhom', 'KHAC');
        foreach ($model as $ct) {
            $ct->tongthu = 0;
            foreach ($model_thu as $thu) {
                $id = $thu->id;
                $ct->$id = $thu->sotien;
                $ct->tongthu += $thu->sotien;
            }
            $ct->tongchi = 0;

            foreach ($model_chikt as $thu) {
                $id = $thu->id;
                $ct->$id = $thu->sotien;
                $ct->tongchi += $thu->sotien;
            }
            foreach ($model_chikhac as $thu) {
                $id = $thu->id;
                $ct->$id = $thu->sotien;
                $ct->tongchi += $thu->sotien;
            }
        }
        $a_thu = array_column($model_thu->toarray(), 'tentieuchi', 'id');
        $a_chikt = array_column($model_chikt->toarray(), 'tentieuchi', 'id');
        $a_chikhac = array_column($model_chikhac->toarray(), 'tentieuchi', 'id');
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TongHop.QuyKhenThuong')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_thu', $a_thu)
            ->with('a_chikt', $a_chikt)
            ->with('a_chikhac', $a_chikhac)
            ->with('col_thu', count($a_thu) > 0 ? count($a_thu) : 1)
            ->with('col_chikt', count($a_chikt) > 0 ? count($a_chikt) : 1)
            ->with('col_chikhac', count($a_chikhac) > 0 ? count($a_chikhac) : 1)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp hình thức khen thưởng');
    }

    function getMaDiaBan(&$chitiet, $m_phanloai)
    {
        //Truyền vào đơn vị
        //gán madiaban: T, H, X căn cứ theo cấp độ
    }
}
