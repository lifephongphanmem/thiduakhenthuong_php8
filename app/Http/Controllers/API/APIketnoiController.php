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
use App\Models\KetNoi\thongtintruyennhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_detai;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIketnoiController extends Controller
{
    public static $url = '/HeThongAPI/KetNoi/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function LayDSFile(Request $request)
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

        $a_pltailieu = getPhanLoaiTaiLieuDK();
        $model = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $result['message'] = '<div id="dsfiledulieu"  class="col-6">';
        $result['message'] .= '<label class="form-control-label">Chọn file dữ liệu:</label>';
        $result['message'] .= '<select class="form-control" id ="matailieu" onchange="getThongTinFile(event)">';
        $result['message'] .= '<option value="-1">--Chọn tài liệu--</option>';
        foreach ($model as $val) {
            $pltailieu = $a_pltailieu[$val->phanloai] ?? $val->phanloai;
            $result['message'] .= '<option value="' . $val->id . '">' . $pltailieu . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';

        $result['status'] = 'success';
        return response()->json($result);
    }

    public function LayThongTinFile(Request $request)
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
        $model = dshosothiduakhenthuong_tailieu::where('id', $inputs['id'])->first();
        if ($model == null && $inputs['id'] > 0) {
            $result['status'] = 'error';
            $result['message'] = 'Không tìm thấy tài liệu bạn đã chọn trong hồ sơ.';
        } else {
            //Kiểm tra file
            $filepath = '/data/tailieudinhkem/' . $model->tentailieu;
            if (file_exists(public_path($filepath))) {
                $result['status'] = 'success';
                $result['tenfiledulieu'] = $model->tentailieu;
                $fileContent = file_get_contents(public_path($filepath));
                $result['filedulieu'] = base64_encode($fileContent);
            } else {
                $result['status'] = 'error';
                $result['message'] = 'File dữ liệu không tồn tại';
            }
        }

        return response()->json($result);
    }

    public function QuanLyCanBo(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url . '/CaNhan';
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;

        return view('API.KetNoi.QuanLyCanBo')
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm quản lý cán bộ');
    }

    public function QuanLyVanBan(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url . '/QuanLyVanBan';
        $inputs['url_tailieudinhkem'] = '/DungChung/DinhKemHoSoKhenThuong';
        $m_donvi = getDonVi(session('admin')->capdo);
        //$a_donvi = array_column($m_donvi->toarray(), 'madonvi');
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        //dd($a_donvi);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $model_ketnoi = thongtintruyennhan::where('madonvi', $inputs['madonvi'])->where('phanmem', 'QLVB')->get();

        $modelQuery = dshosothiduakhenthuong::where(function ($query) use ($inputs) {
            $query->where('madonvi', $inputs['madonvi'])
                ->orWhere('madonvi_xd', $inputs['madonvi'])
                ->orWhere('madonvi_kt', $inputs['madonvi']);
        })->orderBy('ngayhoso', 'asc');

        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        if ($inputs['trangthaihoso'] != 'ALL') {
            $modelQuery->where('trangthai', $inputs['trangthaihoso']);
        }

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL') {
            $modelQuery->whereYear('ngayhoso', $inputs['nam']);
        }

        // Thực hiện truy vấn và lấy kết quả
        $model = $modelQuery->get();

        foreach ($model as $chitiet) {
            $ketnoi = $model_ketnoi->where('mahoso', $chitiet->mahoso)->count();
            $chitiet->trangthaiketnoi = $ketnoi > 0 ? true : false;
        }



        return view('API.KetNoi.QuanLyVanBan')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm quản lý văn bản');
    }

    public function TruyenVanBan(Request $request)
    {
        $inputs = $request->all();
        return view('errors.404')
            ->with('url', '/HeThongAPI/KetNoi/QuanLyVanBan')           
            ->with('message', 'Hệ thống không thể kết nối tới API. Bạn hãy kiểm tra lại API trước khi truyền dữ liệu');
    }

    public function QuanLyLuuTru(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url . '/CaNhan';
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;

        return view('API.KetNoi.QuanLyLuuTru')
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm quản lý lưu trữ');
    }

    public function QuanLyTDKT(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url . '/CaNhan';
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;

        return view('API.KetNoi.QuanLyTDKT')
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm thi đua khen thưởng của Bộ nội vụ');
    }
}
