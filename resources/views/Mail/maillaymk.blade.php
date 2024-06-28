<!DOCTYPE html>
<html>
<head>
    <title>Reset mật khẩu</title>
</head>
<body>
    <h1>Yêu cầu reset mật khẩu</h1>
    <p>Chào {{ $details['name'] }},</p>
    <p>Bạn đã yêu cầu reset mật khẩu. Vui lòng click vào link dưới đây để đặt lại mật khẩu của bạn:</p>
    <a href="{{ $details['reset_link'] }}">Reset mật khẩu</a>
    <p>Nếu bạn không yêu cầu reset mật khẩu, hãy bỏ qua email này.</p>
</body>
</html>