<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dsdonvi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao;
use App\Models\NghiepVu\KhenCao\dshosodenghikhencao_tailieu;
use App\Models\NghiepVu\KhenCao\dshosokhencao_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use Illuminate\Support\Facades\File;

class dungchung_nghiepvu_tailieuController extends Controller
{
    public function ThemTaiLieu(Request $request)
    {
        $inputs = $request->all();        
        if (isset($inputs['tentailieu'])) {
            $filedk = $request->file('tentailieu');
            $inputs['tentailieu'] = $inputs['mahosotdkt'] . '.' . $inputs['phanloai'] . '.' . $filedk->getClientOriginalName();
            $filedk->move(public_path() . '/data/tailieudinhkem/', $inputs['tentailieu']);
        }
        
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong_tailieu::where('id', $inputs['id'])->first();
                    unset($inputs['id']);
                    if ($model == null) {
                        dshosothiduakhenthuong_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    $danhsach = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao_tailieu::where('id', $inputs['id'])->first();
                    unset($inputs['id']);
                    if ($model == null) {
                        dshosokhencao_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    $danhsach = dshosokhencao_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi_tailieu::where('id', $inputs['id'])->first();
                    unset($inputs['id']);
                    if ($model == null) {
                        dshosotdktcumkhoi_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    $danhsach = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
                    break;
                }
            case 'dshosodenghikhencao': {
                    $model = dshosodenghikhencao::where('id', $inputs['id'])->first();
                    unset($inputs['id']);
                    if ($model == null) {
                        dshosodenghikhencao_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    $danhsach = dshosodenghikhencao_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
                    break;
                }
        }

        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        // return response()->json($inputs);

        $this->htmlTaiLieu($result, $danhsach, $inputs['madonvi']);
        return response()->json($result);
    }

    //Thêm tài liệu cho các nghiệp vụ goi (Tờ trình kết quả KT, Quyết định khen thương)
    function ThemTaiLieuDK(Request $request, $phanloaihoso, $truongdulieu, $madonvi)
    {
        $inputs = $request->all();
        //Gán lại trường thông tin
        $inputs['phanloai'] = $inputs['phanloaitailieu'];
        unset($inputs['phanloaitailieu']);
        $inputs['madonvi'] = $madonvi;
        $filedk = $request->file($truongdulieu);
        $inputs['tentailieu'] = $inputs['mahosotdkt'] . '.' . $inputs['phanloai'] . '.' . $filedk->getClientOriginalName();
        $filedk->move(public_path() . '/data/tailieudinhkem/', $inputs['tentailieu']);

        switch ($phanloaihoso) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', $inputs['phanloai'])->first();
                    if ($model == null) {
                        dshosothiduakhenthuong_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', $inputs['phanloai'])->first();
                    if ($model == null) {
                        dshosokhencao_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', $inputs['phanloai'])->first();
                    unset($inputs['id']);
                    if ($model == null) {
                        dshosotdktcumkhoi_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    break;
                }

            case 'dshosodenghikhencao': {
                    $model = dshosodenghikhencao_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', $inputs['phanloai'])->first();
                    unset($inputs['id']);
                    if ($model == null) {
                        dshosodenghikhencao_tailieu::create($inputs);
                    } else {
                        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
                            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
                        }
                        $model->update($inputs);
                    }
                    break;
                }
        }
        return  array(
            'status' => 'success',
            'message' => 'Thêm mới thành công',
        );
    }

    function LayTaiLieu(Request $request)
    {
        $inputs = $request->all();
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong_tailieu::where('id', $inputs['id'])->first();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao_tailieu::where('id', $inputs['id'])->first();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi_tailieu::where('id', $inputs['id'])->first();
                    break;
                }
            case 'dshosodenghikhencao': {
                    $model = dshosodenghikhencao_tailieu::where('id', $inputs['id'])->first();
                    break;
                }
        }
        return response()->json($model);
    }

    function XoaTaiLieu(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //return response()->json($inputs);
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong_tailieu::where('id', $inputs['id'])->first();
                    $model->delete();
                    $danhsach = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao_tailieu::where('id', $inputs['id'])->first();
                    $model->delete();
                    $danhsach = dshosokhencao_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi_tailieu::where('id', $inputs['id'])->first();
                    $model->delete();
                    $danhsach = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    break;
                }

