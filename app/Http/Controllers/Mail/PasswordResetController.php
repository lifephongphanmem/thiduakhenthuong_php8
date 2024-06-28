<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Models\DanhMuc\dstaikhoan;
use App\Http\Controllers\Controller;
use App\Mail\MailLayMK;

class PasswordResetController extends Controller
{


    public function SendMail(Request $request)
    {
       $request->validate(['email' => 'required|email']);
        $user = dstaikhoan::where('email', $request->email)->first();

        if (!$user) {
            return view('errors.laymatkhau')
            ->with('message','Email không chính xác hoặc đơn vị chưa cập nhật email. Vui lòng liên hệ với bộ phận văn phòng hỗ trợ của công ty để lấy lại mật khẩu.')
            ->with('url','/DangNhap')
            ->with('url_hotro','/DanhSachHoTro');
        }


        $details = [
            'name' => $user->tentaikhoan,
            'reset_link' => url('/password/reset/')
        ];

        Mail::to($request->email)->send(new MailLayMK($details));

        return back()->with('success', 'Link reset mật khẩu đã được gửi!');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);




        $user = dstaikhoan::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => trans('User không tồn tại')]);
        }

        $user->matkhau = md5($request->password);
        $user->save();

        // Xóa token sau khi đã sử dụng

        return redirect('/DangNhap')->with('success', 'Mật khẩu đã được thay đổi!');
    }

    public function showResetForm($token = null)
    {
        return view('Mail.FormDatLaiMK');
    }
}
