<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dmtoadoinphoi;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_hogiadinh;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_tailieu;
use App\Models\NghiepVu\KhenCao\dshosokhencao;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;

class dungchung_nghiepvuController extends Controller
{
    public function getDonViKhenThuong_ThemHS(Request $request)
    {
        $inputs = $request->all();
        $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if ($donvi != null)
            $model = getDonViQuanLyDiaBan($donvi);
        else
            $model = ['ALL' => 'Chọn đơn vị'];
        $result['status'] = 'success';
        $result['message'] = '<div id="donvikhenthuong" class="col-6">';
        $result['message'] .= '<label>Đơn vị khen thưởng</label>';
        $result['message'] .= '<select id="madonvi_kt_themhs" class="form-control" required="" name="madonvi_kt">';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select></div>';
        die(json_encode($result));
    }

    function htmlTapThe(&$result, $model, $url, $bXoa = true, $maloaihinhkt)
    {
        if (isset($model)) {
            //$a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            //$a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');
            $a_loaihinh = array_column(dmloaihinhkhenthuong::all()->toarray(), 'tenloaihinhkt', 'maloaihinhkt');
            $a_linhvuc = getLinhVucHoatDong();

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tập thể</th>';
            $result['message'] .= '<th>Phân loại<br>đối tượng</th>';
            $result['message'] .= '<th>Lĩnh vực hoạt động</th>';
            $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
            $result['message'] .= '<th>Loại hình khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td>' . ($a_linhvuc[$tt->linhvuchoatdong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_loaihinh[$maloaihinhkt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                if ($bXoa)
                    $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . $url . 'XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                // $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;TAPTHE&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

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

    function htmlCaNhan(&$result, $model, $url, $bXoa = true, $maloaihinhkt)
    {
        if (isset($model)) {
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');
            $a_loaihinh = array_column(getLoaiHinhKhenThuong()->toarray(), 'tenloaihinhkt', 'maloaihinhkt');
            //$a_linhvuc = getLinhVucHoatDong();


            $result['message'] = '<div class="row" id="dskhenthuongcanhan">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Tên đối tượng</th>';
            // $result['message'] .= '<th width="8%">Ngày sinh</th>';
            $result['message'] .= '<th width="5%">Giới</br>tính</th>';
            $result['message'] .= '<th>Phân loại cán bộ</th>';
            $result['message'] .= '<th>Thông tin công tác</th>';
            $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
            $result['message'] .= '<th>Loại hình khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
                // $result['message'] .= '<td class="text-center">' . getDayVn($tt->ngaysinh) . '</td>';
                $result['message'] .= '<td>' . $tt->gioitinh . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaicanbo] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_loaihinh[$maloaihinhkt] ?? '') . '</td>';

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                if ($bXoa)
                    $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . $url . 'XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                // $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;CANHAN&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

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

    function htmlHoGiaDinh(&$result, $model, $url, $bXoa = true, $maloaihinhkt)
    {
        if (isset($model)) {
            //$a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            //$a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');
            $a_loaihinh = array_column(dmloaihinhkhenthuong::all()->toarray(), 'tenloaihinhkt', 'maloaihinhkt');
            $a_linhvuc = getLinhVucHoatDong();

            $result['message'] = '<div class="row" id="dskhenthuonghogiadinh">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_5" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên hộ gia đình</th>';
            // $result['message'] .= '<th>Phân loại<br>đối tượng</th>';
            $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
            $result['message'] .= '<th>Loại hình khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                // $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_loaihinh[$maloaihinhkt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getHoGiaDinh(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-hogiadinh" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                if ($bXoa)
                    $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . $url . 'XoaHoGiaDinh&#39;, &#39;HOGIADINH&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                // $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;TAPTHE&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

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

    function htmlDeTai(&$result, $model, $url, $bXoa = true)
    {
        if (isset($model)) {
            $result['message'] = '<div class="row" id="dsdetai">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_5" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên đề tài, sáng kiến</th>';
            $result['message'] .= '<th>Thông tin tác giả</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tensangkien . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->tendoituong . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getDeTai(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-detai" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delDeTai(' . $tt->id . ', &#39;' . $url . 'XoaDeTai&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-detai" data-toggle="modal">
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

    public function DinhKemHoSoThamGia(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahs'])->first();
        $result['message'] .= '<h5>Tài liệu hồ sơ đề nghị khen thưởng</h5>';
        if ($model != null) {
            if (isset($model->totrinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->baocao)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->bienban)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
                $result['message'] .= '</div>';
            }
            if (isset($model->tailieukhac)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->quyetdinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->quyetdinh) . '">' . $model->quyetdinh . '</a ></div>';
                $result['message'] .= '</div>';
            }
            $result['message'] .= '<hr><h5>Tài liệu phong trào thi đua</h5>';
            $model_pt = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
            if (isset($model_pt->qdkt)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model_pt->qdkt) . '">' . $model_pt->qdkt . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model_pt->tailieukhac)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model_pt->tailieukhac) . '">' . $model_pt->tailieukhac . '</a ></div>';
                $result['message'] .= '</div>';
            }
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function DinhKemHoSoKhenCao(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahs'])->first();
        if ($model != null) {
            if (isset($model->totrinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->baocao)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->bienban)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
                $result['message'] .= '</div>';
            }
            if (isset($model->tailieukhac)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->totrinhdenghi)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình kết quả khen thưởng:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinhdenghi) . '">' . $model->totrinhdenghi . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->quyetdinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->quyetdinh) . '">' . $model->quyetdinh . '</a ></div>';
                $result['message'] .= '</div>';
            }
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    function htmlPheDuyetCaNhan(&$result, $model)
    {
        if (isset($model)) {
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');

            $result['message'] = '<div class="row" id="dskhenthuongcanhan">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Tên đối tượng</th>';
            $result['message'] .= '<th width="8%">Ngày sinh</th>';
            $result['message'] .= '<th width="15%">Phân loại cán bộ</th>';
            $result['message'] .= '<th>Thông tin công tác</th>';
            $result['message'] .= '<th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th>Lý do không khen/</br>Nội dung khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
                $result['message'] .= '<td class="text-center">' . getDayVn($tt->ngaysinh) . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaicanbo] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';

                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-check text-primary icon-2x"></i></button></td>';
                else
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></button></td>';
                $result['message'] .= '<td>' . $tt->noidungkhenthuong . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';

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

    function htmlPheDuyetTapThe(&$result, $model)
    {
        if (isset($model)) {
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tập thể</th>';
            $result['message'] .= '<th>Phân loại<br>tập thể</th>';
            $result['message'] .= '<th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th>Lý do không khen/</br>Nội dung khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';

                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><a class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-check text-primary icon-2x"></i></a></td>';
                else
                    $result['message'] .= '<td class="text-center"><a class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></a></td>';
                $result['message'] .= '<td>' . $tt->noidungkhenthuong . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;/KhenThuongCongHien/HoSo/XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>';

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

    function htmlPheDuyetHoGiaDinh(&$result, $model)
    {
        if (isset($model)) {
            //$a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            //$a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            //$a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');
            //$a_loaihinh = array_column(dmloaihinhkhenthuong::all()->toarray(), 'tenloaihinhkt', 'maloaihinhkt');
            //$a_linhvuc = getLinhVucHoatDong();

            $result['message'] = '<div class="row" id="dskhenthuonghogiadinh">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_5" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên hộ gia đình</th>';
            // $result['message'] .= '<th>Phân loại<br>đối tượng</th>';
            $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th>Lý do không khen/</br>Nội dung khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                // $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';

                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><a class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-check text-primary icon-2x"></i></a></td>';
                else
                    $result['message'] .= '<td class="text-center"><a class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></a></td>';
                $result['message'] .= '<td>' . $tt->noidungkhenthuong . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getHoGiaDinh(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-hogiadinh" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';

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

    public function InPhoi(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongCongTrang/HoSoKT/';
        $inputs['url_xd'] = '/KhenThuongCongTrang/HoSoKT/';
        $inputs['url_qd'] = '/KhenThuongCongTrang/HoSoKT/';
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        $model->tendonvi = $m_donvi->tendonvi;
        return view('NghiepVu._DungChung.InPhoi')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen');
    }

    public function LuuToaDo(Request $request)
    {
        $inputs = $request->all();
        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                // dd($this->setToaDo($inputs));
                                dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->update($this->setToaDo($inputs));
                                break;
                            }
                        case "CANHAN": {
                                dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->update($this->setToaDo($inputs));
                                break;
                            }
                        case "HOGIADINH": {
                                dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->update($this->setToaDo($inputs));
                                break;
                            }
                    }
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->update($this->setToaDo($inputs));
                                break;
                            }
                        case "CANHAN": {
                                dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->update($this->setToaDo($inputs));
                                break;
                            }
                        case "HOGIADINH": {
                                dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->update($this->setToaDo($inputs));
                                break;
                            }
                    }
                    break;
                }
        }
        $result['status'] = 'success';
        $result['message'] = 'Lưu tọa độ thành công.';
        die(json_encode($result));
    }

    public function GanToaDoMacDinh(Request $request)
    {
        $inputs = $request->all();
        $model = dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
            ->where('phanloaidoituong', $inputs['phanloaidoituong'])
            ->where('phanloaiphoi', $inputs['phanloaiphoi'])
            ->where('madonvi', $inputs['madonvi'])->first();

        if ($model != null) {
            $model->update([
                'toado_tendoituongin' => $inputs['toado_tendoituongin'],
                'toado_noidungkhenthuong' => $inputs['toado_noidungkhenthuong'],
                'toado_ngayqd' => $inputs['toado_ngayqd'],
                'toado_chucvunguoikyqd' => $inputs['toado_chucvunguoikyqd'],
                'toado_hotennguoikyqd' => $inputs['toado_hotennguoikyqd'],
                'toado_chucvudoituong' => $inputs['toado_chucvudoituong'],
                'toado_pldoituong' => $inputs['toado_pldoituong'],
                'toado_quyetdinh' => $inputs['toado_quyetdinh'],
                'toado_chucvudoituong' => $inputs['toado_chucvudoituong'],
                'phanloaikhenthuong' => $inputs['phanloaikhenthuong'],
                'phanloaidoituong' => $inputs['phanloaidoituong'],
                'phanloaiphoi' => $inputs['phanloaiphoi'],
                'madonvi' => $inputs['madonvi'],
            ]);
        } else
            dmtoadoinphoi::create($inputs);

        $result['status'] = 'success';
        $result['message'] = 'Đặt tọa độ mặc định thành công.';
        die(json_encode($result));
    }

    function setToaDo($inputs)
    {
        return  [
            'toado_tendoituongin' => $inputs['toado_tendoituongin'],
            'toado_noidungkhenthuong' => $inputs['toado_noidungkhenthuong'],
            'toado_ngayqd' => $inputs['toado_ngayqd'],
            'toado_chucvunguoikyqd' => $inputs['toado_chucvunguoikyqd'],
            'toado_hotennguoikyqd' => $inputs['toado_hotennguoikyqd'],
            'toado_quyetdinh' => $inputs['toado_quyetdinh'],
            'toado_chucvudoituong' => $inputs['toado_chucvudoituong'],
            'toado_pldoituong' => $inputs['toado_pldoituong'],
        ];
    }

    public function LuuThayDoiViTri(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->update($this->setViTri($inputs));
                                break;
                            }
                        case "CANHAN": {
                                dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->update($this->setViTri($inputs));
                                //return redirect('/DungChung/InPhoiKhenThuong/InBangKhenCaNhan?id=' . $inputs['id']);
                                break;
                            }
                        case "HOGIADINH": {
                                dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->update($this->setViTri($inputs));
                                //return redirect('/DungChung/InPhoiKhenThuong/InBangKhenHoGiaDinh?id=' . $inputs['id']);
                                break;
                            }
                    }
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->update($this->setViTri($inputs));
                                //return redirect('/DungChung/InPhoiKhenThuong/InGiayKhenTapThe?id=' . $inputs['id']);
                                break;
                            }
                        case "CANHAN": {
                                dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->update($this->setViTri($inputs));
                                //return redirect('/DungChung/InPhoiKhenThuong/InGiayKhenCaNhan?id=' . $inputs['id']);
                                break;
                            }
                        case "HOGIADINH": {
                                dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->update($this->setViTri($inputs));
                                //return redirect('/DungChung/InPhoiKhenThuong/InGiayKhenHoGiaDinh?id=' . $inputs['id']);
                                break;
                            }
                    }
                    break;
                }
        }

        if ($inputs["phanloaiphoi"] == 'BANGKHEN')
            return redirect('/DungChung/InPhoiKhenThuong/InBangKhen?phanloaikhenthuong=' . $inputs['phanloaikhenthuong'] . '&phanloaidoituong=' . $inputs['phanloaidoituong'] . '&id=' . $inputs['id'] . '&madonvi=' . $inputs['madonvi']);
        else
            return redirect('/DungChung/InPhoiKhenThuong/InGiayKhen?phanloaikhenthuong=' . $inputs['phanloaikhenthuong'] . '&phanloaidoituong=' . $inputs['phanloaidoituong'] . '&id=' . $inputs['id'] . '&madonvi=' . $inputs['madonvi']);
    }

    public function TaiLaiToaDo(Request $request)
    {
        $inputs = $request->all();
        $m_toado = dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
            ->where('phanloaidoituong', $inputs['phanloaidoituong'])
            ->where('phanloaiphoi', $inputs['phanloaiphoi'])
            ->where('madonvi', $inputs['madonvi_laytoado'])->first();

        //Gán lại ảnh phôi 
        $m_donvi_laytoado = dsdonvi::where('madonvi', $inputs['madonvi_laytoado'])->first();
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_donvi->phoi_bangkhen = $m_donvi_laytoado->phoi_bangkhen;
        $m_donvi->dodai_bangkhen = $m_donvi_laytoado->dodai_bangkhen;
        $m_donvi->chieurong_bangkhen = $m_donvi_laytoado->chieurong_bangkhen;
        $m_donvi->phoi_giaykhen = $m_donvi_laytoado->phoi_giaykhen;
        $m_donvi->dodai_giaykhen = $m_donvi_laytoado->dodai_giaykhen;
        $m_donvi->chieurong_giaykhen = $m_donvi_laytoado->chieurong_giaykhen;
        $m_donvi->save();

        $a_toado = [
            'toado_tendoituongin' => $m_toado->toado_tendoituongin ?? '',
            'toado_noidungkhenthuong' => $m_toado->toado_noidungkhenthuong ?? '',
            'toado_ngayqd' => $m_toado->toado_ngayqd ?? '',
            'toado_chucvunguoikyqd' => $m_toado->toado_chucvunguoikyqd ?? '',
            'toado_hotennguoikyqd' => $m_toado->toado_hotennguoikyqd ?? '',
            'toado_quyetdinh' => $m_toado->toado_quyetdinh ?? '',
            'toado_chucvudoituong' => $m_toado->toado_chucvudoituong ?? '',
            'toado_pldoituong' => $m_toado->toado_pldoituong ?? '',
        ];

        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->update($a_toado);
                                break;
                            }
                        case "CANHAN": {
                                dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->update($a_toado);
                                break;
                            }
                        case "HOGIADINH": {
                                dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->update($a_toado);
                                break;
                            }
                    }
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->update($a_toado);
                                break;
                            }
                        case "CANHAN": {
                                dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->update($a_toado);
                                break;
                            }
                        case "HOGIADINH": {
                                dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->update($a_toado);
                                break;
                            }
                    }
                    break;
                }
        }

        if ($inputs["phanloaiphoi"] == 'BANGKHEN')
            return redirect('/DungChung/InPhoiKhenThuong/InBangKhen?phanloaikhenthuong=' . $inputs['phanloaikhenthuong'] . '&phanloaidoituong=' . $inputs['phanloaidoituong'] . '&id=' . $inputs['id'] . '&madonvi=' . $inputs['madonvi']);
        else
            return redirect('/DungChung/InPhoiKhenThuong/InGiayKhen?phanloaikhenthuong=' . $inputs['phanloaikhenthuong'] . '&phanloaidoituong=' . $inputs['phanloaidoituong'] . '&id=' . $inputs['id'] . '&madonvi=' . $inputs['madonvi']);
    }

    function setViTri($inputs)
    {
        return  [
            $inputs['tentruong'] => $inputs['toado']
                . 'font-size:' . ($inputs['font-size'] ?? '30px') . ';' //30px
                . 'font-weight:' . ($inputs['font-weight'] ?? 'normal') . ';' //normal
                . 'font-style:' . ($inputs['font-style'] ?? 'normal') . ';' //normal
                . 'font-family:' . ($inputs['font-family'] ?? 'Times New Roman') . ';'
                . 'text-align:' . ($inputs['text-align'] ?? 'center') . ';'
                . 'color:' . ($inputs['color'] ?? 'black') . ';'
                . 'width:' . ($inputs['width'] ?? '400px') . ';'
                . 'text-transform:' . ($inputs['text-transform'] ?? 'none') . ';',
            getTenTruongTheToaDo($inputs['tentruong']) => $inputs['noidung'],
        ];
    }

    public function InLichSuHoSo(Request $request)
    {
        $inputs = $request->all();        
        $model = trangthaihoso::where('mahoso', $inputs['mahosotdkt'])->get();
        //dd($model);
        $a_donvi = array_column(dsdonvi::all()->toArray(),'tendonvi','madonvi');
        return view('NghiepVu._DungChung.InLichSuHoSo')
            ->with('model', $model)            
            ->with('a_donvi', $a_donvi)            
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Lịch sử hồ sơ');
        
    }
}
