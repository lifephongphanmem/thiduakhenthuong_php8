<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua\GiaoUoc;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmdanhhieuthidua;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosogiaouocthidua;
use App\Models\NghiepVu\CumKhoiThiDua\dshosogiaouocthidua_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosogiaouocthidua_detai;
use App\Models\NghiepVu\CumKhoiThiDua\dshosogiaouocthidua_tapthe;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosogiaouocthiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/GiaoUocThiDua/HoSo/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dsgiaouocthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsgiaouocthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $m_donvi = getDonViCK(session('admin')->capdo, null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        //dd($m_donvi);
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $model = dshosogiaouocthidua::where('madonvi', $inputs['madonvi']);
        if ($inputs['nam'] != 'ALL')
            $model = $model->where('namdangky', $inputs['nam']);
        $model = $model->orderby('ngayhoso')->get();
        $inputs['trangthai'] = session('chucnang')['dsgiaouocthiduacumkhoi']['trangthai'] ?? 'CC';

        return view('NghiepVu.CumKhoiThiDua.GiaoUoc.HoSo.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViXetDuyetCumKhoi($donvi->macumkhoi))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ giao ước thi đua');
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('dsgiaouocthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsgiaouocthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();        
        $inputs['mahosodk'] = (string)getdate()[0];
        $inputs['trangthai'] = session('chucnang')['dshosodangkythidua']['trangthai'] ?? 'CC';
       //Thiết lập lại do chỉ có 2 bước trong quy trình
        $inputs['trangthai'] = $inputs['trangthai'] != 'CC' ? 'DD' : $inputs['trangthai']; 
        $inputs['namdangky'] = date('Y');
        dshosogiaouocthidua::create($inputs);
        return redirect(static::$url . 'Sua?mahosodk=' . $inputs['mahosodk']);
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dsgiaouocthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsgiaouocthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosogiaouocthidua::where('mahosodk', $inputs['mahosodk'])->first();
        $model_canhan = dshosogiaouocthidua_canhan::where('mahosodk', $inputs['mahosodk'])->get();
        $model_tapthe = dshosogiaouocthidua_tapthe::where('mahosodk', $inputs['mahosodk'])->get();
        $model_detai = dshosogiaouocthidua_detai::where('mahosodk', $inputs['mahosodk'])->get();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $m_donvi = getDonVi(session('admin')->capdo);
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        return view('NghiepVu.CumKhoiThiDua.GiaoUoc.HoSo.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_danhhieutd', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ giao ước thi đua');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosogiaouocthidua::where('mahosodk', $inputs['mahosodk'])->first();
        $model_canhan = dshosogiaouocthidua_canhan::where('mahosodk', $inputs['mahosodk'])->get();
        $model_tapthe = dshosogiaouocthidua_tapthe::where('mahosodk', $inputs['mahosodk'])->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $m_danhhieu = dmdanhhieuthidua::all();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        return view('NghiepVu.CumKhoiThiDua.GiaoUoc.HoSo.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieutd', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('dsgiaouocthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsgiaouocthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();

        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $inputs['mahosodk'] . '_bienban.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['mahosodk'] . 'tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        dshosogiaouocthidua::where('mahosodk', $inputs['mahosodk'])->first()->update($inputs);

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function ThemCaNhan(Request $request)
    {
        $inputs = $request->all();
        $model = dshosogiaouocthidua_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null)
            dshosogiaouocthidua_canhan::create($inputs);
        else
            $model->update($inputs);
        return redirect(static::$url . 'Sua?mahosodk=' . $inputs['mahosodk']);
    }

    public function ThemTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosogiaouocthidua_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null)
            dshosogiaouocthidua_tapthe::create($inputs);
        else
            $model->update($inputs);
        return redirect(static::$url . 'Sua?mahosodk=' . $inputs['mahosodk']);
    }

    public function LayLyDo(Request $request)
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
        $model = dshosogiaouocthidua::where('mahosodk', $inputs['mahosotdkt'])->first();
        die(json_encode($model));
    }

    public function XoaDoiTuong(Request $request)
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
        if ($inputs['phanloaixoa'] == 'TAPTHE') {
            $model = dshosogiaouocthidua_tapthe::findorfail($inputs['iddelete']);
            $model->delete();
        } else {
            $model = dshosogiaouocthidua_canhan::findorfail($inputs['iddelete']);
            $model->delete();
        }

        return redirect(static::$url . 'Sua?mahosodk=' . $model->mahosodk);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dsgiaouocthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dsgiaouocthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosogiaouocthidua::where('mahosodk', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();

        $model->trangthai = 'CD';
        $model->madonvi_nhan = $inputs['madonvi_nhan'];
        $model->thoigian = date('Y-m-d H:i:s');
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CD']);
        //dd($model);
        $model->save();

        $trangthai = new trangthaihoso();
        $trangthai->trangthai = 'CD';
        $trangthai->madonvi = $model->madonvi;
        $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
        $trangthai->phanloai = 'dshosogiaouocthidua';
        $trangthai->mahoso = $model->mahosotdkt;
        $trangthai->thoigian = $model->thoigian;
        $trangthai->save();

        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function LayTapThe(Request $request)
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
        $model = dshosogiaouocthidua_tapthe::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function LayCaNhan(Request $request)
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
        $model = dshosogiaouocthidua_canhan::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaHoSo(Request $request)
    {
        if (!chkPhanQuyen('dsgiaouocthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsgiaouocthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosogiaouocthidua::findorfail($inputs['id']);
        dshosogiaouocthidua_canhan::where('mahosodk', $model->mahosodk)->delete();
        dshosogiaouocthidua_tapthe::where('mahosodk', $model->mahosodk)->delete();
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function NhanExcelTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosodk'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tentapthe']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosodk' => $inputs['mahosodk'],
                'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
            );
        }
        dshosogiaouocthidua_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosodk=' . $inputs['mahosodk']);
    }

    public function NhanExcelCaNhan(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosodk', $inputs['mahosodk'])->first();
        $filename = $inputs['mahosodk'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tendoituong']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosodk' => $inputs['mahosodk'],
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'gioitinh' => $data[$i][$inputs['gioitinh']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
            );
        }

        dshosogiaouocthidua_canhan::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosodk=' . $inputs['mahosodk']);
    }
}
