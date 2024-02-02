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
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách cụm, khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dscumkhoithidua', 'thaydoi'))
                    <a href="{{ url($inputs['url'] . 'Them') }}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên cụm, khối thi đua</th>
                                <th>Đơn vị quản</br>lý hồ sơ</th>
                                <th>Đơn vị xét</br>duyệt hồ sơ</th>
                                <th>Đơn vị phê</br>duyệt khen thưởng</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td class="active">{{ $tt->tencumkhoi }}</td>
                                <td>{{ $a_donvi[$tt->madonviql] ?? '' }}</td>
                                <td>{{ $a_donvi[$tt->madonvixd] ?? '' }}</td>
                                <td>{{ $a_donvi[$tt->madonvikt] ?? '' }}</td>
                                <td class=" text-center">
                                    @if (chkPhanQuyen('dscumkhoithidua', 'thaydoi'))
                                        <a title="Chỉnh sửa"
                                            href="{{ url($inputs['url'] . 'Sua?macumkhoi=' . $tt->macumkhoi) }}"
                                            class="btn btn-sm btn-clean btn-icon"><i
                                                class="icon-lg flaticon-edit-1 text-primary"></i>
                                        </a>

                                        <a href="{{ url($inputs['url'] . 'DanhSach/?macumkhoi=' . $tt->macumkhoi) }}"
                                            class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                            title="Danh sách đơn vị">
                                            <span class="svg-icon svg-icon-xl">
                                                <i class="icon-lg flaticon-list-2 text-dark"></i>
                                            </span>
                                            <span
                                                class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->sodonvi }}</span>
                                        </a>

                                        <button title="Tài liệu đính kèm" type="button"
                                            onclick="get_attack('{{ $tt->macumkhoi }}','{{ $inputs['url'] . 'TaiLieuDinhKem' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg flaticon-download text-dark"></i>
                                        </button>

                                        <button title="Xóa cụm khối" type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la flaticon-delete text-danger"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    

    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-delete')
@stop
