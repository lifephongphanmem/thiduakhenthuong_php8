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
        });

        function delKhenThuong(id, phanloai) {
            $('#frm_XoaDoiTuong').find("[name='phanloaixoa']").val(phanloai);
            $('#frm_XoaDoiTuong').find("[name='id']").val(id);
        }

        function setCaNhan() {
            $('#frm_ThemCaNhan').find("[name='id']").val('-1');
        }

        function setTapThe() {
            $('#frm_ThemTapThe').find("[name='id']").val('-1');
        }

        function getCaNhan(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:"{{$inputs['url']}}" +  'CaNhan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemCaNhan');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='tendoituong']").val(data.tendoituong);
                    form.find("[name='ngaysinh']").val(data.ngaysinh);
                    form.find("[name='gioitinh']").val(data.gioitinh).trigger('change');
                    form.find("[name='chucvu']").val(data.chucvu);
                    form.find("[name='tenphongban']").val(data.tenphongban);
                    form.find("[name='tencoquan']").val(data.tencoquan);
                    form.find("[name='maphanloaicanbo']").val(data.maphanloaicanbo).trigger('change');
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
                }
            })
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{$inputs['url']}}" + 'TapThe',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='maphanloaitapthe']").val(data.maphanloaitapthe).trigger('change');
                    form.find("[name='tentapthe']").val(data.tentapthe);
                    //filedk: form.find("[name='filedk']").val(data.madoituong),
                }
            })
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin hồ sơ giao ước thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => $inputs['url'].'Sua',
            'class' => 'form',
            'id' => 'frm_ThayDoi',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosodk', null, ['id' => 'mahosodk']) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Tên đơn vị</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Ngày tạo hồ sơ<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Năm đăng ký</label>
                    {!! Form::select('namdangky', getNam(false), null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Biên bản cuộc họp: </label>
                    {!! Form::file('bienban', null, ['id' => 'bienban', 'class' => 'form-control']) !!}
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>

                <div class="col-lg-6">
                    <label>Tài liệu khác: </label>
                    {!! Form::file('tailieukhac', null, ['id' => 'tailieukhac', 'class' => 'form-control']) !!}
                    @if ($model->tailieukhac != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                target="_blank">{{ $model->tailieukhac }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tapthe">
                                            <span class="nav-icon">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <span class="nav-text">Khen thưởng tập thể</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_canhan">
                                            <span class="nav-icon">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <span class="nav-text">Khen thưởng cá nhân</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="kt_tapthe" role="tabpanel"
                                    aria-labelledby="kt_tapthe">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button type="button" onclick="setTapThe()"
                                                    data-target="#modal-create-tapthe" data-toggle="modal"
                                                    class="btn btn-light-dark btn-icon btn-sm">
                                                    <i class="fa fa-plus"></i></button>
                                                {{-- <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-info btn-icon btn-sm"><i
                                                        class="fas fa-file-import"></i></button>
                                                <a target="_blank" title="Tải file mẫu" href="/data/download/TapThe.xlsx"
                                                    class="btn btn-primary btn-icon btn-sm"><i
                                                        class="fa flaticon-download"></i></button></a> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dskhenthuongtapthe">
                                        <div class="col-md-12">
                                            <table id="sample_4" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="5%">STT</th>
                                                        <th>Tên tập thể</th>
                                                        <th>Phân loại<br>tập thể</th>
                                                        <th>Danh hiệu<br>thi đua</th>
                                                        <th width="15%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_tapthe as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tentapthe }}</td>
                                                            <td>{{ $a_tapthe[$tt->maphanloaitapthe] ?? '' }}</td>
                                                            <td class="text-center">
                                                                {{ $a_danhhieutd[$tt->madanhhieutd] ?? '' }}</td>
                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getTapThe('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>

                                                                <button title="Xóa" type="button"
                                                                    onclick="delKhenThuong('{{ $tt->id }}', 'TAPTHE')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-delete-khenthuong"
                                                                    data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kt_canhan" role="tabpanel" aria-labelledby="kt_canhan">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button title="Thêm đối tượng" type="button" data-target="#modal-create"
                                                    data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm"
                                                    onclick="setCaNhan()">
                                                    <i class="fa fa-plus"></i></button>

                                                {{-- <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-info btn-icon btn-sm"><i
                                                        class="fas fa-file-import"></i></button>

                                                <a target="_blank" title="Tải file mẫu" href="/data/download/CANHAN.xlsx"
                                                    class="btn btn-primary btn-icon btn-sm"><i
                                                        class="fa flaticon-download"></i></button></a> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dskhenthuongcanhan">
                                        <div class="col-md-12">
                                            <table id="sample_3" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="2%">STT</th>
                                                        <th>Tên đối tượng</th>
                                                        <th width="8%">Ngày sinh</th>
                                                        <th width="5%">Giới</br>tính</th>
                                                        <th width="15%">Phân loại cán bộ</th>
                                                        <th>Thông tin công tác</th>
                                                        <th>Danh hiệu<br>thi đua</th>
                                                        <th width="10%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_canhan as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tendoituong }}</td>
                                                            <td class="text-center">{{ getDayVn($tt->ngaysinh) }}</td>
                                                            <td>{{ $tt->gioitinh }}</td>
                                                            <td>{{ $a_canhan[$tt->maphanloaicanbo] ?? '' }}</td>
                                                            <td class="text-center">
                                                                {{ $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}
                                                            </td>

                                                            <td class="text-center">
                                                                {{ $a_danhhieutd[$tt->madanhhieutd] ?? '' }}</td>
                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getCaNhan('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>

                                                                <button title="Xóa" type="button"
                                                                    onclick="delKhenThuong('{{ $tt->id }}', 'CANHAN')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-delete-khenthuong"
                                                                    data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade" id="kt_detai" role="tabpanel" aria-labelledby="kt_detai">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url($inputs['url'].'ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

    {{-- Cá nhân --}}
    {!! Form::open([
        'url' =>$inputs['url']. 'CaNhan',
        'id' => 'frm_ThemCaNhan',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="mahosodk" value="{{ $model->mahosodk }}" />
    <div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-1">
                            <label class="text-center">Chọn</label>
                            <button type="button" class="btn btn-default btn-icon" data-target="#modal-doituong"
                                data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label">Ngày sinh</label>
                            {!! Form::input('date', 'ngaysinh', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Giới tính</label>
                            {!! Form::select('gioitinh', getGioiTinh(), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label">Địa chỉ</label>
                            {!! Form::text('diachi', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Phân loại cán bộ</label>
                            {!! Form::select('maphanloaicanbo', $a_canhan, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="form-control-label">Chức vụ/Chức danh</label>
                            {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Tên phòng ban công tác</label>
                            {!! Form::text('tenphongban', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label">Tên đơn vị công tác</label>
                            {!! Form::text('tencoquan', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Danh hiệu thi đua</label>
                            {!! Form::select('madanhhieutd', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="submit" class="btn btn-primary">Hoàn thành</button>
                    {{-- <button type="button" class="btn btn-primary" onclick="LuuCaNhan()">Hoàn thành</button> --}}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- tập thể --}}
    {!! Form::open([
        'url' => $inputs['url'].'TapThe',
        'id' => 'frm_ThemTapThe',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahosodk" value="{{ $model->mahosodk }}" />
    <input type="hidden" name="id" />
    <div class="modal fade bs-modal-lg" id="modal-create-tapthe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đối tượng tập thể</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-11">
                            <label class="form-control-label">Tên tập thể</label>
                            {!! Form::text('tentapthe', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-1">
                            <label class="text-center">Chọn</label>
                            <button type="button" class="btn btn-default btn-icon" data-target="#modal-tapthe"
                                data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Phân loại đơn vị</label>
                            {!! Form::select('maphanloaitapthe', $a_tapthe, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Danh hiệu thi đua</label>
                            {!! Form::select('madanhhieutd', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="submit" class="btn btn-primary">Hoàn thành</button>
                    {{-- <button type="button" class="btn btn-primary" onclick="LuuTapThe()">Cập nhật</button> --}}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Xóa đối tượng --}}
    {!! Form::open([
        'url' => $inputs['url'].'XoaDoiTuong',
        'id' => 'frm_XoaDoiTuong',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="modal fade" id="modal-delete-khenthuong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa thông tin đối tượng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="id">
                <input type="hidden" name="phanloaixoa">
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="submit" class="btn btn-primary"">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {{-- Nhận file Excel --}}
    <div class="modal fade bs-modal-lg" id="modal-nhanexcel" tabindex="-1" role="dialog" aria-hidden="true">
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
                                            <span class="nav-text">Tập thể</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#excel_canhan">
                                            <span class="nav-icon">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <span class="nav-text">Cá nhân</span>
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
                                        'url' => $inputs['url'] . 'NhanExcelTapThe',
                                        'method' => 'POST',
                                        'id' => 'frm_NhanExcel',
                                        'class' => 'form',
                                        'files' => true,
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="mahosodk" value="{{ $model->mahosodk }}" />

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Tên đơn vị / tập thể</label>
                                            {!! Form::text('tentapthe', 'B', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Phân loại đơn vị</label>
                                            {!! Form::text('maphanloaitapthe', 'C', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Danh hiệu thi đua</label>
                                            {!! Form::text('madanhhieutd', 'E', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
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
                                        <div class="col-md-4">
                                            <label class="control-label">Phân loại đơn vị<span
                                                    class="require">*</span></label>
                                            {!! Form::select('maphanloaitapthe_md', $a_tapthe, null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>

                                        <div class="col-md-4">
                                            <label class="control-label">Danh hiệu thi đua</label>
                                            {!! Form::select('madanhhieutd_md', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                                'class' => 'form-control',
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

                                <div class="tab-pane fade" id="excel_canhan" role="tabpanel"
                                    aria-labelledby="excel_canhan">
                                    {!! Form::open([
                                        'url' => $inputs['url'] . 'NhanExcelCaNhan',
                                        'id' => 'frm_NhanExcel',
                                        'method' => 'POST',
                                        'class' => 'form',
                                        'files' => true,
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="mahosodk" value="{{ $model->mahosodk }}" />
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Tên đối tượng</label>
                                            {!! Form::text('tendoituong', 'B', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Giới tính</label>
                                            {!! Form::text('gioitinh', 'C', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Ngày sinh</label>
                                            {!! Form::text('ngaysinh', 'D', ['class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="form-control-label">Chức vụ/Chức danh</label>
                                            {!! Form::text('chucvu', 'E', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tên phòng ban</label>
                                            {!! Form::text('tenphongban', 'F', ['class' => 'form-control']) !!}
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label class="form-control-label">Tên cơ quan</label>
                                            {!! Form::text('tencoquan', 'G', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Nơi ở / Địa chỉ</label>
                                            {!! Form::text('tencoquan', 'H', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Phân loại cán bộ</label>
                                            {!! Form::text('maphanloaicanbo', 'I', ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Danh hiệu thi đua</label>
                                            {!! Form::text('madanhhieutd', 'K', ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
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
                                        <div class="col-md-4">
                                            <label class="control-label">Phân loại cán bộ<span
                                                    class="require">*</span></label>
                                            {!! Form::select('maphanloaicanbo_md', $a_canhan, null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>

                                        <div class="col-md-4">
                                            <label class="control-label">Danh hiệu thi đua</label>
                                            {!! Form::select('madanhhieutd_md', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                                'class' => 'form-control',
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
        function adddvt() {
            $('#modal-doituong').modal('hide');
        }
    </script>
@stop
