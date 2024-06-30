<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Models\DanhMuc\dstaikhoan;
use App\Http\Controllers\Controller;
use App\Mail\MailLayMK;
use Illuminate\Support\Str;

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

        $m_password=\DB::table('password_resets')->where('email',$request->email)->first();
        if (isset($m_password)) {
            return back()->with('message', 'Email đã sử dụng. Kiểm tra lại thư trên email !!!')->with('alert-type','error');
        }
        $token = Str::random(60);

        // Save token to database or another storage
        // For simplicity, we assume a 'password_resets' table exists
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $details = [
            'name' => $user->tentaikhoan,
            'reset_link' => url('/password/reset/' . $token)
        ];

        Mail::to($request->email)->send(new MailLayMK($details));

        return back()->with('message', 'Link reset mật khẩu đã được gửi!')->with('alert-type','success');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $passwordReset = \DB::table('password_resets')->where('token', $request->token)->first();

        if (!$passwordReset || $passwordReset->email != $request->email) {
            return back()->with('message', 'Link reset mật khẩu không hợp lệ')->with('alert-type','error');
        }


        $user = dstaikhoan::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('message', 'Email chưa chính xác !!!')->with('alert-type','error');
        }

        $user->matkhau = md5($request->password);
        $user->save();

        // Xóa token sau khi đã sử dụng
        \DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/DangNhap')->with('message', 'Mật khẩu đã được thay đổi!')->with('alert-type','success');
    }

    public function showResetForm($token = null)
    {
        return view('Mail.FormDatLaiMK')->with(['token' => $token]);
    }
}
