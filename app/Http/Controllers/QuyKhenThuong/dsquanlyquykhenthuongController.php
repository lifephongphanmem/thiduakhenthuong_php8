<?php

namespace App\Http\Controllers\QuyKhenThuong;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HeThong\trangthaihoso;
use App\Models\QuyKhenThuong\dsquanlyquykhenthuong;
use App\Models\QuyKhenThuong\dsquanlyquykhenthuong_chitiet;
use Illuminate\Support\Facades\Session;

class dsquanlyquykhenthuongController extends Controller
{
    static $url = '/QuyKhenThuong/';
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

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('quykhenthuong', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'quykhenthuong');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;

        $m_donvi = getDonVi(session('admin')->capdo);
        // $m_donvi = getDonVi(session('admin')->capdo, 'quykhenthuong');
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        $inputs['nam'] = $inputs['nam'] ?? date('Y');
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;

        $model = dsquanlyquykhenthuong::where('madonvi', $inputs['madonvi'])
            ->where('nam', $inputs['nam'])->get();


        //dd($model);
        return view('QuyKhenThuong.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách quỹ khen thưởng');
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('quykhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'quykhenthuong')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['maso'] = (string)getdate()[0];
        dsquanlyquykhenthuong::create($inputs);

        //Lưu nhật ký
        $trangthai = new trangthaihoso();
        $trangthai->madonvi = $inputs['madonvi'];
        $trangthai->thongtin = "Thêm mới quỹ thi đua, khen thưởng";
        $trangthai->phanloai = 'dsquanlyquykhenthuong';
        $trangthai->mahoso = $inputs['maso'];
        $trangthai->thoigian = date('Y-m-d');
        $trangthai->save();

        return redirect(static::$url . 'Sua?maso=' . $inputs['maso']);
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongchuyende', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongchuyende')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dsquanlyquykhenthuong::where('maso', $inputs['maso'])->first();
        $model_chitiet = dsquanlyquykhenthuong_chitiet::where('maso', $model->maso)->get();

        return view('QuyKhenThuong.ThayDoi')
            ->with('model', $model)
            ->with('model_thu', $model_chitiet->where('phanloai', 'THU'))
            ->with('model_chi', $model_chitiet->where('phanloai', 'CHI'))
            ->with('a_phannhom', getNhomChiQuy())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin chi tiết quỹ thi đua, khen thưởng');
    }

    public function LayChiTiet(Request $request)
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
        $model = dsquanlyquykhenthuong_chitiet::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function ThemThu(Request $request)
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
        //$id =  $inputs['id'];       
        $model = dsquanlyquykhenthuong_chitiet::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['phanloai'] = 'THU';
            dsquanlyquykhenthuong_chitiet::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dsquanlyquykhenthuong_chitiet::where('maso', $inputs['maso'])->where('phanloai', 'THU')->get();

        $this->htmlThu($result, $danhsach);
        return response()->json($result);
    }

    function htmlThu(&$result, $model)
    {
        if (isset($model)) {
            $result['message'] = '<div class="row" id="dsthu">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tiêu chí</th>';
            $result['message'] .= '<th>Số tiền</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';

            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $tt->stt . '</td>';
                $result['message'] .= '<td>' . $tt->tentieuchi . '</td>';
                $result['message'] .= '<td class="text-right">' . dinhdangso($tt->sotien) . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getThuChi(' . $tt->id . ', &#39;THU&#39;)"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-thu" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';

                $result['message'] .= '<button title="Xóa" type="button" onclick="delChiTiet(' . $tt->id . ', &#39;' . static::$url . 'XoaChiTiet&#39;, &#39;THU&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    public function ThemChi(Request $request)
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
        //$id =  $inputs['id'];       
        $model = dsquanlyquykhenthuong_chitiet::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['phanloai'] = 'CHI';
            dsquanlyquykhenthuong_chitiet::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dsquanlyquykhenthuong_chitiet::where('maso', $inputs['maso'])->where('phanloai', 'CHI')->get();

        $this->htmlChi($result, $danhsach);
        return response()->json($result);
    }

    function htmlChi(&$result, $model)
    {
        $a_phannhom = getNhomChiQuy();
        if (isset($model)) {
            $result['message'] = '<div class="row" id="dschi">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Phân loại</th>';
            $result['message'] .= '<th>Tên tiêu chí</th>';
            $result['message'] .= '<th>Số tiền</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';

            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $tt->stt . '</td>';
                $result['message'] .= '<td>' . ($a_phannhom[$tt->phannhom] ?? '') . '</td>';
                $result['message'] .= '<td>' . $tt->tentieuchi . '</td>';
                $result['message'] .= '<td class="text-right">' . dinhdangso($tt->sotien) . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getThuChi(' . $tt->id . ', &#39;CHI&#39;)"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-thu" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';

                $result['message'] .= '<button title="Xóa" type="button" onclick="delChiTiet(' . $tt->id . ', &#39;' . static::$url . 'XoaChiTiet&#39;, &#39;CHI&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    public function XoaChiTiet(Request $request)
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
        //$id =  $inputs['id'];       
        $model = dsquanlyquykhenthuong_chitiet::where('id', $inputs['id'])->first();
        $inputs['maso'] = $model->maso;
        $model->delete();
        if ($inputs['phanloai'] == 'CHI') {
            $danhsach = dsquanlyquykhenthuong_chitiet::where('maso',)->where('phanloai', 'CHI')->get();

            $this->htmlChi($result, $danhsach);
        } else {
            $danhsach = dsquanlyquykhenthuong_chitiet::where('maso', $inputs['maso'])->where('phanloai', 'THU')->get();

            $this->htmlThu($result, $danhsach);
        }


        return response()->json($result);
    }

    public function Xoa(Request $request)
    {
        if (!chkPhanQuyen('dshosokhenthuongchuyende', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosokhenthuongchuyende')->with('tenphanquyen', 'thaydoi');
        }
        $id=$request->id;
        $model=dsquanlyquykhenthuong::findOrFail($id);
        if(isset($model)){
            $m_chitiet=dsquanlyquykhenthuong_chitiet::where('maso',$model->maso)->delete();
            $model->delete();
        }

        return redirect(static::$url . 'ThongTin');


    }
}
