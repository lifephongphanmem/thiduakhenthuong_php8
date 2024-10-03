<?php

namespace App\Http\Controllers\ThongBao;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\ThongBao\taikhoan_nhanthongbao;
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
        // dd(session('admin'));
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'quanly';
        $a_chucnang = array(
            'phongtraothidua' => [
                'dsphongtraothidua' => 'Phong trào thi đua',
                'khenthuongphongtrao' => 'Khen thưởng theo phong trào thi đua'

            ],
            'quanly' => [
                'congtrang' => 'Khen thưởng công trạng',
                'chuyende' => 'Khen thưởng phong trào thi đua',
                'dotxuat' => 'Khen thưởng đột xuất',
                'conghien' => 'Khen thưởng quá trình cống hiến',
                'nienhan' => 'Khen thưởng theo niên hạn',
                'doingoai' => 'Khen thưởng đối ngoại',
                'khangchien' => 'Khen thưởng kháng chiến'
            ],
            'cumkhoi' => [
                'dsphongtraothiduacumkhoi' => 'Phong trào thi đua cụm khối',
                'khenthuongcumkhoi' => 'Khen thưởng cụm khối'
            ]
        );
        // $a_chucnangphanquyen = array('tnhosodenghikhenthuongcongtrang', 'xdhosodenghikhenthuongcongtrang', 'qdhosodenghikhenthuongcongtrang');
        $chucnang = $a_chucnang[$inputs['phanloai']];
        $inputs['phanloai_ct'] = $inputs['phanloai_ct'] ?? 'ALL';

        $model = thongbao::where(function ($q) use ($inputs) {
            if ($inputs['phanloai_ct'] != 'ALL') {
                $q->where('chucnang', $inputs['phanloai_ct']);
            }
        })->where('phanloai', $inputs['phanloai']);


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
                    // $a_trangthai_tiepnhan = array('CD', 'DTN', 'DCCVXD');
                    $a_dsphanquyen_tn = array(
                        'tnhosodenghikhenthuongcongtrang',
                        'tnhosodenghikhenthuongdoingoai',
                        'tnhosodenghikhenthuongconghien',
                        'tnhosodenghikhenthuongchuyende',
                        'tnhosodenghikhenthuongdotxuat',
                        'tnhosodenghikhenthuongnienhan',
                        'tnhosodenghikhenthuongkhangchien'
                    );
                    $a_phanquyen_xd = array(
                        'xdhosodenghikhenthuongcongtrang',
                        'xdhosodenghikhenthuongdoingoai',
                        'xdhosodenghikhenthuongconghien',
                        'xdhosodenghikhenthuongchuyende',
                        'xdhosodenghikhenthuongdotxuat',
                        'xdhosodenghikhenthuongnienhan',
                        'xdhosodenghikhenthuongkhangchien'
                    );
                    $a_phanquyen_qd = array(
                        'qdhosodenghikhenthuongcongtrang',
                        'qdhosodenghikhenthuongdoingoai',
                        'qdhosodenghikhenthuongconghien',
                        'qdhosodenghikhenthuongchuyende',
                        'qdhosodenghikhenthuongdotxuat',
                        'qdhosodenghikhenthuongnienhan',
                        'qdhosodenghikhenthuongkhangchien',
                    );
                    foreach ($model as $key => $ct) {
                        // $hosokt = dshosothiduakhenthuong::where('mahosotdkt', $ct->mahs_mapt)->first();
                        // dd($hosokt);
                        //Xem xét hồ sơ đang ở giai đoạn nào
                        $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $ct->mahs_mapt)->orderby('created_at', 'desc')->get();
                        // dd($hoso);
                        if (count($hoso) <= 0 && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                            $model->forget($key);
                            continue;
                        }

                        if (count($hoso) > 0) {
                            //Thông báo cho chức năng tiếp nhận
                            foreach ($a_dsphanquyen_tn as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                } else {
                                    if ($ct->taikhoan_tn != session('admin')->tendangnhap && $ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }

                            foreach ($a_phanquyen_xd as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }

                            foreach ($a_phanquyen_qd as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
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
                    if ($inputs['phanloai_ct'] == 'khenthuongphongtrao') {
                        $model = $model->where('madonvi_nhan', session('admin')->madonvi);
                    }
                    if ($inputs['phanloai_ct'] == 'dsphongtraothidua') {
                        $model = $model->wherein('phamvi', $a_phamvi)->where('madonvi_thongbao', '!=', session('admin')->madonvi);
                    }
                    if ($inputs['phanloai_ct'] == 'ALL') {
                        $model = $model->where(function ($query) use ($a_phamvi) {
                            $query->whereIn('phamvi', $a_phamvi)
                                ->where('madonvi_thongbao', '!=', session('admin')->madonvi);
                        })->orWhere(function ($query) use ($inputs) {
                            $query->where('madonvi_nhan', session('admin')->madonvi)->where('phanloai', $inputs['phanloai']);
                        });
                        // dd($model);
                    }
                    $model = $model->get();
                    //phong trào cấp tỉnh thì tất cả đơn vị có thể nhìn thấy, phong trào cấp huyện thì chỉ có các đơn vị thuộc huyên mới xem được
                    //kiểm tra đơn vị có thuộc huyện, sở ban ngành để hiển thị thông báo phong trào
                    foreach ($model as $key => $ct) {
                        $phongtrao = dsphongtraothidua::where('maphongtraotd', $ct->mahs_mapt)->first();
                        if (isset($phongtrao)) {
                            //Kiểm tra quyền
                            if (chkPhanQuyen('dshosothidua', 'phanquyen') == '0') {
                                $model->forget($key);
                                continue;
                            }
                            if (in_array($ct->phamvi, ['H', 'SBN'])) {
                                $madiaban = dsdonvi::where('madonvi', $ct->madonvi_thongbao)->first()->madiaban;
                                $diaban = array_column(dsdiaban::where('madiabanQL', $madiaban)->get()->toarray(), 'madiaban');
                                // dd($diaban);
                                // dd(session('admin'));
                                if (!in_array(session('admin')->madiaban, $diaban)) {
                                    $model->forget($key);
                                    continue;
                                }
                            }
                        } else {
                            $a_dsphanquyen_tn = array(
                                'tnhosodenghikhenthuongthidua',
                            );
                            $a_phanquyen_xd = array(
                                'xdhosodenghikhenthuongthidua',
                            );
                            $a_phanquyen_qd = array(
                                'qdhosodenghikhenthuongthidua',
                            );
                            $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $ct->mahs_mapt)->orderby('created_at', 'desc')->get();
                            if (count($hoso) <= 0 && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                                $model->forget($key);
                                continue;
                            }
                            if (count($hoso) > 0) {
                                //Thông báo cho chức năng tiếp nhận
                                foreach ($a_dsphanquyen_tn as $val) {
                                    if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                        if ($ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    } else {
                                        if ($ct->taikhoan_tn != session('admin')->tendangnhap && $ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    }
                                }

                                foreach ($a_phanquyen_xd as $val) {
                                    if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                        if ($ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    }
                                }

                                foreach ($a_phanquyen_qd as $val) {
                                    if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                        if ($ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                }

            case 'cumkhoi': {
                    $a_macumkhoi = array_column($m_cumkhoi->toarray(), 'macumkhoi');
                    if ($inputs['phanloai_ct'] == 'khenthuongcumkhoi') {
                        $model = $model->where('madonvi_nhan', session('admin')->madonvi);
                    }
                    if ($inputs['phanloai_ct'] == 'dsphongtraothiduacumkhoi') {
                        $model = $model->wherein('phamvi', $a_macumkhoi)->where('madonvi_thongbao', '!=', session('admin')->madonvi);
                    }
                    if ($inputs['phanloai_ct'] == 'ALL') {
                        $model = $model->where(function ($query) use ($a_macumkhoi) {
                            $query->whereIn('phamvi', $a_macumkhoi)
                                ->where('madonvi_thongbao', '!=', session('admin')->madonvi);
                        })->orWhere(function ($query) use ($inputs) {
                            $query->where('madonvi_nhan', session('admin')->madonvi)->where('phanloai', $inputs['phanloai']);
                        });
                    }
                    $model = $model->get();

                    foreach ($model as $key => $ct) {
                        $phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $ct->mahs_mapt)->first();
                        // dd($phongtrao);
                        if (isset($phongtrao)) {
                            //Kiểm tra quyền
                            if (chkPhanQuyen('dshosothiduacumkhoi', 'phanquyen') == '0') {
                                $model->forget($key);
                                continue;
                            }
                            // if (in_array($ct->phamvi, $a_macumkhoi)) {
                            //     $madiaban = dsdonvi::where('madonvi', $ct->madonvi_thongbao)->first()->madiaban;
                            //     $diaban = array_column(dsdiaban::where('madiabanQL', $madiaban)->get()->toarray(), 'madiaban');
                            //     // dd($diaban);
                            //     // dd(session('admin'));
                            //     if (!in_array(session('admin')->madiaban, $diaban)) {
                            //         $model->forget($key);
                            //         continue;
                            //     }
                            // }
                        } else {
                            $a_dsphanquyen_tn = array(
                                'tnhosodenghikhenthuongthiduacumkhoi',
                            );
                            $a_phanquyen_xd = array(
                                'xdhosodenghikhenthuongthiduacumkhoi',
                            );
                            $a_phanquyen_qd = array(
                                'qdhosodenghikhenthuongthiduacumkhoi',
                            );
                            $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $ct->mahs_mapt)->orderby('created_at', 'desc')->get();
                            if (count($hoso) <= 0 && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                                $model->forget($key);
                                continue;
                            }
                            if (count($hoso) > 0) {
                                //Thông báo cho chức năng tiếp nhận
                                foreach ($a_dsphanquyen_tn as $val) {
                                    if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                        if ($ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    } else {
                                        if ($ct->taikhoan_tn != session('admin')->tendangnhap && $ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    }
                                }

                                foreach ($a_phanquyen_xd as $val) {
                                    if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                        if ($ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    }
                                }

                                foreach ($a_phanquyen_qd as $val) {
                                    if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                        if ($ct->phanquyen == $val) {
                                            $model->forget($key);
                                            continue;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                }
        }
        foreach ($model as $ct) {
            if ($ct->chucnang == 'dsphongtraothiduacumkhoi') {
                $ct->url = $ct->url . session('admin')->madonvi;
            }
            $trangthai=taikhoan_nhanthongbao::where('mathongbao',$ct->mathongbao)->where('tendangnhap',session('admin')->tendangnhap)->first();
            $ct->trangthai=isset($trangthai)?'DADOC':'CHUADOC';
            $ct->class = $ct->trangthai == 'CHUADOC' ? 'text-primary' : '';
        }
        $a_donvi = array_column(dsdonvi::all()->toarray(), 'tendonvi', 'madonvi');
        $dscumkhoi = array_column(dscumkhoi::all()->toarray(), 'tencumkhoi', 'macumkhoi');

        $phanloai = array(
            'phongtraothidua' => 'Quản lý phong trào thi đua',
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
            'status' => '401',
            'url'=>''
        );
        if (isset($model)) {
            //add dữ liệu các tài khoản đã đọc vào bảng để loại khi lấy số lượng thông báo
            $taikhoan_thongbao=taikhoan_nhanthongbao::where('mathongbao',$model->mathongbao)->where('tendangnhap',session('admin')->tendangnhap)->first();
            if(!isset($taikhoan_thongbao)){
                $data=array('mathongbao'=>$model->mathongbao,'tendangnhap'=>session('admin')->tendangnhap);
                taikhoan_nhanthongbao::insert($data);
            }
            if ($model->chucnang == 'dsphongtraothiduacumkhoi') {
                $model->url = $model->url . session('admin')->madonvi;
            }
            $result = array(
                'status' => '200',
                'url'=>$model->url
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
