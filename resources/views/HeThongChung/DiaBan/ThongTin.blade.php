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
        });

        function getId(id) {
            document.getElementById("iddelete").value = id;
        }

        function ClickDelete() {
            $('#frm_delete').submit();
        }

        function add() {
            $('#madiaban').val('');
            $('#madiaban').attr('readonly', true);
        }

        function setDiaBan(madiaban, tendiaban, capdo, madonviQL, madiabanQL, madonviKT) {
            var form = $('#frm_modify');
            form.find("[name='madiaban']").val(madiaban);
            form.find("[name='tendiaban']").val(tendiaban);
            form.find("[name='capdo']").val(capdo).trigger('change');

            form.find("[name='madiabanQL']").val(madiabanQL).trigger('change');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/DiaBan/LayDonVi",
                type: "GET",
                data: {
                    _token: CSRF_TOKEN,
                    madiaban: form.find("[name='madiaban']").val(),
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#donviql').replaceWith(data.message);
                        form.find("[name='madonviQL']").val(madonviQL).trigger('change');
                        form.find("[name='madonviKT']").val(madonviKT).trigger('change');
                    }
                }
            });
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin {{ chkGiaoDien('dsdiaban', 'tenchucnang') }}</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsdiaban', 'thaydoi'))
                    <button title="Nhận từ file Excel" data-target="#modal-nhanexcel" onclick="setDiaBanExCel('')"
                        data-toggle="modal" type="button" class="btn btn-info btn-sm mr-5"><i
                            class="fas fa-file-import"></i>Nhận Excel
                    </button>

                    <button type="button" onclick="setDiaBan('','','T','','')" class="btn btn-success btn-sm"
                        data-target="#modify-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th colspan="3">STT</th>
                                <th rowspan="2">Mã số</th>
                                <th rowspan="2">Tên địa bàn</th>
                                <th rowspan="2" width="25%">Đơn vị phê<br>duyệt khen thưởng</th>
                                <th rowspan="2" width="25%">Đơn vị xét<br>duyệt hồ sơ</th>
                                <th rowspan="2" width="10%">Thao tác</th>
                            </tr>
                            <tr>
                                <th width="3%">T</th>
                                <th width="3%">H</th>
                                <th width="3%">X</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $model_t = $model->where('capdo', 'T');
                            ?>
                            @foreach ($model_t as $ct_t)
                                <?php
                                $j = 1;
                                $model_h = $model->where('madiabanQL', $ct_t->madiaban);
                                ?>
                                <tr class="success">
                                    <td class="text-primary text-center text-uppercase">{{ toAlpha($i++) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-primary">{{ $ct_t->madiaban }}</td>
                                    <td class="text-primary">{{ $ct_t->tendiaban }}</td>
                                    <td class="text-primary">{{ $a_donvi[$ct_t->madonviQL] ?? '' }}</td>
                                    <td class="text-primary">{{ $a_donvi[$ct_t->madonviKT] ?? '' }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dsdonvi', 'thaydoi'))
                                            <button
                                                onclick="setDiaBan('{{ $ct_t->madiaban }}','{{ $ct_t->tendiaban }}','{{ $ct_t->capdo }}','{{ $ct_t->madonviQL }}','{{ $ct_t->madiabanQL }}','{{ $ct_t->madonviKT }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                title="Thay đổi thông tin địa bàn" data-toggle="modal">
                                                <i class="icon-lg flaticon-edit-1 text-primary"></i>
                                            </button>

                                            <button onclick="setDiaBan('','','H','','{{ $ct_t->madiaban }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                title="Thêm địa bàn trực thuộc" data-toggle="modal">
                                                <i class="icon-lg flaticon-add text-info"></i>
                                            </button>

                                            <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_t->madiaban }}"
                                                class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                title="Danh sách đơn vị">
                                                <span class="svg-icon svg-icon-xl">
                                                    <i class="icon-lg flaticon-list-2 text-dark"></i>
                                                </span>
                                                <span
                                                    class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $ct_t->sodonvi }}</span>
                                            </a>



                                            <button title="Xóa thông tin" type="button"
                                                onclick="confirmDelete('{{ $ct_t->id }}','/DiaBan/Xoa')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg flaticon-delete text-danger"></i>
                                            </button>
                                        @endif

                                    </td>
                                </tr>

                                @foreach ($model_h as $ct_h)
                                    <tr class="info">
                                        <td></td>
                                        <td class="text-info text-center">{{ romanNumerals($j++) }}</td>
                                        <td></td>
                                        <td class="text-info">{{ $ct_h->madiaban }}</td>
                                        <td class="text-info">{{ $ct_h->tendiaban }}</td>
                                        <td class="text-info">{{ $a_donvi[$ct_h->madonviQL] ?? '' }}</b></td>
                                        <td class="text-info">{{ $a_donvi[$ct_h->madonviKT] ?? '' }}</b></td>
                                        <td style="text-align: center">
                                            @if (chkPhanQuyen('dsdonvi', 'thaydoi'))
                                                <button
                                                    onclick="setDiaBan('{{ $ct_h->madiaban }}','{{ $ct_h->tendiaban }}','{{ $ct_h->capdo }}','{{ $ct_h->madonviQL }}','{{ $ct_h->madiabanQL }}','{{ $ct_h->madonviKT }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                    title="Thay đổi thông tin địa bàn" data-toggle="modal">
                                                    <i class="icon-lg flaticon-edit-1 text-primary"></i>
                                                </button>

                                                <button onclick="setDiaBan('','','X','','{{ $ct_h->madiaban }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                    title="Thêm địa bàn trực thuộc" data-toggle="modal">
                                                    <i class="icon-lg flaticon-add text-info"></i>
                                                </button>

                                                <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_h->madiaban }}"
                                                    class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                    title="Danh sách đơn vị">
                                                    <span class="svg-icon svg-icon-xl">
                                                        <i class="icon-lg flaticon-list-2 text-dark"></i>
                                                    </span>
                                                    <span
                                                        class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $ct_h->sodonvi }}</span>
                                                </a>

                                                <button title="Xóa thông tin" type="button"
                                                    onclick="confirmDelete('{{ $ct_h->id }}','/DiaBan/Xoa')"
                                                    class="btn btn-sm btn-clean btn-icon"
                                                    data-target="#delete-modal-confirm" data-toggle="modal">
                                                    <i class="icon-lg flaticon-delete text-danger"></i>
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                    <?php
                                    $k = 1;
                                    $model_x = $model->where('madiabanQL', $ct_h->madiaban);
                                    ?>
                                    @foreach ($model_x as $ct_x)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center">{{ $k++ }}</td>
                                            <td style="font-style: italic;">{{ $ct_x->madiaban }}</td>
                                            <td style="font-style: italic;">{{ $ct_x->tendiaban }}</td>
                                            <td style="font-style: italic;"> {{ $a_donvi[$ct_x->madonviQL] ?? '' }}</td>
                                            <td style="font-style: italic;"> {{ $a_donvi[$ct_x->madonviKT] ?? '' }}</td>
                                            <td style="text-align: center">
                                                @if (chkPhanQuyen('dsdonvi', 'thaydoi'))
                                                    <button
                                                        onclick="setDiaBan('{{ $ct_x->madiaban }}','{{ $ct_x->tendiaban }}','{{ $ct_x->capdo }}','{{ $ct_x->madonviQL }}','{{ $ct_x->madiabanQL }}','{{ $ct_x->madonviKT }}')"
                                                        class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                        title="Thay đổi thông tin địa bàn" data-toggle="modal">
                                                        <i class="icon-lg flaticon-edit-1 text-primary"></i>
                                                    </button>

                                                    <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_x->madiaban }}"
                                                        class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                        title="Danh sách đơn vị">
                                                        <span class="svg-icon svg-icon-xl">
                                                            <i class="icon-lg flaticon-list-2 text-dark"></i>
                                                        </span>
                                                        <span
                                                            class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $ct_x->sodonvi }}</span>
                                                    </a>

                                                    <button title="Xóa thông tin" type="button"
                                                        onclick="confirmDelete('{{ $ct_x->id }}','/DiaBan/Xoa')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#delete-modal-confirm" data-toggle="modal">
                                                        <i class="icon-lg flaticon-delete text-danger"></i>
                                                    </button>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <!--Modal thông tin chi tiết -->
    {!! Form::open(['url' => 'DiaBan/Sua', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin địa bàn quản lý</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-3">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('madiaban', null, ['id' => 'madiaban', 'class' => 'form-control']) !!}
                            </div>

                            <div class="col-9">
                                <label class="control-label">Tên địa bàn<span class="require">*</span></label>
                                {!! Form::text('tendiaban', null, ['id' => 'tendiaban', 'class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label class="control-label">Phân loại</label>
                                {!! Form::select('capdo', getPhanLoaiDonVi_DiaBan(), null, [
                                    'id' => 'capdo',
                                    'class' => 'form-control select2_modal',
                                ]) !!}
                            </div>

                            <div class="col-6">
                                <label class="control-label">Trực thuộc địa bàn</label>
                                {!! Form::select('madiabanQL', $a_diaban, null, ['id' => 'madiabanQL', 'class' => 'form-control select2_modal']) !!}
                            </div>
                        </div>

                        <div id="donviql" class="form-group row">
                            <div class="col6">
                                <label class="control-label">Đơn vị phê duyệt khen thưởng</label>
                                {!! Form::select('madonviQL', [], null, ['id' => 'madonviQL', 'class' => 'form-control select2_modal']) !!}
                            </div>
                            <div class="col6">
                                <label class="control-label">Đơn vị xét duyệt hồ sơ</label>
                                {!! Form::select('madonviKT', [], null, ['id' => 'madonviKT', 'class' => 'form-control select2_modal']) !!}
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


    {{-- Nhận file Excel --}}
    <div class="modal fade bs-modal-lg kt_select2_modal" id="modal-nhanexcel" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nhận dữ liệu từ file</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#excel_tapthe">
                                            <span class="nav-icon">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <span class="nav-text">Thông tin nhận File</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="excel_tapthe" role="tabpanel"
                                    aria-labelledby="excel_tapthe">
                                    {!! Form::open([
                                        'url' => $inputs['url'] . 'NhanExcel',
                                        'method' => 'POST',
                                        'id' => 'frm_NhanExcel',
                                        'class' => 'form',
                                        'files' => true,
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="madiaban" />

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Tên đơn vi</label>
                                            {!! Form::text('tendonvi', 'B', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tài khoản đăng nhập </label>
                                            {!! Form::text('tendangnhap', 'C', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tài khoản tổng hợp</label>
                                            {!! Form::text('tendangnhap', 'D', ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-control-label">Mật khẩu</label>
                                            {!! Form::text('matkhau', 'E', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Sheet nhận dữ liệu<span
                                                    class="require">*</span></label>
                                            {!! Form::text('sheet', '0', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Nhận từ dòng<span
                                                    class="require">*</span></label>
                                            {!! Form::text('tudong', '4', ['class' => 'form-control']) !!}
                                            {{-- {!! Form::text('tudong', '4', ['class' => 'form-control', 'required', 'data-mask' => 'fdecimal']) !!} --}}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Nhận đến dòng</label>
                                            {!! Form::text('dendong', '200', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>File danh sách: </label>
                                            {!! Form::file('fexcel', null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <h4>Tham số mặc định</h4>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="control-label">Nhóm chức năng<span
                                                    class="require">*</span></label>
                                            {!! Form::select('manhomchucnang', $a_nhomchucnang, null, [
                                                'class' => 'form-control select2_modal',
                                            ]) !!}
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label">Cụm, khối thi đua<span
                                                    class="require">*</span></label>
                                            {!! Form::select('macumkhoi', setArrayAll($a_cumkhoi, 'Không chọn', 'NULL'), null, [
                                                'class' => 'form-control select2_modal',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="control-label">Phân loại phạm vị<span
                                                    class="require">*</span></label>
                                            {!! Form::select('madiabanQL', setArrayAll($a_cumkhoi, 'Không chọn', 'NULL'), null, [
                                                'class' => 'form-control select2_modal',
                                            ]) !!}
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label">Phạm vị - cấp trên<span
                                                    class="require">*</span></label>
                                            {!! Form::select('madiabanQL', setArrayAll($a_cumkhoi, 'Không chọn', 'NULL'), null, [
                                                'class' => 'form-control select2_modal',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-check"></i>Hoàn thành</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <script>
        function setDiaBanExCel(madiaban) {
            var form = $('#frm_NhanExcel');
            form.find("[name='madiaban']").val(madiaban);
        }
    </script>

    @include('includes.modal.modal-delete')
@stop
