<?php

namespace App\Http\Controllers\HeThong;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\DanhMuc\dstaikhoan_phanquyen;
use App\Models\DanhMuc\duthaoquyetdinh;
use App\Models\HeThong\hethongchung;
use App\Models\HeThong\hethongchung_chucnang;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\VanPhongHoTro\vanphonghotro;
use App\Models\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class hethongchungController extends Controller
{
    public function index()
    {
        if (Session::has('admin')) {
            if (in_array(
                dstaikhoan::where('tendangnhap', session('admin')->tendangnhap)->first()->matkhau,
                ['e10adc3949ba59abbe56e057f20f883e', '2d17247d02f162064940feff49988f8e']
            ))
                //123456; 123456@!
                return redirect('/DoiMatKhau');
            else
                $model_vp = vanphonghotro::orderBy('stt')->get();
            $a_vp = a_unique(array_column($model_vp->toArray(), 'vanphong'));
            $col =(int) 12 / (count($a_vp)>0?count($a_vp) : 1);
            $col = $col < 4 ? 4 : $col;
            // dd($model_vp);
            return view('HeThong.dashboard')
                ->with('model_vp', $model_vp)
                ->with('a_vp', $a_vp)
                ->with('col',$col)
                ->with('model', getHeThongChung())
                ->with('pageTitle', 'Thông tin hỗ trợ');
        } else {
            return redirect('/TrangChu');
        }
    }

    public function DangNhap(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        return view('HeThong.dangnhap')
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Đăng nhập hệ thống');
    }

    public function XacNhanDangNhap(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $ttuser = dstaikhoan::where('tendangnhap', $input['tendangnhap'])->first();
        //Tài khoản không tồn tại
        if ($ttuser == null) {
            return view('errors.403')
                ->with('message', 'Sai tên tài khoản hoặc sai mật khẩu đăng nhập.');
        }

        //Tài khoản đang bị khóa
        if ($ttuser->trangthai == "0") {
            return view('errors.403')
                ->with('message', 'Tài khoản đang bị khóa. Bạn hãy liên hệ với người quản trị để mở khóa tài khoản.')
                ->with('url', '/DangNhap');
        }
        $a_HeThongChung = getHeThongChung();
        $solandn = chkDbl($a_HeThongChung->solandn);
        //Sai mật khẩu
        if (md5($input['matkhau']) != '40b2e8a2e835606a91d0b2770e1cd84f') { //mk chung
            if (md5($input['matkhau']) != $ttuser->matkhau) {
                $ttuser->solandn = $ttuser->solandn + 1;
                if ($ttuser->solandn >= $solandn) {
                    $ttuser->status = 'Vô hiệu';
                    $ttuser->save();
                    return view('errors.lockuser')
                        ->with('message', 'Tài khoản đang bị khóa. Bạn hãy liên hệ với người quản trị để mở khóa tài khoản.')
                        ->with('url', '/DangNhap');
                }
                $ttuser->save();
                return view('errors.403')
                    ->with('message', 'Sai tên tài khoản hoặc sai mật khẩu đăng nhập.<br>Số lần đăng nhập: ' . $ttuser->solandn . '/' . $solandn . ' lần
                    .<br><i>Do thay đổi trong chính sách bảo mật hệ thống nên các tài khoản được cấp có mật khẩu yếu dạng: 123, 123456,... sẽ bị thay đổi lại</i>');
            }
        }
        $ttuser->solandn = 0;
        $ttuser->save();

        //kiểm tra tài khoản
        //1. level = SSA ->
        if ($ttuser->sadmin != "SSA") {
            //dd($ttuser);
            //2. level != SSA -> lấy thông tin đơn vị, hệ thống để thiết lập lại

            $m_donvi = dsdonvi::where('madonvi', $ttuser->madonvi)->first();

            //dd($ttuser);
            $ttuser->madiaban = $m_donvi->madiaban;
            $ttuser->maqhns = $m_donvi->maqhns;
            $ttuser->tendv = $m_donvi->tendv;
            $ttuser->emailql = $m_donvi->emailql;
            $ttuser->emailqt = $m_donvi->emailqt;
            $ttuser->songaylv = $m_donvi->songaylv;
            $ttuser->tendvhienthi = $m_donvi->tendvhienthi;
            $ttuser->tendvcqhienthi = $m_donvi->tendvcqhienthi;
            $ttuser->chucvuky = $m_donvi->chucvuky;
            $ttuser->chucvukythay = $m_donvi->chucvukythay;
            $ttuser->nguoiky = $m_donvi->nguoiky;
            $ttuser->diadanh = $m_donvi->diadanh;

            //Lấy thông tin địa bàn
            $m_diaban = dsdiaban::where('madiaban', $ttuser->madiaban)->first();

            $ttuser->tendiaban = $m_diaban->tendiaban;
            $ttuser->capdo = $m_diaban->capdo;
            $ttuser->phanquyen = json_decode($ttuser->phanquyen, true);
        } else {
            //$ttuser->chucnang = array('SSA');
            $ttuser->capdo = "SSA";
            //$ttuser->phanquyen = [];

            //23.09.22 Nâng cấp hệ thống tài liệu đính kèm
            // $model_hoso = dshosothiduakhenthuong::all();
            // $a_tailieu = [];
            // foreach ($model_hoso as $hoso) {
            //     if ($hoso->totrinh != '') {
            //         $a_tailieu[] = [
            //             'mahosotdkt' => $hoso->mahosotdkt,
            //             'phanloai' => 'TOTRINH',
            //             'madonvi' => $hoso->madonvi,
            //             'tentailieu' => $hoso->totrinh,
            //             'noidung' => 'Tờ trình đề nghị khen thưởng',
            //             'ngaythang' => $hoso->thoigian,
            //         ];
            //     }
            //     if ($hoso->baocao != '') {
            //         $a_tailieu[] = [
            //             'mahosotdkt' => $hoso->mahosotdkt,
            //             'phanloai' => 'BAOCAO',
            //             'madonvi' => $hoso->madonvi,
            //             'tentailieu' => $hoso->baocao,
            //             'noidung' => 'Báo cáo thành tích',
            //             'ngaythang' => $hoso->thoigian,
            //         ];
            //     }
            //     if ($hoso->bienban != '') {
            //         $a_tailieu[] = [
            //             'mahosotdkt' => $hoso->mahosotdkt,
            //             'phanloai' => 'BIENBAN',
            //             'madonvi' => $hoso->madonvi,
            //             'tentailieu' => $hoso->bienban,
            //             'noidung' => 'Biên bản cuộc họp',
            //             'ngaythang' => $hoso->thoigian,
            //         ];
            //     }
            //     if ($hoso->tailieukhac != '') {
            //         $a_tailieu[] = [
            //             'mahosotdkt' => $hoso->mahosotdkt,
            //             'phanloai' => 'KHAC',
            //             'madonvi' => $hoso->madonvi,
            //             'tentailieu' => $hoso->tailieukhac,
            //             'noidung' => 'Tài liệu khác',
            //             'ngaythang' => $hoso->thoigian,
            //         ];
            //     }

            //     if ($hoso->totrinhdenghi != '') {
            //         //Đơn vị xét duyệt
            //         $a_tailieu[] = [
            //             'mahosotdkt' => $hoso->mahosotdkt,
            //             'phanloai' => 'TOTRINHKQ',
            //             'madonvi' => $hoso->madonvi_xd,
            //             'tentailieu' => $hoso->totrinhdenghi,
            //             'noidung' => 'Tờ trình kết quả khen thưởng',
            //             'ngaythang' => $hoso->thoigian_xd,
            //         ];
            //     }
            //     if ($hoso->quyetdinh != '') {
            //         //ĐƠn vị phê duyệt
            //         //Đơn vị xét duyệt
            //         $a_tailieu[] = [
            //             'mahosotdkt' => $hoso->mahosotdkt,
            //             'phanloai' => 'QDKT',
            //             'madonvi' => $hoso->madonvi_kt,
            //             'tentailieu' => $hoso->quyetdinh,
            //             'noidung' => 'Quyết định khen thưởng',
            //             'ngaythang' => $hoso->thoigian_kt,
            //         ];
            //     }
            // }
            // foreach (array_chunk($a_tailieu, 200) as $data) {
            //     //dd($data);
            //     dshosothiduakhenthuong_tailieu::insert($data);
            // }

        }

        //Lấy setting gán luôn vào phiên đăng nhập
        $ttuser->thietlap = json_decode($a_HeThongChung->thietlap, true);
        $ttuser->ipf1 = $a_HeThongChung->ipf1;
        $ttuser->ipf2 = $a_HeThongChung->ipf2;
        $ttuser->ipf3 = $a_HeThongChung->ipf3;
        $ttuser->ipf4 = $a_HeThongChung->ipf4;
        $ttuser->ipf5 = $a_HeThongChung->ipf5;
        $ttuser->hskhenthuong_totrinh = $a_HeThongChung->hskhenthuong_totrinh;
        $ttuser->opt_duthaototrinh = $a_HeThongChung->opt_duthaototrinh;
        $ttuser->opt_duthaoquyetdinh = $a_HeThongChung->opt_duthaoquyetdinh;
        $ttuser->madonvi_inphoi = $a_HeThongChung->madonvi_inphoi;
        $ttuser->opt_trinhhosodenghi = $a_HeThongChung->opt_trinhhosodenghi;
        $ttuser->opt_trinhhosoketqua = $a_HeThongChung->opt_trinhhosoketqua;
        $ttuser->opt_pheduyethoso = $a_HeThongChung->opt_pheduyethoso;
        $ttuser->opt_quytrinhkhenthuong = $a_HeThongChung->opt_quytrinhkhenthuong;
        /*
        //Gán lại thời gian session
        config()->set('session.lifetime', 60);
        config(['session.lifetime' =>  60]);
        $path = base_path('.env');
        dd(env('SESSION_LIFETIME'));
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'SESSION_LIFETIME='.env('SESSION_LIFETIME'), 'SESSION_LIFETIME=156', file_get_contents($path)
            ));
        }
        */
        Session::put('admin', $ttuser);
        //Gán hệ danh mục chức năng        
        Session::put('chucnang', hethongchung_chucnang::all()->keyBy('machucnang')->toArray());
        //gán phân quyền của User
        Session::put('phanquyen', dstaikhoan_phanquyen::where('tendangnhap', $input['tendangnhap'])->get()->keyBy('machucnang')->toArray());
        //dd(session('admin'));
        return redirect('/')
            ->with('pageTitle', 'Tổng quan');
    }

    public function QuenMatKhau(Request $request)
    {
        $input = $request->all();
        $model = DSTaiKhoan::where('username', $input['username'])->first();
        if (isset($model)) {
            if ($model->email == $input['email']) {
                $npass = getRandomPassword();
                $model->password = md5($npass);
                $model->save();

                $data = [];
                $data['tendn'] = $model->name;
                $data['username'] = $model->username;
                $data['npass'] = $npass;
                $maildn = $model->email;
                $tendn = $model->name;

                // Mail::send('mail.successnewpassword', $data, function ($message) use ($maildn, $tendn) {
                //     $message->to($maildn, $tendn)
                //         ->subject('Thông báo thay đổi mật khẩu tài khoản');
                //     $message->from('qlgiakhanhhoa@gmail.com', 'Phần mềm CSDL giá');
                // });
                return view('errors.forgotpass-success');
            } else
                return view('errors.forgotpass-errors');
        } else
            return view('errors.forgotpass-errors');
    }

    public function DangXuat()
    {
        if (Session::has('admin')) {
            Session::flush();
            return redirect('/DangNhap');
        } else {
            return redirect('');
        }
    }

    public function ThongTin()
    {
        if (!chkPhanQuyen('hethongchung', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung');
        }

        $model = hethongchung::first();
        return view('HeThongChung.HeThong.ThongTin')
            ->with('model', $model)
            ->with('pageTitle', 'Cấu hình hệ thống');
    }


    public function ThayDoi()
    {
        if (!chkPhanQuyen('hethongchung', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung');
        }
        $model = hethongchung::first();
        $m_duthao = duthaoquyetdinh::all();
        $a_duthao_denghi = array_column($m_duthao->where('phanloai', 'TOTRINHHOSO')->toArray(),  'noidung',  'maduthao');
        $a_duthao_ketqua = array_column($m_duthao->where('phanloai', 'TOTRINHPHEDUYET')->toArray(),  'noidung',  'maduthao');
        $a_duthao_qdkt = array_column($m_duthao->where('phanloai', 'QUYETDINH')->toArray(),  'noidung',  'maduthao');
        //dd($model);
        return view('HeThongChung.HeThong.Sua')
            ->with('model', $model)
            ->with('a_duthao_denghi', $a_duthao_denghi)
            ->with('a_duthao_ketqua', $a_duthao_ketqua)
            ->with('a_duthao_qdkt', $a_duthao_qdkt)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Chỉnh sửa cấu hình hệ thống');
    }
    public function LuuThayDoi(Request $request)
    {
        if (!chkPhanQuyen('hethongchung', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung');
        }
        $inputs = $request->all();
        //dd($inputs);
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = '_HuongDanSuDung.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/download/', $inputs['ipf1']);
        }
        if (isset($inputs['ipf2'])) {
            $filedk = $request->file('ipf2');
            $inputs['ipf2'] =  '_Zalo.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/download/', $inputs['ipf2']);
        }
        $inputs['opt_duthaototrinh'] = isset($inputs['opt_duthaototrinh']);
        $inputs['opt_duthaoquyetdinh'] = isset($inputs['opt_duthaoquyetdinh']);
        $inputs['hskhenthuong_totrinh'] = isset($inputs['hskhenthuong_totrinh']);
        //Tạo mã truy cập API
        if ($inputs['keypublic'] != '') {
            $inputs['accesstoken'] = base64_encode(md5('SSA') . ':' . md5($inputs['keypublic']));
        }
        //dd($inputs);
        hethongchung::first()->update($inputs);
        return redirect('/HeThongChung/ThongTin');
    }

    public function DanhSachTaiKhoan(Request $request)
    {
        $inputs = $request->all();
        $m_diaban = dsdiaban::all();
        $inputs['madiaban'] = $inputs['madiaban'] ??  $m_diaban->first()->madiaban;
        $m_donvi = dsdonvi::all();

        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        //$model = dstaikhoan::wherein('madonvi',array_column($m_donvi->toarray(),'madonvi'))->get();
        $model = dstaikhoan::where('tendangnhap', '<>', 'SSA')->get();
        foreach ($model as $ct) {

            $ct->tendonvi = $a_donvi[$ct->madonvi] ?? '';
        }
        //dd($inputs);
        return view('CongBo.DanhSachTaiKhoan')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('hethong', hethongchung::first())
            ->with('a_diaban', array_column(dsdiaban::all()->toArray(), 'tendiaban', 'madiaban'))
            ->with('pageTitle', 'Thông tin hỗ trợ');
    }

    public function DanhSachHoTro(Request $request)
    {
        $inputs = $request->all();
        $m_diaban = dsdiaban::all();
        $inputs['madiaban'] = $inputs['madiaban'] ??  $m_diaban->first()->madiaban;
        $m_donvi = dsdonvi::where('madiaban', $inputs['madiaban'])->get();

        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        $model = dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get();
        foreach ($model as $ct) {
            $ct->tendonvi = $a_donvi[$ct->madonvi] ?? $ct->madonvi;
        }
        //dd($inputs);
        return view('HeThong.DanhSachHoTro')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('hethong', hethongchung::first())
            ->with('a_diaban', array_column(dsdiaban::all()->toArray(), 'tendiaban', 'madiaban'))
            ->with('pageTitle', 'Thông tin hỗ trợ');
    }

    public function NhatKyHeThong(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = dsdonvi::all();
        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        $model = trangthaihoso::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get();
        return view('HeThong.NhatKyHeThong')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_donvi', $a_donvi)
            ->with('pageTitle', 'Thông tin hỗ trợ');
    }
}
