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
                <h3 class="card-label text-uppercase">Thông tin ý kiến góp ý</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => '/YKienGopY/Sua',
            'class' => 'form',
            'id' => 'frm_ThayDoi',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('magopy', null, ['id' => 'magopy']) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="control-label">Tiêu đề</label>
                    {!! Form::text('tieude', null, ['class' => 'form-control ']) !!}
                </div>
                <div class="col-lg-12">
                    <label class="control-label">Nội dung</label>
                    {!! Form::textarea('noidung', null, ['id' => 'noidung', 'class' => 'form-control','rows' => '3']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tailieu">
                                            <span class="nav-icon">
                                                <i class="far flaticon-folder-1"></i>
                                            </span>
                                            <span class="nav-text">Tài liệu đính kèm</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane fade active show" id="kt_tailieu" role="tabpanel"
                                    aria-labelledby="kt_tailieu">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button title="Thêm đối tượng" type="button" data-target="#modal-tailieu"
                                                    data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm"
                                                    onclick="setTaiLieu()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dstailieu">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover dulieubang">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="2%">STT</th>
                                                        <th>Nội dung</th>
                                                        <th width="15%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_tailieu as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td class="text-center">{{ $tt->noidung }}</td>

                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getTaiLieu('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-tailieu" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>
                                                                <button title="Xóa" type="button"
                                                                    onclick="delTaiLieu('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-delete-tailieu" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i>
                                                                </button>
                                                                @if ($tt->tentailieu != '')
                                                                    <a target="_blank" title="Tải file đính kèm"
                                                                        href="{{ '/data/tailieudinhkem/' . $tt->tentailieu }}"
                                                                        class="btn btn-clean btn-icon btn-sm"><i
                                                                            class="fa flaticon-download text-info"></i>
                                                                    </a>
                                                                @endif
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
                    <a href="{{ url('/YKienGopY/ThongTin') }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->
    {{-- Xóa Tài liệu đính kèm --}}
    {!! Form::open([
        'url' => '/DungChung/TaiLieuDinhKem/XoaTaiLieu',
        'id' => 'frm_XoaTaiLieu',
        'class' => 'form',
    ]) !!}
    <div class="modal fade" id="modal-delete-tailieu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa thông tin tài liệu?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="id">
                <input type="hidden" name="madonvi" value="{{ $model->madonvi }}" />
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="confirmXoaTaiLieu()">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}


    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemTaiLieu',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="mahosotdkt" value="{{ $model->magopy }}" />
    <input type="hidden" name="madonvi" value="{{ $model->madonvi }}" />
    <input type="hidden" name="phanloaihoso" value="{{ $inputs['phanloaihoso'] }}" />
    <input type="hidden" name="phanloai" value="{{$inputs['phanloai']}}" />
    <div class="modal fade bs-modal-lg" id="modal-tailieu" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin tài liệu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Nội dung</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Tài liệu đính kèm: </label>
                            {!! Form::file('tentailieu', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTaiLieu()">Hoàn thành</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        function delTaiLieu(id) {
            $('#frm_XoaTaiLieu').find("[name='id']").val(id);
        }

        function confirmXoaTaiLieu() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // var form = $('#frm_XoaTaiLieu');
            $.ajax({
                url: '/DungChung/TaiLieuDinhKem/XoaTaiLieu',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: $('#frm_XoaTaiLieu').find("[name='id']").val(),
                    phanloaihoso: "{{ $inputs['phanloaihoso'] }}",
                    madonvi: $('#frm_XoaTaiLieu').find("[name='madonvi']").val(),
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    toastr.success("Bạn đã xóa thông tin tài liệu thành công!", "Thành công!");
                    $('#dstailieu').replaceWith(data.message);
                    jQuery(document).ready(function() {
                        TableManagedclass.init();
                    });
                }
            });
            $('#modal-delete-tailieu').modal("hide");
        }

        function setTaiLieu() {
            $('#frm_ThemTaiLieu').find("[name='id']").val('-1');
            $('#frm_ThemTaiLieu').find("[name='noidung']").val('');
        }

        function getTaiLieu(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/DungChung/TaiLieuDinhKem/LayTaiLieu",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    phanloaihoso: "{{ $inputs['phanloaihoso'] }}"
                },
                dataType: 'JSON',
                success: function(data) {
                    // console.log(data);
                    var form = $('#frm_ThemTaiLieu');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='phanloai']").val(data.phanloai);
                    form.find("[name='noidung']").val(data.noidung);
                }
            });
        }
        function LuuTaiLieu() {
            if (!$('#frm_ThemTaiLieu').find("[name='tentailieu']").val() && $('#frm_ThemTaiLieu').find("[name='id']")
                .val() == '-1') {
                toastr.error("Chưa có tài liệu đính kèm", "Lỗi !!!");
            } else {
                var formData = new FormData($('#frm_ThemTaiLieu')[0]);
                $.ajax({
                    url: "/DungChung/TaiLieuDinhKem/ThemTaiLieu",
                    method: "POST",
                    cache: false,
                    dataType: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            $('#dstailieu').replaceWith(data.message);
                            TableManagedclass.init();
                        }
                    }
                });
                $('#modal-tailieu').modal("hide");
            }
        }
    </script>
@stop
