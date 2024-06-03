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
            TableManagedclass.init();
            $('#madonvi').change(function() {
                window.location.href = '/DangKyDanhHieu/HoSo/ThongTin?madonvi=' + $(
                    '#madonvi').val() + '&nam=' + $('#nam').val();
            });
            $('#nam').change(function() {
                window.location.href = '/DangKyDanhHieu/HoSo/ThongTin?madonvi=' + $(
                    '#madonvi').val() + '&nam=' + $('#nam').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ đăng ký danh hiệu thi đua</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dshosodangkythidua', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs mr-2" data-toggle="modal"
                        data-target="#tonghophoso-modal">
                        <i class="fa fa-plus"></i>&nbsp;Tổng hợp
                    </button>
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($m_diaban as $diaban)
                            <optgroup label="{{ $diaban->tendiaban }}">
                                <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="10%">Ngày tạo</th>
                                <th width="10%">Trạng thái</th>
                                <th width="15%">Đơn vị tiếp nhận</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    <a title="Hồ sơ đăng ký phong trào"
                                        href="{{ url('/DangKyDanhHieu/HoSo/Xem?mahosodk=' . $tt->mahosodk) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark"></i>
                                    </a>
                                    @if ($inputs['trangthai'] == 'CC')
                                        {{-- Quy trình cũ --}}
                                        @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                            <a title="Thông tin hồ sơ"
                                                href="{{ url('/DangKyDanhHieu/HoSo/Sua?mahosodk=' . $tt->mahosodk) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </a>

                                            <button title="Trình hồ sơ đăng ký" type="button"
                                                onclick="confirmChuyen('{{ $tt->mahosodk }}','/DangKyDanhHieu/HoSo/ChuyenHoSo')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#chuyen-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-share text-primary"></i>
                                            </button>

                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','/DangKyDanhHieu/HoSo/Xoa')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash text-danger"></i>
                                            </button>
                                        @endif

                                        @if ($tt->trangthai == 'BTL')
                                            <button title="Lý do hồ sơ bị trả lại" type="button"
                                                onclick="viewLyDo('{{ $tt->mahosodk }}','{{ $inputs['madonvi'] }}', '/DangKyDanhHieu/HoSo/LayLyDo')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-archive text-dark"></i>
                                            </button>
                                        @endif
                                    @else
                                        <a title="Thông tin hồ sơ"
                                            href="{{ url('/DangKyDanhHieu/HoSo/Sua?mahosodk=' . $tt->mahosodk) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                        </a>
                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','/DangKyDanhHieu/HoSo/Xoa')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i>
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
    <!--Modal Nhận hồ sơ-->
    {!! Form::open(['url' => '/DangKyDanhHieu/HoSo/Them', 'id' => 'frm_hoso']) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ đăng ký?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung hồ sơ</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <!--Modal tổng hợp hồ sơ-->
    {!! Form::open(['url' => $inputs['url_hs'] . 'ThemTongHop', 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    {{-- <input type="hidden" name="maloaihinhkt" value="{{ $inputs['maloaihinhkt'] }}" /> --}}

    <div id="tonghophoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ đăng ký?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-custom">
                                <div class="card-header card-header-tabs-line">
                                    <div class="card-toolbar">
                                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#kt_thongtinchung">
                                                    <span class="nav-icon">
                                                        <i class="fas fa-users"></i>
                                                    </span>
                                                    <span class="nav-text">Thông tin chung</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_hoso">
                                                    <span class="nav-icon">
                                                        <i class="fas fa-users"></i>
                                                    </span>
                                                    <span class="nav-text">Danh sách hồ sơ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-toolbar"></div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="kt_thongtinchung" role="tabpanel"
                                            aria-labelledby="kt_thongtinchung">

                                            <div class="form-group row">

                                                <div class="col-12">
                                                    <label>Ngày tạo hồ sơ</label>
                                                    {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label>Nội dung hồ sơ</label>
                                                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="kt_hoso" role="tabpanel"
                                            aria-labelledby="kt_hoso">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <table
                                                        class="table table-striped table-bordered table-hover dulieubang">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th width="2%">STT</th>
                                                                {{-- <th>Phân loại hồ sơ</th> --}}
                                                                <th>Đơn vị đề nghị</th>
                                                                <th>Nội dung hồ sơ</th>
                                                                <th width="8%">Ngày tháng</th>
                                                                <th width="8%">Trạng thái</th>
                                                                <th width="20%">Đơn vị tiếp nhận</th>
                                                                {{-- <th width="20%">Phân loại hồ sơ</th> --}}
                                                                <th width="8%">Thao tác</th>
                                                            </tr>
                                                        </thead>

                                                        <?php $i = 1; ?>
                                                        @foreach ($model_hoso as $key => $tt)
                                                            <tr>
                                                                <td class="text-center">{{ $i++ }}</td>
                                                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                                                <td>{{ $tt->noidung }}</td>
                                                                <td class="text-center">
                                                                    {{ getDayVn($tt->ngayhoso) }}
                                                                </td>
                                                                @include('includes.td.td_trangthai_hosotonghop')
                                                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>
                                                                {{-- <td>{{$a_phanloaihs[$tt->phanloai] ?? $tt->phanloai }}</td> --}}
                                                                <td class="text-center">
                                                                    <input type="checkbox"
                                                                        name="{{ 'hoso[' . $tt->mahosodk . ']' }}" />
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" onclick="chkThongTinHoSoTH()" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @include('includes.modal.modal-lydo')
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_approve_hs')
    {{-- @include('NghiepVu._DungChung.HoSo_TongHopHoSo') --}}
@stop
