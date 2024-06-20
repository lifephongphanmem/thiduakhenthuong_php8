<?php

namespace App\Http\Controllers\YKienGopY;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dsdonvi;
use App\Models\View\viewdiabandonvi;
use App\Models\YKienGopY\ykiengopy;
use App\Models\YKienGopY\ykiengopy_tailieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ykiengopyController extends Controller
{
    public static $url = '/YKienGopY/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            if(!chkaction()){
                Session::flush();
                return response()->view('errors.error_login');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {

        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo);
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        // dd($m_donvi);
        // $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['madonvi'] = session('admin')->madonvi;
        if (in_array(session('admin')->sadmin, ['SSA'])) {
            $model = ykiengopy::all();
        }else if (in_array(session('admin')->sadmin, ['ADMIN','SSA'])) {
            $model = ykiengopy::wherein('trangthai', ['1', '2'])->get();
        } else {
            $model = ykiengopy::where('madonvi', $inputs['madonvi'])->get();
        }
        $inputs['url'] = static::$url;
        $inputs['url_tailieudinhkem'] = '/YKienGopY/DinhKemGopY';
        return view('YKienGopY.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Ý kiến góp ý');
    }

    public function Them(Request $request)
    {

        $inputs = $request->all();
        $inputs['magopy'] = (string)getdate()[0];
        $inputs['phanloai'] = 'GOPY';

        //Kiểm tra trạng thái hồ sơ
        // dd($inputs);
        ykiengopy::create($inputs);
        return redirect(static::$url . 'Sua?magopy=' . $inputs['magopy'] . '&phanloai=' . $inputs['phanloai'] . '&madonvi=' . $inputs['madonvi']);
    }

    public function ThayDoi(Request $request)
    {

        $inputs = $request->all();
        $inputs['phanloaihoso'] = 'ykiengopy';
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'GOPY';
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();

        $model_tailieu = ykiengopy_tailieu::where('magopy', $model->magopy)->where('phanloai', 'GOPY')->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        $model->tendonvi = $donvi->tendonvi;

        // $m_donvi = dsdonvi::all();

        // dd($model);
        // dd(session('admin'));
        return view('YKienGopY.ThayDoi')
            ->with('model', $model)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin y kiến góp ý');
    }

    public function LuuThayDoi(Request $request)
    {
        $inputs = $request->all();
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();
        // if (isset($inputs['ipf1'])) {
        //     $filedk = $request->file('ipf1');
        //     $inputs['ipf1'] = $inputs['mavanban'] . '1.' . $filedk->getClientOriginalName() . '.' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/vanban/', $inputs['ipf1']);
        // }
        $currentTimeInVietnam = Carbon::now('Asia/Ho_Chi_Minh');
        $thoigian = $currentTimeInVietnam->format('Y-m-d H:i:s');
        $inputs['thoigiangopy'] = $thoigian;
        if ($model == null) {
            ykiengopy::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }
    public function Xoa(Request $request)
    {
        // if (!chkPhanQuyen('vanbanphaply', 'thaydoi')) {
        //     return view('errors.noperm')->with('machucnang', 'vanbanphaply')->with('tenphanquyen', 'thaydoi');
        // }
        $inputs = $request->all();
        $model = ykiengopy::findorfail($inputs['id']);
        if (isset($model)) {
            $m_tailieu = ykiengopy_tailieu::where('magopy', $model->magopy)->get();
            foreach ($m_tailieu as $ct) {
                if (file_exists('/data/tailieudinhkem/' . $ct->tentailieu)) {
                    File::Delete('/data/tailieudinhkem/' . $ct->tentailieu);
                }
                $ct->delete();
            }

            $model->delete();
        }
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function NhanYKien(Request $request)
    {
        $inputs = $request->all();

        $currentTimeInVietnam = Carbon::now('Asia/Ho_Chi_Minh');
        $thoigian = $currentTimeInVietnam->format('Y-m-d H:i:s');
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 1; //Đã tiếp nhận
        $model->thoigiantiepnhan = $thoigian;
        $model->madonviphanhoi = session('admin')->madonvi;
        // $model->tendangnhap_xl=session('admin')->tendangnhap;
        // dd($model);
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function PhanHoi(Request $request)
    {

        $inputs = $request->all();
        $inputs['phanloaihoso'] = 'ykiengopy';
        $inputs['phanloai'] = 'PHANHOI';

        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();

        $model_tailieu = ykiengopy_tailieu::where('magopy', $model->magopy)->where('phanloai', 'PHANHOI')->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        $model->tendonvi = $donvi->tendonvi;
        return view('YKienGopY.PhanHoi')
            ->with('model', $model)
            ->with('model_tailieu', $model_tailieu)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin phản hồi');
    }
    public function LuuPhanHoi(Request $request)
    {
        $inputs = $request->all();
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();
        $currentTimeInVietnam = Carbon::now('Asia/Ho_Chi_Minh');
        $thoigian = $currentTimeInVietnam->format('Y-m-d H:i:s');
        $inputs['thoigianphanhoi'] = $thoigian;
        $inputs['trangthai'] = 2;
        // dd($inputs);
        if (isset($model)) {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin');
    }

    public function LayThongTin(Request $request)
    {
        $inputs = $request->all();
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();
        return response()->json($model);
    }

    public function DinhKemGopY(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = ykiengopy_tailieu::where('magopy', $inputs['mahs'])->orderby('phanloai')->get();
        if (count($model) > 0) {

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table class="table table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Phân loại</th>';
            $result['message'] .= '<th>Nội dung</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . ($tt->phanloai == "GOPY" ? 'GÓP Ý' : "PHẢN HỒI") . '</td>';
                $result['message'] .= '<td>' . $tt->noidung . '</td>';
                $result['message'] .= '<td class="text-center">';

                if ($tt->tentailieu != '')
                    $result['message'] .= '<a target="_blank" title="Tải file đính kèm"
                            href="/data/tailieudinhkem/' . $tt->tentailieu . '" class="btn btn-clean btn-icon btn-sm"><i class="fa flaticon-download text-info"></i></a>';
                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
        }

        $result['message'] .= '</div>';
        $result['status'] = 'success';
        die(json_encode($result));
        // die(json_encode($model_gopy));
    }
}
