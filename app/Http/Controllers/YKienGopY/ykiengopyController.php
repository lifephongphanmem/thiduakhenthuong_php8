<?php

namespace App\Http\Controllers\YKienGopY;

use App\Http\Controllers\Controller;
use App\Models\YKienGopY\ykiengopy;
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
        
        $inputs['madonvi']=$inputs['madonvi']??'';
    }
}
