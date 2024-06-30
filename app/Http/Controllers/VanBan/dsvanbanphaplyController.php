<?php

namespace App\Http\Controllers\VanBan;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VanBan\dsvanbanphaply;
use App\Models\VanBan\vanbanphaply_tailieu;
use Illuminate\Support\Facades\Session;

class dsvanbanphaplyController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/QuanLyVanBan/VanBanPhapLy/';
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
        if (!chkPhanQuyen('vanbanphaply', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'vanbanphaply')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['loaivb'] = $inputs['loaivb'] ?? 'ALL';
        $inputs['phannhom'] = $inputs['phannhom'] ?? 'ALL';
        $model = dsvanbanphaply::query();
        if ($inputs['loaivb'] != 'ALL')
            $model = $model->where('loaivb', $inputs['loaivb']);
            if ($inputs['phannhom'] != 'ALL')
            $model = $model->where('phannhom', $inputs['phannhom']);
        $model = $model->orderby('ngayqd')->get();
        return view('VanBan.TaiLieu.ThongTin')
            ->with('model', $model)
            ->with('a_tinhtrang', getTrangThaiVanBan())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách văn bản pháp lý');
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('vanbanphaply', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'vanbanphaply')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dsvanbanphaply::where('mavanban', $inputs['mavanban'])->first();
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = $inputs['mavanban'] . '1.' . $filedk->getClientOriginalName() . '.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/vanban/', $inputs['ipf1']);
        }
        if ($model == null) {
            dsvanbanphaply::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin');
    }

    public function XoaHoSo(Request $request)
    {
        if (!chkPhanQuyen('vanbanphaply', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'vanbanphaply')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model=dsvanbanphaply::findorfail($inputs['id']);
        if(isset($model)){
            $m_tailieu=vanbanphaply_tailieu::where('mavanban',$model->mavanban)->get();
            foreach($m_tailieu as $ct)
            {
                if (file_exists('/data/tailieudinhkem/' . $ct->tentailieu)) {
                    File::Delete('/data/tailieudinhkem/' . $ct->tentailieu);
                }
            }

            $model->delete();
        }
        return redirect(static::$url . 'ThongTin');
    }

    public function Them()
    {
        if (!chkPhanQuyen('vanbanphaply', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'vanbanphaply')->with('tenphanquyen', 'thaydoi');
        }
        $inputs['phanloaihoso'] = 'vanbanphaply';
        $model = new dsvanbanphaply();
        $model->mavanban = getdate()[0];
        $model_tailieu = vanbanphaply_tailieu::where('mavanban', $model->mavanban)->orderby('stt')->get();
        $model->save();
        $stt = $model_tailieu->max('stt');
        return view('VanBan.TaiLieu.ThayDoi')
            ->with('model', $model)
            ->with('stt', $stt)
            ->with('model_tailieu', $model_tailieu)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin văn bản pháp lý');
    }

    public function ThayDoi(Request $request)
    {

        if (!chkPhanQuyen('vanbanphaply', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'vanbanphaply')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['phanloaihoso'] = 'vanbanphaply';
        $model = dsvanbanphaply::where('mavanban', $inputs['mavanban'])->first();
        $model_tailieu = vanbanphaply_tailieu::where('mavanban', $model->mavanban)->orderby('stt')->get();
        $stt = $model_tailieu->max('stt');
        return view('VanBan.TaiLieu.ThayDoi')
            ->with('model', $model)
            ->with('stt', $stt)
            ->with('inputs', $inputs)
            ->with('model_tailieu', $model_tailieu)
            ->with('pageTitle', 'Thông tin văn bản pháp lý');
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();

        $model = dsvanbanphaply::where('mavanban', $inputs['mahs'])->first();
        $model_tailieu = vanbanphaply_tailieu::where('mavanban', $model->mavanban)->orderby('stt')->get();
        //dd($model);
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if (count($model_tailieu) > 0) {
            $result['message'] .= '<div class="row" id="dstailieu">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table class="table table-bordered table-hover dulieubang"';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Nội dung</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model_tailieu as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->noidung . '</td>';
                $result['message'] .= '<td class="text-center">';
                // $result['message'] .= '<button title="Sửa thông tin" type="button" onclick="getTaiLieu(&#39;' . $tt->id . '&#39;)"  class="btn btn-sm btn-clean btn-icon"
                //     data-target="#modal-tailieu" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';

                // $result['message'] .= '<button title="Xóa" type="button" onclick="delTaiLieu(&#39;' . $tt->id . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-tailieu" data-toggle="modal">
                //     <i class="icon-lg la fa-trash text-danger"></i></button>';

                if ($tt->tentailieu != '')
                    $result['message'] .= '<a target="_blank" title="Tải file đính kèm"
                            href="/data/tailieudinhkem/' . $tt->tentailieu . '" class="btn btn-clean btn-icon btn-sm"><i class="fa flaticon-download text-info"></i></a>';
                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
