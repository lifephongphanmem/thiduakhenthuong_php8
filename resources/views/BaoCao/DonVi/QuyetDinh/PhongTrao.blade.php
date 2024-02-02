@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script')

@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <script src="/assets/plugins/custom/ckeditor/ckeditor-document.bundle.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="/assets/js/pages/crud/forms/editors/ckeditor-document.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->

    <!-- END PAGE LEVEL PLUGINS -->

@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin dự thảo quyết định khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <a title="Tải lại quyết định" class="btn btn-primary mr-5" href="{{url('/KhenThuongHoSoThiDua/MacDinhQuyetDinh?maquyetdinh=QUYETDINH&mahosokt='.$model->mahosokt)}}" class="btn btn-primary"><i class="fa fas fa-sync"></i></a>
                <a title="In quyết định" class="btn btn-info" target="_blank" href="{{url('/KhenThuongHoSoThiDua/XemQuyetDinh?mahosokt='.$model->mahosokt)}}" class="btn btn-primary"><i class="fa fas fa-print"></i></a>
            </div>
        </div>
        {!! Form::model($model, ['method' => 'POST', 'url' => '/KhenThuongHoSoThiDua/QuyetDinh', 'class' => 'form', 'id' => 'frm_In', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('mahosokt', null) }}
        {{ Form::hidden('thongtinquyetdinh', null) }}
        <div class="card-body">
            <div id="kt-ckeditor-1-toolbar"></div>
            <div id="kt-ckeditor-1">
                {!! html_entity_decode($model->thongtinquyetdinh) !!}
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/KhenThuongHoSoThiDua/ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    {{-- <button onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành123</button> --}}
                    <button type="submit" onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn
                        thành</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {!! Form::close() !!}
    <script>
        function setGiaTri() {
            $('#frm_In').find("[name='thongtinquyetdinh']").val(myEditor.getData());
        }

    </script>
@stop
