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
            $('#madonvi, #nam, #phanloai').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + "ThongTin?madonvi=" + $(
                    '#madonvi').val() + "&nam=" + $('#nam').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng theo công trạng và thành tích</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs mr-2" data-toggle="modal"
                        data-target="#tonghophoso-modal">
                        <i class="fa fa-plus"></i>&nbsp;Tổng hợp
                    </button>
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới
                    </button>
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

                {{-- <div class="col-5">
                    <label style="font-weight: bold">Phân loại hồ sơ</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloaihs, 'Tất cả', 'ALL'), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div> --}}

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
                                <th width="20%">Phân loại hồ sơ</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="8%">Ngày tháng</th>
                                <th width="8%">Trạng thái</th>
                                <th width="20%">Đơn vị tiếp nhận</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{$a_phanloaihs[$tt->phanloai] ?? $tt->phanloai }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">{{ $tt->sototrinh }}<br>{{ getDayVn($tt->ngayhoso) }}
                                </td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    {{-- 21/02/2023 gộp các chức năng
                                         <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthai }}', '{{ $inputs['trangthai'] == 'CC' ? false : true }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '{{ $inputs['url_hs'] . 'TaiLieuDinhKem' }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button> --}}

                                    @include('NghiepVu._DungChung.TD_XemThongTinTDKT')

                                    @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']) && chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi'))
                                        @if (in_array($inputs['trangthai'], ['CC', 'CD']))
                                            {{-- Trường hợp cũ đầy đủ quy trình --}}
                                            @include('NghiepVu._DungChung.HoSo.TD_TrangThai_CC')
                                        @else
                                            {{-- Trường hợp gộp các quy trình vào làm một để chỉ theo dõi hồ sơ --}}
                                            @include('NghiepVu._DungChung.HoSo.TD_TrangThai_CXKT')
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

    @include('NghiepVu._DungChung.modal_PheDuyet')
    @include('NghiepVu._DungChung.HoSo_TaoHoSo')
    @include('NghiepVu._DungChung.HoSo_TongHopHoSo')
    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_chuyenhs')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
