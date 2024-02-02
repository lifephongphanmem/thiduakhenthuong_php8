<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>Thi đua khen thưởng</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ url('assets/congbo/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->

    <link href="{{ url('assets/congbo/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/congbo/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('assets/congbo/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ url('assets/congbo/assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('assets/congbo/assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('assets/congbo/assets/css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/congbo/assets/css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ url('assets/media/logos/LIFESOFT.png') }}" />
    @yield('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body onload="display_ct6()" id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->

    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="/">
            <img alt="Logo" src="{{ url('assets/media/logos/LoGo_TDKT.jpg') }}" class="logo-default max-h-30px" />
        </a>


        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="btn p-0 burger-icon ml-4 mr-2" id="kt_aside_mobile_toggle" title="Menu">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->
            <!--begin::Header Menu Mobile Toggle-->
            <!--<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>-->
            <!--end::Header Menu Mobile Toggle-->
            <!--begin::Topbar Mobile Toggle-->
            <a href="{{ url('/DanhSachTaiKhoan') }}">
                <img alt="Logo" src="{{ url('assets/media/logos/LoGo_TDKT.jpg') }}"
                    class="logo-default max-h-30px" />
            </a>

            <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
            <!--end::Topbar Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <!--Test-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                <!-- 2023.12.26 Chưa làm ẩn hiện menu aside -->
                <!--begin::Aside-->
                {{-- <div class="aside aside-left" id="kt_aside">
                    <!--begin::Secondary-->
                    <div class="aside-secondary d-flex flex-row-fluid">
                        <!--begin::Workspace-->
                        <div class="aside-workspace scroll scroll-push my-2">
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tab Pane-->
                                <div class="tab-pane fade show active" id="kt_aside_tab_2">
                                    <!--begin::Aside Menu-->
                                    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                                        <!--begin::Menu Container-->
                                        <div id="kt_aside_menu" class="aside-menu min-h-lg-800px" data-menu-vertical="1"
                                            data-menu-scroll="1">
                                            <!--begin::Menu Nav-->
                                            <ul class="menu-nav">
                                                <li class="menu-section">
                                                    <h3 class="menu-text">Thi đua, khen thưởng các cấp - </h3>
                                                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                                </li>

                                                <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                                    data-menu-toggle="hover">
                                                    <a href="javascript:;" class="menu-link menu-toggle">
                                                        <span class="svg-icon menu-icon">
                                                            <i class="fas fa-folder"></i>
                                                        </span>
                                                        <span class="menu-text font-weight-bold">Quản lý phong trào thi
                                                            đua</span>
                                                        <i class="menu-arrow"></i>
                                                    </a>
                                                    <div class="menu-submenu">
                                                        <i class="menu-arrow"></i>
                                                        <ul class="menu-subnav">

                                                            <li class="menu-item menu-item-submenu"
                                                                aria-haspopup="true" data-menu-toggle="hover">
                                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                                    <i class="menu-bullet menu-bullet-dot">
                                                                        <span></span>
                                                                    </i>
                                                                    <span class="menu-text font-weight-bold">Phong
                                                                        trào</span>
                                                                    <i class="menu-arrow"></i>
                                                                </a>
                                                                <div class="menu-submenu">
                                                                    <i class="menu-arrow"></i>
                                                                    <ul class="menu-subnav">
                                                                        <li class="menu-item" aria-haspopup="true">
                                                                            <a href="{{ url('/PhongTraoThiDua/ThongTin') }}"
                                                                                class="menu-link">
                                                                                <i class="menu-bullet menu-bullet-dot">
                                                                                    <span></span>
                                                                                </i>
                                                                                <span
                                                                                    class="menu-text font-weight-bold">Danh
                                                                                    sách phong trào</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!--end::Menu Nav-->
                                        </div>
                                        <!--end::Menu Container-->
                                    </div>
                                    <!--end::Aside Menu-->
                                </div>
                                <!--end::Tab Pane-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Workspace-->
                    </div>
                    <!--end::Secondary-->
                </div> --}}
                <!--end::Aside-->
                <!-- 2023.12.26 Chưa làm ẩn hiện menu aside -->
                <!--begin::Header-->
                <div id="kt_header" class="header header-fixed">
                    <!--begin::Container-->
                    <div class="container d-flex align-items-stretch justify-content-between">
                        <!--begin::Header Menu Wrapper-->
                        <div class="topbar">
                            <!--begin::Header Menu-->
                            <div class="topbar-item">
                                <!--begin::Header Nav-->
                                <a class="no-underline btn btn-sm font-weight-bold" href="/">
                                    <h2 style="text-transform: uppercase;"><img
                                            src="{{ url('assets/media/logos/TDKT.png') }}" class="max-h-35px" />

                                    </h2>
                                </a>
                                <b class="text-uppercase" style="color: #25aae2">THI ĐUA KHEN THƯỞNG -
                                    {{ $hethong->diadanh }}</b>
                                <!--end::Header Nav-->
                            </div>
                            <!--end::Header Menu-->
                        </div>
                        <!--end::Header Menu Wrapper-->
                        <div class="topbar">
                            <!--begin::Subheader-->
                            <div class="subheader py-2 py-lg-4 subheader-solid bg-white" id="kt_subheader">
                                <div
                                    class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-stretch mr-3">
                                        <!--begin::Header Menu Wrapper-->
                                        <div class="header-menu-wrapper header-menu-wrapper-left"
                                            id="kt_header_menu_wrapper">
                                            <!--begin::Header Menu-->
                                            <div id="kt_header_menu"
                                                class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                                                <!--begin::Header Nav-->
                                                <ul class="menu-nav">
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/CongBo/VanBan" class="menu-link">
                                                            <span class="menu-text">Văn bản QLNN</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/CongBo/QuyetDinh" class="menu-link">
                                                            <span class="menu-text">Quyết định khen thưởng</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item menu-item-submenu menu-item-rel"
                                                        data-menu-toggle="click" aria-haspopup="true">
                                                        <a href="javascript:;" class="menu-link menu-toggle">
                                                            <span class="menu-text">Hỗ trợ</span>
                                                            <span class="menu-desc"></span>
                                                            <i class="menu-arrow"></i>
                                                        </a>
                                                        <div
                                                            class="menu-submenu menu-submenu-classic menu-submenu-left">
                                                            <ul class="menu-subnav">
                                                                <li class="menu-item" aria-haspopup="true">
                                                                    <a target="_blank"
                                                                        href="{{ url('/DanhSachTaiKhoan') }}"
                                                                        class="menu-link">

                                                                        <span class="menu-text">Danh sách tài khoản
                                                                            tập
                                                                            huấn</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menu-item" aria-haspopup="true">
                                                                    <a target="_blank"
                                                                        href="{{ url('/DanhSachHoTro') }}"
                                                                        class="menu-link">

                                                                        <span class="menu-text">Thông tin hỗ
                                                                            trợ</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <!--end::Header Nav-->
                                            </div>
                                            <!--end::Header Menu-->
                                        </div>
                                        <!--end::Header Menu Wrapper-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Toolbar-->
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="btn btn-sm btn-light font-weight-bold mr-2">
                                            <span id='ct6'
                                                class="text-primary font-size-base font-weight-bolder">
                                            </span>
                                        </a>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>

                            </div>
                            <!--end::Subheader-->
                        </div>
                        <div class="topbar">
                            <!--begin::Header Menu-->
                            <div class="topbar-item">
                                @if (Illuminate\Support\Facades\Session::has('admin'))
                                    <a class="btn btn-sm btn-light mr-1 pulse pulse-danger text-primary font-weight-bolder"
                                        href="/">
                                        <span class="pulse-ring"></span>
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"></path>
                                                    <path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        Vào chương trình</a>
                                @else
                                    <a class="btn btn-sm btn-light mr-1 pulse pulse-danger text-primary font-weight-bolder"
                                        href="/DangNhap">
                                        <span class="pulse-ring"></span>
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"></path>
                                                    <path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        Đăng nhập</a>
                                @endif
                            </div>
                            <!--end::Header Menu-->
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content"
                    style="background-image: url('/assets/media/bg/bg-10.jpg')">

                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Row-->
                            @yield('content')
                            <!--end::Row-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container d-flex flex-column justify-content-between">
                        <div class="row">
                            <div class="col-8">
                                <p>Đơn vị: &nbsp;<b style="color: #25aae2">{{ $hethong->tendonvi }}</b>
                                </p>
                                <p>Địa chỉ: &nbsp;<b style="color: #25aae2">{{ $hethong->diachi }}</b></p>
                                <p>Thông tin liên hệ: &nbsp;<b style="color: #25aae2">Điện thoại:
                                        {{ $hethong->dienthoai }} -
                                        Email: {{ $hethong->emailql }}</b></p>
                            </div>
                            <div class="col-4 footer-block" style="text-align: left">
                                <p>Đơn vị phát triển: &nbsp;<b style="color: #25aae2">Công ty phát triển phần mềm Cuộc
                                        sống</b></p>
                                <p>Địa chỉ: &nbsp;<b style="color: #25aae2">Khu Tái Định Cư X2A, Phường Yên Sở, Quận
                                        Hoàng Mai, TP Hà Nội</b></p>
                            </div>
                        </div>



                        {{-- <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted font-weight-bold mr-2">Copyright © 2013-@DateTime.Now.Year.ToString()</span>
                            <a href="https://phanmemcuocsong.com/" target="_blank" class="text-dark-75 text-hover-primary">LifeSoft</a>
                            <span class="text-muted font-weight-bold mr-2">Tiện ích hơn - Hiệu quả hơn</span>
                        </div>
                        
                        <!--end::Copyright-->
                        <!--begin::Nav-->
                        <div class="nav nav-dark">
                            <a href="https://phanmemcuocsong.com/gioi-thieu/" target="_blank" class="nav-link pl-0 pr-5">Về chúng tôi</a>                           
                            <a href="https://phanmemcuocsong.com/lien-he/" target="_blank" class="nav-link pl-0 pr-0">Liên hệ</a>                           
                        </div>
                        <!--end::Nav--> --}}
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
    <!-- begin::User Panel-->
    <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop">
            <span class="svg-icon">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10"
                            rx="1"></rect>
                        <path
                            d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                            fill="#000000" fill-rule="nonzero"></path>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </div>
        <!--end::Scrolltop-->
        <!--end::Demo Panel-->
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
                    "xxl": 1400
                },
                "colors": {
                    "theme": {
                        "base": {
                            "white": "#ffffff",
                            "primary": "#3699FF",
                            "secondary": "#E5EAEE",
                            "success": "#1BC5BD",
                            "info": "#8950FC",
                            "warning": "#FFA800",
                            "danger": "#F64E60",
                            "light": "#E4E6EF",
                            "dark": "#181C32"
                        },
                        "light": {
                            "wte": "#ffffff",
                            "primary": "#E1F0FF",
                            "secondary": "#EBEDF3",
                            "success": "#C9F7F5",
                            "info": "#EEE5FF",
                            "warning": "#FFF4DE",
                            "danger": "#FFE2E5",
                            "light": "#F3F6F9",
                            "dark": "#D6D6E0"
                        },
                        "inverse": {
                            "white": "#ffffff",
                            "primary": "#ffffff",
                            "secondary": "#3F4254",
                            "success": "#ffffff",
                            "info": "#ffffff",
                            "warning": "#ffffff",
                            "danger": "#ffffff",
                            "light": "#464E5F",
                            "dark": "#ffffff"
                        }
                    },
                    "gray": {
                        "gray - 100": "#F3F6F9",
                        "gray - 200": "#EBEDF3",
                        "gray - 300": "#E4E6EF",
                        "gray - 400": "#D1D3E0",
                        "gray - 500": "#B5B5C3",
                        "gray - 600": "#7E8299",
                        "gray- 700": "#5E6278",
                        "gray- 800": "#3F4254",
                        "gray - 900": "#181C32"
                    }
                },
                "font-family": "Nunito Sans"
            };
        </script>
        <!--end::Global Config-->
        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="{{ url('assets/congbo/assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ url('assets/congbo/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
        <script src="{{ url('assets/congbo/assets/js/scripts.bundle.js') }}"></script>
        <!--end::Global Theme Bundle-->
        <!--begin::Page Vendors(used by this page)-->
        <script src="{{ url('assets/congbo/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
        <!--end::Page Vendors-->
        <!--begin::Page Scripts(used by this page)-->
        <script src="{{ url('assets/congbo/assets/js/pages/widgets.js') }}"></script>
        <!--end::Page Scripts-->

        <script type="text/javascript">
            function display_ct6() {
                var x = new Date()
                var month = x.getMonth() + 1;
                var date = x.getDate();
                var year = x.getFullYear();
                var hour = x.getHours();
                var minute = x.getMinutes();
                var second = x.getSeconds();

                if (date < 10) {
                    date = '0' + date
                }
                if (month < 10) {
                    month = '0' + month
                }
                if (hour < 10) {
                    hour = '0' + hour
                }
                if (minute < 10) {
                    minute = '0' + minute
                }
                if (second < 10) {
                    second = '0' + second
                }

                var x1 = date + "/" + month + "/" + year;
                x1 = x1 + " - " + hour + ":" + minute + ":" + second;
                document.getElementById('ct6').innerHTML = x1;
                display_c6();
            }

            function display_c6() {
                var refresh = 1000; // Refresh rate in milli seconds
                mytime = setTimeout('display_ct6()', refresh)
            }
            display_c6()
        </script>

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="/assets/js/pages/select2.js"></script>
        <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
        <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
        <script src="/assets/js/pages/table-lifesc.js"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <script>
            jQuery(document).ready(function() {
                TableManaged3.init();
                // var toggleElement = document.querySelector("#kt_aside_toggle);
                //     var toggle = KTToggle.getInstance(toggleElement); toggle.disabled();
            });
        </script>


    </div>
</body>
<!--end::Body-->

</html>
