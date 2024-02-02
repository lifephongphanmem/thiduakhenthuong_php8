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
            TableManagedclass.init();
        });


        function setCaNhan() {
            $('#frm_ThemCaNhan').find("[name='id']").val('-1');
        }

        function setTapThe() {
            $('#frm_ThemTapThe').find("[name='id']").val('-1');
        }

        function getCaNhan(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "LayCaNhan",
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
                    form.find("[name='ketqua']").val(data.ketqua).trigger('change');
                }
            })
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "LayTapThe",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='maphanloaitapthe']").val(data.maphanloaitapthe).trigger('change');
                    form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='tentapthe']").val(data.tentapthe);
                    form.find("[name='ketqua']").val(data.ketqua);
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
                <h3 class="card-label text-uppercase">Thông tin hồ sơ đề nghị khen thưởng niên hạn</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => '',
            'class' => 'form',
            'id' => 'frm_ThayDoi',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosotdkt', null, ['id' => 'mahosotdkt']) }}
        <div class="card-body">
            @include('NghiepVu._DungChung.HoSo_ThongTinChung')

            @include('NghiepVu._DungChung.HoSo_TaiLieuDinhKem')

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
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="kt_tapthe" role="tabpanel"
                                    aria-labelledby="kt_tapthe">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button title="Khen thưởng cả tập thể"
                                                    onclick="setKhenThuongTatCa('TAPTHE')"
                                                    data-target="#modal-GanKhenThuong" data-toggle="modal" type="button"
                                                    class="btn btn-info btn-icon btn-sm"><i class="fas flaticon-list"></i>
                                                </button>
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
                                                        <th>Hình thức<br>khen thưởng</th>
                                                        <th>Danh hiệu<br>thi đua</th>
                                                        <th>Kết quả<br>khen thưởng</th>
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
                                                                {{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                                            <td class="text-center">
                                                                {{ $a_danhhieutd[$tt->madanhhieutd] ?? '' }}</td>

                                                            @if ($tt->ketqua == 1)
                                                                <td class="text-center">
                                                                    <button class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-check text-primary icon-2x"></i></button>
                                                                @else
                                                                <td class="text-center">
                                                                    <button class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-times-circle text-danger icon-2x"></i></button>
                                                                </td>
                                                            @endif

                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getTapThe('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal">
                                                                    <i
                                                                        class="icon-lg la fa-edit text-primary icon-2x"></i></button>
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
                                                <button title="Khen thưởng cả cá nhân"
                                                    onclick="setKhenThuongTatCa('CANHAN')"
                                                    data-target="#modal-GanKhenThuong" data-toggle="modal" type="button"
                                                    class="btn btn-info btn-icon btn-sm"><i class="fas flaticon-list"></i>
                                                </button>
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
                                                        <th>Hình thức<br>khen thưởng</th>
                                                        <th>Danh hiệu<br>thi đua</th>
                                                        <th>Kết quả<br>khen thưởng</th>
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
                                                                {{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                                            <td class="text-center">
                                                                {{ $a_danhhieutd[$tt->madanhhieutd] ?? '' }}</td>
                                                            @if ($tt->ketqua == 1)
                                                                <td class="text-center">
                                                                    <button class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-check text-primary icon-2x"></i></button>
                                                                @else
                                                                <td class="text-center">
                                                                    <button class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-times-circle text-danger icon-2x"></i></button>
                                                                </td>
                                                            @endif
                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getCaNhan('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary icon-2x"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url($inputs['url_xd'] . 'ThongTin?madonvi=' . $model->madonvi_xd) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

    {{-- Cá nhân --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemCaNhan',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Ngày sinh</label>
                            {!! Form::input('date', 'ngaysinh', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Giới tính</label>
                            {!! Form::select('gioitinh', getGioiTinh(), null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label">Địa chỉ</label>
                            {!! Form::text('diachi', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Phân loại cán bộ</label>
                            {!! Form::select('maphanloaicanbo', $a_canhan, null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="form-control-label">Chức vụ/Chức danh</label>
                            {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Tên phòng ban công tác</label>
                            {!! Form::text('tenphongban', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label">Tên đơn vị công tác</label>
                            {!! Form::text('tencoquan', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Danh hiệu thi đua</label>
                            {!! Form::select('madanhhieutd', setArrayAll($a_hinhthuckt, 'Không đăng ký', 'null'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Hình thức khen thưởng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, $inputs['mahinhthuckt'], ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Kết quả khen thưởng</label>
                            {!! Form::select('ketqua', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Nội dung khen thưởng / Lý do không khen thưởng</label>
                            {!! Form::textarea('noidungkhenthuong', null, [
                                'class' => 'form-control',
                                'rows' => '2',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuCaNhan()">Hoàn thành</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- tập thể --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemTapThe',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
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
                        <div class="col-md-12">
                            <label class="form-control-label">Tên tập thể</label>
                            {!! Form::text('tentapthe', null, ['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Phân loại đơn vị</label>
                            {!! Form::select('maphanloaitapthe', $a_tapthe, null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Danh hiệu thi đua</label>
                            {!! Form::select('madanhhieutd', setArrayAll($a_hinhthuckt, 'Không đăng ký', 'null'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Hình thức khen thưởng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, $inputs['mahinhthuckt'], ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Kết quả khen thưởng</label>
                            {!! Form::select('ketqua', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Nội dung khen thưởng / Lý do không khen thưởng</label>
                            {!! Form::textarea('noidungkhenthuong', null, [
                                'class' => 'form-control',
                                'rows' => '2',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTapThe()">Cập nhật</button>
                    {{-- <button type="submit" class="btn btn-primary">Hoàn thành</button> --}}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Gán giá trị khen thưởng --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_GanKhenThuong',
        'class' => 'form',
    ]) !!}
    <div class="modal fade" id="modal-GanKhenThuong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gán thông tin khen thưởng cho cả danh sách</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Nhóm đối tượng</label>
                            {!! Form::select('phanloai', ['TAPTHE' => 'Tập thể', 'CANHAN' => 'Cá nhân'], null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-6">
                            <label>Kết quả khen thưởng</label>
                            {!! Form::select('ketqua', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Nội dung khen thưởng / Lý do không khen thưởng </label>
                            <span>(Nội dung in trên phôi bằng khen)</span>
                            {!! Form::textarea('noidungkhenthuong', $model->noidung, [
                                'class' => 'form-control',
                                'rows' => '6',
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" onclick="confirmKhenThuongTatCa()" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    <script>
        function setKhenThuongTatCa(phanloai) {
            $('#frm_GanKhenThuong').find("[name='phanloai']").val(phanloai).trigger('change');
        }

        function confirmKhenThuongTatCa() {
            var formData = new FormData($('#frm_GanKhenThuong')[0]);
            $.ajax({
                url: "{{ $inputs['url_xd'] }}" + "GanKhenThuong",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        if (formData.get('phanloai') == 'TAPTHE') {
                            $('#dskhenthuongtapthe').replaceWith(data.message);
                            TableManaged4.init();
                        } else {
                            $('#dskhenthuongcanhan').replaceWith(data.message);
                            TableManaged3.init();
                        }

                    }
                }
            })

            $('#modal-GanKhenThuong').modal("hide");
        }

        function LuuTapThe() {
            var formData = new FormData($('#frm_ThemTapThe')[0]);

            $.ajax({
                url: "{{ $inputs['url_xd'] }}" + "ThemTapThe",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        TableManaged4.init();
                    }
                }
            })
            $('#modal-create-tapthe').modal("hide");
        }

        function LuuCaNhan() {
            var formData = new FormData($('#frm_ThemCaNhan')[0]);

            $.ajax({
                url: "{{ $inputs['url_xd'] }}" + "ThemCaNhan",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        $('#dskhenthuongcanhan').replaceWith(data.message);
                        TableManaged3.init();
                    }
                }
            })
            $('#modal-create').modal("hide");
        }
    </script>
@stop
