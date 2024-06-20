<?php

namespace App\Http\Controllers\YKienGopY;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dsdonvi;
use App\Models\View\viewdiabandonvi;
use App\Models\YKienGopY\ykiengopy;
use App\Models\YKienGopY\ykiengopy_tailieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ykiengopyController extends Controller
{
    public static $url = '/YKienGopY/';
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (!Session::has('admin')) {
        //         return redirect('/');
        //     };
        //     if(!chkaction()){
        //         Session::flush();
        //         return response()->view('errors.error_login');
        //     };
        //     return $next($request);
        // });
    }

    public function ThongTin(Request $request)
    {

        $inputs=$request->all();
        $m_donvi=getDonVi(session('admin')->capdo);
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        // dd($m_donvi);
        $inputs['madonvi']=$inputs['madonvi']??$m_donvi->first()->madonvi;
        if(in_array(session('admin')->sadmin,['ADMIN'])){
            $model=ykiengopy::wherein('trangthai',['1','2'])->get();
        }else{
            $model=ykiengopy::where('madonvi',$inputs['madonvi'])->get();
        }
        $inputs['url']=static::$url;
        $inputs['url_tailieudinhkem']='/DungChung/DinhKemHoSoKhenThuong';
        return view('YKienGopY.ThongTin')
                ->with('model',$model)
                ->with('m_donvi', $m_donvi)
                ->with('a_diaban', $a_diaban)
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Ý kiến góp ý');

    }

    public function Them(Request $request)
    {

        $inputs = $request->all();
        $inputs['magopy'] = (string)getdate()[0];
        $inputs['phanloai'] = 'GOPY';

        //Kiểm tra trạng thái hồ sơ
        // dd($inputs);
        ykiengopy::create($inputs);
        return redirect(static::$url . 'Sua?magopy=' . $inputs['magopy'].'&phanloai='.$inputs['phanloai'].'&madonvi='.$inputs['madonvi']);
    }

    public function ThayDoi(Request $request)
    {

        $inputs = $request->all();
        $inputs['phanloaihoso']='ykiengopy';
        $inputs['phanloai']=$inputs['phanloai']??'GOPY';
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();

        $model_tailieu = ykiengopy_tailieu::where('magopy', $model->magopy)->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        $model->tendonvi = $donvi->tendonvi;

        // $m_donvi = dsdonvi::all();
 
        // dd($model);
        // dd(session('admin'));
        return view('YKienGopY.ThayDoi')
            ->with('model', $model)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }

    public function LuuThayDoi(Request $request)
    {
        $inputs = $request->all();
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();
        // if (isset($inputs['ipf1'])) {
        //     $filedk = $request->file('ipf1');
        //     $inputs['ipf1'] = $inputs['mavanban'] . '1.' . $filedk->getClientOriginalName() . '.' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/vanban/', $inputs['ipf1']);
        // }
        if ($model == null) {
            ykiengopy::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin');
    }
    public function Xoa(Request $request)
    {
        // if (!chkPhanQuyen('vanbanphaply', 'thaydoi')) {
        //     return view('errors.noperm')->with('machucnang', 'vanbanphaply')->with('tenphanquyen', 'thaydoi');
        // }
        $inputs = $request->all();
        $model=ykiengopy::findorfail($inputs['id']);
        if(isset($model)){
            $m_tailieu=ykiengopy_tailieu::where('magopy',$model->magopy)->get();
            foreach($m_tailieu as $ct)
            {
                if (file_exists('/data/tailieudinhkem/' . $ct->tentailieu)) {
                    File::Delete('/data/tailieudinhkem/' . $ct->tentailieu);
                }
            }

            $model->delete();
        }
        return redirect(static::$url . 'ThongTin');
    }

    public function NhanYKien(Request $request)
    {
        $inputs = $request->all();

        $thoigian = date('Y-m-d H:i:s');
        $model = ykiengopy::where('magopy', $inputs['magopy'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 1;//Đã tiếp nhận
        $model->thoigiantiepnhan = $thoigian;
        // $model->tendangnhap_xl=session('admin')->tendangnhap;
        // dd($model);
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }
}
