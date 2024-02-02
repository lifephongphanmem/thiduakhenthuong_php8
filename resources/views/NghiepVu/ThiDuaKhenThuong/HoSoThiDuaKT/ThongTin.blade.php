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
            $('#madonvi, #nam, #phamviapdung').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + 'ThongTin?madonvi=' + $('#madonvi')
                    .val() +
                    '&nam=' + $('#nam').val() + '&phamviapdung=' + $('#phamviapdung').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ khen thưởng thi dua</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <label style="font-weight: bold">Phạm vi phát động</label>
                    {!! Form::select('phamviapdung', setArrayAll($a_phamvi, 'Tất cả', 'ALL'), $inputs['phamviapdung'], [
                        'id' => 'phamviapdung',
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

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" width="2%">STT</th>
                                <th colspan="2">Hồ sơ khen thưởng</th>
                                <th colspan="2">Phong trào</th>
                                <th rowspan="2" style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                            <tr class="text-center">
                                <th>Nội dung hồ sơ</th>
                                <th>Trạng thái</th>
                                <th>Phạm vị phát động</th>
                                <th width="25%">Tên phong trào thi đua</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td>{{ $tt->noidungkt }}</td>
                                @include('includes.td.td_trangthai_khenthuong')

                                <td class="text-center">
                                    {{ $a_phamvi[$tt->phamviapdung] ?? '' }}<br>({{ $a_trangthaihoso[$tt->nhanhoso] }})
                                </td>
                                <td>{{ $tt->noidung }}</td>
                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthaikt }}', true)"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoKhenThuong' )"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>

                                    {{-- <a title="Danh sách chi tiết"
                                        href="{{ url('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $tt->maphongtraotd . '&madonvi=' . $inputs['madonvi'] . '&trangthai=false') }}"
                                        class="btn btn-icon btn-clean btn-lg mb-1 position-relative">
                                        <span class="svg-icon svg-icon-xl">
                                            <i class="icon-lg la flaticon-folder-1 text-dark"></i>
                                        </span>
                                        <span
                                            class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->sohoso }}</span>
                                    </a> --}}
                                    @if ($tt->nhanhoso == 'KETTHUC' && chkPhanQuyen('dshosokhenthuongthidua', 'hoanthanh'))
                                        @if ($tt->mahosotdkt == '-1')
                                            <button title="Tạo hồ sơ khen thưởng" type="button"
                                                onclick="confirmKhenThuong('{{ $tt->maphongtraotd }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#taohoso-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </button>
                                        @elseif(in_array($tt->trangthaikt, ['CXKT']))
                                            <a href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt . '&madonvi=' . $inputs['madonvi']) }}"
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

                                            <a title="Tạo dự thảo quyết định khen thưởng"
                                                href="{{ url($inputs['url_hs'] . 'QuyetDinh?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </a>

                                            <a title="Phê duyệt hồ sơ khen thưởng"
                                                href="{{ url($inputs['url_hs'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                <i class="icon-lg la flaticon-interface-10 text-success"></i>
                                            </a>

                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg flaticon-delete text-danger"></i>
                                            </button>
                                        @endif

                                        @if ($tt->trangthaikt == 'DKT')
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


    <!--Modal Tao hồ sơ đề nghị-->
    {!! Form::open(['url' => $inputs['url_hs'] . 'ThemKT', 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ khen thưởng?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Phong trào thi đua</label>
                            {!! Form::select('maphongtraotd', $a_phongtraotd, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label>Trạng thái hồ sơ</label>
                            {!! Form::select('trangthai', getTrangThaiChucNangHoSo($inputs['trangthai']), $inputs['trangthai'], [
                                'class' => 'form-control',
                            ]) !!}
                        </div>


                        <div class="col-6">
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    
                    @if ($inputs['taototrinh'])
                        <div class="form-group row">
                            <div class="col-4">
                                <label>Số tờ trình</label>
                                {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="col-lg-4">
                                <label>Chức vụ người ký tờ trình</label>
                                {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-4">
                                <label>Họ tên người ký tờ trình</label>
                                {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung trình khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 3]) !!}
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
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        function confirmKhenThuong(maphongtraotd) {
            $('#frm_hoso').find("[name='maphongtraotd']").val(maphongtraotd).trigger('change');
        }
    </script>

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
    </script>

    @include('NghiepVu._DungChung.InDuLieu')
    {{-- @include('NghiepVu.ThiDuaKhenThuong._DungChung.InDuLieu') --}}
    @include('includes.modal.modal_attackfile')
    @include('NghiepVu._DungChung.modal_PheDuyet')
@stop
