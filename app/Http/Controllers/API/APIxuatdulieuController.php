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
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_detai;
use App\Models\View\view_tdkt_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIxuatdulieuController extends Controller
{
    public static $url = '/HeThongAPI/XuatDuLieu/';

    public function CaNhan(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDonVi('SSA'); //mặc định để đơn vị tổng hợp sử dụng hệ thống
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['url'] = static::$url . 'CaNhan';

        return view('API.CaNhan')
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Xuất dữ liệu khen thưởng theo cá nhân');
    }

    public function XuatCaNhan(Request $request)
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
        $a_giatri = explode(':', base64_decode($inputs['maso']));

        //Nếu nhóm giá trị nhỏ hơn 3 => lỗi
        if (count($a_giatri) < 3) {
            $a_API['Body'] = ['message' => 'Lỗi đường link API.'];
            return response()->json($a_API, Response::HTTP_NOT_FOUND);
        }
        //Chưa kiểm tra thời hạn của link ở $a_giatri[3]
        $model_khenthuong = view_tdkt_canhan::where('trangthai', 'DKT')
            ->where('ngayqd', '>=', $a_giatri[1])
            ->where('ngayqd', '<=', $a_giatri[2])
            ->where('madonvi',  $a_giatri[0])
            ->get();
        $a_kq = [];
        foreach ($model_khenthuong as $khenthuong) {
            $a_kq[] = [
                'MaDonVi' => $khenthuong->madonvi,
                'TenDonVi' => '',
                'LoaiHinhKhenThuong' => $khenthuong->mahinhthuckt,
                'NoiDungKhenThuong' => $khenthuong->noidung,
                'SoQuyetDinh' => $khenthuong->soqd,
                'NgayQuyetDinh' => $khenthuong->ngayqd,
                'MaCanBo' => '',
                'TenCanBo' => $khenthuong->tendoituong,
                // 'MaChucVu'
                'TenChucVu' => $khenthuong->chucvu,
                'MaHinhThucKhenThuong' => $khenthuong->madanhhieukhenthuong,
                // 'TenHinhThucKhenThuong'=>'',
            ];
        }
        $a_API['Body'] = $a_kq;
        return response()->json($a_API, Response::HTTP_OK);
    }

    public function TapThe(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDonVi('SSA'); //mặc định để đơn vị tổng hợp sử dụng hệ thống
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['url'] = static::$url . 'CaNhan';

        return view('API.TapThe')
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Xuất dữ liệu khen thưởng theo cá nhân');
    }

    public function XuatTapThe(Request $request)
    {

        $inputs = $request->all();
        $currentDate = Carbon::now();
        $a_API['Header'] = [
            'Version' => '',
            'Tran_Code' => '',
            'Export_Date' =>  $currentDate->toDateString(),
            'Msg_ID' => '',
            'Path' => '',
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $a_giatri = explode(':', base64_decode($inputs['maso']));

        //Nếu nhóm giá trị nhỏ hơn 3 => lỗi
        if (count($a_giatri) < 3) {
            $a_API['Body'] = ['message' => 'Lỗi đường link API.'];
            return response()->json($a_API, Response::HTTP_NOT_FOUND);
        }
        //Chưa kiểm tra thời hạn của link ở $a_giatri[3]
        $ngayketxuat = Carbon::createFromFormat('Y-m-d', $a_giatri[3]);
        // dd($ngayketxuat);

        $model_khenthuong = view_tdkt_tapthe::where('trangthai', 'DKT')
            ->where('ngayqd', '>=', $a_giatri[1])
            ->where('ngayqd', '<=', $a_giatri[2])
            ->where('madonvi',  $a_giatri[0])
            ->get();
        $a_kq = [];

        foreach ($model_khenthuong as $khenthuong) {
            $a_kq[] = [
                'MaDonVi' => $khenthuong->madonvi,
                'TenDonVi' => '',
                'LoaiHinhKhenThuong' => $khenthuong->mahinhthuckt,
                'NoiDungKhenThuong' => $khenthuong->noidung,
                'SoQuyetDinh' => $khenthuong->soqd,
                'NgayQuyetDinh' => $khenthuong->ngayqd,
                'TenTapThe' => $khenthuong->tentapthe,
                'LinhVucHoatDong' => $khenthuong->linhvuchoatdong,
                'MaHinhThucKhenThuong' => $khenthuong->madanhhieukhenthuong,
                // 'TenHinhThucKhenThuong'=>'',
            ];
        }
        $a_API['Body'] = $a_kq;
        return response()->json($a_API, Response::HTTP_OK);
    }
}
