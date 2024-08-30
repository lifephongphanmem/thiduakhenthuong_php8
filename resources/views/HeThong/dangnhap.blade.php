<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    {{-- <base href="../../../../"> --}}
    <meta charset="utf-8" />
    <title>Đăng nhập hệ thống</title>
    <meta name="description" content="Trang đăng nhập" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://phanmemcuocsong.com/" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ url('assets/css/pages/login/classic/login-6.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ url('assets/media/logos/LIFESOFT.png') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-6 login-signin-on login-signin-on d-flex flex-column-fluid" id="kt_login">
            <div class="d-flex flex-column flex-lg-row flex-row-fluid text-center"
                style="background-image: url(assets/media/bg/bg-3.jpg);">
                <!--begin:Aside-->
                <div class="d-flex w-100 flex-center p-15">
                    <div class="login-wrapper">
                        <!--begin:Aside Content-->
                        <div class="text-dark-75">
                            <a href="/">
                                <img src="assets/media/logos/LoGo_TDKT.jpg" class="max-h-100px" alt="" />
                            </a>
                            <h3 class="mb-8 mt-15 font-weight-bold text-uppercase">Phần mềm thi đua khen thưởng</h3>
                            <p class="mb-15 text-muted font-weight-bold text-uppercase">
                                <a href="https://phanmemcuocsong.com/" target="_blank">
                                    Tiện ích hơn - hiệu quả hơn
                                </a>
                            </p>
                        </div>
                        <!--end:Aside Content-->
                    </div>
                </div>
                <!--end:Aside-->
                <!--begin:Divider-->
                <div class="login-divider">
                    <div></div>
                </div>
                <!--end:Divider-->
                <!--begin:Content-->
                <div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden">
                    <div class="login-wrapper">
                        <!--begin:Sign In Form-->
                        <div class="login-signin">
                            <div class="text-center mb-10 mb-lg-20">
                                <h2 class="font-weight-bold">ĐĂNG NHẬP HỆ THỐNG</h2>
                                <p class="text-muted font-weight-bold">Nhập thông tin tài khoản</p>
                            </div>
                            {{-- {!! Form::open(['url' => '/DangNhap', 'id' => 'form-kt_login_signin_form', 'class' => 'form text-left']) !!} --}}
                            {!! Form::open(['url' => '/DangNhap', 'id' => 'kt_login_signin_form', 'class' => 'form text-left']) !!}
                            <div class="input-group form-group py-2 m-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                <input class="form-control border-1 px-5 placeholder-dark-75" title="Tên tài khoản"
                                    type="text" placeholder="Tên tài khoản truy cập" id="tendangnhap"
                                    name="tendangnhap" value="{{ $inputs['tendangnhap'] ?? '' }}" required
                                    autocomplete="off" />
                            </div>

                            <div class="input-group form-group py-2 m-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                                <input class="form-control border-1 px-5 placeholder-dark-75" title="Mật khẩu đăng nhập"
                                    type="Password" placeholder="Mật khẩu" id="matkhau" name="matkhau" required />
                                <div class="input-group-prepend password-container">
                                    <button class="input-group-text form-group" type="button" style="border-bottom-right-radius: 0.42rem;border-top-right-radius: 0.42rem;" onclick="HienMK()"> <i class="fa fa-eye-slash"></i></button>
                                </div>
                            </div>
                            <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">
                                <div class="checkbox-inline">
                                    {{-- <label class="checkbox m-0 text-muted font-weight-bold">
                                        <input type="checkbox" name="remember" />
                                        <span></span>Nhớ thông tin tài khoản</label> --}}
                                </div>
                                <a href="javascript:;" class="text-muted text-hover-primary font-weight-bold" id="kt_login_forgot">Quên mật
                                    khẩu ?</a>
                            </div>
                            <div class="text-center mt-15">
                                <button type="submit"
                                    class="btn btn-primary btn-pill shadow-sm py-4 px-9 font-weight-bold" id="kt_login_signin_submit">ĐĂNG
                                    NHẬP</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!--end:Sign In Form-->

                        <!--begin:Sign Up Form-->
                        <div class="login-signup">
                            <div class="text-center mb-10 mb-lg-20">
                                <h3 class="">Sign Up</h3>
                                <p class="text-muted font-weight-bold">Enter your details to create your account</p>
                            </div>
                            <form class="form text-left" id="kt_login_signup_form">
                                <div class="form-group py-2 m-0">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="text"
                                        placeholder="Fullname" name="fullname" />
                                </div>
                                <div class="form-group py-2 m-0 border-top">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="text"
                                        placeholder="Email" name="email" autocomplete="off" />
                                </div>
                                <div class="form-group py-2 m-0 border-top">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="password"
                                        placeholder="Password" name="password" />
                                </div>
                                <div class="form-group py-2 m-0 border-top">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75"
                                        type="password" placeholder="Confirm Password" name="cpassword" />
                                </div>
                                <div class="form-group mt-5">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-outline font-weight-bold">
                                            <input type="checkbox" name="agree" />
                                            <span></span>I Agree the
                                            <a href="#" class="ml-1">terms and conditions</a>.</label>
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap flex-center">
                                    <button id="kt_login_signup_submit"
                                        class="btn btn-primary btn-pill font-weight-bold px-9 py-4 my-3 mx-2">Submit</button>
                                    <button id="kt_login_signup_cancel"
                                        class="btn btn-outline-primary btn-pill font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <!--end:Sign Up Form-->

                        <!--begin:Forgot Password Form-->
                        <div class="login-form login-forgot">
                            <div class="text-center mb-10 mb-lg-20">
                                <h3 class="">Quên mật khẩu đăng nhập ?</h3>
                                <p class="text-muted font-weight-bold">Nhập email để reset mật khẩu</p>
                            </div>
                            <form class="form text-left" id="kt_login_forgot_form" action="{{'/SendMail'}}" method="POST">
                                @csrf
                                <div class="form-group py-2 m-0 border-bottom">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75"
                                        type="text" placeholder="Email" name="email" autocomplete="off" />
                                </div>
                                <div class="form-group d-flex flex-wrap flex-center mt-10">
                                    <button id="kt_login_forgot_submit" type="submit"
                                        class="btn btn-primary btn-pill font-weight-bold px-9 py-4 my-3 mx-2">Hoàn
                                        thành</button>
                                    <button id="kt_login_forgot_cancel"
                                        class="btn btn-outline-primary btn-pill font-weight-bold px-9 py-4 my-3 mx-2">Bỏ
                                        qua</button>
                                </div>
                            </form>
                        </div>
                        <!--end:Forgot Password Form-->
                    </div>
                </div>
                <!--end:Content-->

            </div>
        </div>
        <!--end::Login-->

        {{-- <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
			<!--begin::Container-->
			<div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
				<!--begin::Copyright-->
				<div class="text-dark order-2 order-md-1">
					<span class="text-muted font-weight-bold mr-2">© 2013 - 2022</span>
					<a href="http://phanmemcuocsong.com" target="_blank" class="text-dark-75 text-hover-primary">LifeSoft Tiện ích hơn - Hiệu quả hơn</a>
				</div>
				<!--end::Copyright-->
			</div>

			<div class="container d-flex flex-column text-right justify-content-between">
				<!--begin::Copyright-->
				<div class="text-dark order-2 order-md-1">
					<span class="text-muted font-weight-bold mr-2">© 2013 - 2022</span>
					<a href="http://phanmemcuocsong.com" target="_blank" class="text-dark-75 text-hover-primary">LifeSoft Tiện ích hơn - Hiệu quả hơn</a>
				</div>
				<!--end::Copyright-->
			</div>
			<!--end::Container-->
		</div> --}}
    </div>
    <!--end::Main-->

    {{-- <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script> --}}
    {{-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script> --}}
    {{-- <script>
			jQuery(document).ready(function() {
				$("#matkhau").keydown(function(event){
					if(event.keyCode == 13){
						$("#kt_login_signin_form").click();
					}
				});
		
    		}); 
    </script>--}}
    <script>
        var HOST_URL = "https://phanmemcuocsong.com/";
    
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#1BC5BD",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#6993FF",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#1BC5BD",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#E1E9FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
        function HienMK(){            
            var passwordField = document.getElementById('matkhau');
            var iconElement = document.querySelector('.password-container i');

            var isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';

            iconElement.classList.toggle('fa-eye', isPassword);
            iconElement.classList.toggle('fa-eye-slash', !isPassword);
        }
    </script>
        <script>
            @if(Session::has('message'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr["{{ Session::get('alert-type', 'info') }}"]("{{ Session::get('message') }}");
         @endif 
        </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{url('assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
    <script src="{{url('assets/js/scripts.bundle.js')}}"></script>

    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{url('assets/js/pages/custom/login/login-general.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>
