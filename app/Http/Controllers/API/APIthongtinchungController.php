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
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\hethongchung;
use App\Models\View\view_tdkt_canhan;
use App\Models\View\view_tdkt_detai;
use App\Models\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIthongtinchungController extends Controller
{
    public static $url = '/HeThongAPI/XuatDuLieu/';
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (!Session::has('admin')) {
        //         return redirect('/');
        //     };
        //     return $next($request);
        // });
    }

    function checkHeader($header)
    {
        if (!isset($header['tdktaccesstoken']) && !isset($header['authorization']))
            return false;
        $model_hethong = hethongchung::all()->first();
        //Trường hợp có mã tdktaccesstoken
        if (isset($header['tdktaccesstoken'])) {
            if ($header['tdktaccesstoken'][0] != $model_hethong->accesstoken)
                return false;
        }
        return true;
        //Trường hợp có mã authorization
        if (isset($header['authorization'])) {
            $chuoi = explode(':', base64_decode(str_replace('Bearer ', '', $header['authorization'][0])));
            if (count($chuoi) != 3) //Chuỗi ko đúng định dạng
                return false;
            //Kiểm tra chuỗi
            if (base64_encode($chuoi[0] . ':' . $chuoi[1]) != $model_hethong->accesstoken)
                return false;
            //kiểm tra thời gian
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $thoigian = Carbon::create($now->year, $now->month, $now->day, $now->hour, $now->minute, $now->second);
            $hethan = Carbon::createFromFormat('Y-m-d H:i:s', $chuoi[2] . ':00:00');
            if ($thoigian->hour >= $hethan->hour)
                return false;
        }
        return true;
    }

    public function token(Request $request)
    {
        $header = $request->headers->all();
        /*Xử lý: Headers
            1. có chuỗi tdktaccesstoken => ko check lại thời gian
            2. Authorization => dịch ngược chuỗi để lấy thời gian => đưa ra xử lý

            Authorization có dạng: Bearer xxxxxxx
            xxxxx => tendangnhap:chuoiketnoi:thoigianhethan (SSA:TDKTTUYENQUANG:2023-12-26 17)

        */
        $model_hethong = hethongchung::all()->first();
        if (!isset($header['tdktaccesstoken']) || $model_hethong == null || $header['tdktaccesstoken'][0] != $model_hethong->accesstoken) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ.',
            ];
        } else {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $thoigian = Carbon::create($now->year, $now->month, $now->day, $now->hour, $now->minute, $now->second);
            // $hethan = Carbon::createFromFormat('Y-m-d H:i:s','2023-12-27 04'.':00:00');
            $hethan = Carbon::create($now->year, $now->month, $now->day, $now->hour + 1);
            $a_API = [
                // 'access_token' => base64_decode($header['tdktaccesstoken'][0]) . ':' . $hethan->format('Y-m-d H'),
                'access_token' => base64_encode(base64_decode($header['tdktaccesstoken'][0]) . ':' . $hethan->format('Y-m-d H')),
                'scope' => 'am_application_scope default',
                'token_type' => 'Bearer',
                'expires_in' => $hethan->diffInSeconds($thoigian),
            ];
        }

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function LoaiHinhKhenThuong(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();
        //return response()->json($header, Response::HTTP_OK);
        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dmloaihinhkhenthuong::all();
        $a_kq = [];
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertLoaiHinhKhenThuong($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function HinhThucKhenThuong(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dmhinhthuckhenthuong::all();
        $a_kq = [];
        if (isset($body['PhanLoaiKhenThuong'])) {
            $model = $model->where('phanloai', $body['PhanLoaiKhenThuong']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertHinhThucKhenThuong($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function PhanLoaiDoiTuong(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dmnhomphanloai_chitiet::all();
        $a_kq = [];
        if (isset($body['NhomDoiTuong'])) {
            $model = $model->where('manhomphanloai', $body['NhomDoiTuong']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertPhanLoaiDoiTuong($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function DiaBanHanhChinh(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dsdiaban::all();
        $a_kq = [];
        if (isset($body['NhomDiaBan'])) {
            $model = $model->where('capdo', $body['NhomDiaBan']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertDiaBanHanhChinh($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function DonViSuDung(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dsdonvi::all();
        $a_kq = [];
        if (isset($body['MaDiaBan'])) {
            $model = $model->where('madiaban', $body['madiaban']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertDonViSuDung($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function LinhVucHoatDong(Request $request)
    {
    }
}
