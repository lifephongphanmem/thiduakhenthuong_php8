<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dsdonvi;
use App\Models\HeThong\hethongchung;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\VanBan\dsquyetdinhkhenthuong;
use App\Models\VanBan\dsvanbanphaply;
use App\Models\VanBan\vanbanphaply_tailieu;
use Illuminate\Support\Facades\Session;

class congboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TrangChu(Request $request)
    {
        //tesst
        $inputs = $request->all();
        $inputs['url'] = '/QuanLyVanBan/VanBanPhapLy';
        // dd($inputs);
        $model = hethongchung::first();
        //dd($model);
        return view('CongBo.TrangChu')
            ->with('inputs', $inputs)
            ->with('hethong', $model)
            ->with('pageTitle', 'Thi đua khen thưởng');
    }

    public function VanBan(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/QuanLyVanBan/VanBanPhapLy';
        $inputs['phannhom']=$inputs['phannhom']??'ALL';
        // $model = dsvanbanphaply::all();
        $model = dsvanbanphaply::when($inputs['phannhom'] !== 'ALL', function($q) use($inputs) {
            return $q->where('phannhom', $inputs['phannhom']);
        })->get();
        $hethong = hethongchung::first();
        return view('CongBo.VanBan')
            ->with('model', $model)
            ->with('hethong', $hethong)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách văn bản pháp lý');
    }

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/QuanLyVanBan/VanBanPhapLy';
        //$a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
        $model = dsquyetdinhkhenthuong::all();
        $inputs['capkhenthuong'] = $inputs['capkhenthuong'] ?? 'ALL';
        //dd($model);
        foreach($model as $ct){
            $ct->phanloaikhenthuong='dsquyetdinh';
        }
        //Hô sơ khen thưởng
        $dshosothiduakhenthuong = dshosothiduakhenthuong::where('trangthai', 'DKT')->get();
        foreach ($dshosothiduakhenthuong as $hoso) {
            $hoso->tieude = $hoso->noidung;
            $hoso->maquyetdinh = $hoso->mahosotdkt;
            $hoso->phanloaikhenthuong = 'dshosothiduakhenthuong';
            $model->add($hoso);
        }
        $dshosotdktcumkhoi = dshosotdktcumkhoi::where('trangthai', 'DKT')->get();
        foreach ($dshosotdktcumkhoi as $hoso) {
            $hoso->tieude = $hoso->noidung;
            $hoso->phanloaikhenthuong = 'dshosotdktcumkhoi';
            $hoso->maquyetdinh = $hoso->mahosotdkt;
            $model->add($hoso);
        }
        $inputs['capkhenthuong'] = $inputs['capkhenthuong'] ?? 'ALL';
        if ($inputs['capkhenthuong'] != 'ALL') {
            $model = $model->where('capkhenthuong', $inputs['capkhenthuong']);
        }
        // dd($model);
        $hethong = hethongchung::first();
        return view('CongBo.QuyetDinh')
            ->with('model', $model->sortby('ngayqd'))
            ->with('hethong', $hethong)
            ->with('inputs', $inputs)
            ->with('a_donvi',array_column(getDonVi('SSA')->toarray(),'tendonvi','madonvi'))
            ->with('a_phamvi', getPhamViApDung())
            ->with('pageTitle', 'Danh sách quyết định khen thưởng');
    }

    public function TaiLieuQuyetDinh(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $inputs['phanloai'] = $inputs['phanloai'] == null ? 'dsquyetdinhkhenthuong' : $inputs['phanloai'];
        switch ($inputs['phanloai']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['maqd'])->first();
                    $model_tailieu=dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['maqd'])->first();
                    $model_tailieu=dshosotdktcumkhoi_tailieu::where('mahosotdkt',$model->mahosotdkt)->get();
                    break;
                }
            default: {
                    $model = dsquyetdinhkhenthuong::where('maquyetdinh', $inputs['maqd'])->first();
                    $model->qdkt = $model->ipf1;
                    $model_tailieu=array();
                }
        }

        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if (count($model_tailieu) > 0) {
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
            foreach ($model_tailieu as $key => $tt) {
                // $filepath='/data/tailieudinhkem/' . $tt->tentailieu;
                // if(File::exists($filepath))
                // {
                //     continue;
                // }
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
        if ($model->totrinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->qdkt != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
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
