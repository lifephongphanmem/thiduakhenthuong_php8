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

            $('#madonvi').change(function() {
                window.location.href = "{{ $inputs['url'] }}" + "ThongTin?madonvi=" + $('#madonvi').val();
            });

            $('#madiaban').change(function() {                
                var madiaban = $(this).val();                
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "/TraCuu/DungChung/LayDonVi",
                    type: "GET",
                    data: {
                        _token: CSRF_TOKEN,
                        madiaban: madiaban,
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            $('#div_donvi').replaceWith(data.message);
                        }
                    }
                });
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::open([
        'method' => 'POST',
        'url' => '/TraCuu/CaNhan/ThongTin',
        'class' => 'form',
        'id' => 'frm_ThayDoi',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="card card-custom wave wave-animate-slow wave-info">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin tìm kiếm kết quả khen thưởng theo cá nhân</h3>
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

                <div class="col-6">
                    <label>Địa bàn tìm kiếm</label>
                    {!! Form::select('madiaban', setArrayAll($a_diaban), null, [
                        'id' => 'madiaban',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                {{-- <div id="#div_donvi" class="col-6">
                    <label>Đơn vị tìm kiếm</label>
                    {!! Form::select('madonvi_tc', setArrayAll([]), null, [
                        'id' => 'madonvi_tc',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div> --}}
            </div>

            <div class="form-group row">
                <div class="col-4">
                    <label class="form-control-label">Tên đối tượng</label>
                    {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-4">
                    <label class="form-control-label">Tên phòng ban làm việc</label>
                    {!! Form::text('tenphongban', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-4">
                    <label>Tên đơn vị công tác</label>
                    {!! Form::text('tencoquan', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3">
                    <label>Khen thưởng - Từ</label>
                    {!! Form::input('date', 'ngaytu', null, [
                        'class' => 'form-control',
                        'title' => 'Căn cứ ngày quyết định khen thưởng',
                    ]) !!}
                </div>
                <div class="col-lg-3">
                    <label>Khen thưởng - Đến</label>
                    {!! Form::input('date', 'ngayden', null, [
                        'class' => 'form-control',
                        'title' => 'Căn cứ ngày quyết định khen thưởng',
                    ]) !!}
                </div>

                <div class="col-md-3">
                    <label class="form-control-label">Giới tính</label>
                    {!! Form::select('gioitinh', setArrayAll(getGioiTinh(), 'Tất cả', 'ALL'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label class="form-control-label">Phân loại cán bộ</label>
                    {!! Form::select('maphanloaicanbo', setArrayAll($a_canhan, 'Tất cả', 'ALL'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>

                <div class="col-md-6">
                    <label class="form-control-label">Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', setArrayAll($a_loaihinhkt, 'Tất cả', 'ALL'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Tìm
                        kiếm</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->
@stop
