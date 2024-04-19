<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\View\view_dscumkhoi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class xetduyethosothamgiathiduacumkhoiController extends Controller
{
    //lấy theo chức năng hồ sơ đề nghị khen thưởng thi đua
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/XetDuyetThamGiaThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongcumkhoi');
        if ($m_donvi->count() == 0) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        
        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        
        $ngayhientai = date('Y-m-d');
        KiemTraPhongTrao($m_phongtrao, $ngayhientai);

        $model = dshosothamgiathiduacumkhoi::where('madonvi_xd', $inputs['madonvi'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->get();
        
        foreach ($model as $chitiet) {
            $chitiet->nhanhoso = $m_phongtrao->nhanhoso;
            // $chitiet->mahosodk = $m_hoso_dangky->where('madonvi', $chitiet->madonvi)->first()->mahosodk ?? null;
            getDonViChuyen($inputs['madonvi'], $chitiet);
        }
        //dd($model);
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetThamGiaThiDua.DanhSach')
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng của cụm, khối');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiXD($model, $inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DD';
        $model->trangthai_xd = 'DD';
        $model->thoigian_xd = $thoigian;
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosothamgiathiduacumkhoi',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Tiếp nhận hồ sơ tham gia phong trào thi đua.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd . '&maphongtraotd=' . $model->maphongtraotd);
    }

}
