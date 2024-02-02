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
                <h3 class="card-label text-uppercase">Danh sách phân trưởng cụm, khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dstruongcumkhoi', 'thaydoi'))
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
                                <th>Mô tả</th>
                                <th>Từ ngày</th>
                                <th>Đến ngày</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td class="active">{{ $tt->mota }}</td>

                                <td class=" text-center">{{ getDayVn($tt->ngaytu) }}</td>
                                <td class=" text-center">{{ getDayVn($tt->ngayden) }}</td>

                                <td class=" text-center">
                                    @if (chkPhanQuyen('dstruongcumkhoi', 'thaydoi'))
                                        <a title="Chỉnh sửa"
                                            href="{{ url($inputs['url'] . 'Sua?madanhsach=' . $tt->madanhsach) }}"
                                            class="btn btn-sm btn-clean btn-icon"><i
                                                class="icon-lg la fa-edit text-success"></i>
                                        </a>

                                        <a title="Chi tiết danh sách"
                                            href="{{ url($inputs['url'] . 'DanhSach/?madanhsach=' . $tt->madanhsach) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg flaticon-list-2 text-dark"></i>
                                        </a>                                       

                                        <button title="Tài liệu đính kèm" type="button"
                                            onclick="get_attack('{{ $tt->macumkhoi }}','{{ $inputs['url'] . 'TaiLieuDinhKem' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg flaticon-download text-dark"></i>
                                        </button>

                                        <button title="Xóa danh sách" type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash-alt text-danger"></i>
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
    @include('includes.modal.modal-delete')
@stop
