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
                window.location.href = "{{ $inputs['url_hs'] }}" + 'ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
            $('#nam').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + 'ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
            $('#maloaihinhkt').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + 'ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ khen cao của chính phủ</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dshosokhencaochinhphu', 'thaydoi'))
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

            {{-- <div class="form-group row">                
                <div class="col-md-6">
                    <label style="font-weight: bold">Cấp độ hồ sơ khen thưởng</label>
                    {!! Form::select('capkhenthuong', setArrayAll($a_phamvi), $inputs['capkhenthuong'], [
                        'id' => 'capkhenthuong',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-md-6">
                    <label style="font-weight: bold">Phân loại hồ sơ khen thưởng</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloaidt), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th width="10%">Cấp độ khen thưởng</th>
                                <th width="15%">Hình thức khen thưởng</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="8%">Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $a_phamvi[$tt->capkhenthuong] ?? $tt->capkhenthuong }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? $tt->maloaihinhkt }}</td>
                                <td>{{ $tt->noidung }}</td>
                                @include('includes.td.td_trangthai_hoso')

                                <td style="text-align: center">
                                    <button type="button" title="In quyết định khen thưởng"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}','DKT',false)"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>
                                    
                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '{{ $inputs['url_hs'] . 'TaiLieuDinhKem' }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>
                                    @if (in_array($tt->trangthai, ['DD', 'CC']))
                                        {{-- <a title="Thông tin hồ sơ"
                                            href="{{ url($inputs['url'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                        </a>                                       --}}

                                        <a href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                            class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                            title="Thông tin hồ sơ khen thưởng">
                                            <span class="svg-icon svg-icon-xl">
                                                <i class="icon-lg la flaticon-list text-success"></i>
                                            </span>
                                            <span
                                                class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
                                        </a>
                                        @if (chkPhanQuyen('dshosokhencaochinhphu', 'hoanthanh'))
                                            <a href="{{ url($inputs['url_hs'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon"
                                                title="Cập nhật thông tin khen thưởng">
                                                <i class="icon-lg la flaticon-interface-10 text-success"></i>
                                            </a>
                                        @endif

                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i>
                                        </button>
                                    @endif


                                    @if ($tt->trangthai == 'DKT' && chkPhanQuyen('dshosokhencaochinhphu', 'hoanthanh'))
                                        <button title="Hủy thông tin khen thưởng" type="button"
                                            onclick="setHuyPheDuyet('{{ $tt->mahosotdkt }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-HuyPheDuyet"
                                            data-toggle="modal">
                                            <i class="icon-lg la flaticon-interface-10 text-danger"></i>
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

    <!--Modal Tạo hồ sơ-->
    {!! Form::open(['url' => $inputs['url_hs'] . 'Them', 'id' => 'frm_hoso']) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
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
                            <label>Cấp độ khen thưởng</label>
                            {!! Form::select('capkhenthuong', $a_phamvi, null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
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
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @include('NghiepVu._DungChung.HoSo_KhenCao_TongHopHoSo')
    @include('NghiepVu._DungChung.InDuLieu_KhenCao')
    {{-- @include('NghiepVu._DungChung.InDuLieuKT') --}}
    @include('NghiepVu._DungChung.modal_KhenThuong')
    @include('includes.modal.modal-lydo')
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_accept_hs')
    @include('includes.modal.modal_attackfile')
@stop
