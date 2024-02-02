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
            $('#madonvi, #nam, #phanloai, #trangthaihoso').change(function() {
                window.location.href = "{{ $inputs['url_xd'] }}" + 'ThongTin?madonvi=' + $('#madonvi')
                    .val() + '&nam=' + $('#nam').val() + "&phanloai=" + $('#phanloai').val() +
                    "&trangthaihoso=" + $('#trangthaihoso').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng theo chuyên đề</h3>
            </div>
            <div class="card-toolbar">
                {{-- @if (chkPhanQuyen('xdhosodenghikhencao', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif --}}
            </div>
        </div>
        <div class="card-body">
            @include('NghiepVu._DungChung.ROW_LocHocSo')

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Tên đơn vị trình</th>
                                <th>Phân loại hồ sơ</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="8%">Ngày tạo</th>
                                <th width="8%">Trạng thái</th>
                                <th>Đơn vị tiếp nhận</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td>{{ $a_phanloaihs[$tt->phanloai] ?? $tt->phanloai }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan_xd] ?? '' }}</td>

                                <td style="text-align: center">
                                    @include('NghiepVu._DungChung.TD_XemThongTinTDKT')

                                    @if (chkPhanQuyen('xdhosodenghikhencao', 'thaydoi'))
                                        @if (in_array($tt->trangthai_hoso, ['CD']))
                                            <button title="Tiếp nhận hồ sơ" type="button"
                                                onclick="confirmNhan('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'NhanHoSo' }}','{{ $inputs['madonvi'] }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg flaticon-interface-5 text-success"></i>
                                            </button>
                                        @endif

                                        @if (in_array($tt->trangthai_hoso, ['DD', 'BTLXD']))
                                            <button title="Chuyển phê duyệt khen thưởng" type="button"
                                                onclick="confirmNhanvaTKT('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
                                                class="btn btn-sm btn-clean btn-icon"
                                                {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
                                                data-target="#nhanvatkt-modal" data-toggle="modal">
                                                <i class="icon-lg la fa-share-square text-success"></i>
                                            </button>
                                        @endif

                                        @if ($tt->trangthai_hoso == 'BTLXD')
                                            <button title="Lý do hồ sơ bị trả lại" type="button"
                                                onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'LayLyDo' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon2-information text-dark"></i>
                                            </button>
                                        @endif

                                        @if (in_array($tt->trangthai_hoso, ['DD', 'CD', 'BTLXD']))
                                            <button title="Trả lại hồ sơ" type="button"
                                                onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai"
                                                data-toggle="modal">
                                                <i class="icon-lg la la-reply text-danger"></i>
                                            </button>
                                        @endif
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

    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal_accept_hs')
    @include('includes.modal.modal_nhanvatrinhkt_hs')
    @include('NghiepVu._DungChung.InDuLieu_KhenCao')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
