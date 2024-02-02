<?php

namespace App\Http\Controllers\NghiepVu\DangKyDanhHieu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class xdhosodangkyphongtraothiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = 'DangKyDanhHieu/HoSo/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('xdhosodangkythidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodangkythidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'xdhosodangkythidua');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $capdo = $donvi->capdo ?? '';

        $model = dshosodangkyphongtraothidua::wherein('mahosodk', function ($qr) use ($inputs) {
            $qr->select('mahosodk')->from('dshosodangkyphongtraothidua')
                ->where('madonvi_nhan', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
        });

        if ($inputs['nam'] != 'ALL')
            $model = $model->where('namdangky', $inputs['nam']);

        $model = $model->orderby('ngayhoso')->get();
        foreach ($model as $hoso) {
            //Trường đơn vị tiếp nhận là cấp xã thì lấy luôn thông tin hồ so            
            if ($capdo == 'X') {
                $hoso->madonvi_hoso = $hoso->madonvi;
                $hoso->trangthai_hoso = $hoso->trangthai;
                $hoso->thoigian_hoso = $hoso->thoigian;
                $hoso->lydo_hoso = $hoso->lydo;
            } else
                getDonViChuyen($inputs['madonvi'], $hoso);
        }
        return view('NghiepVu.DangKyDanhHieu.XetDuyet.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViQuanLyTinh())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký');
    }


    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('xdhosodangkythidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodangkythidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
        $m_nhatky = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
        //lấy thông tin lưu nhật ký
        getDonViChuyen($inputs['madonvi'], $m_nhatky);
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'], 'trangthai' => 'BTL',
            'thoigian' => $thoigian, 'lydo' => $inputs['lydo'], 'phanloai' => 'dshosodangkyphongtraothidua',
            'madonvi_nhan' => $m_nhatky->madonvi_hoso, 'madonvi' => $m_nhatky->madonvi_nhan_hoso
        ]);
        
        //Gán lại trạng thái cho hồ sơ
        setNhanHoSo($inputs['madonvi'], $model, ['trangthai' => 'BTL', 'thoigian' => $thoigian, 'lydo' => $inputs['lydo'], 'madonvi_nhan' => '']);
        setTrangThaiHoSo($inputs['madonvi'], $model, ['trangthai' => '', 'thoigian' => '', 'lydo' => '', 'madonvi_nhan' => '', 'madonvi' => '']);
        //dd($model);
        $model->save();

        return redirect('/DangKyDanhHieu/XetDuyet/ThongTin?madonvi=' . $inputs['madonvi']);
    }

    //chưa dùng
    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosodangkythidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodangkythidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        dd($inputs);
        $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $model->trangthai_h = 'DD';
        $model->madonvi_nhan_h = $inputs['madonvi_nhan'];
        $model->thoigian_h = date('Y-m-d H:i:s');

        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'DD']);
        //dd($model);
        $model->save();

        return redirect('/DangKyDanhHieu/XetDuyet/ThongTin?madonvi=' . $model->madonvi_h);
    }

    //Chưa hoàn thiện
    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosodangkythidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosodangkythidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosodangkyphongtraothidua::where('mahosodk', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();

        setNhanHoSo($inputs['madonvi_nhan'], $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'DD']);
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'DD']);
        //dd($model);
        $model->save();

        return redirect('/DangKyDanhHieu/XetDuyet/ThongTin?madonvi=' . $inputs['madonvi_nhan']);
    }
}
