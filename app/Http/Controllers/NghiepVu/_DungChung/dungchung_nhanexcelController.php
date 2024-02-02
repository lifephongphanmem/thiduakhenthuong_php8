<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dmloaihinhkhenthuong;
use App\Models\DanhMuc\dmnhomphanloai_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class dungchung_nhanexcelController extends Controller
{
    public function NhanExcelKhenThuong(&$request)
    {
        $inputs = $request->all();
        if ($request->file('fexcel') == null) {
            dd('File dữ liệu không tồn tại.');
        }
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahoso'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm_canhan = array();
        $a_dm_tapthe = array();
        $a_dm_hogiadinh = array();

        //Mã hợp lệ => gán về mã mặc định (xem xét nếu gán mà ko thông báo thì khó hiểu cho ng nhận)
        $a_dhkt = array_column(dmhinhthuckhenthuong::all()->toarray(), 'madanhhieukhenthuong');

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['phanloaikhenthuong']])) {
                continue;
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'TAPTHE') {
                $a_dm_tapthe[] = array(
                    'mahosotdkt' => $inputs['mahoso'],
                    'tentapthe' => $data[$i][$inputs['tendoituong']] ?? '',
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_tt'],
                    'maphanloaitapthe' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_tt'],
                    'linhvuchoatdong' => $data[$i][$inputs['linhvuchoatdong']] ?? $inputs['linhvuchoatdong_tt'],
                    'ketqua' => '1',
                );
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'CANHAN') {
                $pldoituong = $data[$i][$inputs['pldoituong']] ?? 'Ông';
                $a_dm_canhan[] = array(
                    'mahosotdkt' => $inputs['mahoso'],
                    'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                    'pldoituong' => $pldoituong,
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_cn'],
                    'maphanloaicanbo' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_cn'],
                    'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                    'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                    'ketqua' => '1',
                    'gioitinh' => in_array($pldoituong, ['Ông', 'ÔNG', 'ông']) ? 'NAM' : 'NU',
                    //'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                    //'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                );
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'HOGIADINH') {
                $a_dm_hogiadinh[] = array(
                    'mahosotdkt' => $inputs['mahoso'],
                    'tentapthe' => $data[$i][$inputs['tendoituong']] ?? '',
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_hgd'],
                    'maphanloaitapthe' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_hgd'],
                    'ketqua' => '1',
                );
            }
        }
        File::Delete($path);
        //dd($data);
        foreach (array_chunk($a_dm_canhan, 100) as $data) {
            dshosothiduakhenthuong_canhan::insert($data);
        }
        foreach (array_chunk($a_dm_tapthe, 100) as $data) {
            dshosothiduakhenthuong_tapthe::insert($data);
        }
        foreach (array_chunk($a_dm_hogiadinh, 100) as $data) {
            dshosothiduakhenthuong_hogiadinh::insert($data);
        }
        File::Delete($path);
    }

    public function NhanExcelThamGia(&$request)
    {
        $inputs = $request->all();
        if ($request->file('fexcel') == null) {
            dd('File dữ liệu không tồn tại.');
        }
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahoso'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm_canhan = array();
        $a_dm_tapthe = array();
        $a_dm_hogiadinh = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['phanloaikhenthuong']])) {
                continue;
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'TAPTHE') {
                $a_dm_tapthe[] = array(
                    'mahosothamgiapt' => $inputs['mahoso'],
                    'tentapthe' => $data[$i][$inputs['tendoituong']] ?? '',
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_tt'],
                    'maphanloaitapthe' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_tt'],
                    'linhvuchoatdong' => $data[$i][$inputs['linhvuchoatdong']] ?? $inputs['linhvuchoatdong_tt'],

                );
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'CANHAN') {
                $a_dm_canhan[] = array(
                    'mahosothamgiapt' => $inputs['mahoso'],
                    'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_cn'],
                    'maphanloaicanbo' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_cn'],
                    'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                    'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',

                    'gioitinh' => 'NAM',
                    //'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                    //'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                );
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'HOGIADINH') {
                $a_dm_hogiadinh[] = array(
                    'mahosothamgiapt' => $inputs['mahoso'],
                    'tentapthe' => $data[$i][$inputs['tendoituong']] ?? '',
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_hgd'],
                    'maphanloaitapthe' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_hgd'],

                );
            }
        }
        dshosothamgiaphongtraotd_canhan::insert($a_dm_canhan);
        dshosothamgiaphongtraotd_tapthe::insert($a_dm_tapthe);
        dshosothamgiaphongtraotd_hogiadinh::insert($a_dm_hogiadinh);
        File::Delete($path);
    }

    public function NhanExcelCumKhoi(&$request)
    {
        $inputs = $request->all();
        if ($request->file('fexcel') == null) {
            dd('File dữ liệu không tồn tại.');
        }
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahoso'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm_canhan = array();
        $a_dm_tapthe = array();
        // $a_dm_hogiadinh = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['phanloaikhenthuong']])) {
                continue;
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'TAPTHE') {
                $a_dm_tapthe[] = array(
                    'mahosotdkt' => $inputs['mahoso'],
                    'tentapthe' => $data[$i][$inputs['tendoituong']] ?? '',
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_tt'],
                    'maphanloaitapthe' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_tt'],
                    'linhvuchoatdong' => $data[$i][$inputs['linhvuchoatdong']] ?? $inputs['linhvuchoatdong_tt'],
                    'ketqua' => '1',
                );
            }
            if ($data[$i][$inputs['phanloaikhenthuong']] == 'CANHAN') {
                $a_dm_canhan[] = array(
                    'mahosotdkt' => $inputs['mahoso'],
                    'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                    'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_cn'],
                    'maphanloaicanbo' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_cn'],
                    'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                    'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                    'ketqua' => '1',
                    'gioitinh' => 'NAM',
                    //'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                    //'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                );
            }
            // if($data[$i][$inputs['phanloaikhenthuong']] == 'HOGIADINH'){
            //     $a_dm_hogiadinh[] = array(
            //         'mahosotdkt' => $inputs['mahoso'],
            //         'tentapthe' => $data[$i][$inputs['tendoituong']] ?? '',
            //         'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_hgd'],
            //         'maphanloaitapthe' => $data[$i][$inputs['maphanloaidoituong']] ?? $inputs['maphanloaidoituong_hgd'],               
            //         'ketqua' => '1',                    
            //     );
            // }

        }
        dshosotdktcumkhoi_canhan::insert($a_dm_canhan);
        dshosotdktcumkhoi_tapthe::insert($a_dm_tapthe);
        //dshosothiduakhenthuong_hogiadinh::insert($a_dm_hogiadinh);
        File::Delete($path);
    }
}
