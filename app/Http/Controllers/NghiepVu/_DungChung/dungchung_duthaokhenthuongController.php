<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Models\NghiepVu\KhenCao\dshosokhencao;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;

class dungchung_duthaokhenthuongController extends Controller
{
    //Tờ trình đề nghị khen thưởng
    public function InToTrinhDeNghiKhenThuong(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'TOTRINHHOSO')->get()->toArray(), 'noidung', 'maduthao');
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo tờ trình đề nghị khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);

        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhhoso == '') {
                        getTaoDuThaoToTrinhHoSo($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhhoso == '') {
                        getTaoDuThaoToTrinhHoSo($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhhoso == '') {
                        getTaoDuThaoToTrinhHoSo($model, $inputs['maduthao']);
                    }
                    break;
                }
        }
        
        $model->thongtintotrinhhoso = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtintotrinhhoso);
        $model->thongtinquyetdinh = $model->thongtintotrinhhoso;
        return view('NghiepVu._DungChung.DuThao.InDuThao')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Tờ trình đề nghị khen thưởng');
    }

    public function ToTrinhDeNghiKhenThuong(Request $request)
    {
        $inputs = $request->all();
        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'TOTRINHHOSO')->get()->toArray(), 'noidung', 'maduthao');
        // dd($a_duthao);
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo tờ trình đề nghị khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);

        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $inputs['phanloaihoso'] = $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong';
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    // dd($model);
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    // dd($model);
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyetCumKhoi($model, $inputs['maduthao']);
                    }
                    break;
                }
        }
