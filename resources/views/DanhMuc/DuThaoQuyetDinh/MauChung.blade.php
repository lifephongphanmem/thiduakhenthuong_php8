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
    <script>
        jQuery(document).ready(function() {
            TableManagedclass.init();
        });
    </script>
    <script src="/assets/js/pages/custom/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/pages/custom/ckeditor/ckeditor-custom.js"></script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin dự thảo quyết định khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <button class="btn btn-info" data-target="#dstruongdl-modal" data-toggle="modal"><i
                        class="fa fa-list-ol"></i>Tên trường</button>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-12">
                    <label style="font-weight: bold">Tên dự thảo</label>
                    {!! Form::text('tenduthao', $model->noidung, ['id' => 'tenduthao', 'class' => 'form-control muted']) !!}
                </div>
            </div>
            <hr>
            {!! Form::model($model, [
                'method' => 'POST',
                'url' => $inputs['url'] . 'Luu',
                'class' => 'form',
                'id' => 'frm_In',
                'files' => true,
                'enctype' => 'multipart/form-data',
            ]) !!}
            {{ Form::hidden('maduthao', null) }}
            {{ Form::hidden('codehtml', null) }}

            <div class="document-editor__toolbar"></div>
            <div class="form-control editor" style="height: auto; border: 1px solid #E4E6EF;">
                {!! html_entity_decode($model->codehtml) !!}
            </div>

            {{-- <div id="kt-ckeditor-1-toolbar"></div>
            <div id="kt-ckeditor-1">
                {!! html_entity_decode($model->thongtinquyetdinh) !!}
            </div> --}}
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url($inputs['url'] . 'ThongTin') }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn
                        thành</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {!! Form::close() !!}

    <!--Modal danh sách trường dữ liệu-->
    <div id="dstruongdl-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Danh sách trường dữ liệu</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover dulieubang">
                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">STT</th>
                                        <th>Tên trường dữ liệu</th>
                                        <th>Diễn giải</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach (getTenTruongDuLieuDuThao() as $key => $tt)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $key }}</td>
                                            <td>{{ $tt }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <script>
        function setGiaTri() {
            $('#frm_In').find("[name='codehtml']").val(myEditor.getData());
        }
    </script>
@stop
