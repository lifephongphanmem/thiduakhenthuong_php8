<?php

namespace App\Http\Controllers\HeThong;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dsnhomtaikhoan;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ColectionImport;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsnhomtaikhoan_phanquyen;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\DanhMuc\dstaikhoan_phanquyen;
use Illuminate\Support\Facades\Hash;

class dsdiabanController extends Controller
{
    public static $url = '/DiaBan/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            chkaction();
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        if (!chkPhanQuyen('dsdiaban', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdiaban');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = getDiaBan(session('admin')->capdo); //1649996519
        //dd($model->where('madiabanQL', '1649996519')->toarray());
        $m_donvi = dsdonvi::all();
        foreach ($model as $chitiet) {
            $chitiet->sodonvi = $m_donvi->where('madiaban', $chitiet->madiaban)->count();
        }
        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        $a_nhomchucnang = array_column(dsnhomtaikhoan::all()->toArray(), 'tennhomchucnang', 'manhomchucnang');
        $a_cumkhoi = array_column(dscumkhoi::all()->toArray(), 'tencumkhoi', 'macumkhoi');
        $a_phanloai = getPhanLoaiDiaBan();
        $a_diabancaptren = array_column($model->wherein('capdo', ['T', 'H'])->toArray(), 'tendiaban', 'madiaban');
        return view('HeThongChung.DiaBan.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phanloai', getPhanLoaiDonVi_DiaBan())
            ->with('a_diaban', getDiaBan_All(true))
            ->with('a_donvi', $a_donvi)
            ->with('a_nhomchucnang', $a_nhomchucnang)
            ->with('a_cumkhoi', $a_cumkhoi)
            ->with('a_phanloai', $a_phanloai)
            ->with('a_diabancaptren', $a_diabancaptren)
            ->with('pageTitle', chkGiaoDien('dsdiaban', 'tenchucnang'));
    }

    public function modify(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dsdiaban', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdiaban');
        }

        $inputs = $request->all();
        $model = dsdiaban::where('madiaban', $inputs['madiaban'])->first();

        if ($model == null) {
            $inputs['madiaban'] = getdate()[0];
            dsdiaban::create($inputs);
        } else {
            $model->tendiaban = $inputs['tendiaban'];
            $model->capdo = $inputs['capdo'];
            $model->phanloai = $inputs['phanloai'];
            $model->madonviQL = $inputs['madonviQL'];
            $model->madonviKT = $inputs['madonviKT'];
            $model->madiabanQL = $inputs['madiabanQL'] ?? null;
            $model->save();
        }
        return redirect('/DiaBan/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dsdiaban', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdiaban');
        }
        $inputs = $request->all();

        $model = dsdiaban::findorfail($inputs['id']);
        $chk_db = dsdiaban::where('madiabanQL', $model->madiaban)->count();
        $chk_dv = dsdonvi::where('madiaban', $model->madiaban)->count();
        if ($chk_db == 0 && $chk_dv == 0) {
            $model->delete();
        } else {
            return view('errors.403')
                ->with('message', 'Bạn cần xóa hết địa bàn trực thuộc và các đơn vị trong địa bàn.')
                ->with('url', '/DiaBan/ThongTin');
        }

