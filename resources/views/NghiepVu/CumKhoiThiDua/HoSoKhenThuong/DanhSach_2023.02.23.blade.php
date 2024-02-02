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
            $('#madonvi,#nam,#macumkhoi,#maloaihinhkt').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + 'DanhSach?madonvi=' + $('#madonvi')
                    .val() + '&nam=' + $('#nam').val() + '&macumkhoi=' + $('#macumkhoi').val() +
                    '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ đề nghị khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button -->
                @if (chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'thaydoi') && $inputs['truongcumkhoi'])
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
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
                                <th>Nội dung hồ sơ</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                <th width="8%">Ngày tạo</th>
                                <th width="8%">Trạng thái</th>
                                <th>Đơn vị tiếp nhận</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}','{{ $tt->maphongtraotd }}', '{{ $tt->trangthai }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoKhenCao')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>
                                    @if ($inputs['trangthai'] == 'CC')
                                        @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                            <a title="Hồ sơ đăng ký phong trào"
                                                href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </a>

                                            @if ($tt->trangthai == 'BTL')
                                                <button title="Lý do hồ sơ bị trả lại" type="button"
                                                    onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_hs'] . 'LayLyDo' }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                                    data-toggle="modal">
                                                    <i class="icon-lg la fa-archive text-dark"></i>
                                                </button>
                                            @endif

                                            <button title="Trình hồ sơ đăng ký" type="button"
                                                onclick="confirmChuyen('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'ChuyenHoSo' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#chuyen-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-share text-primary"></i>
                                            </button>

                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash text-danger"></i>
                                            </button>
                                        @endif
                                    @else
                                        {{-- Trường hợp gộp các quy trình vào làm một để chỉ theo dõi hồ sơ --}}
                                        @if (in_array($tt->trangthai, ['CXKT', 'CC', 'BTL', 'CXD']))
                                            @if (chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'thaydoi'))
                                                <a href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                    title="Thông tin hồ sơ khen thưởng">
                                                    <span class="svg-icon svg-icon-xl">
                                                        <i class="icon-lg la flaticon-list text-success"></i>
                                                    </span>
                                                    <span
                                                        class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
                                                </a>

                                                <a title="Tạo dự thảo tờ trình"
                                                    href="{{ url($inputs['url_hs'] . 'ToTrinhHoSo?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a>

                                                {{-- <a title="Tạo dự thảo quyết định khen thưởng"
                                                    href="{{ url($inputs['url_hs'] . 'QuyetDinh?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a> --}}

                                                <button type="button"
                                                    onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
                                                    class="btn btn-sm btn-clean btn-icon"
                                                    data-target="#delete-modal-confirm" data-toggle="modal">
                                                    <i class="icon-lg la fa-trash text-danger"></i>
                                                </button>
                                            @endif
                                            {{-- @if (chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'hoanthanh'))
                                                <a title="Phê duyệt hồ sơ khen thưởng"
                                                    href="{{ url($inputs['url_hs'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-interface-10 text-success"></i>
                                                </a>
                                            @endif --}}
                                        @endif

                                        {{-- @if ($tt->trangthai == 'DKT' && chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'hoanthanh'))
                                            <button title="Hủy phê duyệt hồ sơ khen thưởng" type="button"
                                                onclick="setHuyPheDuyet('{{ $tt->mahosotdkt }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modal-HuyPheDuyet"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon-interface-10 text-danger"></i>
                                            </button>
                                        @endif --}}
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

    <!--Modal Thêm mới hồ sơ-->
    {!! Form::open(['url' => $inputs['url_hs'] . 'Them', 'id' => 'frm_hoso']) !!}
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
                        <div class="col-6">
                            <label>Loại hình khen thưởng</label>
                            {!! Form::select('maloaihinhkt', $a_loaihinhkt, $inputs['maloaihinhkt'], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-6">
                            <label>Trạng thái hồ sơ</label>
                            {!! Form::select('trangthai', getTrangThaiChucNangHoSo($inputs['trangthai']), $inputs['trangthai'], [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    @if ($inputs['trangthai'] != 'CC')
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
                        <div class="col-6">
                            <label>Số tờ trình</label>
                            {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label>Chức vụ người ký tờ trình</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
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

                    {{-- <div class="form-group row">
                        <div class="col-12">
                            <label>Tờ trình: </label>
                            {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                        </div>

                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" onclick="chkThongTinHoSo()" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <script>
        function getDonViKhenThuong_ThemHS(e) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/DungChung/getDonViKhenThuong_ThemHS",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madonvi: e.val(),
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#donvikhenthuong').replaceWith(data.message);
                    }
                }
            });
        }

        function chkThongTinHoSo() {
            var ok = true,
                message = '';

            if ($('#madonvi_xd_themhs')[0] && $('#madonvi_xd_themhs').val() == 'ALL') {
                ok = false;
                message += 'Đơn vị xét duyệt đề nghị không được bỏ trống. \n';
            }

            if ($('#madonvi_kt_themhs')[0] && $('#madonvi_kt_themhs').val() == 'ALL') {
                ok = false;
                message += 'Đơn vị phê duyệt đề nghị không được bỏ trống. \n';
            }

            //Kết quả
            if (ok == false) {
                toastr.error(message, "Lỗi!");
                $("#frm_hoso").submit(function(e) {
                    e.preventDefault();
                });
            } else {
                $("#frm_hoso").unbind('submit').submit();
            }
        }
    </script>

    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_approve_hs')
    @include('NghiepVu._DungChung.modal_PheDuyet')
    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
