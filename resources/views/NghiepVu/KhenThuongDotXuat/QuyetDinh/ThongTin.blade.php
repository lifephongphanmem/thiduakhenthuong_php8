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
            $('#madonvi, #maloaihinhkt, #nam, #phanloai, #trangthaihoso').change(function() {
                window.location.href = "{{ $inputs['url_qd'] }}" +
                    'ThongTin?madonvi=' + $('#madonvi ').val() +
                    '&nam=' + $('#nam').val() +
                    "&phanloai=" + $('#phanloai').val() +
                    "&trangthaihoso=" + $('#trangthaihoso').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng đột xuất</h3>
            </div>
            <div class="card-toolbar">
                {{-- @if (chkPhanQuyen('qdhosodenghikhenthuongcongtrang', 'thaydoi'))
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
                                    @if (chkPhanQuyen('qdhosodenghikhenthuongdotxuat', 'hoanthanh'))
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

    <!--Modal tạo hồ sơ-->
    <div id="khenthuong-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => '/KhenThuongDotXuat/KhenThuong/KhenThuong', 'id' => 'frm_khenthuong']) !!}
        <input type="hidden" name="mahosotdkt" />
        <input type="hidden" name="madonvi" />
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ khen thưởng?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đơn vị quyết định khen thưởng</label>
                            {!! Form::text('donvikhenthuong', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Cấp độ khen thưởng</label>
                            {!! Form::select('capkhenthuong', getPhamViApDung(), 'T', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-lg-6">
                            <label>Ngày ra quyết định</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '2']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Chức vụ người ký</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Họ tên người ký</label>
                            {!! Form::text('hotennguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                     <div class="col-lg-12">
                         <label>Quyết định khen thưởng</label>
                         {!! Form::select('chucvunguoiky', ['0'=>'Không khen thưởng','1'=>'Khen thưởng'], null, ['class' => 'form-control']) !!}
                     </div>                        
                 </div>

                 <div class="form-group row">
                     <div class="col-lg-12">
                         <label>Lý do (không khen thưởng)</label>
                         {!! Form::textarea('lydo', null, ['class' => 'form-control', 'rows' => '2']) !!}
                     </div>
                 </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickKhenThuong()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    @include('NghiepVu._DungChung.InDuLieu')
    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-delete')
    @include('NghiepVu._DungChung.modal_QD_PheDuyet')

@stop
