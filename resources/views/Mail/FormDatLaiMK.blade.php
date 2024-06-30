
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
    <link rel="shortcut icon" href="{{ url('/assets/media/logos/LIFESOFT.png') }}" />
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
                style="background-image: url(/assets/media/bg/bg-3.jpg);">
                <!--begin:Aside-->
                <div class="d-flex w-100 flex-center p-15">
                    <div class="login-wrapper">
                        <!--begin:Aside Content-->
                        <div class="text-dark-75">
                            <a href="/">
                                <img src="/assets/media/logos/LoGo_TDKT.jpg" class="max-h-100px" alt="" />
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
                    {{-- <div></div> --}}
                </div>
                <!--end:Divider-->
                <!--begin:Content-->
                <div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden">
                    {{-- <div class="login-wrapper"> --}}
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        <div class="card-header text-uppercase" style="font-weight:500;font-size:16px">reset password</div>
                        
                                        <div class="card-body">
                                            <form method="POST" action="{{ '/password/reset' }}">
                                                @csrf
                        
                                                <input type="hidden" name="token" value="{{ $token }}">
                        
                                                <div class="form-group row">
                                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                        
                                                    <div class="col-md-6">
                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                        
                                                <div class="form-group row">
                                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                        
                                                    <div class="col-md-6">
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                        
                                                <div class="form-group row">
                                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Đặt lại mật khẩu</label>
                        
                                                    <div class="col-md-6">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                    </div>
                                                </div>
                        
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Reset Password') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- </div> --}}
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
            // var type = document.getElementById('matkhau').type;            
            // if(type == 'password'){
            //     document.getElementById('matkhau').type = 'text';
            //     var iconElement = document.querySelector('i.fa-eye-slash');
            //     iconElement.classList.remove('fa-eye-slash');
            //     iconElement.classList.add('fa-eye');
            // }else{
            //     document.getElementById('matkhau').type = 'password';
            //     var iconElement = document.querySelector('i.fa-eye');
            //     iconElement.classList.remove('fa-eye');
            //     iconElement.classList.add('fa-eye-slash');
            // }

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
    {{-- <script src="{{url('assets/js/pages/custom/login/login-general.js')}}"></script> --}}
    <!--end::Page Scripts-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
<!--end::Body-->

</html>
