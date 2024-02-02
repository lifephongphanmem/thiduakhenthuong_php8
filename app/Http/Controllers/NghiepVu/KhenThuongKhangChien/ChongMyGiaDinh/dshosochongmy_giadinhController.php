<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongMyGiaDinh;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\KhenThuongKhangChien\dshosochongmy_giadinh;
use Illuminate\Support\Facades\Session;

class dshosochongmy_giadinhController extends Controller
{
    public static $url = '/KhenThuongKhangChien/ChongMyGiaDinh/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('khenthuongchongmygiadinh', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'khenthuongchongmygiadinh')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $m_donvi = getDonVi(session('admin')->capdo, 'khenthuongchongmygiadinh');
        if (count($m_donvi) == 0) {
            return view('errors.noperm')
                ->with('url', '/')
                ->with('machucnang', 'khenthuongchongmygiadinh');
        }
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toArray(), 'madiaban'))->get();
        $m_loaihinh = dmloaihinhkhenthuong::all();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;

        $inputs['maloaihinhkt'] = $inputs['maloaihinhkt'] ?? 'ALL';
        $model = dshosochongmy_giadinh::where('madonvi', $inputs['madonvi']);
        if ($inputs['maloaihinhkt'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);

        $inputs['trangthai'] = $inputs['trangthai'] ?? 'ALL';
        if ($inputs['trangthai'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);
        $model = $model->orderby('ngayhoso')->get();

        return view('NghiepVu.KhenThuongKhangChien.ChongMyGiaDinh.HoSo.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng kháng chiến chống Mỹ cho hộ gia đình');
    }

    public function SuaHoSo(Request $request)
    {
        if (!chkPhanQuyen('khenthuongchongmygiadinh', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'khenthuongchongmygiadinh')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosochongmy_giadinh::where('mahosokt', $inputs['mahosokt'])->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $m_danhhieu = dmdanhhieuthidua::all();
        return view('NghiepVu.KhenThuongKhangChien.ChongMyGiaDinh.HoSo.ThayDoi')
            ->with('model', $model)
            ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosochongmy_giadinh::where('mahosokt', $inputs['mahosokt'])->first();
        $m_donvi = dsdonvi::where('madonvi',$model->madonvi)->first();
        $m_danhhieu = dmdanhhieuthidua::all();
        return view('NghiepVu.KhenThuongKhangChien.ChongMyGiaDinh.HoSo.Xem')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }

    public function ThemHoSo(Request $request)
    {
        if (!chkPhanQuyen('khenthuongchongmygiadinh', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'khenthuongchongmygiadinh')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = new dshosochongmy_giadinh;
        $model->trangthai = 'CC';
        $model->mahosokt = (string)getdate()[0];
        $model->madonvi =  $inputs['madonvi'];
        $model->ngayhoso =  date('Y-m-d');
        $model->tendonvi =  getThongTinDonVi($inputs['madonvi'], 'tendonvi');
        $m_danhhieu = dmdanhhieuthidua::all();
        return view('NghiepVu.KhenThuongKhangChien.ChongMyGiaDinh.HoSo.ThayDoi')
            ->with('model', $model)
            ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('khenthuongchongmygiadinh', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'khenthuongchongmygiadinh')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();

        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['mahosokt'] . '_tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        $model = dshosochongmy_giadinh::where('mahosokt', $inputs['mahosokt'])->first();
        if ($model == null) {
            $inputs['trangthai'] = 'CC';
            dshosochongmy_giadinh::create($inputs);
        } else
            $model->update($inputs);

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    //chưa dùng
    public function NhanHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosochongmy_giadinh::where('mahosokt', $inputs['mahoso'])->first();

        $model->trangthai = 'DD';
        $model->thoigian = date('Y-m-d H:i:s');
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CD']);
        //dd($model);
        $model->save();

        $trangthai = new trangthaihoso();
        $trangthai->trangthai = 'DD';
        $trangthai->madonvi = $model->madonvi;
        $trangthai->phanloai = 'dshosochongmy_giadinh';
        $trangthai->mahoso = $model->mahosokt;
        $trangthai->thoigian = $model->thoigian;
        $trangthai->save();

        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosochongmy_giadinh::where('mahosokt', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if ($model->totrinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->qdkt != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->bienban != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->tailieukhac != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function PheDuyet(Request $request)
    {
        if (!chkPhanQuyen('khenthuongchongmygiadinh', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'khenthuongchongmygiadinh')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosochongmy_giadinh::where('mahosokt', $inputs['mahosokt'])->first();
        setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => 'DKT']);
        $model->trangthai = 'DKT'; //gán trạng thái hồ sơ để theo dõi
        $model->donvikhenthuong = $inputs['donvikhenthuong'];
        $model->capkhenthuong = $inputs['capkhenthuong'];
        $model->soqd = $inputs['soqd'];
        $model->ngayqd = $inputs['ngayqd'];
        $model->chucvunguoikyqd = $inputs['chucvunguoikyqd'];
        $model->hotennguoikyqd = $inputs['hotennguoikyqd'];
        //dd($model);
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('khenthuongchongmygiadinh', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'khenthuongchongmygiadinh')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $trangthai = 'CD';
        $model = dshosochongmy_giadinh::where('mahosokt', $inputs['mahosokt'])->first();
        setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $trangthai]);
        $model->trangthai = $trangthai; //gán trạng thái hồ sơ để theo dõi
        $model->donvikhenthuong = null;
        $model->capkhenthuong = null;
        $model->soqd = null;
        $model->ngayqd = null;
        $model->chucvunguoikyqd = null;
        $model->hotennguoikyqd = null;
        //dd($model);
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }
}
