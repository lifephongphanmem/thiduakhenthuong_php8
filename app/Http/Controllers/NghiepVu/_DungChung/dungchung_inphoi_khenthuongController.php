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
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_hogiadinh;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;

class dungchung_inphoi_khenthuongController extends Controller
{

    public function DanhSach(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL','ALL');
        $model->tendonvi = $m_donvi->tendonvi;
        foreach($model_canhan as $ct)
        {
            $danhhieu=explode(';',$ct->madanhhieukhenthuong);
            $ct->madanhhieukhenthuong='';
            foreach($danhhieu as $item)
            {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] .'; ';
            }
        }

        foreach($model_tapthe as $ct)
        {
            $danhhieu=explode(';',$ct->madanhhieukhenthuong);
            $ct->madanhhieukhenthuong='';
            foreach($danhhieu as $item)
            {
                $ct->madanhhieukhenthuong .= $a_dhkt[$item] .'; ';
            }
        }
        return view('NghiepVu._DungChung.InPhoi')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen');
    }

    public function DanhSachCumKhoi(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosotdktcumkhoi_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL','ALL');
        $model->tendonvi = $m_donvi->tendonvi;
        return view('NghiepVu._DungChung.InPhoiCumKhoi')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen');
    }

    public function InBangKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'BANGKHEN';
        //$tendoituong = '';
        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
                                // $tendoituong = 'tentapthe';
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
                                // $tendoituong = 'tendoituong';
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->get();
                                // $tendoituong = 'tentapthe';
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
                                // $tenoituong = 'tentapthe';
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
                                // $tendoituong = 'tendoituong';
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->get();
                                // $tendoituong = 'tentapthe';
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
        }

        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        getPhoiBk($m_donvi);
        $m_toado = getToaDoMacDinh($inputs);
        foreach ($model as $doituong) {
            //dd($doituong);
            //$doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->noidungkhenthuong = $doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');
            $doituong->toado_noidungkhenthuong = $doituong->toado_noidungkhenthuong != '' ? $doituong->toado_noidungkhenthuong : ($m_toado->toado_noidungkhenthuong ?? '');

            //$doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');

            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->toado_chucvunguoikyqd = $doituong->toado_chucvunguoikyqd != '' ? $doituong->toado_chucvunguoikyqd : ($m_toado->toado_chucvunguoikyqd ?? '');

            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->toado_hotennguoikyqd = $doituong->toado_hotennguoikyqd != '' ? $doituong->toado_hotennguoikyqd : ($m_toado->toado_hotennguoikyqd ?? '');

            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayqd));
            $doituong->toado_ngayqd = $doituong->toado_ngayqd != '' ? $doituong->toado_ngayqd : ($m_toado->toado_ngayqd ?? '');


            switch ($inputs["phanloaidoituong"]) {
                case "CANHAN": {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : catchuoi($doituong->tendoituong, $m_donvi->sochu);
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        // $cq = $doituong->chucvu . ';' . $doituong->tenphongban . ';' . $doituong->tencoquan;
                        $cq = $doituong->chucvu . ($doituong->tenphongban == '' ? '' :  ', ' . $doituong->tenphongban) . ($doituong->tencoquan == '' ? '' :  ', ' . $doituong->tencoquan);
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($cq != '' ? catchuoi($cq, $m_donvi->sochu) : 'Tên phòng ban - cơ quan');
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');


                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : ($doituong->gioitinh == 'NAM' ? 'Ông:' : 'Bà');
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
                default: {

                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : catchuoi($doituong->tentapthe, $m_donvi->sochu);
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        //$doituong->chucvudoituong = '';tendonvi
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($doituong->tencoquan != '' ? $doituong->tencoquan : $m_donvi->tendonvi);
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        //$doituong->pldoituong = '';
                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : 'Tập thể:';
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');

                        break;
                    }
            }

            $doituong->quyetdinh = $doituong->quyetdinh != '' ? $doituong->quyetdinh : ('Số: ' . $m_hoso->soqd . ', ' . Date2Str($m_hoso->ngayqd) . '</br>Số bằng: 01');
            $doituong->toado_quyetdinh = $doituong->toado_quyetdinh != '' ? $doituong->toado_quyetdinh : ($m_toado->toado_quyetdinh ?? '');
        }
        // dd($m_donvi);
        //dd($model);
        return view('BaoCao.DonVi.InBangKhenTapThe')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_hoso', $m_hoso)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin phôi bằng khen');
    }

    public function InGiayKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'GIAYKHEN';

        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
        }

        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        getPhoiBk($m_donvi);
        $m_toado = getToaDoMacDinh($inputs);
        // dd($m_toado);
        foreach ($model as $doituong) {
            //dd($doituong);
            $doituong->noidungkhenthuong = $doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');
            $doituong->toado_noidungkhenthuong = $doituong->toado_noidungkhenthuong != '' ? $doituong->toado_noidungkhenthuong : ($m_toado->toado_noidungkhenthuong ?? '');

            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->toado_chucvunguoikyqd = $doituong->toado_chucvunguoikyqd != '' ? $doituong->toado_chucvunguoikyqd : ($m_toado->toado_chucvunguoikyqd ?? '');

            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->toado_hotennguoikyqd = $doituong->toado_hotennguoikyqd != '' ? $doituong->toado_hotennguoikyqd : ($m_toado->toado_hotennguoikyqd ?? '');

            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayqd));
            $doituong->toado_ngayqd = $doituong->toado_ngayqd != '' ? $doituong->toado_ngayqd : ($m_toado->toado_ngayqd ?? '');

            switch ($inputs["phanloaidoituong"]) {
                case "CANHAN": {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : catchuoi($doituong->tendoituong, $m_donvi->sochu);
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        // $cq = $doituong->chucvu . ' ' . $doituong->tenphongban . ' ' . $doituong->tencoquan;
                        $cq = $doituong->chucvu . ($doituong->tenphongban == '' ? '' :  ', ' . $doituong->tenphongban) . ($doituong->tencoquan == '' ? '' :  ', ' . $doituong->tencoquan);
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($cq != '' ? catchuoi($cq, $m_donvi->sochu) : 'Tên phòng ban - cơ quan');
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');


                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : ($doituong->gioitinh == 'NAM' ? 'Ông:' : 'Bà');
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
                default: {

                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : catchuoi($doituong->tentapthe, $m_donvi->sochu);
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($doituong->tencoquan != '' ? $doituong->tencoquan : $m_donvi->tendonvi);
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : 'Tập thể:';
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
            }

            $doituong->quyetdinh = $doituong->quyetdinh != '' ? $doituong->quyetdinh : ('Số: ' . $m_hoso->soqd . ', ' . Date2Str($m_hoso->ngayqd) . '</br>Số bằng: 01');
            $doituong->toado_quyetdinh = $doituong->toado_quyetdinh != '' ? $doituong->toado_quyetdinh : ($m_toado->toado_quyetdinh ?? '');
        }
        // dd($m_donvi);
        return view('BaoCao.DonVi.InGiayKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin phôi giấy khen');
    }

    public function InGiayKhen_20231009(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'GIAYKHEN';

        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
        }

        $m_donvi = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        $m_toado = getToaDoMacDinh($inputs);
        foreach ($model as $doituong) {
            //$doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->noidungkhenthuong = $doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');
            $doituong->toado_noidungkhenthuong = $doituong->toado_noidungkhenthuong != '' ? $doituong->toado_noidungkhenthuong : ($m_toado->toado_noidungkhenthuong ?? '');

            //$doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');

            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->toado_chucvunguoikyqd = $doituong->toado_chucvunguoikyqd != '' ? $doituong->toado_chucvunguoikyqd : ($m_toado->toado_chucvunguoikyqd ?? '');

            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->toado_hotennguoikyqd = $doituong->toado_hotennguoikyqd != '' ? $doituong->toado_hotennguoikyqd : ($m_toado->toado_hotennguoikyqd ?? '');

            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayqd));
            $doituong->toado_ngayqd = $doituong->toado_ngayqd != '' ? $doituong->toado_ngayqd : ($m_toado->toado_ngayqd ?? '');


            switch ($inputs["phanloaidoituong"]) {

                case "CANHAN": {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : catchuoi($doituong->tendoituong, $m_donvi->sochu);
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        $cq = $doituong->chucvu . ' ' . $doituong->tenphongban . ' ' . $doituong->tencoquan;
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($cq != '' ? catchuoi($cq, $m_donvi->sochu) : 'Tên phòng ban - cơ quan');
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        $doituong->pldoituong =  '';
                        // $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : ($doituong->gioitinh == 'NAM' ? 'Ông:' : 'Bà');
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
                default: {

                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : catchuoi($doituong->tentapthe, $m_donvi->sochu);
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($doituong->tencoquan != '' ? $doituong->tencoquan : $m_donvi->tendonvi);
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : 'Tập thể:';
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');

                        break;
                    }
            }

            $doituong->quyetdinh = $doituong->quyetdinh != '' ? $doituong->quyetdinh : ('Số: ' . $m_hoso->soqd . ', ' . Date2Str($m_hoso->ngayqd) . '</br>Số bằng: 01');
            $doituong->toado_quyetdinh = $doituong->toado_quyetdinh != '' ? $doituong->toado_quyetdinh : ($m_toado->toado_quyetdinh ?? '');
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('m_donvi', $m_donvi)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InMauBangKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'BANGKHEN';

        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
        }

        // $m_donvi = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        getPhoiBk($m_donvi);
        $m_toado = getToaDoMacDinh($inputs);
        //dd($m_toado);
        foreach ($model as $doituong) {
            //$doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->noidungkhenthuong = $doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');
            $doituong->toado_noidungkhenthuong = $doituong->toado_noidungkhenthuong != '' ? $doituong->toado_noidungkhenthuong : ($m_toado->toado_noidungkhenthuong ?? '');

            //$doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');

            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->toado_chucvunguoikyqd = $doituong->toado_chucvunguoikyqd != '' ? $doituong->toado_chucvunguoikyqd : ($m_toado->toado_chucvunguoikyqd ?? '');

            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->toado_hotennguoikyqd = $doituong->toado_hotennguoikyqd != '' ? $doituong->toado_hotennguoikyqd : ($m_toado->toado_hotennguoikyqd ?? '');

            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayqd));
            $doituong->toado_ngayqd = $doituong->toado_ngayqd != '' ? $doituong->toado_ngayqd : ($m_toado->toado_ngayqd ?? '');


            switch ($inputs["phanloaidoituong"]) {

                case "CANHAN": {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tendoituong;
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        // $cq = $doituong->chucvu . ' ' . $doituong->tenphongban . ' ' . $doituong->tencoquan;
                        $cq = $doituong->chucvu . ($doituong->tenphongban == '' ? '' :  ', ' . $doituong->tenphongban) . ($doituong->tencoquan == '' ? '' :  ', ' . $doituong->tencoquan);
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($cq != '' ? $cq : 'Tên phòng ban - cơ quan');
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : ($doituong->gioitinh == 'NAM' ? 'Ông:' : 'Bà');
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
                default: {

                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tentapthe;
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($doituong->tencoquan != '' ? $doituong->tencoquan : $m_donvi->tendonvi);
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : 'Tập thể:';
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
            }

            $doituong->quyetdinh = $doituong->quyetdinh != '' ? $doituong->quyetdinh : ('Số: ' . $m_hoso->soqd . ', ' . Date2Str($m_hoso->ngayqd) . '</br>Số bằng: 01');
            $doituong->toado_quyetdinh = $doituong->toado_quyetdinh != '' ? $doituong->toado_quyetdinh : ($m_toado->toado_quyetdinh ?? '');
        }
        // dd($model);
        return view('BaoCao.DonVi.InMauBangKhenTapThe')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_hoso', $m_hoso)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function InMauGiayKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'GIAYKHEN';

        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
        }

        // $m_donvi = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        getPhoiBk($m_donvi);
        $m_toado = getToaDoMacDinh($inputs);
        foreach ($model as $doituong) {
            //$doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->noidungkhenthuong = $doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');
            $doituong->toado_noidungkhenthuong = $doituong->toado_noidungkhenthuong != '' ? $doituong->toado_noidungkhenthuong : ($m_toado->toado_noidungkhenthuong ?? '');

            //$doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');

            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->toado_chucvunguoikyqd = $doituong->toado_chucvunguoikyqd != '' ? $doituong->toado_chucvunguoikyqd : ($m_toado->toado_chucvunguoikyqd ?? '');

            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->toado_hotennguoikyqd = $doituong->toado_hotennguoikyqd != '' ? $doituong->toado_hotennguoikyqd : ($m_toado->toado_hotennguoikyqd ?? '');

            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayqd));
            $doituong->toado_ngayqd = $doituong->toado_ngayqd != '' ? $doituong->toado_ngayqd : ($m_toado->toado_ngayqd ?? '');


            switch ($inputs["phanloaidoituong"]) {

                case "CANHAN": {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tendoituong;
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        // $cq = $doituong->chucvu . ' ' . $doituong->tenphongban . ' ' . $doituong->tencoquan;
                        $cq = $doituong->chucvu . ($doituong->tenphongban == '' ? '' :  ', ' . $doituong->tenphongban) . ($doituong->tencoquan == '' ? '' :  ', ' . $doituong->tencoquan);
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($cq != '' ? $cq : 'Tên phòng ban - cơ quan');
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : ($doituong->gioitinh == 'NAM' ? 'Ông:' : 'Bà');
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
                default: {

                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tentapthe;
                        $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');

                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($doituong->tencoquan != '' ? $doituong->tencoquan : $m_donvi->tendonvi);
                        $doituong->toado_chucvudoituong = $doituong->toado_chucvudoituong != '' ? $doituong->toado_chucvudoituong : ($m_toado->toado_chucvudoituong ?? '');

                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : 'Tập thể:';
                        $doituong->toado_pldoituong = $doituong->toado_pldoituong != '' ? $doituong->toado_pldoituong : ($m_toado->toado_pldoituong ?? '');
                        break;
                    }
            }

            $doituong->quyetdinh = $doituong->quyetdinh != '' ? $doituong->quyetdinh : ('Số: ' . $m_hoso->soqd . ', ' . Date2Str($m_hoso->ngayqd) . '</br>Số bằng: 01');
            $doituong->toado_quyetdinh = $doituong->toado_quyetdinh != '' ? $doituong->toado_quyetdinh : ($m_toado->toado_quyetdinh ?? '');
        }
        // dd($model);
        //dd($m_donvi);
        return view('BaoCao.DonVi.InMauGiayKhenTapThe')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_hoso', $m_hoso)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InDanhSachBangKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'BANGKHEN';
        if ($inputs['noidungkhenthuong'] != '')
            $inputs['noidungkhenthuong'] = str_replace("\r\n", '<br>', $inputs['noidungkhenthuong']);
        //dd($inputs['noidungkhenthuong']);
        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
                    break;
                }
        }

        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_donvi_dn = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        $m_toado = getToaDoMacDinh($inputs);
        $chieurong_bangkhen_px = chkDbl($m_donvi->chieurong_bangkhen) * 3.779527559055;
        $i = 0;
        $a_truongtoado = [
            'toado_tendoituongin',
            'toado_noidungkhenthuong',
            'toado_ngayqd',
            'toado_quyetdinh',
            'toado_chucvunguoikyqd',
            'toado_chucvudoituong',
            'toado_pldoituong',
            'toado_hotennguoikyqd'
        ];
        //dd($chieurong_bangkhen_px);

        //1 Milimét [mm] = 3,779 527 559 055 Pixel [px] 
        $i_sobang = 1;
        foreach ($model as $doituong) {
            //$doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->noidungkhenthuong = $doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');
            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayqd));
            $doituong->quyetdinh = $doituong->quyetdinh != '' ? $doituong->quyetdinh : ('Số: ' . $m_hoso->soqd . ', ' . Date2Str($m_hoso->ngayqd) . '</br>Số bằng: '. str_pad($i_sobang, 2, '0', STR_PAD_LEFT));
            $i_sobang++;
            switch ($inputs["phanloaidoituong"]) {
                case "CANHAN": {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tendoituong;

                        // $cq = $doituong->chucvu . ' ' . $doituong->tenphongban . ' ' . $doituong->tencoquan;
                        $cq = $doituong->chucvu . ($doituong->tenphongban == '' ? '' :  ', ' . $doituong->tenphongban) . ($doituong->tencoquan == '' ? '' :  ', ' . $doituong->tencoquan);
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($cq != '' ? $cq : 'Tên phòng ban - cơ quan');
                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : ($doituong->gioitinh == 'NAM' ? 'Ông:' : 'Bà');
                        break;
                    }
                default: {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tentapthe;
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($doituong->tencoquan != '' ? $doituong->tencoquan : $m_donvi_dn->tendonvi);
                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : 'Tập thể:';
                        break;
                    }
            }

            //
            $doituong->toado_quyetdinh = $m_toado->toado_quyetdinh ?? '';
            $doituong->toado_chucvunguoikyqd = $m_toado->toado_chucvunguoikyqd ?? '';
            $doituong->toado_hotennguoikyqd = $m_toado->toado_hotennguoikyqd ?? '';
            $doituong->toado_ngayqd = $m_toado->toado_ngayqd ?? '';
            $doituong->toado_tendoituongin = $m_toado->toado_tendoituongin ?? '';
            $doituong->toado_chucvudoituong = $m_toado->toado_chucvudoituong ?? '';
            $doituong->toado_pldoituong = $m_toado->toado_pldoituong ?? '';
            $doituong->toado_noidungkhenthuong = $m_toado->toado_noidungkhenthuong ?? '';
            //Gán lại ô nội dung
            if ($inputs['noidungkhenthuong'] != '')
                $doituong->noidungkhenthuong = $inputs['noidungkhenthuong'];
            //chạy lại tọa độ
            $chieurong = round($chieurong_bangkhen_px * $i);
            foreach ($a_truongtoado as $tentruong) {
                $a_toado = [];
                foreach (explode(';', $doituong->$tentruong) as $toado) {
                    if (str_contains($toado, 'top:')) {
                        $a_toado[] = 'top:' . round($chieurong + round(Str2Bbl($toado))) . 'px';
                    } else
                        $a_toado[] = $toado;
                }
                $doituong->$tentruong = implode(';', $a_toado);
                //kiểm tra trường ẩn thì để nội dung == '' để ko in
                if (str_contains($doituong->$tentruong, 'color:red;')) {
                    $truong =  getTenTruongTheToaDo($tentruong);
                    $doituong->$truong = '';
                }
            }
            $i++;
        }
        //dd($model);
        return view('BaoCao.DonVi.InDanhSachBangKhen')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_hoso', $m_hoso)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In danh sách bằng khen');
    }

    public function InDanhSachGiayKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'GIAYKHEN';
        if ($inputs['noidungkhenthuong'] != '')
            $inputs['noidungkhenthuong'] = str_replace("\r\n", '<br>', $inputs['noidungkhenthuong']);
        //dd($inputs['noidungkhenthuong']);
        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('mahosotdkt', $inputs['mahoso'])->get();
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
                    break;
                }
        }

        $m_donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_donvi_dn = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        $m_toado = getToaDoMacDinh($inputs);
        $chieurong_bangkhen_px = chkDbl($m_donvi->chieurong_giaykhen) * 3.779527559055;
        $i = 0;
        $a_truongtoado = [
            'toado_tendoituongin',
            'toado_noidungkhenthuong',
            'toado_ngayqd',
            'toado_quyetdinh',
            'toado_chucvunguoikyqd',
            'toado_chucvudoituong',
            'toado_pldoituong',
            'toado_hotennguoikyqd'
        ];
        //dd($chieurong_bangkhen_px);

        //1 Milimét [mm] = 3,779 527 559 055 Pixel [px]
        $i_sobang = 1;
        foreach ($model as $doituong) {
            //$doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->noidungkhenthuong = $doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');
            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayqd));
            $doituong->quyetdinh = $doituong->quyetdinh != '' ? $doituong->quyetdinh : ('Số: ' . $m_hoso->soqd . ', ' . Date2Str($m_hoso->ngayqd) . '</br>Số bằng: ' . str_pad($i_sobang, 2, '0', STR_PAD_LEFT));
            $i_sobang++;
            switch ($inputs["phanloaidoituong"]) {
                case "CANHAN": {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tendoituong;

                        // $cq = $doituong->chucvu . ' ' . $doituong->tenphongban . ' ' . $doituong->tencoquan;
                        $cq = $doituong->chucvu . ($doituong->tenphongban == '' ? '' :  ', ' . $doituong->tenphongban) . ($doituong->tencoquan == '' ? '' :  ', ' . $doituong->tencoquan);
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($cq != '' ? $cq : 'Tên phòng ban - cơ quan');
                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : ($doituong->gioitinh == 'NAM' ? 'Ông:' : 'Bà');
                        break;
                    }
                default: {
                        $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->tentapthe;
                        $doituong->chucvudoituong = $doituong->chucvudoituong != '' ? $doituong->chucvudoituong : ($doituong->tencoquan != '' ? $doituong->tencoquan : $m_donvi_dn->tendonvi);
                        $doituong->pldoituong = $doituong->pldoituong != '' ? $doituong->pldoituong : 'Tập thể:';
                        break;
                    }
            }

            //
            $doituong->toado_quyetdinh = $m_toado->toado_quyetdinh ?? '';
            $doituong->toado_chucvunguoikyqd = $m_toado->toado_chucvunguoikyqd ?? '';
            $doituong->toado_hotennguoikyqd = $m_toado->toado_hotennguoikyqd ?? '';
            $doituong->toado_ngayqd = $m_toado->toado_ngayqd ?? '';
            $doituong->toado_tendoituongin = $m_toado->toado_tendoituongin ?? '';
            $doituong->toado_chucvudoituong = $m_toado->toado_chucvudoituong ?? '';
            $doituong->toado_pldoituong = $m_toado->toado_pldoituong ?? '';
            $doituong->toado_noidungkhenthuong = $m_toado->toado_noidungkhenthuong ?? '';
            //Gán lại ô nội dung
            if ($inputs['noidungkhenthuong'] != '')
                $doituong->noidungkhenthuong = $inputs['noidungkhenthuong'];
            //chạy lại tọa độ
            $chieurong = round($chieurong_bangkhen_px * $i);
            foreach ($a_truongtoado as $tentruong) {
                $a_toado = [];
                foreach (explode(';', $doituong->$tentruong) as $toado) {
                    if (str_contains($toado, 'top:')) {
                        $a_toado[] = 'top:' . round($chieurong + round(Str2Bbl($toado))) . 'px';
                    } else
                        $a_toado[] = $toado;
                }
                $doituong->$tentruong = implode(';', $a_toado);
                //kiểm tra trường ẩn thì để nội dung == '' để ko in
                if (str_contains($doituong->$tentruong, 'color:red;')) {
                    $truong =  getTenTruongTheToaDo($tentruong);
                    $doituong->$truong = '';
                }
            }
            $i++;
        }
        //dd($model);
        return view('BaoCao.DonVi.InDanhSachGiayKhen')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_hoso', $m_hoso)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In danh sách giấy khen');
    }

    public function getDuLieu($inputs)
    {
        # code...
    }

    public function getNoiDungKhenThuong(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();

        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->first();
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->first();
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->first();
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->first();
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->mahosotdkt)->first();
                    break;
                }
        }
        $m_donvi = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        //xử lý nội dung
        $model->noidungkhenthuong = $model->noidungkhenthuong != '' ? $model->noidungkhenthuong : ($m_hoso->noidung != '' ? catchuoi($m_hoso->noidung, $m_donvi->sochu) : 'Nội dung khen thưởng');

        //tên đối tượng in
        $tentruong = getTenTruongTheToaDo($inputs['tentruong']);
        $result['message'] = $model->$tentruong;
        $result['status'] = 'success';

        die(json_encode($result));
    }


    // public function NoiDungKhenThuong(Request $request)
    // {
    //     $inputs = $request->all();

    //     if ($inputs['phanloai'] == 'CANHAN') {
    //         $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
    //         $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
    //         $model->save();
    //     } else {
    //         $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
    //         $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
    //         $model->save();
    //     }
    //     //dd($m_hoso);
    //     return redirect($inputs['url'] . 'InPhoi?mahosotdkt=' . $model->mahosotdkt);
    // }
}
