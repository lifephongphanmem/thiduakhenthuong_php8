<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dsnhomtaikhoan;
use App\Models\DanhMuc\dstaikhoan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ColectionImport;
use Illuminate\Support\Facades\Hash;

class dsdonviController extends Controller
{
    public static $url = '/DonVi/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = getDiaBan(session('admin')->capdo);
        $m_donvi = dsdonvi::all();
        foreach ($model as $chitiet) {
            $chitiet->sodonvi = $m_donvi->where('madiaban', $chitiet->madiaban)->count();
        }

        return view('HeThongChung.DonVi.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách đơn vị');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['tendiaban'] = dsdiaban::where('madiaban', $inputs['madiaban'])->first()->tendiaban ?? '';
        $m_diaban = dsdiaban::where('madiaban', $inputs['madiaban'])->first();
        $model = dsdonvi::where('madiaban', $inputs['madiaban'])->get();
        $m_taikhoan = dstaikhoan::all();
        foreach ($model as $chitiet) {
            $chitiet->sotaikhoan = $m_taikhoan->where('madonvi', $chitiet->madonvi)->count();
        }
        $a_nhomchucnang = array_column(dsnhomtaikhoan::all()->toArray(), 'tennhomchucnang', 'manhomchucnang');
        $a_cumkhoi = array_column(dscumkhoi::all()->toArray(), 'tencumkhoi', 'macumkhoi');
        return view('HeThongChung.DonVi.DanhSach')
            ->with('model', $model)
            ->with('m_diaban', $m_diaban)
            ->with('a_nhomchucnang', $a_nhomchucnang)
            ->with('a_cumkhoi', $a_cumkhoi)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách đơn vị');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        //$modeldvql = DSDonVi::where('tonghop', '1')->get();
        $model = new dsdonvi();
        $model->madonvi = null;
        $model->madiaban = $inputs['madiaban'];
        return view('HeThongChung.DonVi.Sua')
            ->with('model', $model)
            ->with('pageTitle', 'Tạo mới thông tin đơn vị');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if ($model == null) {
            $inputs['madonvi'] = (string) getdate()[0];
            dsdonvi::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DonVi/DanhSach?madiaban=' . $inputs['madiaban']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('HeThongChung.DonVi.Sua')
            ->with('model', $model)
            ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $id = $request->all()['id'];
        $model = dsdonvi::findorFail($id);
        //xoá tài khoản
        dstaikhoan::where('madonvi', $model->madonvi)->delete();
        //dd($model);
        $model->delete();
        return redirect('/DonVi/DanhSach?madiaban=' . $model->madiaban);
    }

