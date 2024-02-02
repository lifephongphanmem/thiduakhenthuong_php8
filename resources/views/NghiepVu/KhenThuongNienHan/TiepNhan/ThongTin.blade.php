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
                <h3 class="card-label text-uppercase">Tiếp nhận hồ sơ trình khen thưởng công trạng và thành tích</h3>
            </div>
            <div class="card-toolbar">
                {{-- @if (chkPhanQuyen('tnhosodenghikhenthuongcongtrang', 'thaydoi'))
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
                                {{-- <th>Ngày tạo</th> --}}
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
                                {{-- <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td> --}}
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan_hoso] ?? '' }}</td>

                                <td style="text-align: center">
                                    @include('NghiepVu._DungChung.TD_XemThongTinTDKT')
                                    @if (chkPhanQuyen('tnhosodenghikhenthuongcongtrang', 'thaydoi'))
                                        @include('NghiepVu._DungChung.TiepNhan.TD_TrangThai_CC')
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
    @include('includes.modal.modal_trinhhs')
    @include('includes.modal.modal_chuyenchuyenvien')
    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
