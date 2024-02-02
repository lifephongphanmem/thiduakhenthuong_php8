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
            TableManagedclass.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin hồ sơ đề nghị khen thưởng chuyên đề</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => $inputs['url_hs'] . 'Sua',
            'class' => 'form',
            'id' => 'frm_ThayDoi',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosotdkt', null, ['id' => 'mahosotdkt']) }}
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tên đơn vị</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>

                <div class="col-lg-6">
                    <label>Phân loại hồ sơ</label>
                    {!! Form::select('phanloai', getPhanLoaiHoSo('KHENCAO'), null, ['class' => 'form-control']) !!}
                </div>
                {{-- <div class="col-lg-6">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control']) !!}
                </div> --}}
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Số tờ trình</label>
                    {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Ngày tháng trình<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
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
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>


            @include('NghiepVu._DungChung.HoSo_KhenCao_DanhSachKhenThuong')
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url($inputs['url_hs'] . 'ThongTin?madonvi=' . $model->madonvi) }}"
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
        'url' => '',
        'id' => 'frm_ThemCaNhan',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="maloaihinhkt" value="{{ $model->maloaihinhkt }}" />
    <div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-3">
                            <label class="form-control-label">Đối tượng</label>

                            <div class="input-group">
                                {!! Form::select(
                                    'pldoituong',
                                    array_unique(array_merge([$model->pldoituong => $model->pldoituong], getPhanLoaiDoiTuong())),
                                    null,
                                    ['class' => 'form-control', 'id' => 'pldoituong'],
                                ) !!}
                                <div class="input-group-prepend">
                                    <button type="button" data-target="#modal-pldoituong" data-toggle="modal"
                                        class="btn btn-light-dark btn-icon">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <label class="form-control-label">Ngày sinh</label>
                            {!! Form::input('date', 'ngaysinh', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-3">
                            <label class="form-control-label">Giới tính</label>
                            {!! Form::select('gioitinh', getGioiTinh(), null, ['class' => 'form-control']) !!}
                        </div>
                        {{-- </div>
    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-control-label">Địa chỉ</label>
                                {!! Form::text('diachi', null, ['class' => 'form-control']) !!}
                            </div> --}}

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
                        <div class="col-md-12">
                            <label class="control-label">Danh hiệu thi đua/Hình thức khen thưởng</label>
                            {!! Form::select('madanhhieukhenthuong', $a_dhkt_canhan, null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>
                        {{-- <div class="col-md-6">
                                <label class="control-label">Danh hiệu thi đua</label>
                                {!! Form::select('madanhhieutd', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
    
                            <div class="col-md-6">
                                <label class="control-label">Hình thức khen thưởng</label>
                                {!! Form::select('mahinhthuckt', $a_hinhthuckt, $inputs['mahinhthuckt'], ['class' => 'form-control']) !!}
                            </div> --}}
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

    <script>
        function setCaNhan() {
            $('#frm_ThemCaNhan').find("[name='id']").val('-1');
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
                    form.find("[name='madanhhieukhenthuong']").val(data.madanhhieukhenthuong).trigger('change');
                    form.find("[name='pldoituong']").val(data.pldoituong).trigger('change');
                }
            })
        }

        function LuuCaNhan() {
            var formData = new FormData($('#frm_ThemCaNhan')[0]);

            $.ajax({
                url: "{{ $inputs['url'] }}" + "ThemCaNhan",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#dskhenthuongcanhan').replaceWith(data.message);
                        TableManaged3.init();
                    }
                }
            })
            $('#modal-create').modal("hide");
        }
    </script>


    {{-- tập thể --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemTapThe',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="maloaihinhkt" value="{{ $model->maloaihinhkt }}" />
    <input type="hidden" name="id" />
    <div class="modal fade bs-modal-lg kt_select2_modal" id="modal-create-tapthe" tabindex="-1" role="dialog"
        aria-hidden="true">
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
                            {!! Form::text('tentapthe', null, ['class' => 'form-control']) !!}
                        </div>
                        {{-- <div class="col-lg-1">
                            <label class="text-center">Chọn</label>
                            <button type="button" class="btn btn-default btn-icon" data-target="#modal-tapthe"
                                data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div> --}}
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Tên đơn vị / cơ quan</label>
                            {!! Form::text('tencoquan', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label class="control-label">Phân loại đối tượng</label>
                            {!! Form::select('maphanloaitapthe', $a_tapthe, null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>

                        <div class="col-6">
                            <label class="control-label">Lĩnh vực hoạt động</label>
                            {!! Form::select('linhvuchoatdong', getLinhVucHoatDong(), null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Danh hiệu thi đua/Hình thức khen thưởng</label>
                            {!! Form::select('madanhhieukhenthuong', $a_dhkt_tapthe, null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>
                        {{-- <div class="col-md-6">
                            <label class="control-label">Danh hiệu thi đua</label>
                            {!! Form::select('madanhhieutd', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Hình thức khen thưởng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, $inputs['mahinhthuckt'], ['class' => 'form-control']) !!}
                        </div> --}}
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
    <script>
        function setTapThe() {
            $('#frm_ThemTapThe').find("[name='id']").val('-1');
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ $inputs['url'] }}" + "LayTapThe",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='maphanloaitapthe']").val(data.maphanloaitapthe).trigger('change');
                    form.find("[name='linhvuchoatdong']").val(data.linhvuchoatdong).trigger('change');
                    form.find("[name='madanhhieukhenthuong']").val(data.madanhhieukhenthuong).trigger('change');
                    form.find("[name='tentapthe']").val(data.tentapthe);
                    form.find("[name='tencoquan']").val(data.tencoquan);
                }
            });
        }

        function LuuTapThe() {
            var formData = new FormData($('#frm_ThemTapThe')[0]);

            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "ThemTapThe",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    console.log(data);               
                    if (data.status == 'success') {
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        TableManaged4.init();
                    }
                }
            })
            $('#modal-create-tapthe').modal("hide");
        }
    </script>


    {{-- chưa dùng tiêu chuẩn --}}
    @include('NghiepVu._DungChung.modal_XoaDoiTuong')
    @include('NghiepVu._DungChung.modal_Excel')
    @include('NghiepVu._DungChung.modal_TaiLieuDinhKem')

    @include('NghiepVu._DungChung.modal_ThemPLDoiTuong')
    @include('NghiepVu._DungChung.modal_ThemDanhMuc')
    {{-- @include('NghiepVu._DungChung.modal_DoiTuong') --}}

@stop
