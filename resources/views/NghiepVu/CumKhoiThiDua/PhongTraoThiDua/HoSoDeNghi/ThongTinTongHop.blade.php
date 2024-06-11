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
                window.location.href = "{{ $inputs['url_hs'] }}" + 'ThongTin?madonvi=' + $('#madonvi')
                    .val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách cụm khối thi đua của đơn vị</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                {{-- @if (chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi')) --}}
                <button type="button" class="btn btn-success btn-xs mr-2" data-toggle="modal"
                    data-target="#tonghophoso-modal">
                    <i class="fa fa-plus"></i>&nbsp;Tổng hợp
                </button>
                {{-- <a href="{{$inputs['url_hs'].'TongHopHoSo'}}" class="btn btn-success btn-xs mr-2"><i class="fa fa-plus">Tổng hợp</a> --}}
                {{-- @endif --}}
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
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
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th witdt="8%">Đơn vị</th>
                                <th>nội dung</th>
                                <th width="8%">Trạng thái</th>
                                {{-- <th width="30%">Nội dung phong trào thi đua</th> --}}
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td class="active">{{ $a_dsdonvi[$tt->madonvi] ?? '' }}</td>
                                <td class=" text-center">{{ $tt->noidung }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                {{-- @include('includes.td.td_trangthai_khenthuong') --}}
                                {{-- <td>{{$tt->noidungphongtrao}}</td> --}}
                                <td class=" text-center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahoso }}','{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthaikt }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoDeNghiCumKhoi')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>

                                    @if (chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'hoanthanh') &&
                                            in_array($tt->trangthai, ['CC','BTL']))
                                        <a href="{{ url($inputs['url_hs'] . 'XetKT?mahosotdkt=' . $tt->mahosotdkt . '&madonvi=' . $inputs['madonvi']) }}"
                                            class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                            title="Thông tin hồ sơ khen thưởng">
                                            <span class="svg-icon svg-icon-xl">
                                                <i class="icon-lg la flaticon-list text-success"></i>
                                            </span>
                                            <span
                                                class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
                                        </a>

                                        @if (session('admin')->opt_duthaototrinh)
                                            <a title="Tạo dự thảo đề nghị khen thưởng" target="_blank"
                                                href="{{ url('/DungChung/DuThao/ToTrinhDeNghiKhenThuong?mahosotdkt=' . $tt->mahosotdkt . '&phanloaihoso=' . $inputs['phanloaihoso']) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                {{-- class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}"> --}}
                                                <i class="icon-lg la flaticon-clipboard text-success"></i>
                                            </a>
                                        @endif

                                        <button title="Chuyển phê duyệt khen thưởng" type="button"
                                            onclick="confirmNhanvaTKT('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
                                            class="btn btn-sm btn-clean btn-icon"
                                            {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
                                            data-target="#nhanvatkt-modal" data-toggle="modal">
                                            <i class="icon-lg la fa-share-square text-success"></i>
                                        </button>
                                        @if (chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'thaydoi'))
                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'XoaHoSoKT' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg flaticon-delete text-danger"></i>
                                            </button>
                                        @endif
                                    @endif
                                    @if ($tt->trangthai == 'BTL')
                                        <button title="Lý do hồ sơ bị trả lại" type="button"
                                            onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '/CumKhoiThiDua/DeNghiThiDua/LayLyDo' )"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-archive text-dark"></i>
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
    {!! Form::open(['url' => $inputs['url_hs'] . 'ThemTongHop', 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <input type="hidden" name="maloaihinhkt" value="{{ $inputs['maloaihinhkt'] }}" />

    <div id="tonghophoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ trình khen thưởng?</h4>
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
                                            @if (!in_array($inputs['trangthai'], ['CC', 'CD']))
                                                <div class="form-group row">
                                                    <div id="donvixetduyet" class="col-6">
                                                        <label>Đơn vị xét duyệt</label>
                                                        {!! Form::select('madonvi_xd', setArrayAll($a_donviql, 'Chọn đơn vị', 'ALL'), 'ALL', [
                                                            'onchange' => 'getDonViKhenThuong_ThemHS($(this))',
                                                            'id' => 'madonvi_xd_themhs',
                                                            'class' => 'form-control select2_modal',
                                                            'required',
                                                        ]) !!}
                                                    </div>

                                                    <div id="donvikhenthuong" class="col-6">
                                                        <label>Đơn vị khen thưởng</label>
                                                        {!! Form::select('madonvi_kt', ['ALL' => 'Chọn đơn vị'], null, [
                                                            'id' => 'madonvi_kt_themhs',
                                                            'class' => 'form-control select2_modal',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Trạng thái hồ sơ</label>
                                                    {!! Form::select('trangthai', getTrangThaiChucNangHoSo($inputs['trangthai']), $inputs['trangthai'], [
                                                        'class' => 'form-control',
                                                    ]) !!}
                                                </div>
                                                @if (isset($inputs['khangchien']))
                                                    <div class="col-4">
                                                        <label>Phân loại hồ sơ</label>
                                                        {!! Form::select('phanloai', getPhanLoaiHoSo(isset($inputs['khangchien']) ? 'KHANGCHIEN' : 'KHENTHUONG'), null, [
                                                            'class' => 'form-control',
                                                        ]) !!}
                                                    </div>
                                                @endif
                                                <div class="col-4">
                                                    <label>Ngày tạo hồ sơ</label>
                                                    {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Số tờ trình</label>
                                                    {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                                                </div>
                                                <div class="col-4">
                                                    <label>Chức vụ người ký tờ trình</label>
                                                    {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                                                </div>
                                                <div class="col-4">
                                                    <label>Họ tên người ký tờ trình</label>
                                                    {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label>Nội dung trình khen thưởng</label>
                                                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
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
                                                                {{-- <th width="20%">Đơn vị tiếp nhận</th> --}}
                                                                <th width="20%">Phân loại hồ sơ</th>
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
                                                                    {{ $tt->sototrinh }}<br>{{ getDayVn($tt->ngayhoso) }}
                                                                </td>
                                                                @include('includes.td.td_trangthai_hosotonghop')
                                                                {{-- <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td> --}}
                                                                <td>{{ $a_phanloaihs[$tt->phanloai] ?? $tt->phanloai }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="checkbox"
                                                                        name="{{ 'hoso[' . $tt->mahosotdkt . ']' }}" />
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


    {!! Form::open(['url' => '', 'id' => 'frm_delete']) !!}
    <div id="delete-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý xoá?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    <input type="hidden" name="mahosotdkt" />
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickdelete()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <script>
        function confirmDelete(mahosotdkt, url) {
            $('#frm_delete').attr('action', url);
            $('#frm_delete').find("[name='mahosotdkt']").val(mahosotdkt);
        }

        function clickdelete() {
            $('#frm_delete').submit();
        }

        function confirmKhenThuong(maphongtraotd, macumkhoi) {
            $('#frm_hoso').find("[name='maphongtraotd']").val(maphongtraotd).trigger('change');
            $('#frm_hoso').find("[name='macumkhoi']").val(macumkhoi);
        }
    </script>

    @include('NghiepVu.ThiDuaKhenThuong._DungChung.InDuLieu_CumKhoi')
    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal_accept_hs')
    @include('includes.modal.modal_nhanvatrinhkt_hs')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
