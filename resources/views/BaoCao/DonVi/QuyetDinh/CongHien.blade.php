@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script')

@stop

@section('custom-script-footer')
<script>
    jQuery(document).ready(function() {
        $('#maduthao').change(function() {
            window.location.href = "/DungChung/DuThao/TaoQuyetDinhKhenThuong?maduthao=" + $('#maduthao').val() + "&mahosotdkt=" + "{{$inputs['mahosotdkt']}}";
        });       
    });
</script>

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
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin dự thảo quyết định khen thưởng theo cống hiến</h3>
            </div>
            <div class="card-toolbar">                

            </div>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Mẫu dự thảo khen thưởng</label>
                    {!! Form::select('maduthao', $a_duthao, $inputs['maduthao'], ['id' => 'maduthao', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>
            <hr>
            {!! Form::model($model, [
                'method' => 'POST',
                'url' => '/DungChung/DuThao/QuyetDinhKhenThuong',
                'class' => 'form',
                'id' => 'frm_In',
                'files' => true,
                'enctype' => 'multipart/form-data',
            ]) !!}
            {{ Form::hidden('mahosotdkt', null) }}
            {{ Form::hidden('thongtinquyetdinh', null) }}
            <div id="kt-ckeditor-1-toolbar"></div>
            <div id="kt-ckeditor-1">
                {!! html_entity_decode($model->thongtinquyetdinh) !!}
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    {{-- <a href="{{ url($inputs['url'] . 'ThongTin?madonvi=' . $inputs['madonvi']) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a> --}}
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