        return redirect('/DiaBan/ThongTin');
    }

    public function LayDonVi(Request $request)
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

        $model = array_column(dsdonvi::where('madiaban', $inputs['madiaban'])->get()->toarray(), 'tendonvi', 'madonvi');
        $result['message'] = '<div id="donviql" class="form-group row">';
        $result['message'] .= '<div class="col-6">';
        $result['message'] .= '<label class="form-control-label">Đơn vị phê duyệt khen thưởng</label>';
        $result['message'] .= '<select class="form-control select2_modal" name="madonviQL">';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';

        $result['message'] .= '<div class="col-6">';
        $result['message'] .= '<label class="form-control-label">Đơn vị xét duyệt hồ sơ</label>';
        $result['message'] .= '<select class="form-control select2_modal" name="madonviKT">';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';
        $result['message'] .= '<div>';

        $result['status'] = 'success';
        return response()->json($result);
    }

    public function NhanExcel(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        if (!isset($inputs['manhomchucnang'])) {
            return view('errors.403')
                ->with('message', 'Bạn cần tạo nhóm chức năng trước khi nhận dữ liệu để phân quyền thuận tiện hơn.')
                ->with('url', '/DiaBan/ThongTin');
        }

        if (!isset($inputs['fexcel'])) {
            return view('errors.403')
                ->with('message', 'File Excel không hợp lệ.')
                ->with('url', '/DiaBan/ThongTin');
        }

        //Lấy địa bàn quản lý
        $capdoquanly = dsdiaban::where('madiaban', $inputs['madiabanQL'])->first()->capdo;
        $capdo = 'X';
        if ($capdoquanly == 'T')
            $capdo = 'H';
        //Lấy danh sách phân quyền
        $model_phanquyen = dsnhomtaikhoan_phanquyen::where('manhomchucnang', $inputs['manhomchucnang'])->get();
        $model_phanquyen_tonghop = dsnhomtaikhoan_phanquyen::where('manhomchucnang', $inputs['manhomchucnangth'])->get();
        //Đọc dữ liệu
        $dataObj = new ColectionImport();
        $theArray = Excel::toArray($dataObj, $inputs['fexcel']);
        $data = $theArray[0];

        $a_diaban = [];
        $a_dv = array();
        $a_tk = array();
        $a_ck = [];
        $a_pq = [];
        $ma = getdate()[0];
        $ima = 1;
        $a_taikhoan = array_column(dstaikhoan::all()->toArray(), 'tendangnhap');
        //Kiểm tra dữ liệu
        $thongbao = 'Tài khoản đã có trên hệ thống: ';
        $nhandulieu = true;
        for ($i = ($inputs['tudong'] - 1); $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][ColumnName()[$inputs['tendonvi']]])) {
                continue;
            }
            $madiaban = $ma . $ima++;
            $a_diaban[] = [
                'madiaban' => $madiaban,
                'tendiaban' => $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                'capdo' => $capdo,
                'phanloai' =>  $inputs['phanloai'],
                'madiabanQL' => $inputs['madiabanQL'],
            ];
            $a_dv[] = array(
                'madiaban' => $madiaban,
                'tendonvi' => $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                'madonvi' => $madiaban,
            );
            //Tài khoản
            $matkhau = $data[$i][ColumnName()[$inputs['matkhau']]] ?? '123456abc';
            $tk = $data[$i][ColumnName()[$inputs['tendangnhap']]] ?? '';
            //Check tài khoản
            if (in_array($tk, $a_taikhoan)) {
                $thongbao .= $tk . ';';
                $nhandulieu = false;
            } else {
                $a_tk[] = array(
                    'madonvi' => $madiaban,
                    'manhomchucnang' => $inputs['manhomchucnang'],
                    'tentaikhoan' => $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                    'matkhau' => md5($matkhau),
                    'trangthai' => '1',
                    'tendangnhap' => $tk,
                );
                foreach ($model_phanquyen as $pq)
                    $a_pq[] = [
                        'tendangnhap' => $tk,
                        'machucnang' => $pq->machucnang,
                        'phanquyen' => $pq->phanquyen,
                        'danhsach' => $pq->danhsach,
                        'thaydoi' => $pq->thaydoi,
                        'hoanthanh' => $pq->hoanthanh,
                        'tiepnhan' => $pq->tiepnhan,
                        'xuly' => $pq->xuly,
                    ];
            }

            //Tài khoản tổng hợp
            $tktonghop = $data[$i][ColumnName()[$inputs['tentonghop']]] ?? '';
            if ($tktonghop != '')
                if (in_array($tktonghop, $a_taikhoan)) {
                    $thongbao .= $tktonghop . ';';
                    $nhandulieu = false;
                } else{
                    $a_tk[] = array(
                        'madonvi' => $madiaban,
                        'manhomchucnang' => $inputs['manhomchucnang'],
                        'tentaikhoan' => 'Tổng hợp ' . $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                        'matkhau' => md5($matkhau),
                        'trangthai' => '1',
                        'tendangnhap' => $tktonghop,
                    );
                    foreach ($model_phanquyen_tonghop as $pq)
                    $a_pq[] = [
                        'tendangnhap' => $tktonghop,
                        'machucnang' => $pq->machucnang,
                        'phanquyen' => $pq->phanquyen,
                        'danhsach' => $pq->danhsach,
                        'thaydoi' => $pq->thaydoi,
                        'hoanthanh' => $pq->hoanthanh,
                        'tiepnhan' => $pq->tiepnhan,
                        'xuly' => $pq->xuly,
                    ];
                }
                    

            if ($inputs['macumkhoi'] != 'NULL') {
                $a_ck[] = [
                    'madonvi' => $madiaban,
                    'macumkhoi' => $inputs['macumkhoi'],
                    'phanloai' => 'THANHVIEN',
                ];
            }
        }
        //dd($a_tk);
        if ($nhandulieu) {
            foreach (array_chunk($a_pq, 50) as $data) {
                dstaikhoan_phanquyen::insert($data);
            }
            
            foreach (array_chunk($a_tk, 50) as $data) {
                dstaikhoan::insert($data);
            }

            foreach (array_chunk($a_diaban, 50) as $data) {
                dsdiaban::insert($data);
            }

            foreach (array_chunk($a_dv, 50) as $data) {
                dsdonvi::insert($data);
            }

            foreach (array_chunk($a_ck, 50) as $data) {
                dscumkhoi_chitiet::insert($data);
            }            
        } else {
            return view('errors.403')
                ->with('message', $thongbao)
                ->with('url', '/DiaBan/ThongTin');
        }
        return redirect(static::$url . 'ThongTin');
    }
}
