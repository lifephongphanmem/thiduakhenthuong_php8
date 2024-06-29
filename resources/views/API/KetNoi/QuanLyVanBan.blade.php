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
            $('#madonvi, #nam, #trangthaihoso').change(function() {
                window.location.href = '/HeThongAPI/KetNoi/QuanLyVanBan?madonvi=' + $('#madonvi')
                    .val() + '&nam=' + $('#nam').val() + "&trangthaihoso=" + $('#trangthaihoso').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                {{-- <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng theo chuyên đề</h3> --}}
                <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng theo phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
                {{-- @if (chkPhanQuyen('xdhosodenghikhenthuongchuyende', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif --}}
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-4">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($m_donvi as $ct)
                            <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }} value="{{ $ct->madonvi }}">
                                {{ $ct->tendonvi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-3">
                    <label style="font-weight: bold">Trạng thái hồ sơ</label>
                    {!! Form::select(
                        'trangthaihoso',
                        setArrayAll(getTrangThaiChucNangHoSo('ALL'), 'Tất cả', 'ALL'),
                        $inputs['trangthaihoso'],
                        [
                            'id' => 'trangthaihoso',
                            'class' => 'form-control select2basic',
                        ],
                    ) !!}
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
                                <th>Tên đơn vị trình</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="8%">Ngày tạo</th>
                                <th width="8%">Trạng thái</br>hồ sơ</th>
                                <th>Đơn vị tiếp nhận</th>
                                <th width="8%">Trạng thái</br>kết nối</th>
                                <th width="8%">Thao tác</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan_xd] ?? '' }}</td>
                                <td class="text-center">
                                    <button type="button"
                                        onclick="setThongTinKetNoi('{{ $tt->madonvi }}','{{ $tt->mahosotdkt }}','QLVB')"
                                        title="Thông tin kết nối" data-toggle="modal" data-target="#ketnoi-modal"
                                        class="btn btn-sm btn-clean btn-icon">
                                        <i
                                            class="icon-lg la {{ $tt->trangthaiketnoi ? 'fa-check text-primary' : 'fa-times-circle text-danger' }} text-primary icon-2x"></i>
                                    </button>
                                </td>

                                <td style="text-align: center">
                                    @include('NghiepVu._DungChung.TD_XemThongTinTDKT')
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <!--Modal thông tin đơn vị quản lý -->
    {!! Form::open(['url' => '/HeThongAPI/KetNoi/TruyenVanBan', 'id' => 'frm_ketnoi', 'method=>post']) !!}
    {!! Form::hidden('mahosotdkt', null) !!}
    {!! Form::hidden('madonvi', null) !!}
    {!! Form::hidden('phanmem', null) !!}
    <div id="ketnoi-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết nối tới phần mềm quản lý văn bản
                    </h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Link API kết nối<span class="text-danger">*</span></label>
                                {!! Form::text('linkAPI', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Mã truy cập (Token Access)<span
                                        class="text-danger">*</span></label>
                                {!! Form::text('matoken', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4">
                                <label class="control-label">Người tạo<span class="text-danger">*</span></label>
                                {!! Form::text('canbotiepnhan', null, [
                                    'class' => 'form-control',
                                    'placeholder ' => 'Tài khoản trên phần mềm QLVB',
                                    'required',
                                ]) !!}
                            </div>
                            <div class="col-4">
                                <label class="control-label">Thời gian tạo<span class="text-danger">*</span></label>
                                {!! Form::input('date', 'thoigian', date('Y-m-d'), ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="col-4">
                                <label class="control-label">Thời hạn<span class="text-danger">*</span></label>
                                {!! Form::input('date', 'thoihan', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div id ="dsfiledulieu" class="col-6">
                                <label>Chọn file dữ liệu: </label>
                                {!! Form::select(null, [], null, [
                                    'id' => 'matailieu',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>

                            <div class="col-6">
                                <label>Tải file dữ liệu: </label>
                                <input type="file" id="fileupload" onchange="convertFile2Base64(event)" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label>Tên file dữ liệu<span class="text-danger">*</span> </label>
                                {!! Form::text('tenfiledulieu', null, ['id' => 'tenfiledulieu', 'class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label>File dữ liệu mã hoá (base64)<span class="text-danger">*</span> </label>
                                {!! Form::textarea('filedulieu', null, [
                                    'id' => 'filedulieu',
                                    'class' => 'form-control',
                                    'required',
                                    'rows' => 4,
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng
                        ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        //Chuyển file tải lên thành mã base64
        function convertFile2Base64(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            const fileName = file.name;

            reader.onload = function(event) {
                const base64String = event.target.result.split(',')[
                    1]; // Lấy phần base64 từ chuỗi data URL                
                document.getElementById('filedulieu').value = base64String;
                document.getElementById('tenfiledulieu').value = fileName;
            };

            reader.readAsDataURL(file);
        }

        function getThongTinFile(event) {
            const id = event.target.value;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/HeThongAPI/KetNoi/LayThongTinFile",
                type: "GET",
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    //console.log(data);
                    if (data.status == 'success') {
                        document.getElementById('filedulieu').value = data.filedulieu;
                        document.getElementById('tenfiledulieu').value = data.tenfiledulieu;
                    } else {
                        alert(data.message, 'Thông báo lỗi!!!');
                    }
                }
            });
        }

        function setThongTinKetNoi(madonvi, mahosotdkt, phanmem) {
            document.getElementById('filedulieu').value = null;
            document.getElementById('tenfiledulieu').value = null;
            var form = $('#frm_ketnoi');
            form.find("[name='madonvi']").val(madonvi);
            form.find("[name='mahosotdkt']").val(mahosotdkt);
            form.find("[name='phanmem']").val(phanmem);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/HeThongAPI/KetNoi/LayDSFile",
                type: "GET",
                data: {
                    _token: CSRF_TOKEN,
                    mahosotdkt: mahosotdkt,
                },
                dataType: 'JSON',
                success: function(data) {
                    //console.log(data);
                    if (data.status == 'success') {
                        $('#dsfiledulieu').replaceWith(data.message);
                    }
                }
            });
        }
    </script>
    {{-- @include('NghiepVu._DungChung.InDuLieu') --}}
    @include('includes.modal.modal_attackfile')
@stop
