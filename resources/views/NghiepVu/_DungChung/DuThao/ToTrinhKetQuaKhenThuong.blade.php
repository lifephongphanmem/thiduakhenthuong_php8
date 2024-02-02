@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script')

@stop

@section('custom-script-footer')
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
                <h3 class="card-label text-uppercase">Thông tin dự thảo kết quả khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <button class="btn btn-primary mr-2" data-target="#taoduthao-modal" data-toggle="modal"><i
                        class="fa fa-check"></i>Tạo mới</button>
                <button class="btn btn-info" data-target="#dstruongdl-modal" data-toggle="modal"><i
                        class="fa fa-list-ol"></i>Tên trường</button>
            </div>
        </div>

        <div class="card-body">
            {!! Form::model($model, [
                'method' => 'POST',
                'url' => '/DungChung/DuThao/LuuToTrinhKetQuaKhenThuong',
                'class' => 'form',
                'id' => 'frm_In',
                'files' => true,
                'enctype' => 'multipart/form-data',
            ]) !!}
            {{ Form::hidden('mahosotdkt', null) }}
            {{ Form::hidden('thongtintotrinhdenghi', null) }}
            {{ Form::hidden('phanloaihoso', $inputs['phanloaihoso']) }}

            <div class="document-editor__toolbar"></div>
            <div class="form-control editor" style="height: auto; border: 1px solid #E4E6EF;">
                {!! html_entity_decode($model->thongtintotrinhdenghi) !!}
            </div>

            {{-- <div id="kt-ckeditor-1-toolbar"></div>
            <div id="kt-ckeditor-1">
                {!! html_entity_decode($model->thongtinquyetdinh) !!}
            </div> --}}
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    {{-- <a onclick="quay_lai_trang_truoc()" class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay
                        lại</a> --}}
                    <button type="submit" onclick="setGiaTri()" class="btn btn-primary"><i class="fa fa-check"></i>Lưu dữ
                        liệu</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {!! Form::close() !!}

    <!--Modal Tạo mới dự thảo-->
    {!! Form::open(['url' => '/DungChung/DuThao/TaoToTrinhKetQuaKhenThuong', 'id' => 'frm_hoso']) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="phanloaihoso" value="{{ $inputs['phanloaihoso'] }}" />
    <div id="taoduthao-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo mới dự thảo quyết định khen thưởng
                    </h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label style="font-weight: bold">Mẫu dự thảo khen thưởng</label>
                            {!! Form::select('maduthao', $a_duthao, $inputs['maduthao'], [
                                'id' => 'maduthao',
                                'class' => 'form-control select2basic',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
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
                                        <th width="10%">STT</th>
                                        <th>Tên tập thể</th>
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
        function quay_lai_trang_truoc() {
            history.back();
        }

        function setGiaTri() {
            $('#frm_In').find("[name='thongtintotrinhdenghi']").val(myEditor.getData());
        }
    </script>
@stop
