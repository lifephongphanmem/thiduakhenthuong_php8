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
            TableManaged4.init();
            TableManaged5.init();
            TableManagedclass.init();
        });       
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ khen thưởng</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Tên phong trào</label>
                    <textarea class="form-control" readonly>{{ $m_phongtrao->noidung }}</textarea>
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Tên đơn vị trình</th>
                                <th>Phân loại hồ sơ</th>
                                <th>Nội dung hồ sơ</th>
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
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>

                                <td style="text-align: center">
                                    @include('NghiepVu._DungChung.TD_XemThongTinTDKT')
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ '/PhongTraoThiDua/ThongTin?madonvi=' . $inputs['madonvi'].'&nam=ALL&phuongthuctochuc=ALL' }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal_huypheduyet')
    {{-- @include('includes.modal.modal_accept_hs') --}}
    {{-- @include('includes.modal.modal_nhanvatrinhkt_hs') --}}
    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal_attackfile')
    {{-- @include('includes.modal.modal-lydo') --}}
@stop
