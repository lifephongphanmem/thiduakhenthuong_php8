<?php

namespace App\Http\Controllers\API;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\View\viewdiabandonvi;
use Illuminate\Http\Response;

class APInghiepvuController extends Controller
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

    public function getDanhSachHoSo(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();
        $apidungchung = new APIthongtinchungController();
        if (!$apidungchung->checkHeader($header)) {
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
        
        $model_khenthuong = dshosothiduakhenthuong::all();
        $m_donvi = viewdiabandonvi::all();
        return response()->json($m_donvi, Response::HTTP_OK);
        $a_kq = [];
        foreach ($model_khenthuong as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertDanhSachHoSo($hoso, $m_donvi);
        }
        $a_API['Body'] = $a_kq;
        return response()->json($a_API, Response::HTTP_OK);
    }

    public function getHoSoKhenThuong(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();
        $apidungchung = new APIthongtinchungController();
        if (!$apidungchung->checkHeader($header)) {
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

        if (!isset($body['MaHoSoTDKT'])) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Mã hồ sơ không hợp lệ.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }

        $model_khenthuong = dshosothiduakhenthuong::where('mahosotdkt', $body['MaHoSoTDKT'])->get();
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
        $header = $request->headers->all();
        $body = $request->all();
        $apithongtin = new APIthongtinchungController();
        if (!$apithongtin->checkHeader($header)) {
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
        //Kiểm tra thông tin để lưu vào csdl
        $apidungchung = new APIdungchungController();
        if (!$apidungchung->convertHoSoKhenThuong2DB($body)) {
            $a_kq = [
                'matrave' => '-1',
                'thongbao' => 'Hồ sơ không đúng định dạng.',
            ];
            return response()->json($a_kq, Response::HTTP_OK);
        }

        $a_API['Body'] = [
            'matrave' => '1',
            'thongbao' => 'Truyền hồ sơ khen thưởng thành công.',
        ];;
        return response()->json($a_API, Response::HTTP_OK);
    }

    public function getKhenThuongCaNhan(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();
        $apidungchung = new APIthongtinchungController();
        if (!$apidungchung->checkHeader($header)) {
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

        if (!isset($body['MaHoSoTDKT'])) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Mã hồ sơ không hợp lệ.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }

        if (!isset($body['MaCongChucVienChuc'])) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Mã công chức, viên chức không hợp lệ.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }

        $model_khenthuong = dshosothiduakhenthuong::where('mahosotdkt', $body['MaHoSoTDKT'])->get();
        $m_donvi = viewdiabandonvi::all();
        $a_kq = [];
        foreach ($model_khenthuong as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertHoSoCaNhan($hoso, $m_donvi,$body['MaCongChucVienChuc']);
        }
        $a_API['Body'] = $a_kq;
        return response()->json($a_API, Response::HTTP_OK);
    }

    public function postKhenThuongCaNhan(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();
        $apithongtin = new APIthongtinchungController();
        if (!$apithongtin->checkHeader($header)) {
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
        //Kiểm tra thông tin để lưu vào csdl
        $apidungchung = new APIdungchungController();
        if (!$apidungchung->convertHoSoKhenThuong2DB($body)) {
            $a_kq = [
                'matrave' => '-1',
                'thongbao' => 'Hồ sơ không đúng định dạng.',
            ];
            return response()->json($a_kq, Response::HTTP_OK);
        }

        $a_API['Body'] = [
            'matrave' => '1',
            'thongbao' => 'Truyền hồ sơ khen thưởng thành công.',
        ];;
        return response()->json($a_API, Response::HTTP_OK);
    }
}