// dd($model);
        return view('NghiepVu._DungChung.DuThao.ToTrinhDeNghiKhenThuong')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình kết quả khen thưởng');
    }

    public function TaoToTrinhDeNghiKhenThuong(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $inputs['phanloaihoso'] = $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong';
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi == '';
                    getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi == '';
                    getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi == '';
                    getTaoDuThaoToTrinhPheDuyetCumKhoi($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
        }
        // dd($model);
        return redirect('/DungChung/DuThao/ToTrinhDeNghiKhenThuong?mahosotdkt=' . $inputs['mahosotdkt'] . '&phanloaihoso=' . $inputs['phanloaihoso']);
    }

    public function LuuToTrinhDeNghiKhenThuong(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $inputs['phanloaihoso'] = $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong';
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
                    $model->save();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
                    $model->save();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
                    $model->save();
                    break;
                }
        }

        return redirect('DungChung/DuThao/ToTrinhDeNghiKhenThuong?mahosotdkt=' . $inputs['mahosotdkt'] . '&phanloaihoso=' . $inputs['phanloaihoso']);
    }

    //Tờ trình kết quả khen thưởng
    public function InToTrinhKetQuaKhenThuong(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'TOTRINHPHEDUYET')->get()->toArray(), 'noidung', 'maduthao');
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo tờ trình kết quả khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        // dd($inputs);
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    // dd($model);
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyetCumKhoi($model, $inputs['maduthao']);
                    }
                    break;
                }
        }
        // dd($model);
        $model->thongtintotrinhdenghi = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtintotrinhdenghi);
        $model->thongtinquyetdinh = $model->thongtintotrinhdenghi;
        return view('NghiepVu._DungChung.DuThao.InDuThao')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_duthao', $a_duthao)
            ->with('pageTitle', 'Tờ trình đề nghị khen thưởng');
    }

    public function ToTrinhKetQuaKhenThuong(Request $request)
    {
        $inputs = $request->all();


        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'TOTRINHPHEDUYET')->get()->toArray(), 'noidung', 'maduthao');
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo tờ trình kết quả khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        $inputs['phanloaihoso'] = $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong'; //Cho các hàm đã gán từ trc
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtintotrinhdenghi == '') {
                        getTaoDuThaoToTrinhPheDuyetCumKhoi($model, $inputs['maduthao']);
                    }
                    break;
                }
        }

        if ($model->thongtintotrinhdenghi == '') {
            getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
        }
        // dd($model);
        return view('NghiepVu._DungChung.DuThao.ToTrinhKetQuaKhenThuong')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình kết quả khen thưởng');
    }

    public function TaoToTrinhKetQuaKhenThuong(Request $request)
    {
        $inputs = $request->all();
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi = '';
                    getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi = '';
                    getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi = '';
                    getTaoDuThaoToTrinhPheDuyetCumKhoi($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
        }

        return redirect('/DungChung/DuThao/ToTrinhKetQuaKhenThuong?mahosotdkt=' . $inputs['mahosotdkt'] . '&phanloaihoso=' . $inputs['phanloaihoso']);
    }

    public function LuuToTrinhKetQuaKhenThuong(Request $request)
    {
        $inputs = $request->all();
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
                    $model->save();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
                    $model->save();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
                    $model->save();
                    break;
                }
        }
        return redirect('DungChung/DuThao/ToTrinhKetQuaKhenThuong?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    //Quyết định khen thưởng
    public function InQuyetDinhKhenThuong(Request $request)
    {
        $inputs = $request->all();

        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'QUYETDINH')->get()->toArray(), 'noidung', 'maduthao');
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo quyết định khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        // dd($inputs);
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtinquyetdinh == '') {
                        getTaoQuyetDinhKT($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    if ($model->thongtinquyetdinh == '') {
                        getTaoQuyetDinhKT($model, $inputs['maduthao']);
                    }
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    getTaoQuyetDinhKTCumKhoi($model, $inputs['maduthao']);
                    break;
                }
        }
        // $model->thongtinquyetdinh = str_replace('<table>', '<table style="border: 0px;">', $model->thongtinquyetdinh);
        // dd($model->thongtinquyetdinh);
        return view('NghiepVu._DungChung.DuThao.InDuThao')
            //return view('NghiepVu._DungChung.DuThao.QuyetDinhKhenThuong')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_duthao', $a_duthao)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function QuyetDinhKhenThuong(Request $request)
    {
        $inputs = $request->all();

        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'QUYETDINH')->get()->toArray(), 'noidung', 'maduthao');
        if (count($a_duthao) == 0) {
            return view('errors.nodata')
                ->with('messegae', 'Hệ thống chưa có mẫu dự thảo quyết định khen thưởng. Hãy liên hệ với đơn vị quản lý để tạo mẫu thảo.')
                ->with('pageTitle', 'Thông báo lỗi');
        }
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        $inputs['phanloaihoso'] = $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong';
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    getTaoQuyetDinhKT($model, $inputs['maduthao']);
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    getTaoQuyetDinhKTKhenCao($model, $inputs['maduthao']);

                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    getTaoQuyetDinhKTCumKhoi($model, $inputs['maduthao']);
                    break;
                }
        }

        return view('NghiepVu._DungChung.DuThao.QuyetDinhKhenThuong')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    }

    public function TaoQuyetDinhKhenThuong(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);        
        $inputs['phanloaihoso'] = $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong';

        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtinquyetdinh = '';
                    getTaoQuyetDinhKT($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtinquyetdinh = '';
                    getTaoQuyetDinhKT($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtinquyetdinh = '';
                    getTaoQuyetDinhKTCumKhoi($model, $inputs['maduthao']);
                    $model->save();
                    break;
                }
        }

        $a_duthao = array_column(duthaoquyetdinh::where('phanloai', 'QUYETDINH')->get()->toArray(), 'noidung', 'maduthao');

        return redirect('/DungChung/DuThao/QuyetDinhKhenThuong?mahosotdkt=' . $inputs['mahosotdkt'] . '&phanloaihoso=' . $inputs['phanloaihoso']);
    }

    public function LuuQuyetDinhKhenThuong(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        switch ($inputs['phanloaihoso']) {
            case 'dshosothiduakhenthuong': {
                    $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
                    $model->save();
                    break;
                }
            case 'dshosokhencao': {
                    $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
                    $model->save();
                    break;
                }
            case 'dshosotdktcumkhoi': {
                    $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                    $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
                    $model->save();
                    break;
                }
        }
        return redirect('DungChung/DuThao/QuyetDinhKhenThuong?mahosotdkt=' . $inputs['mahosotdkt'] . '&phanloaihoso=' . $inputs['phanloaihoso']);
    }

    public function QuyetDinhCumKhoi(Request $request)
    {
        $inputs = $request->all();
        dd();
    }
}
