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
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin chi tiết quỹ thi đua, khen thưởng</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => $inputs['url'] . 'Sua',
            'class' => 'form',
            'id' => 'frm_ThayDoi',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('maso', null, ['id' => 'madonvi']) }}
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-12">
                    <label>Tên quỹ thi đua, khen thưởng</label>
                    {!! Form::text('tendonvi', $model->tenquy, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_thu">
                                            <span class="nav-icon">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <span class="nav-text">Thông tin thu</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_chi">
                                            <span class="nav-icon">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <span class="nav-text">Thông tin chi</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="kt_thu" role="tabpanel"
                                    aria-labelledby="kt_thu">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button type="button" onclick="setThuChi('THU')"
                                                    data-target="#modal-create-thu" data-toggle="modal"
                                                    class="btn btn-light-dark btn-icon btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dsthu">
                                        <div class="col-md-12">
                                            <table id="sample_3" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="5%">STT</th>
                                                        <th>Tên tiêu chí</th>
                                                        <th>Số tiền</th>
                                                        <th width="15%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_thu as $key => $tt)
                                                        <tr>
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tentieuchi }}</td>
                                                            <td class="text-right">
                                                                {{ dinhdangso($tt->sotien) }}
                                                            </td>
                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getThuChi('{{ $tt->id }}', 'THU')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-thu" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>
                                                                <button title="Xóa" type="button"
                                                                    onclick="delChiTiet('{{ $tt->id }}',  '{{ $inputs['url'] . 'XoaChiTiet' }}', 'THU')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-delete-khenthuong" data-toggle="modal">
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
                                <div class="tab-pane fade" id="kt_chi" role="tabpanel" aria-labelledby="kt_chi">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button title="Thêm đối tượng" type="button"
                                                    data-target="#modal-create-chi" data-toggle="modal"
                                                    class="btn btn-light-dark btn-icon btn-sm" onclick="setThuChi('CHI')">
                                                    <i class="fa fa-plus"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dschi">
                                        <div class="col-md-12">
                                            <table id="sample_4" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="5%">STT</th>
                                                        <th>Phân loại</th>
                                                        <th>Tên tiêu chí</th>
                                                        <th>Số tiền</th>
                                                        <th width="10%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_chi as $key => $tt)
                                                        <tr>
                                                            <td class="text-center">{{ $tt->stt }}</td>
                                                            <td>{{ $a_phannhom[$tt->phannhom] ?? '' }}</td>
                                                            <td>{{ $tt->tentieuchi }}</td>
                                                            <td class="text-right">
                                                                {{ dinhdangso($tt->sotien) }}
                                                            </td>
                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getThuChi('{{ $tt->id }}','CHI')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-chi" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>

                                                                <button title="Xóa" type="button"
                                                                    onclick="delChiTiet('{{ $tt->id }}',  '{{ $inputs['url'] . 'XoaCaNhan' }}', 'CANHAN')"
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url($inputs['url'] . 'ThongTin?madonvi=' . $model->madonvi . '&nam=' . $model->nam) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    {{-- <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button> --}}

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->


    {{-- Thu --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemThu',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="maso" value="{{ $model->maso }}" />
    <div class="modal fade bs-modal-lg" id="modal-create-thu" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin chi tiết</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="form-control-label">Tên tiêu chí</label>
                            {!! Form::text('tentieuchi', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label class="control-label">Số tiền</label>
                            {!! Form::number('sotien', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <label class="control-label">Số thứ tự</label>
                            {!! Form::number('stt', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuThu()">Hoàn thành</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Chi --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemChi',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="maso" value="{{ $model->maso }}" />
    <div class="modal fade bs-modal-lg" id="modal-create-chi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin chi tiết</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="form-control-label">Phân nhóm tiêu chí</label>
                            {!! Form::select('phannhom', $a_phannhom, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="form-control-label">Tên tiêu chí</label>
                            {!! Form::text('tentieuchi', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label class="control-label">Số tiền</label>
                            {!! Form::number('sotien', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <label class="control-label">Số thứ tự</label>
                            {!! Form::number('stt', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuChi()">Hoàn thành</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    <script>
        function setThuChi(phanloai) {
            if (phanloai == 'THU')
                $('#frm_ThemThu').find("[name='id']").val('-1');
            else
                $('#frm_ThemChi').find("[name='id']").val('-1');
        }


        function getThuChi(id, phanloai) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ $inputs['url'] }}" + "LayChiTiet",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    if (phanloai == 'THU') {
                        var form = $('#frm_ThemThu');
                        form.find("[name='id']").val(data.id);
                        form.find("[name='tentieuchi']").val(data.tentieuchi);
                        form.find("[name='sotien']").val(data.sotien);
                        form.find("[name='stt']").val(data.stt);
                    } else {
                        var form = $('#frm_ThemChi');
                        form.find("[name='id']").val(data.id);
                        form.find("[name='tentieuchi']").val(data.tentieuchi);
                        form.find("[name='sotien']").val(data.sotien);
                        form.find("[name='phannhom']").val(data.phannhom).trigger('change');
                        form.find("[name='stt']").val(data.stt);
                    }
                }
            });
        }

        function LuuThu() {
            var formData = new FormData($('#frm_ThemThu')[0]);

            $.ajax({
                url: "{{ $inputs['url'] }}" + "ThemThu",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#dsthu').replaceWith(data.message);
                        TableManaged3.init();
                    }
                }
            })
            $('#modal-create-thu').modal("hide");
        }

        function LuuChi() {
            var formData = new FormData($('#frm_ThemChi')[0]);

            $.ajax({
                url: "{{ $inputs['url'] }}" + "ThemChi",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#dschi').replaceWith(data.message);
                        TableManaged4.init();
                    }
                }
            })
            $('#modal-create-chi').modal("hide");
        }
    </script>

    {{-- Xóa khen thưởng --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_XoaDoiTuong',
        'class' => 'form',
    ]) !!}
    <div class="modal fade" id="modal-delete-khenthuong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa thông tin đối tượng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" id="iddelete" name="iddelete">
                <input type="hidden" id="phanloaixoa" name="phanloaixoa">
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="confirmXoaKhenThuong()">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    <script>
        function delChiTiet(id, url, phanloai) {
            $('#frm_XoaDoiTuong').attr('action', url);
            $('#frm_XoaDoiTuong').find("[name='iddelete']").val(id);
            $('#frm_XoaDoiTuong').find("[name='phanloaixoa']").val(phanloai);
        }

        function confirmXoaKhenThuong() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_XoaDoiTuong');
            var phanloai = form.find("[name='phanloaixoa']").val();
            var id = form.find("[name='iddelete']").val();


            $.ajax({
                url: form.attr('action'),
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    phanloai: phanloai
                },
                dataType: 'JSON',
                success: function(data) {
                    toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                    if (phanloai == 'THU') {
                        $('#dsthu').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });
                    } else {
                        $('#dschi').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                    }


                }
            });

            $('#modal-delete-khenthuong').modal("hide");
        }
    </script>


@stop
