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
            $('#madonvi,#nam,#macumkhoi').change(function() {
                window.location.href = "{{ $inputs['url_xd'] }}" + 'ThongTin?madonvi=' + $('#madonvi')
                    .val() + '&nam=' + $('#nam').val() + '&macumkhoi=' + $('#macumkhoi').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ đề nghị khen thưởng từ đơn vị cấp dưới</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-9">
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
                <div class="col-md-9">
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
                                <th width="15%">Tên đơn vị</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                <th width="8%">Ngày tạo</th>
                                <th width="8%">Trạng thái</th>
                                <th width="15%">Đơn vị tiếp nhận</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>

                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthai }}', true)"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoCumKhoi')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>

                                    @if ($inputs['trangthai'] == 'CC')
                                        @if (chkPhanQuyen('xdhosokhenthuongcumkhoi', 'thaydoi'))
                                            @if (in_array($tt->trangthai_hoso, ['CD']))
                                                <button title="Tiếp nhận hồ sơ" type="button"
                                                    onclick="confirmNhan('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'NhanHoSo' }}','{{ $inputs['madonvi'] }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm"
                                                    data-toggle="modal">
                                                    <i class="icon-lg flaticon-interface-5 text-success"></i>
                                                </button>
                                            @endif

                                            @if (in_array($tt->trangthai_hoso, ['DD', 'BTLXD']))
                                                <a href="{{ url($inputs['url_xd'] . 'XetKT?mahosotdkt=' . $tt->mahosotdkt . '&madonvi=' . $inputs['madonvi']) }}"
                                                    class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                    title="Thông tin hồ sơ khen thưởng">
                                                    <span class="svg-icon svg-icon-xl">
                                                        <i class="icon-lg la flaticon-list text-success"></i>
                                                    </span>
                                                    <span
                                                        class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
                                                </a>
                                                @if (session('admin')->opt_duthaototrinh)
                                                    <a title="Tạo dự thảo tờ trình kết quả khen thưởng" target="_blank"
                                                        href="{{ url('/DungChung/DuThao/ToTrinhKetQuaKhenThuong?mahosotdkt=' . $tt->mahosotdkt . '&phanloaihoso=' . $inputs['phanloaihoso']) }}"
                                                        class="btn btn-sm btn-clean btn-icon">
                                                        {{-- class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}"> --}}
                                                        <i class="icon-lg la flaticon-clipboard text-success"></i>
                                                    </a>
                                                @endif

                                                <a title="Tờ trình kết quả khen thưởng"
                                                    href="{{ url($inputs['url_xd'] . 'TrinhKetQua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg la flaticon-list-1 text-success"></i>
                                                </a>

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
                                                    <i class="icon-lg la fa-archive text-dark"></i>
                                                </button>
                                            @endif

                                            @if (in_array($tt->trangthai_hoso, ['DD', 'CD', 'BTLXD']) ||
                                                    (in_array($tt->trangthai_hoso, ['CXKT', 'DKT']) && $tt->madonvi_kt == ''))
                                                <!-- Bổ sung đk đơn vị nhận rỗng để trả lại hồ sơ -->
                                                <button title="Trả lại hồ sơ" type="button"
                                                    onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai"
                                                    data-toggle="modal">
                                                    <i class="icon-lg la la-reply text-danger"></i>
                                                </button>
                                            @endif
                                        @endif
                                    @else
                                        @if (in_array($tt->trangthai, ['CXKT']))
                                            @if (in_array($tt->trangthai_hoso, ['DD', 'CD', 'CXKT']))
                                                <button title="Trả lại hồ sơ" type="button"
                                                    onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai"
                                                    data-toggle="modal">
                                                    <i class="icon-lg la la-reply text-danger"></i>
                                                </button>
                                            @endif
                                            @if (session('admin')->opt_duthaototrinh)
                                                <a title="Tạo dự thảo tờ trình"
                                                    href="{{ url($inputs['url_xd'] . 'ToTrinhPheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a>
                                            @endif
                                            @if (session('admin')->opt_duthaoquyetdinh)
                                                <a title="Tạo dự thảo quyết định khen thưởng"
                                                    href="{{ url($inputs['url_xd'] . 'QuyetDinh?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a>
                                            @endif
                                            <a title="Trình kết quả khen thưởng"
                                                href="{{ url($inputs['url_xd'] . 'TrinhKetQua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la flaticon-list-1 text-success"></i>
                                            </a>
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
    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
