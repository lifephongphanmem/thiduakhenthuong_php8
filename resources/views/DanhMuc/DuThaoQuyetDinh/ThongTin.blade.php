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
            $('#phanloai').change(function() {
                window.location.href = "{{ $inputs['url'] }}" + 'ThongTin?phanloai=' + $('#phanloai')
                    .val();
            });
        });

        function add() {
            var form = $('#frm_modify');
            form.find("[name='maduthao']").val('');
            form.find("[name='maduthao']").attr('readonly', true);
            form.find("[name='noidung']").val('');
            form.find("[name='stt']").val('{{ count($model) + 1 }}');
        }

        function edit(maduthao, noidung, stt, phanloai) {
            var form = $('#frm_modify');
            form.find("[name='maduthao']").attr('readonly', false);
            form.find("[name='maduthao']").val(maduthao);
            form.find("[name='noidung']").val(noidung);
            form.find("[name='phanloai']").val(phanloai).trigger('change');
            form.find("[name='stt']").val(stt);
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh mục dự thảo quyết định, tờ trình</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('duthaoquyetdinh', 'thaydoi'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#modify-modal"
                        data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Phân loại dự thảo</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloai, 'Tất cả', 'ALL'), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Phân loại</th>
                                <th>Tên dự thảo</th>
                                <th width="15%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td style="text-align: center">{{ $i++ }}</td>
                                    <td>{{$a_phanloai[$ct->phanloai] ?? $ct->phanloai }}</td>
                                    <td>{{ $ct->noidung }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('duthaoquyetdinh', 'thaydoi'))
                                            <button type="button" title="Chỉnh sửa"
                                                onclick="edit('{{ $ct->maduthao }}','{{ $ct->noidung }}','{{ $ct->stt }}', '{{ $ct->phanloai }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-success"></i>
                                            </button>

                                            <a title="Dự thảo quyết định khen thưởng"
                                                href="{{ url($inputs['url'] . 'Xem?maduthao=' . $ct->maduthao) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-print text-success"></i>
                                            </a>

                                            <button title="Xóa thông tin" type="button"
                                                onclick="confirmDelete('{{ $ct->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash-alt text-danger"></i>
                                            </button>
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
                            <div class="col-md-12">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('maduthao', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Tên phân loại<span class="require">*</span></label>
                                {!! Form::text('noidung', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Phân loại dự thảo</label>
                                {!! Form::select('phanloai', $a_phanloai, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="control-label">Số thứ tự</label>
                                {!! Form::text('stt', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Theo dõi</label>
                                {!! Form::select('theodoi', getTrangThaiTheoDoi(), null, [
                                    'class' => 'form-control',
                                ]) !!}
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
