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
            TableManaged3.init();

            $('#manhomphanloai').change(function() {
                window.location.href = '{{ $inputs['url'] }}' + 'ThongTin?manhomphanloai=' + $(
                    '#manhomphanloai').val();
            });
        });

        function add() {
            var form = $('#frm_modify');
            form.find("[name='maphanloai']").val('');
            form.find("[name='maphanloai']").attr('readonly', true);
            form.find("[name='tenphanloai']").val('');
            form.find("[name='stt']").val('{{count($model) + 1}}');
        }

        function edit(manhomphanloai, maphanloai, tenphanloai, stt) {
            var form = $('#frm_modify');
            form.find("[name='maphanloai']").attr('readonly', false);
            form.find("[name='maphanloai']").val(maphanloai);
            form.find("[name='tenphanloai']").val(tenphanloai);
            form.find("[name='stt']").val(stt);
            form.find("[name='manhomphanloai']").val(manhomphanloai).trigger('change');
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh mục phân loại</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dmnhomphanloai', 'thaydoi'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#modify-modal"
                        data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label style="font-weight: bold">Nhóm phân loại</label>
                    {!! Form::select('manhomphanloai', $a_nhomphanloai, $inputs['manhomphanloai'], [
                        'id' => 'manhomphanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th width="25%">Mã phân loại</th>
                                <th>Tên phân loại</th>
                                <th width="15%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td style="text-align: center">{{ $i++ }}</td>
                                    <td>{{ $ct->maphanloai }}</td>
                                    <td>{{ $ct->tenphanloai }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dmnhomphanloai', 'thaydoi'))
                                            <button type="button" title="Chỉnh sửa"
                                                onclick="edit('{{ $ct->manhomphanloai }}','{{ $ct->maphanloai }}','{{ $ct->tenphanloai }}','{{ $ct->stt }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-success"></i></button>

                                            <button title="Xóa thông tin" type="button"
                                                onclick="confirmDelete('{{ $ct->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash-alt text-danger"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <!--Modal thông tin chi tiết -->
    {!! Form::open(['url' => $inputs['url'] . 'Them', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin chi tiết</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-md-10">
                                <label class="control-label">Nhóm phân loại</label>
                                {!! Form::select('manhomphanloai', $a_nhomphanloai, $inputs['manhomphanloai'], [
                                    'class' => 'form-control select2_modal',
                                ]) !!}
                            </div>
                            <div class="col-md-2">
                                <label class="text-center">Thêm</label>
                                <button type="button" class="btn btn-default btn-icon" data-target="#nhomphanloai-modal"
                                    data-toggle="modal">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('maphanloai', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Tên phân loại<span class="require">*</span></label>
                                {!! Form::text('tenphanloai', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Số thứ tự</label>
                                {!! Form::text('stt', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng
                        ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url' => $inputs['url'] . 'ThemNhom', 'id' => 'frm_themnhom']) !!}
    <div id="nhomphanloai-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin chi tiết</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Mã số nhóm phân loại</label>
                                {!! Form::text('manhomphanloai', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Tên nhóm phân loại<span class="require">*</span></label>
                                {!! Form::text('tennhomphanloai', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Số thứ tự</label>
                                {!! Form::text('stt', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng
                        ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('includes.modal.modal-delete')
@stop
