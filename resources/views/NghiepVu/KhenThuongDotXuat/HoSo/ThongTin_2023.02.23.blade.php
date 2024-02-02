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
            $('#madonvi, #nam, #phanloai').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + "ThongTin?madonvi=" + $(
                    '#madonvi').val() + "&nam=" + $('#nam').val() + "&phanloai=" + $('#phanloai').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ đề nghị khen thưởng đột xuất</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dshosodenghikhenthuongdotxuat', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-5">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($a_diaban as $key => $val)
                            <optgroup label="{{ $val }}">
                                <?php $donvi = $m_donvi->where('madiaban', $key); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="col-5">
                    <label style="font-weight: bold">Phân loại hồ sơ</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloaihs, 'Tất cả', 'ALL'), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>

                <div class="col-2">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                {{-- <th>Phân loại hồ sơ</th> --}}
                                <th>Nội dung hồ sơ</th>
                                {{-- <th width="15%">Loại hình khen thưởng</th> --}}
                                <th width="8%">Ngày tạo</th>
                                <th width="8%">Trạng thái</th>
                                <th>Đơn vị tiếp nhận</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                {{-- <td>{{ $a_phanloaihs[$tt->phanloai] ?? $tt->phanloai }}</td> --}}
                                <td>{{ $tt->noidung }}</td>
                                {{-- <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td> --}}
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthai }}', '{{ $inputs['trangthai'] == 'CC' ? false : true }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoKhenThuong')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>

                                    @if ($inputs['trangthai'] == 'CC')
                                        {{-- Trường hợp cũ đầy đủ quy trình --}}
                                        @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']) && chkPhanQuyen('dshosodenghikhenthuongdotxuat', 'thaydoi'))
                                            <a title="Thông tin hồ sơ"
                                                href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </a>

                                            <a title="Tạo dự thảo tờ trình"
                                                    href="{{ url($inputs['url_hs'] . 'ToTrinhHoSo?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a>

                                            <button title="Trình hồ sơ đăng ký" type="button"
                                                onclick="confirmChuyen('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'ChuyenHoSo' }}', '{{ $tt->phanloai }}')"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-share text-primary"></i>
                                            </button>

                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash text-danger"></i>
                                            </button>
                                        @endif

                                        @if ($tt->trangthai == 'BTL')
                                            <button title="Lý do hồ sơ bị trả lại" type="button"
                                                onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_hs'] . 'LayLyDo' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-archive text-info"></i></button>
                                        @endif
                                    @else
                                        {{-- Trường hợp gộp các quy trình vào làm một để chỉ theo dõi hồ sơ --}}
                                        @if (in_array($tt->trangthai, ['CXKT', 'CC', 'BTL', 'CXD']))
                                            @if (chkPhanQuyen('dshosodenghikhenthuongdotxuat', 'thaydoi'))
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
                                            {{-- @if (chkPhanQuyen('dshosodenghikhenthuongdotxuat', 'hoanthanh'))
                                                <a title="Phê duyệt hồ sơ khen thưởng"
                                                    href="{{ url($inputs['url_hs'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-interface-10 text-success"></i>
                                                </a>
                                            @endif --}}
                                        @endif

                                        {{-- @if ($tt->trangthai == 'DKT' && chkPhanQuyen('dshosodenghikhenthuongdotxuat', 'hoanthanh'))
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

    @include('NghiepVu._DungChung.modal_PheDuyet')
    @include('NghiepVu._DungChung.HoSo_TaoHoSo')
    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_chuyenhs')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
