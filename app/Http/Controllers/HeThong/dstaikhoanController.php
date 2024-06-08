<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dsnhomtaikhoan;
use App\Models\DanhMuc\dsnhomtaikhoan_phanquyen;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\DanhMuc\dstaikhoan_phamvi;
use App\Models\DanhMuc\dstaikhoan_phanquyen;
use App\Models\HeThong\hethongchung_chucnang;
use App\Models\View\viewdiabandonvi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;

class dstaikhoanController extends Controller
{
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
        if (!chkPhanQuyen('dstaikhoan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }

        $inputs = $request->all();

        $m_diaban = getDiaBan(session('admin')->capdo);
        $m_donvi = viewdiabandonvi::wherein('madiaban', array_column($m_diaban->toarray(), 'madiaban'))->get();
        $inputs['capdo'] = $inputs['capdo'] ?? 'ALL';
        if ($inputs['capdo'] != 'ALL') {
            $m_donvi = $m_donvi->where('capdo', $inputs['capdo']);
            $m_diaban = $m_diaban->where('capdo', $inputs['capdo']);
        }

        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $model = dstaikhoan::all();
        foreach ($m_donvi as $donvi) {
            $donvi->sotaikhoan = $model->where('madonvi', $donvi->madonvi)->count();
        }
        return view('HeThongChung.TaiKhoan.ThongTin')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_nhomtk', [])
            ->with('a_capdo', getPhanLoaiDonVi_DiaBan())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách tài khoản');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo);
        //dd($m_donvi);
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        //dd($m_donvi);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $model = dstaikhoan::where('madonvi', $inputs['madonvi'])->get();
        $a_nhomtk = array_column(dsnhomtaikhoan::all()->toArray(), 'tennhomchucnang', 'manhomchucnang');
        return view('HeThongChung.TaiKhoan.DanhSach')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_nhomtk', $a_nhomtk)
            ->with('a_phanloaitk', getPhanLoaiTaiKhoan())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách tài khoản');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }

        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo);
        $model = new dstaikhoan();
        $model->madonvi = $inputs['madonvi'];
        return view('HeThongChung.TaiKhoan.Them')
            //->with('inputs', $inputs)
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Tạo mới thông tin tài khoản');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }
        $inputs = $request->all();
        //dd($inputs);
        $inputs['tendangnhap'] = chuanhoachuoi($inputs['tendangnhap']);

        $model = dstaikhoan::where('id', $inputs['id'])->first();
        if ($model == null) {
            $chk = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->count();
            if ($chk > 0) {
                return view('errors.403')
                    ->with('message', 'Tên đăng nhập: <b>' . $inputs['tendangnhap'] . '</b> đã tồn tại trên phần mềm.')
                    ->with('url', '/TaiKhoan/DanhSach?madonvi=' . $inputs['madonvi']);
            }
            unset($inputs['id']);
            $inputs['matkhau'] = md5($inputs['matkhaumoi']);
            dstaikhoan::create($inputs);
        } else {
            $chk = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->where('id', '<>', $inputs['id'])->count();
            if ($chk > 0) {
                return view('errors.403')
                    ->with('message', 'Tên đăng nhập: <b>' . $inputs['tendangnhap'] . '</b> đã tồn tại trên phần mềm.')
                    ->with('url', '/TaiKhoan/DanhSach?madonvi=' . $inputs['madonvi']);
            }
            if ($inputs['matkhaumoi'] != '')
                $inputs['matkhau'] = md5($inputs['matkhaumoi']);

            //dd($inputs);
            unset($inputs['matkhaumoi']);
            $model->update($inputs);
        }

        return redirect('/TaiKhoan/DanhSach?madonvi=' . $inputs['madonvi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }
        $inputs = $request->all();
        $model = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
        $m_donvi = dsdonvi::all();
        return view('HeThongChung.TaiKhoan.Sua')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function XoaTaiKhoan(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }
        $id = $request->all()['id'];
        $model = dstaikhoan::findorFail($id);
        dstaikhoan_phanquyen::where('tendangnhap',$model->tendangnhap)->delete();
        $model->delete();
        return redirect('/TaiKhoan/DanhSach?madonvi=' . $model->madonvi);
    }

    //chức năng phân quyền
    public function PhanQuyen(Request $request)
    {
        //1. Cần lọc các chức năng ko sử dụng (sudung==0) dùng hàm đệ quy để lọc từng phần
        //2. kết hợp để gán giá trị phân quyền (0;1;null) null là cho các nhóm ko có nhóm con => từ đó xác định đó là nhóm để gán cho các nhóm con
        //duyệt từng phần tử => nếu count(magoc) > 0 => nhóm có phần tử con
        //dùng biến 'phanquyen' tương tư biến "sudung" để lọc chức năng trong nhóm con
        if (!chkPhanQuyen('dstaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }
        $inputs = $request->all();
        $m_taikhoan = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
        $m_phanquyen = dstaikhoan_phanquyen::where('tendangnhap', $inputs['tendangnhap'])->get();
        $m_chucnang = hethongchung_chucnang::where('sudung', '1')->get();
        foreach ($m_chucnang as $chucnang) {
            $phanquyen = $m_phanquyen->where('machucnang', $chucnang->machucnang)->first();
            $chucnang->phanquyen = $phanquyen->phanquyen ?? 0;
            $chucnang->danhsach = $phanquyen->danhsach ?? 0;
            $chucnang->thaydoi = $phanquyen->thaydoi ?? 0;
            $chucnang->hoanthanh = $phanquyen->hoanthanh ?? 0;
            $chucnang->tiepnhan = $phanquyen->tiepnhan ?? 0;
            $chucnang->xuly = $phanquyen->xuly ?? 0;
            $chucnang->nhomchucnang = $m_chucnang->where('machucnang_goc', $chucnang->machucnang)->count() > 0 ? 1 : 0;
        }
        //dd($m_chucnang);
        return view('HeThongChung.TaiKhoan.PhanQuyen')
            ->with('model', $m_chucnang->where('capdo', '1')->sortby('sapxep'))
            ->with('m_chucnang', $m_chucnang)
            ->with('m_taikhoan', $m_taikhoan)
            ->with('pageTitle', 'Phân quyền tài khoản');
    }

    public function LuuPhanQuyen(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }

        $inputs = $request->all();
        $inputs['phanquyen'] = isset($inputs['phanquyen']) ? 1 : 0;
        $inputs['danhsach'] = isset($inputs['danhsach']) ? 1 : 0;
        $inputs['thaydoi'] = isset($inputs['thaydoi']) ? 1 : 0;
        $inputs['hoanthanh'] = isset($inputs['hoanthanh']) ? 1 : 0;
        $inputs['tiepnhan'] = isset($inputs['tiepnhan']) ? 1 : 0;
        $inputs['xuly'] = isset($inputs['xuly']) ? 1 : 0;
        //Mặc định có 1 trong các quyền đều đc mở danh sách
        if ($inputs['hoanthanh'] == 1 || $inputs['thaydoi'] == 1 || $inputs['tiepnhan'] == 1 || $inputs['xuly'] == 1)
            $inputs['danhsach'] = 1;

        //dd($inputs);
        $m_chucnang = hethongchung_chucnang::where('sudung', '1')->get();
        $ketqua = new Collection();
        if (isset($inputs['nhomchucnang'])) {
            $this->getChucNang($m_chucnang, $inputs['machucnang'], $ketqua);
        }
        $ketqua->add($m_chucnang->where('machucnang', $inputs['machucnang'])->first());

        foreach ($ketqua as $ct) {
            $chk = dstaikhoan_phanquyen::where('machucnang', $ct->machucnang)->where('tendangnhap', $inputs['tendangnhap'])->first();
            $a_kq = [
                'machucnang' => $ct->machucnang,
                'tendangnhap' => $inputs['tendangnhap'],
                'phanquyen' => $inputs['phanquyen'],
                'danhsach' => $inputs['danhsach'],
                'thaydoi' => $inputs['thaydoi'],
                'hoanthanh' => $inputs['hoanthanh'],
                'tiepnhan' => $inputs['tiepnhan'],
                'xuly' => $inputs['xuly'],
            ];
            if ($chk == null) {
                dstaikhoan_phanquyen::create($a_kq);
            } else {
                $chk->update($a_kq);
            }
        }
        return redirect('/TaiKhoan/PhanQuyen?tendangnhap=' . $inputs['tendangnhap']);
    }

    function getChucNang(&$dschucnang, $machucnang_goc, &$ketqua)
    {
        foreach ($dschucnang as $key => $val) {
            if ($val->machucnang_goc == $machucnang_goc) {
                $ketqua->add($val);
                $dschucnang->forget($key);
                $this->getChucNang($dschucnang, $val->machucnang, $ketqua);
            }
        }
    }

    public function NhomChucNang(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }

        $inputs = $request->all();
        $m_taikhoan = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
        // dd($inputs);

        if (!isset($inputs['manhomchucnang'])) {
            return view('errors.404')
                ->with('message', 'Bạn cần chọn nhóm chức năng cho tài khoản để cài lại phân quyền')
                ->with('url', '/TaiKhoan/DanhSach?madonvi=' . $m_taikhoan->madonvi);
        }


        $a_phanquyen = [];
        foreach (dsnhomtaikhoan_phanquyen::where('manhomchucnang', $inputs['manhomchucnang'])->get() as $phanquyen) {
            $a_phanquyen[] = [
                "tendangnhap" => $inputs['tendangnhap'],
                "machucnang" => $phanquyen->machucnang,
                "phanquyen" => $phanquyen->phanquyen,
                "danhsach" => $phanquyen->danhsach,
                "thaydoi" => $phanquyen->thaydoi,
                "hoanthanh" => $phanquyen->hoanthanh,
            ];
        }
        //Xóa phân quyền cũ
        dstaikhoan_phanquyen::where('tendangnhap', $inputs['tendangnhap'])->delete();
        //Lưu thông tin nhóm tài khoản
        $m_taikhoan->manhomchucnang = $inputs['manhomchucnang'];
        $m_taikhoan->save();
        //Lưu phân uyền
        dstaikhoan_phanquyen::insert($a_phanquyen);
        return redirect('/TaiKhoan/DanhSach?madonvi=' . $m_taikhoan->madonvi);
    }

    public function DoiMatKhau(Request $request)
    {
        //$inputs = $request->all();
        $model = dstaikhoan::where('tendangnhap', session('admin')->tendangnhap)->first();
        $m_donvi = dsdonvi::all();
        return view('HeThongChung.TaiKhoan.DoiMatKhau')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Đổi mật khẩu đăng nhập');
    }

    public function LuuMatKhau(Request $request)
    {
        $inputs = $request->all();
        $model = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
        $inputs['matkhau'] = md5($inputs['matkhaumoi']);
        unset($inputs['matkhaumoi']);
        $model->update($inputs);
        return redirect('/');
    }

    public function PhamViDuLieu(Request $request)
    {
        if (!chkPhanQuyen('dstaikhoan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }

        $inputs = $request->all();
        $inputs['url'] = '/TaiKhoan/PhamViDuLieu/';
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        $model_taikhoan = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
        $model_donvi = viewdiabandonvi::where('madonvi', $model_taikhoan->madonvi)->first();
        $model = dstaikhoan_phamvi::where('tendangnhap', $inputs['tendangnhap'])->get();

        $m_donvi = getDonVi($model_donvi->capdo);
        //dd($model);
        $a_phamvi = array_column($model->toarray(), 'maphamvi');
        $a_diaban = array_column(dsdiaban::wherein('capdo', ['T', 'H', 'X'])->wherenotin('madiaban', $a_phamvi)->get()->toarray(), 'tendiaban', 'madiaban');
        $a_cumkhoi = array_column(dscumkhoi::wherenotin('macumkhoi', $a_phamvi)->get()->toarray(), 'tencumkhoi', 'macumkhoi');
        $a_donvi = array_column(dsdonvi::wherenotin('madonvi', $a_phamvi)->get()->toarray(), 'tendonvi', 'madonvi');
        if ($inputs['phanloai'] != 'ALL') {
            $model = $model->where('phanloai', $inputs['phanloai']);
        }
        return view('HeThongChung.TaiKhoan.PhamViDuLieu')
            ->with('model', $model)
            ->with('model_taikhoan', $model_taikhoan)
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('a_cumkhoi', $a_cumkhoi)
            ->with('a_donvi', $a_donvi)
            ->with('a_phanloai', getPhanLoaiLocDuLieu())
            //->with('a_nhomtk', [])
            //->with('a_capdo', getPhanLoaiDonVi_DiaBan())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thiết lập phạm vi lọc dữ liệu');
    }

    public function LuuPhamViDuLieu(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/TaiKhoan/PhamViDuLieu/';





        $model = dstaikhoan_phamvi::where('tendangnhap', $inputs['tendangnhap'])
            ->where('maphamvi', $inputs['maphamvi'])->first();

        if ($model == null) {
            $model = new dstaikhoan_phamvi();
            $model->tendangnhap = $inputs['tendangnhap'];
            $model->maphamvi = $inputs['maphamvi'];

            switch ($inputs['phanloai']) {
                case "DONVI": {
                        $a_donvi = array_column(dsdonvi::all()->toarray(), 'tendonvi', 'madonvi');
                        $model->tenphamvi = $a_donvi[$inputs['maphamvi']];
                        break;
                    }
                case "CUMKHOI": {
                        $a_cumkhoi = array_column(dscumkhoi::all()->toarray(), 'tencumkhoi', 'macumkhoi');
                        $model->tenphamvi = $a_cumkhoi[$inputs['maphamvi']];
                        break;
                    }
                case "DIABAN": {
                        $a_diaban = array_column(dsdiaban::all()->toarray(), 'tendiaban', 'madiaban');
                        $model->tenphamvi = $a_diaban[$inputs['maphamvi']];
                        break;
                    }
            }

            $model->phanloai = $inputs['phanloai'];
        }
        //dd($inputs);
        $model->save();

        return redirect('/TaiKhoan/PhamViDuLieu?tendangnhap=' . $inputs['tendangnhap']);
    }

    public function XoaPhamViDuLieu(Request $request)
    {
        $id = $request->all()['id'];
        $model = dstaikhoan_phamvi::findorFail($id);
        $model->delete();
        return redirect('/TaiKhoan/PhamViDuLieu?tendangnhap=' . $model->tendangnhap . '&machucnang=' . $model->machucnang);
    }
}
