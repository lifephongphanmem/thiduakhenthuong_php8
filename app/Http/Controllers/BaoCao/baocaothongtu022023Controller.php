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
use App\Models\View\view_dsphongtrao_cumkhoi;
use App\Models\View\view_khencao_canhan;
use App\Models\View\view_khencao_hogiadinh;
use App\Models\View\view_khencao_tapthe;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaothongtu022023Controller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function Mau0601(Request $request)
    {
        //lấy phong trào thi đua và phong trao thi đua cụm khối
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = getDSPhongTrao($donvi);
        $model = $model->wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']]);
        //Gán mã cụm khối để thống kê
        foreach ($model as $phongtrao) {
            $phongtrao->macumkhoi = '';
        }
        //Lấy phong trào cụm khối thi đua
        $model_cumkhoi = view_dsphongtrao_cumkhoi::wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])->get();
        //Gộp 2 loại phong trào
        foreach ($model_cumkhoi as $phongtrao) {
            $model->add($phongtrao);
        }
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0601')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0602(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $m_hoso = dshosokhencao::wherebetween('ngayqd', [$inputs['ngaytu'], $inputs['ngayden']])
            ->wherein('maloaihinhkt', ['1650358223', '1650358255', '1650358265', '1650358310', '1650358282'])
            ->get();

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
        // $model_hinhthuckt = array_column(dmhinhthuckhenthuong::wherein('mahinhthuckt', $a_danhhieukhenthuong)->get()->toarray(), 'tenhinhthuckt', 'mahinhthuckt');
        $model_hinhthuckt = dmhinhthuckhenthuong::wherein('mahinhthuckt', $a_danhhieukhenthuong)->get();
        $m_huanhuychuong = $model_hinhthuckt->wherein('phanloai',['HUANCHUONG','HUYCHUONG']);
        $m_giaithuonghcm = $model_hinhthuckt->where('mahinhthuckt','1671247920');
        $m_giaithuongnn = $model_hinhthuckt->where('mahinhthuckt','1671247953');
        $m_vinhdunhanuoc = $model_hinhthuckt->wherein('phanloai',['DANHHIEUNN']);
        $m_cothidua = $model_hinhthuckt->where('mahinhthuckt','1647933079');
        $m_bangkhen = $model_hinhthuckt->where('mahinhthuckt','1671247716');
        $m_chiensithidua = $model_hinhthuckt->where('mahinhthuckt','1647933381');
        $m_khenthuongkhac = $model_hinhthuckt->wherein('phanloai',['BANGKHEN'])->where('mahinhthuckt','<>','1671247716');
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0602')
            ->with('model', $model)
            ->with('m_huanhuychuong', $m_huanhuychuong)
            ->with('m_giaithuonghcm', $m_giaithuonghcm)
            ->with('m_giaithuongnn', $m_giaithuongnn)
            ->with('m_vinhdunhanuoc', $m_vinhdunhanuoc)
            ->with('m_cothidua', $m_cothidua)
            ->with('m_bangkhen', $m_bangkhen)
            ->with('m_chiensithidua', $m_chiensithidua)
            ->with('m_khenthuongkhac', $m_khenthuongkhac)
            ->with('m_donvi', $m_donvibc)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp số lượng khen thưởng cấp nhà nước');
    }

    public function Mau0603(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosokhencao::all();
        $model_canhan = view_khencao_canhan::all();
        $model_tapthe = view_khencao_tapthe::all();
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0603')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0604(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosokhencao::all();
        $model_canhan = view_khencao_canhan::all();
        $model_tapthe = view_khencao_tapthe::all();
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0604')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0605(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosokhencao::all();
        $model_canhan = view_khencao_canhan::all();
        $model_tapthe = view_khencao_tapthe::all();
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0605')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }


    function getMaDiaBan(&$chitiet, $m_phanloai)
    {
        //Truyền vào đơn vị
        //gán madiaban: T, H, X căn cứ theo cấp độ
    }
}
