@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
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
            TableManagedclass.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom wave wave-animate-slow wave-info">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Xuất dữ liệu khen thưởng theo tập thể</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-6">
                    <label>Đơn vị</label>
                    {!! Form::select('madonvi', $a_donvi, $inputs['madonvi'], [
                        'id' => 'madonvi',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>

                <div class="col-3">
                    <label>Khen thưởng - Từ</label>
                    {!! Form::input('date', 'ngaytu', null, [
                        'id' => 'ngaytu',
                        'class' => 'form-control',
                        'title' => 'Căn cứ ngày quyết định khen thưởng',
                        'required' => true,
                    ]) !!}
                </div>
                <div class="col-3">
                    <label>Khen thưởng - Đến</label>
                    {!! Form::input('date', 'ngayden', null, [
                        'id' => 'ngayden',
                        'class' => 'form-control',
                        'title' => 'Căn cứ ngày quyết định khen thưởng',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label>Link API</label>
                    {!! Form::text('linkAPI', null, [
                        'id' => 'linkAPI',
                        'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-12">
                    <button class="btn btn-primary" onclick="TaoLinkAPI()"><i class="fa fa-check"></i>Tạo Link API</button>
                </div>
            </div>
        </div>
    </div>

    <!--end::Card-->
    <script>
        function TaoLinkAPI() {
            let currentDate = new Date().toJSON().slice(0, 10);
            let ngaytu = $('#ngaytu').val();
            let ngayden = $('#ngayden').val();
            let madonvi = $('#madonvi').val();
            // btoa() function and decode a base64 string using atob() function
            let currentUrl = window.location.origin;
            if (ngaytu == '' || ngayden == '') {
                toastr.error('Thời gian lấy dữ liệu không được bỏ trống.');
                return false;
            }

            let url = currentUrl + '/api/XuatTapThe?maso=' + btoa(madonvi + ':' + ngaytu + ':' + ngayden + ':' +
                currentDate);
            $('#linkAPI').val(url);
            return false;
        }
    </script>
@stop
