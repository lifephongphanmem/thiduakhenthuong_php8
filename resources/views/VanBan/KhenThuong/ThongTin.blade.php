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
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách quyết định khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('quyetdinhkhenthuong', 'thaydoi'))
                    <a type="button" href="{{ url('/QuanLyVanBan/KhenThuong/Them') }}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Cấp độ khen thưởng</label>
                    {!! Form::select('capkhenthuong', setArrayAll($a_phamvi), null, [
                        'id' => 'capkhenthuong',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th width="15%">Đơn vị ban hành</th>
                                <th>Số hiệu<br>văn bản</th>
                                <th>Nội dung</th>
                                <th>Loại hình khen thưởng</th>
                                <th>Cấp độ</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td class="active">{{ $tt->donvikhenthuong }}</td>
                                    <td class="text-center">{{ $tt->soqd }}<br>{{ getDayVn($tt->ngayqd) }}</td>
                                    <td>{{ $tt->tieude }}</td>
                                    <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? $tt->maloaihinhkt }}</td>
                                    <td style="text-align: center">{{ $a_phamvi[$tt->capkhenthuong] ?? '' }}</td>
                                    <td class="text-center">
                                        <button type="button"
                                            onclick="get_attack('{{ $tt->maquyetdinh }}','{{ $inputs['url'] . 'TaiLieuDinhKem' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la flaticon-download text-dark"></i></button>

                                        @if (chkPhanQuyen('quyetdinhkhenthuong', 'thaydoi'))
                                            <a href="{{ url($inputs['url'] . 'Sua?maquyetdinh=' . $tt->maquyetdinh) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </a>

                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon-delete text-danger"></i>
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
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-delete')
@stop
