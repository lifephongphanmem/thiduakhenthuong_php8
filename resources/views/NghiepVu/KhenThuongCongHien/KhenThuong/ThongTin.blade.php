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
            $('#madonvi, #nam, #phanloai, #trangthaihoso').change(function() {
                window.location.href = "{{ $inputs['url_qd'] }}" +
                    'ThongTin?madonvi=' + $('#madonvi ').val() +
                    '&nam=' + $('#nam').val() + "&phanloai=" + $('#phanloai').val()
                    +"&trangthaihoso=" + $('#trangthaihoso').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng cống hiến</h3>
            </div>
            <div class="card-toolbar">
                {{-- @if (chkPhanQuyen('qdhosodenghikhenthuongconghien', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif --}}
            </div>
        </div>
        <div class="card-body">
            @include('NghiepVu._DungChung.ROW_LocHocSo')

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th width="15%">Tên đơn vị đề nghị</th>
                                <th>Phân loại hồ sơ</th>
                                <th>Nội dung hồ sơ</th>
                                {{-- <th width="15%">Loại hình khen thưởng</th> --}}
                                <th width="8%">Quyết định<br>khen thưởng</th>
                                <th width="8%">Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td>{{ $a_phanloaihs[$tt->phanloai] ?? $tt->phanloai }}</td>
                                <td>{{ $tt->noidung }}</td>
                                {{-- <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td> --}}
                                <td class="text-center">{{ $tt->soqd }}<br>{{ getDayVn($tt->ngayqd) }}</td>
                                @include('includes.td.td_trangthai_hoso')

                                <td style="text-align: center">
                                    <button type="button" title="In quyết định khen thưởng"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}','DKT',true)"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoKhenThuong')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark icon-2x"></i>
                                    </button>
                                    
                                    @if (chkPhanQuyen('qdhosodenghikhenthuongconghien', 'hoanthanh'))
                                        @if ($inputs['trangthai'] == 'CC')
                                            @include('NghiepVu._DungChung.PheDuyet.TD_TrangThai_CC')
                                        @else
                                            @include('NghiepVu._DungChung.PheDuyet.TD_TrangThai_CXKT')
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

    <!--Modal phê duyệt hồ sơ khen thưởng-->
    <div class="modal fade" id="modal-PheDuyet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open([
                    'url' => $inputs['url_qd'] . 'PheDuyet',
                    'method' => 'post',
                    'files' => true,
                    'id' => 'frm_PheDuyet',
                ]) !!}
                <div class="modal-header">

                    <h4 class="modal-title">Đồng ý phê duyệt hồ sơ khen thưởng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="mahosotdkt" />
                <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12 text-info font-weight-bold">
                            Bạn đồng ý phê duyệt hồ sơ khen thưởng và gửi kết quả đến các đơn vị tham gia.
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đơn vị quyết định khen thưởng</label>
                            {!! Form::text('donvikhenthuong', $inputs['tendvcqhienthi'], ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Cấp độ khen thưởng</label>
                            {!! Form::select('capkhenthuong', getPhamViApDung(), $inputs['capdo'], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-lg-4">
                            <label>Số quyết định</label>
                            {!! Form::text('soqd', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-lg-4">
                            <label>Ngày ra quyết định</label>
                            {!! Form::input('date', 'ngayqd', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Chức vụ người ký</label>
                            {!! Form::text('chucvunguoikyqd', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Họ tên người ký</label>
                            {!! Form::text('hotennguoikyqd', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Đồng ý</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Modal hủy phê duyệt hồ sơ khen thưởng-->
    <div class="modal fade" id="modal-HuyPheDuyet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open([
                    'url' => $inputs['url_qd'] . 'HuyPheDuyet',
                    'method' => 'post',
                    'files' => true,
                    'id' => 'frm_HuyPheDuyet',
                ]) !!}
                <div class="modal-header">

                    <h4 class="modal-title">Đồng ý hủy phê duyệt hồ sơ khen thưởng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="mahosotdkt" />
                <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12 text-info font-weight-bold">
                            Bạn đồng ý hủy phê duyệt hồ sơ khen thưởng và chuyển hồ sơ về chờ xét khen thưởng.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Đồng ý</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Modal Tạo hồ sơ-->
    {!! Form::open(['url' => $inputs['url_qd'] . 'Them', 'id' => 'frm_hoso']) !!}
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


    <script>
        function setPheDuyet(mahosotdkt) {
            $('#frm_PheDuyet').find("[name='mahosotdkt']").val(mahosotdkt);
        }

        function setHuyPheDuyet(mahosotdkt) {
            $('#frm_HuyPheDuyet').find("[name='mahosotdkt']").val(mahosotdkt);
        }
    </script>

    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-delete')
@stop
