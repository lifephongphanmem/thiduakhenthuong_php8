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
    <base href="../../../">
    <meta charset="utf-8" />
    <title>Thông báo | TDKT</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
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
        <!--begin::Error-->
        <div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30"
            style="background-image: url(assets/media/error/bg1.jpg);">
            <!--begin::Content-->
            <h3 class="font-weight-boldest text-dark-75 mt-15" style="font-size: 5rem">Thông báo!</h3>
            <p class="font-size-h3 text-danger font-weight-normal">{!! isset($message) ? $message : 'Phần mềm không thể thực hiện thao tác !!!' !!} </p>
            <p>Không thoát khỏi trang này trong khi chờ phản hồi !!!</p>
            <input type="hidden" name="tendangnhap" value="{{$ttuser->tendangnhap}}" id="tendangnhap">
            <input type="hidden" name="sessionID" value="{{$sessionID}}" id="sessionID">
            <!--end::Content-->
        </div>
        <!--end::Error-->
    </div>
    <form action="{{'/DangNhapTB2'}}" method="POST" >
        @csrf
        <div id="modal-thongbao" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <input type="hidden" name="tendangnhap" value={{$ttuser->tendangnhap}}>
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase">Thông báo !!!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body text-danger">
                        <p>Tài khoản đã được chấp nhận cho đăng nhập hệ thống!!!</p>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="boquaDN()">Bỏ
                            qua</button> --}}
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- <form action="{{'/showFormTuChoi'}}" method="GET" > --}}
        @csrf
        <div id="modal-thongbao-tuchoi" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase">Thông báo !!!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body text-danger">
                        <p>Tài khoản đã bị từ chối đăng nhập hệ thống!!!</p>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="boquaDN()">Bỏ
                            qua</button> --}}
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- </form> --}}
    <!--end::Main-->
    <script>
        var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
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
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script>
        jQuery(document).ready(function() {
            setInterval(chkDangNhap, 20000);
            setInterval(chkTuChoi, 20000);
        });

        function chkDangNhap() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var tendangnhap=$('#tendangnhap').val();
            $.ajax({
                url: "/KiemTraDangNhapTB2",
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    tendangnhap: tendangnhap
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data == true) {
                        $('#modal-thongbao').modal('show');
                    }
                },
                error: function(data) {
                    console.log(data)
                }
            });
        }
        function chkTuChoi() {
            // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var tendangnhap=$('#tendangnhap').val();
            var sessionID=$('#sessionID').val();
            $.ajax({
                url: "/showFormTuChoi",
                type: 'GET',
                data: {
                    tendangnhap: tendangnhap,
                    sessionID: sessionID
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data == true) {
                        $('#modal-thongbao-tuchoi').modal('show');
                    }
                },
                error: function(data) {
                    console.log(data)
                }
            });
        }
    </script>
    <!--end::Global Theme Bundle-->
</body>
<!--end::Body-->

</html>
