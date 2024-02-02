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
            $('#madonvi').change(function() {
                window.location.href = '/XetDuyetHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
            $('#nam').change(function() {
                window.location.href = '/XetDuyetHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ thi đua từ đơn vị cấp dưới</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Tên phong trào</label>
                    <textarea class="form-control" readonly>{{ $m_phongtrao->noidung }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_4">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên đơn vị đăng ký</th>
                                <th>Nội dung hồ sơ</th>
                                <th>Đăng ký<br>thi đua</th>
                                <th>Trạng thái</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">
                                    @if ($tt->mahosodk)
                                        <a title="Thông tin hồ sơ đăng ký thi đua"
                                            href="{{ url('/DangKyDanhHieu/HoSo/Xem?mahosodk=' . $tt->mahosodk) }}"
                                            class="btn btn-sm btn-clean btn-icon" target="_blank">
                                            <i class="icon-lg la fa-eye text-dark"></i>
                                        </a>
                                    @else
                                        Chưa đăng ký
                                    @endif
                                </td>
                                @include('includes.td.td_trangthai_hoso')
                                <td class="text-center">
                                    <a title="Thông tin hồ sơ"
                                        href="{{ url('/HoSoThiDua/Xem?mahosothamgiapt=' . $tt->mahosothamgiapt) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark"></i>
                                    </a>
                                    
                                    @if ($tt->nhanhoso == 'DANGNHAN')
                                        @if (in_array($tt->trangthai_hoso, ['CD', 'CNXKT', 'CC']))
                                            <button title="Nhận hồ sơ đăng ký" type="button"
                                                onclick="confirmNhan('{{ $tt->mahosothamgiapt }}','/XetDuyetHoSoThiDua/NhanHoSo','{{ $inputs['madonvi'] }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg flaticon-interface-5 text-success"></i>
                                            </button>
                                        @endif
                                        <button title="Trả lại hồ sơ" type="button"
                                            onclick="confirmTraLai('{{ $tt->mahosothamgiapt }}', '{{ $inputs['madonvi'] }}', '/XetDuyetHoSoThiDua/TraLai')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai"
                                            data-toggle="modal">
                                            <i class="icon-lg la la-reply text-danger"></i>
                                        </button>
                                    @endif
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
                    <a href="{{ url('/HoSoDeNghiKhenThuongThiDua/ThongTin?madonvi=' . $inputs['madonvi']) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal_accept_hs')
@stop
