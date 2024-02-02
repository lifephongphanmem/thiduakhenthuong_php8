<?php

namespace App\Http\Controllers\API;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_detai;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIquanlyvanbanController extends Controller
{
    public static $url = '/HeThongAPI/QuanLyVanBan/';

    public function NhanHoSo(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDonVi('SSA'); //mặc định để đơn vị tổng hợp sử dụng hệ thống
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['url'] = static::$url . 'CaNhan';

        return view('API.QuanLyVanBan.NhanHoSo')
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Nhận hồ sơ từ phần mềm quản lý văn bản');
    }

    public function TruyenHoSo(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo);; //mặc định để đơn vị tổng hợp sử dụng hệ thống
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['url'] = static::$url;
        // $inputs['url'] = static::$url ;
        //Lấy danh sách hồ sơ theo đơn vị để truyền
        $model = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])->orwhere('madonvi_xd', $inputs['madonvi'])->orwhere('madonvi_kt', $inputs['madonvi'])->get();
        // dd($inputs);
        return view('API.QuanLyVanBan.TruyenHoSo')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('a_phanloaihs', getPhanLoaiHoSo())
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))

            ->with('pageTitle', 'Truyền hồ sơ từ phần mềm quản lý văn bản');
    }

    public function TaoAPI(Request $request)
    {
        $inputs = $request->all();

        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $machung = 'QuanLyVanBan'; //Sau thiết lập trên hệ thống chung
        $result['message'] = $inputs['currentUrl'] . $inputs['url'] . '?_token=' . base64_encode($machung . ':' . $inputs['madonvi'] . ':' . $inputs['mahosotdkt']);
        $result['status'] = 'success';

        return (json_encode($result));
    }


    public function getDanhSachHoSo(Request $request)
    {
    }
    public function postHoSo(Request $request)
    {
    }
    public function getHoSoDeNghi(Request $request)
    {
    }
    public function postHoSoDeNghi(Request $request)
    {
    }
    public function getHoSoXetDuyet(Request $request)
    {
    }
    public function postHoSoXetDuyet(Request $request)
    {
    }
    public function getHoSoPheDuyet(Request $request)
    {
    }
    public function postHoSoPheDuyet(Request $request)
    {
    }

    public function getHoSoKhenThuong(Request $request)
    {
        $inputs = $request->all();
        $a_API['Header'] = [
            'Version' => '',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => '',
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $a_giatri = explode(':', base64_decode($inputs['_token']));

        //Nếu nhóm giá trị nhỏ hơn 3 => lỗi
        if (count($a_giatri) < 3) {
            return response()->json([
                'message' => 'Lỗi đường link API.',
                'code' => '-1'
            ], Response::HTTP_OK);
        }
        //Chưa kiểm tra thời hạn của link ở $a_giatri[3]
        $model_khenthuong = dshosothiduakhenthuong::where('mahosotdkt', $a_giatri[2])->get();
        if (count($model_khenthuong) < 1) {
            return response()->json([
                'message' => 'Hồ sơ khen thưởng không hợp lệ.',
                'code' => '-1'
            ], Response::HTTP_OK);
        }
        $donvi = viewdiabandonvi::where('madonvi', $a_giatri[1])->first();
        if ($donvi == null) {
            return response()->json([
                'message' => 'Đơn vị khen thưởng không hợp lệ.',
                'code' => '-1'
            ], Response::HTTP_OK);
        }
        $m_donvi = viewdiabandonvi::all();
        $a_kq = [];
        foreach ($model_khenthuong as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertHoSo($hoso, $m_donvi);
        }
        $a_API['Body'] = $a_kq;
        return response()->json($a_API, Response::HTTP_OK);
    }
    
    public function postHoSoKhenThuong(Request $request)
    {
    }
}
