<?php

namespace App\Http\Controllers\ThongBao;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdonvi;
use App\Models\ThongBao\thongbao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class thongbaoController extends Controller
{
    public static $url = '/ThongBao/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            if (!chkaction()) {
                Session::flush();
                return response()->view('errors.error_login');
            };
            return $next($request);
        });
    }

    public function ThongTin()
    {
        switch (session('admin')->capdo){
            case 'T':{
                $a_phamvi=['T','TW'];
                break;
            }
            case 'TW':{
                $a_phamvi=['T','TW'];
                break;
            }
            case 'H':{
                $a_phamvi=['T','TW','H'];
                break;
            }
            case 'X':{
                $a_phamvi=['T','TW','H','X'];
                break;
            }
            default:{
                $a_phamvi=['T','TW','H','X'];
                break;
            }
        }
            $m_cumkhoi=dscumkhoi_chitiet::where('madonvi',session('admin')->madonvi)->get();
            // $macumkhoi=$cumkhoi->macumkhoi??'';
            $a_macumkhoi=array_column($m_cumkhoi->toarray(),'macumkhoi');
            $model = thongbao::wherein('phamvi',$a_phamvi)->orwherein('phamvi',$a_macumkhoi)->get();
            foreach($model as $ct){
                if($ct->trangthai != 'CHUADOC'){
                    if(in_array(session('admin')->tendangnhap,explode(';',$ct->trangthai))){
                        $ct->trangthai='DADOC';
                    }else{
                        $ct->trangthai='CHUADOC';
                    }
                }
                $ct->class=$ct->trangthai == 'CHUADOC'?'text-primary':'';               
            }
        $a_donvi = array_column(dsdonvi::all()->toarray(), 'tendonvi', 'madonvi');
        $dscumkhoi=array_column(dscumkhoi::all()->toarray(), 'tencumkhoi', 'macumkhoi');
        return view('ThongBao.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', $a_donvi)
            ->with('dscumkhoi', $dscumkhoi)
            ->with('pageTitle', 'Thông tin thông báo');
    }

    public function DocTin(Request $request){
            $model=thongbao::where('mathongbao',$request->mathongbao)->first();
            $result=array(
                'status'=>'401'
            );
            if(isset($model)){
                if($model->trangthai == 'CHUADOC'){
                    $trangthai=session('admin')->tendangnhap;
                }else{
                    $a_trangthai=explode(';',$model->trangthai);
                    if(!in_array(session('admin')->tendangnhap,$a_trangthai)){
                        array_push($a_trangthai,session('admin')->tendangnhap);                     
                    }
                    $trangthai=implode(';',$a_trangthai);

                }

                $model->update(['trangthai'=>$trangthai]);
                $result=array(
                    'status'=>'200'
                );
            }

            return response()->json($result);
    }
}