            case 'dshosodenghikhencao': {
                    $model = dshosodenghikhencao_tailieu::where('id', $inputs['id'])->first();
                    $model->delete();
                    $danhsach = dshosodenghikhencao_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    break;
                }
        }
        //Check xoá file
        if (file_exists('/data/tailieudinhkem/' . $model->tentailieu)) {
            File::Delete('/data/tailieudinhkem/' . $model->tentailieu);
        }
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        //return response()->json($inputs);

        $this->htmlTaiLieu($result, $danhsach, $inputs['madonvi']);
        return response()->json($result);
    }

    function htmlTaiLieu(&$result, $model, $madonvi_cs)
    {
        if (isset($model)) {
            $a_pltailieu = getPhanLoaiTaiLieuDK();
            $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
            $result['message'] = '<div class="row" id="dstailieu">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table class="table table-bordered table-hover dulieubang">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th width="20%">Đơn vị tải lên</th>';
            $result['message'] .= '<th width="20%">Phân loại tài liệu</th>';
            $result['message'] .= '<th>Nội dung tóm tắt</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . ($a_donvi[$tt->madonvi] ?? $tt->madonvi) . '</td>';
                $result['message'] .= '<td>' . ($a_pltailieu[$tt->phanloai] ?? '') . '</td>';
                $result['message'] .= '<td>' . $tt->noidung . '</td>';
                $result['message'] .= '<td class="text-center">';
                if ($tt->madonvi ==  $madonvi_cs) {
                    $result['message'] .= '<button title="Sửa thông tin" type="button" onclick="getTaiLieu(&#39;' . $tt->id . '&#39;)"  class="btn btn-sm btn-clean btn-icon"
                    data-target="#modal-tailieu" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';

                    $result['message'] .= '<button title="Xóa" type="button" onclick="delTaiLieu(&#39;' . $tt->id . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-tailieu" data-toggle="modal">
                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                }

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


            $result['status'] = 'success';
        }
    }

    public function DinhKemHoSoKhenThuong(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahs'])->get();
        if ($model->count() > 0) {
            $a_pltailieu = getPhanLoaiTaiLieuDK();
            $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table class="table table-bordered table-hover dulieubang">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th width="20%">Đơn vị tải lên</th>';
            $result['message'] .= '<th width="20%">Phân loại tài liệu</th>';
            $result['message'] .= '<th>Nội dung tóm tắt</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . ($a_donvi[$tt->madonvi] ?? $tt->madonvi) . '</td>';
                $result['message'] .= '<td>' . ($a_pltailieu[$tt->phanloai] ?? '') . '</td>';
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
            // foreach ($model as $tailieu) {
            //     $result['message'] .= '<div class="form-group row">';
            //     $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >' . ($a_pltailieu[$tailieu->phanloai] ?? $tailieu->phanloai) . ':</label>';
            //     $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieudinhkem/' . $tailieu->tentailieu) . '">' . $tailieu->tentailieu . '</a ></div>';
            //     $result['message'] .= '</div>';
            // }

        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function DinhKemHoSoCumKhoi(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosotdktcumkhoi_tailieu::where('mahosotdkt', $inputs['mahs'])->get();
        if ($model->count() > 0) {
            $a_pltailieu = getPhanLoaiTaiLieuDK();
            $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table class="table table-bordered table-hover dulieubang">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th width="20%">Đơn vị tải lên</th>';
            $result['message'] .= '<th width="20%">Phân loại tài liệu</th>';
            $result['message'] .= '<th>Nội dung tóm tắt</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . ($a_donvi[$tt->madonvi] ?? $tt->madonvi) . '</td>';
                $result['message'] .= '<td>' . ($a_pltailieu[$tt->phanloai] ?? '') . '</td>';
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
            // $a_pltailieu = getPhanLoaiTaiLieuDK();
            // foreach ($model as $tailieu) {
            //     $result['message'] .= '<div class="form-group row">';
            //     $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >' . ($a_pltailieu[$tailieu->phanloai] ?? $tailieu->phanloai) . ':</label>';
            //     $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieudinhkem/' . $tailieu->tentailieu) . '">' . $tailieu->tentailieu . '</a ></div>';
            //     $result['message'] .= '</div>';
            // }
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function DinhKemHoSoDeNghiCumKhoi(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosodenghikhencao_tailieu::where('mahosotdkt', $inputs['mahs'])->get();
        if ($model->count() > 0) {
            $a_pltailieu = getPhanLoaiTaiLieuDK();
            $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table class="table table-bordered table-hover dulieubang">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th width="20%">Đơn vị tải lên</th>';
            $result['message'] .= '<th width="20%">Phân loại tài liệu</th>';
            $result['message'] .= '<th>Nội dung tóm tắt</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . ($a_donvi[$tt->madonvi] ?? $tt->madonvi) . '</td>';
                $result['message'] .= '<td>' . ($a_pltailieu[$tt->phanloai] ?? '') . '</td>';
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
    }
}
