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
        });

        function setNhomTK(manhomchucnang, tennhomchucnang, stt) {
            var form = $('#frm_modify');
            form.find("[name='manhomchucnang']").val(manhomchucnang);
            form.find("[name='tennhomchucnang']").val(tennhomchucnang);
            form.find("[name='stt']").val(stt);

        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách {{ chkGiaoDien('dsnhomtaikhoan', 'tenchucnang') }}</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsnhomtaikhoan', 'thaydoi'))
                    <button type="button" onclick="setNhomTK('','', '{{ count($model) }}')" class="btn btn-success btn-xs"
                        data-target="#modify-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th>Tên nhóm chức năng</th>
                                <th width="15%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach ($model as $tt)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $tt->tennhomchucnang }}</td>
                                    <td class="text-center">
                                        <button
                                            onclick="setNhomTK('{{ $tt->manhomchucnang }}','{{ $tt->tennhomchucnang }}','{{ $tt->stt }}',)"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                            title="Thay đổi thông tin địa bàn" data-toggle="modal">
                                            <i class="icon-lg flaticon-edit-1 text-info"></i>
                                        </button>

                                        <a title="Phân quyền"
                                            href="{{ url('/NhomChucNang/PhanQuyen?manhomchucnang=' . $tt->manhomchucnang) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg flaticon2-user-1 text-primary"></i>
                                        </a>
                                       
                                        <a href="{{ url('/NhomChucNang/DanhSach?manhomchucnang=' . $tt->manhomchucnang) }}"
                                            class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                            title="Danh sách đơn vị trong nhóm">
                                            <span class="svg-icon svg-icon-xl">
                                                <i class="icon-lg la flaticon-list-2 text-dark"></i>
                                            </span>
                                            <span
                                                class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluong }}</span>
                                        </a>
                                        <button title="Xóa thông tin" type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','/NhomChucNang/Xoa')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg flaticon-delete text-danger"></i>
                                        </button>
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

    {!! Form::open(['url' => 'NhomChucNang/Sua', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin nhóm chức năng tài khoản</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('manhomchucnang', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Tên nhóm chức năng<span class="require">*</span></label>
                                {!! Form::text('tennhomchucnang', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label class="control-label">Số thứ tự</label>
                                {!! Form::text('stt', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" value="submit" class="btn btn-primary">Đồng
                        ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('includes.modal.modal-delete')
@stop
