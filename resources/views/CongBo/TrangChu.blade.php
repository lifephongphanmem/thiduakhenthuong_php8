@extends('CongBo.maincongbo')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    <script src="/assets/js/pages/table-lifesc.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        jQuery(document).ready(function() {
            TableManaged3.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="login login-6 login-signin-on login-signin-on d-flex flex-column-fluid" id="kt_login">
        <div class="d-flex flex-column flex-lg-row flex-row-fluid text-center"
            >
            <!--begin:Aside-->
            <div class="d-flex w-100 flex-center mt-15">
                <div class="login-wrapper">
                    <!--begin:Aside Content-->
                    <div>
                        <a href="#">
                            <img src="assets/media/logos/TDKT.png" class="max-h-200px"  />
                        </a>
                        <h1 class="mb-8 mt-15 font-weight-boldest text-uppercase" style="color: red">Phần mềm thi đua khen thưởng</h1>
                        <p class="mb-15 text-muted font-weight-bold text-uppercase">
                            <a href="https://phanmemcuocsong.com/" target="_blank" style="color: red">
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

        </div>
    </div>
@stop