    public function QuanLy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $m_donvi = dsdonvi::where('madiaban', $inputs['madiaban'])->get();
        $model = dsdiaban::where('madiaban', $inputs['madiaban'])->first();
        return view('HeThongChung.DonVi.QuanLy')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Tạo mới thông tin đơn vị');
    }

    public function LuuQuanLy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        dsdiaban::where('madiaban', $inputs['madiaban'])->first()->update($inputs);
        return redirect('DonVi/ThongTin');
    }

    public function ThongTinDonVi(Request $request)
    {
        $inputs = $request->all();
        //$m_donvi = getDonVi(session('admin')->mad, 'dsdonvi');
        //dd();
        //$a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        $inputs['madonvi'] = session('admin')->madonvi;
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_donvi = dsdonvi::where('madiaban',$model->madiaban)->get();
        //dd($model);
        return view('HeThongChung.DonVi.ThongTinDonVi')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban',array_column(dsdiaban::where('madiaban',$model->madiaban)->get()->toArray(), 'tendiaban', 'madiaban'))
            ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
    }

    public function LuuThongTinDonVi(Request $request)
    {

        $inputs = $request->all(); 
        //dd($inputs);
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if (isset($inputs['phoi_bangkhen'])) {
            $filedk = $request->file('phoi_bangkhen');
            $inputs['phoi_bangkhen'] = $inputs['madonvi'] . '_bangkhen.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/uploads/', $inputs['phoi_bangkhen']);
        }
        if (isset($inputs['phoi_giaykhen'])) {
            $filedk = $request->file('phoi_giaykhen');
            $inputs['phoi_giaykhen'] = $inputs['madonvi'] . '_giaykhen.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/uploads/', $inputs['phoi_giaykhen']);
        }

        if ($model == null) {
            $inputs['madonvi'] = (string) getdate()[0];
            dsdonvi::create($inputs);
        } else {
            $model->update($inputs);
        }

        

        return redirect('/');
    }

    public function NhanExcel(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        if (!isset($inputs['manhomchucnang'])) {
            return view('errors.403')
                ->with('message', 'Bạn cần tạo nhóm chức năng trước khi nhận dữ liệu để phân quyền thuận tiện hơn.')
                ->with('url', '/DiaBan/ThongTin');
        }

        if (!isset($inputs['fexcel'])) {
            return view('errors.403')
                ->with('message', 'File Excel không hợp lệ.')
                ->with('url', '/DiaBan/ThongTin');
        }
        //$model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $filename = $inputs['madiaban'] . '_' . getdate()[0];
        $model_diaban = dsdiaban::where('madiaban', $inputs['madiaban'])->first();

        // $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        // $request->file('fexcel')->move('data/uploads/', $filename . '.xlsx');
        // $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        // $path = '/data/uploads/' . $filename . '.xlsx';
        // dd($inputs);
        // dd($path);
        // $data = [];
        $dataObj = new ColectionImport();
        $theArray = Excel::toArray($dataObj, $inputs['fexcel']);
        $data = $theArray[0];
        // dd($data);
        // Excel::load($path, function ($reader) use (&$data) {            
        //     $obj = $reader->getExcel();
        //     $sheet = $obj->getSheet(0);
        //     $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        // });

        // Excel::load($path, function ($reader) use (&$data, $inputs, $path) {
        //     $obj = $reader->getExcel();
        //     $sheetCount = $obj->getSheetCount();
        //     if ($sheetCount < chkDbl($inputs['sheet'])) {
        //         File::Delete($path);
        //         dd('File excel chỉ có tối đa ' . $sheetCount . ' sheet dữ liệu.');
        //     }
        //     $sheet = $obj->getSheet($inputs['sheet']);
        //     $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        // });
        $a_dv = array();
        $a_tk = array();
        $a_ck = [];
        $ma = getdate()[0];
        // dd($data);
        for ($i = ($inputs['tudong']-1); $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][ColumnName()[$inputs['tendonvi']]])) {
                continue;
            }
            $a_dv[] = array(
                'madiaban' => $inputs['madiaban'],
                'tendonvi' => $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                'madonvi' => $ma,
            );

            $a_tk[] = array(
                'madonvi' => $ma,
                'manhomchucnang' => $inputs['manhomchucnang'],
                'tentaikhoan' => $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                // 'matkhau' => '2d17247d02f162064940feff49988f8e', 
                'matkhau' => Hash::make($data[$i][ColumnName()[$inputs['matkhau']]] ?? ''),
                'trangthai' => '1',
                'tendangnhap' => $data[$i][ColumnName()[$inputs['tendangnhap']]] ?? '',
            );
            if ($inputs['macumkhoi'] != 'NULL') {
                $a_ck[] = [
                    'madonvi' => $ma,
                    'macumkhoi' => $inputs['macumkhoi'],
                    'phanloai' => 'THANHVIEN',
                ];
            }
            $ma++;
        }
        dsdonvi::insert($a_dv);
        dstaikhoan::insert($a_tk);
        dscumkhoi_chitiet::insert($a_ck);
        // File::Delete($path);

        return redirect(static::$url . 'DanhSach?madiaban=' . $inputs['madiaban']);
    }
}
