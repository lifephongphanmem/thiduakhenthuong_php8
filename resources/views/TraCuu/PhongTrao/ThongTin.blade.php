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
    {!! Form::open(['method' => 'POST', 'url' => '/TraCuu/PhongTrao/ThongTin', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Tìm kiếm thông tin phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="form-control-label">Địa bàn phát động</label>
                    {!! Form::select('madiaban', $a_diaban ,null, ['class' => 'form-control select2basic']) !!}
                </div>


                <div class="col-lg-6">
                    <label>Tên đơn vị phát động</label>
                    {!! Form::select('madonvi', $a_donvi, null, ['class' => 'form-control select2basic',]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="form-control-label">Phạm vi phát động</label>
                    {!! Form::select('phamviapdung', $a_phamvi, null, ['class' => 'form-control select2basic']) !!}
                </div>
                <div class="col-lg-6">
                    <label class="form-control-label">Hình thức tổ chức</label>
                    {!! Form::select('phanloai', $a_phanloai, null, ['class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3">
                    <label>Thời gian phát động - Từ</label>
                    {!! Form::input('date', 'ngaytu', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Thời gian phát động - Đến</label>
                    {!! Form::input('date', 'ngayden', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Tìm kiếm</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->


    {{-- Thong tin đối tượng --}}
    <div id="modal-donvi" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đơn vị</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDoiTuong(tendoituong) {
            $('#tendoituong').val(tendoituong);
            $('#modal-doituong').modal('hide');
        }
    </script>
@stop
