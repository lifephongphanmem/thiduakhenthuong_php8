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
                window.location.href = "{{ $inputs['url_qd'] }}" + 'DanhSach?madonvi=' + $('#madonvi')
                    .val() + '&macumkhoi=' + $('#macumkhoi').val() + '&nam=' + $('#nam')
                    .val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });

            $('#nam').change(function() {
                window.location.href = "{{ $inputs['url_qd'] }}" + 'DanhSach?madonvi=' + $('#madonvi')
                    .val() + '&macumkhoi=' + $('#macumkhoi').val() + '&nam=' + $('#nam')
                    .val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });

            $('#macumkhoi').change(function() {
                window.location.href = "{{ $inputs['url_qd'] }}" + 'DanhSach?madonvi=' + $('#madonvi')
                    .val() + '&macumkhoi=' + $('#macumkhoi').val() + '&nam=' + $('#nam')
                    .val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });

            $('#maloaihinhkt').change(function() {
                window.location.href = "{{ $inputs['url_qd'] }}" + 'DanhSach?madonvi=' + $('#madonvi')
                    .val() + '&macumkhoi=' + $('#macumkhoi').val() + '&nam=' + $('#nam')
                    .val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ đề nghị khen thưởng từ đơn vị cấp dưới</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('qdhosokhenthuongcumkhoi', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-5">
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
                <div class="col-md-5">
                    <label style="font-weight: bold">Loại hình khen thưởng</label>
                    {!! Form::select('nam', setArrayAll($a_loaihinhkt), $inputs['maloaihinhkt'], [
                        'id' => 'maloaihinhkt',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Cụm, khối thi đua</label>
                    <select class="form-control select2basic" id="macumkhoi">
                        @foreach ($m_cumkhoi as $cumkhoi)
                            <option {{ $cumkhoi->macumkhoi == $inputs['macumkhoi'] ? 'selected' : '' }}
                                value="{{ $cumkhoi->macumkhoi }}">{{ $cumkhoi->tencumkhoi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th width="15%">Tên đơn vị đề nghị</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                {{-- <th width="8%">Ngày tạo</th> --}}
                                <th width="8%">Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                {{-- <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td> --}}
                                @include('includes.td.td_trangthai_hoso')

                                <td style="text-align: center">
                                    <button type="button" title="In quyết định khen thưởng"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}','DKT',true)"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoCumKhoi')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark icon-2x"></i>
                                    </button>
                                    @if ($inputs['trangthai'] == 'CC')
                                        @if ($tt->trangthai == 'CXKT')
                                            @if (session('admin')->opt_duthaoquyetdinh)
                                                <a title="Tạo dự thảo quyết định khen thưởng" target="_blank"
                                                    href="{{ url('/DungChung/DuThao/QuyetDinhKhenThuong?mahosotdkt=' . $tt->mahosotdkt . '&phanloaihoso=' . $inputs['phanloaihoso']) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    {{-- class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}"> --}}
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a>
                                            @endif

                                            @if (chkPhanQuyen('qdhosokhenthuongcumkhoi', 'thaydoi'))
                                                <button title="Trả lại hồ sơ" type="button"
                                                    onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_qd'] . 'TraLai' }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai"
                                                    data-toggle="modal">
                                                    <i class="icon-lg la la-reply text-danger"></i>
                                                </button>
                                            @endif

                                            @if (chkPhanQuyen('qdhosokhenthuongcumkhoi', 'hoanthanh'))
                                                <a title="Phê duyệt hồ sơ khen thưởng"
                                                    href="{{ url($inputs['url_qd'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-interface-10 text-success"></i>
                                                </a>
                                            @endif
                                        @endif

                                        @if ($tt->trangthai == 'DKT' && chkPhanQuyen('qdhosokhenthuongcumkhoi', 'hoanthanh'))
                                            <button title="Hủy phê duyệt hồ sơ khen thưởng" type="button"
                                                onclick="setHuyPheDuyet('{{ $tt->mahosotdkt }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modal-HuyPheDuyet"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon-interface-10 text-danger"></i>
                                            </button>
                                        @endif
                                    @else
                                        @if ($tt->trangthai == 'CXKT' && chkPhanQuyen('qdhosokhenthuongcumkhoi', 'hoanthanh'))
                                            {{-- <a title="Tạo dự thảo tờ trình"
                                                href="{{ url($inputs['url_qd'] . 'ToTrinhPheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </a> --}}
                                            <a title="Phê duyệt hồ sơ khen thưởng"
                                                href="{{ url($inputs['url_qd'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                <i class="icon-lg la flaticon-interface-10 text-success"></i>
                                            </a>
                                        @endif

                                        @if ($tt->trangthai == 'DKT' && chkPhanQuyen('qdhosokhenthuongcumkhoi', 'hoanthanh'))
                                            <button title="Hủy phê duyệt hồ sơ khen thưởng" type="button"
                                                onclick="setHuyPheDuyet('{{ $tt->mahosotdkt }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modal-HuyPheDuyet"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon-interface-10 text-danger"></i>
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

    <!--Modal Tạo hồ sơ-->
    {!! Form::open(['url' => $inputs['url_qd'] . 'Them', 'id' => 'frm_hoso']) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <input type="hidden" name="macumkhoi" value="{{ $inputs['macumkhoi'] }}" />
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ trình khen thưởng?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Loại hình khen thưởng</label>
                            {!! Form::select('maloaihinhkt', $a_loaihinhkt, $inputs['maloaihinhkt'], ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Số tờ trình</label>
                            {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Chức vụ người ký tờ trình</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Họ tên người ký tờ trình</label>
                            {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung trình khen thưởng</label>
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

    @include('NghiepVu._DungChung.InDuLieu')
    @include('NghiepVu._DungChung.modal_KhenThuong')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal-delete')
@stop
