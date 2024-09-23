<?php

namespace App\Http\Controllers\ThongBao;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly;
use App\Models\ThongBao\thongbao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class thongbaoController extends Controller
{
    public static $url = '/ThongBao/';
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
        $inputs = $request->all();
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'quanly';
        // dd(array_keys(session('phanquyen')));
        $a_chucnang = array(
            'phongtraothidua' => [
                'dsphongtraothidua' => 'Phong trào thi đua',
                'khenthuongphongtrao' => 'Khen thưởng theo phong trào thi đua'

            ],
            'quanly' => [
                'congtrang' => 'Khen thưởng công trạng',
                'chuyende' => 'Khen thưởng theo đợt hoặc chuyên đề',
                'dotxuat' => 'Khen thưởng đột xuất',
                'conghien' => 'Khen thưởng theo quá trình cống hiến',
                'doingoai' => 'Khen thưởng đối ngoại'
            ],
            'cumkhoi' => [
                'dsphongtraothiduacumkhoi' => 'Phong trào thi đua cụm khối',
                'khenthuongcumkhoi' => 'Khen thưởng cụm khối'
            ]
        );
        $a_chucnangphanquyen = array('tnhosodenghikhenthuongcongtrang', 'xdhosodenghikhenthuongcongtrang', 'qdhosodenghikhenthuongcongtrang');
        $chucnang = $a_chucnang[$inputs['phanloai']];
        $inputs['phanloai_ct'] = $inputs['phanloai_ct'] ?? 'ALL';

        $model = thongbao::where(function ($q) use ($inputs) {
            if ($inputs['phanloai_ct'] != 'ALL') {
                $q->where('chucnang', $inputs['phanloai_ct']);
            }
        })->where('phanloai', $inputs['phanloai']);
        // dd($model->get());
        //Lấy thông báo theo model
        switch (session('admin')->capdo) {
            case 'T': {
                    $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', session('admin')->madonvi)->get();
                    $a_phamvi = ['T', 'TW'];
                    break;
                }
            case 'TW': {
                    $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', session('admin')->madonvi)->get();
                    $a_phamvi = ['T', 'TW'];
                    break;
                }
            case 'H': {
                    $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', session('admin')->madonvi)->get();
                    $a_phamvi = ['T', 'TW', 'H'];
                    break;
                }
            case 'X': {
                    $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', session('admin')->madonvi)->get();
                    $a_phamvi = ['T', 'TW', 'H', 'X'];
                    break;
                }
            default: {
                    $m_cumkhoi = dscumkhoi_chitiet::all();
                    $a_phamvi = ['T', 'TW', 'H', 'X'];
                    break;
                }
        }
        // dd($inputs);
        switch ($inputs['phanloai']) {
            case 'quanly': {
                    $model = $model->where('madonvi_nhan', session('admin')->madonvi)->get();

                    $a_trangthai_tiepnhan = array('CD', 'DTN', 'DCCVXD');
                    $a_dsphanquyen_tn = array(
                        'tnhosodenghikhenthuongcongtrang',
                        'tnhosodenghikhenthuongdoingoai',
                        'tnhosodenghikhenthuongconghien',
                        'tnhosodenghikhenthuongchuyende',
                        'tnhosodenghikhenthuongdotxuat',
                        'tnhosodenghikhenthuongnienhan',
                        'tnhosodenghikhenthuongkhangchien'
                    );
                    foreach ($model as $key => $ct) {
                        $hosokt = dshosothiduakhenthuong::where('mahosotdkt', $ct->mahs_mapt)->first();
                        // dd($hosokt);
                        //Xem xét hồ sơ đang ở giai đoạn nào
                        // if (in_array($hosokt->trangthai_xd, $a_trangthai_tiepnhan)) {
                        $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $ct->mahs_mapt)->orderby('created_at', 'desc')->get();
                        if (count($hoso) <= 0 && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                            $model->forget($key);
                            continue;
                        }
                        if (count($hoso) > 0) {
                            //Thông báo cho chức năng tiếp nhận
                            foreach ($a_dsphanquyen_tn as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '1') {
                                    if ($ct->taikhoan_tn != session('admin')->tendangnhap) {
                                        $model->forget($key);
                                        continue;
                                    }
                                } else {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }
                        }
                        // }
                    }
                    break;
                }
            case 'phongtraothidua': {
                    //Xét 2 dạng thông báo: phong trào thi đua và hồ sơ gửi lên
                    if ($inputs['phanloai_ct'] != 'dsphongtraothidua') {
                        $model = $model->where('madonvi_nhan', session('admin')->madonvi)->get();
                    } else {
                        $model = $model->wherein('phamvi', $a_phamvi)->get();
                    }
                    break;
                }

            case 'cumkhoi': {
                    // $macumkhoi=$cumkhoi->macumkhoi??'';
                    $a_macumkhoi = array_column($m_cumkhoi->toarray(), 'macumkhoi');
                    if ($inputs['phanloai_ct'] != 'dsphongtraothidua') {
                        $model = $model->where('madonvi_nhan', session('admin')->madonvi)->get();
                    } else {
                        $model = $model->wherein('phamvi', $a_macumkhoi)->get();
                    }
                    break;
                }
        }
        foreach ($model as $ct) {
            if ($ct->trangthai != 'CHUADOC') {
                if (in_array(session('admin')->tendangnhap, explode(';', $ct->trangthai))) {
                    $ct->trangthai = 'DADOC';
                } else {
                    $ct->trangthai = 'CHUADOC';
                }
            }
            $ct->class = $ct->trangthai == 'CHUADOC' ? 'text-primary' : '';
        }
        $a_donvi = array_column(dsdonvi::all()->toarray(), 'tendonvi', 'madonvi');
        $dscumkhoi = array_column(dscumkhoi::all()->toarray(), 'tencumkhoi', 'macumkhoi');

        $phanloai = array(
            'phongtraothidua' => 'Phong trào thi đua',
            'quanly' => 'Quản lý khen thưởng',
            'cumkhoi' => 'Cụm khối thi đua'
        );
        // dd($model);
        // dd(session('admin'));
        return view('ThongBao.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', $a_donvi)
            ->with('dscumkhoi', $dscumkhoi)
            ->with('phanloai', $phanloai)
            ->with('chucnang', $chucnang)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin thông báo');
    }

    public function DocTin(Request $request)
    {
        $model = thongbao::where('mathongbao', $request->mathongbao)->first();
        $result = array(
            'status' => '401'
        );
        if (isset($model)) {
            if ($model->trangthai == 'CHUADOC') {
                $trangthai = session('admin')->tendangnhap;
            } else {
                $a_trangthai = explode(';', $model->trangthai);
                if (!in_array(session('admin')->tendangnhap, $a_trangthai)) {
                    array_push($a_trangthai, session('admin')->tendangnhap);
                }
                $trangthai = implode(';', $a_trangthai);
            }

            $model->update(['trangthai' => $trangthai]);
            $result = array(
                'status' => '200'
            );
        }

        return response()->json($result);
    }

    public function getphanloai(Request $request)
    {
        $inputs = $request->all();
        $result['status'] = 'success';
        $a_chucnang = array(
            'phongtraothidua' => [
                'dsphongtraothidua' => 'Phong trào thi đua',
                'khenthuongphongtrao' => 'Khen thưởng theo phong trào thi đua'

            ],
            'quanly' => [
                'congtrang' => 'Khen thưởng công trạng',
                'chuyende' => 'Khen thưởng theo đợt hoặc chuyên đề',
                'dotxuat' => 'Khen thưởng đột xuất',
                'conghien' => 'Khen thưởng theo quá trình cống hiến',
                'doingoai' => 'Khen thưởng đối ngoại'
            ],
            'cumkhoi' => [
                'dsphongtraothiduacumkhoi' => 'Phong trào thi đua cụm khối',
                'khenthuongcumkhoi' => 'Khen thưởng cụm khối'
            ]
        );
        $result['message'] = '<div class="col-md-6" id="phanloai_ct">';
        $result['message'] .= '<label style="font-weight: bold">Chức năng</label>';
        $result['message'] .= '<select name="phanloai_ct" id="phanloai_chitiet" class="form-control" onchange="getphanloai_ct()">';
        $result['message'] .= '<option value="ALL">Tất cả</option>';
        foreach ($a_chucnang[$inputs['phanloai']] as $key => $ct) {
            $result['message'] .= '<option value="' . $key . '">' . $ct . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';

        return $result;
    }
}
