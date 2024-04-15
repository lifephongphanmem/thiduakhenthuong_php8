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
    </script>
@stop

@section('content')

    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách văn phòng hỗ trợ</h3>
            </div>
            <div class="card-toolbar">
                <a onclick="new_hs()" class="btn btn-xs btn-success mr-3" data-target="#edit-modal"
                data-toggle="modal"><i class="fa fa-plus"></i> &ensp;Thêm mới</a>
            </div>
        </div>
        <div class="card-body">
            @foreach ($a_vp as $vp)
            <?php $vanphong = $model_vp->where('vanphong', $vp)->sortby('stt'); ?>
            <div class="form-group row">
                {{ $vp }}
            </div>
            <table style="width:100%" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr class="uppercase text-center">
                        <th width="40%">
                            Cán bộ hỗ trợ
                        </th>
                        <th width="20%">
                            Chức vụ
                        </th>
                        <th width="20%">
                            Số điện thoại
                        </th>
                        <th>
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vanphong as $ct)
                        <tr class="text-center">
                            <td class="text-left">{{ $ct->hoten }}</td>
                            <td class="text-left">{{ $ct->chucvu }}</td>
                            <td>{{ $ct->sdt }}</td>
                            <td>
                                <button type="button" onclick="change('{{ $ct->maso }}')"
                                    class="btn btn-sm btn-clean btn-icon" data-target="#edit-modal"
                                    data-toggle="modal">
                                    <i class="con-lg la flaticon-edit-1 text-success"></i></button>

                                <button type="button" onclick="getId('{{ $ct->maso }}')"
                                    class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                    data-toggle="modal">
                                    <i class="icon-lg la flaticon-delete text-danger"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
        </div>
    </div>
    <!--end::Card-->


    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">

                <form action="{{ '/VanPhongHoTro/Store' }}" method="POST" id="frm_modify" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="maso" id="maso" />
                    <div class="modal-header">
                        <h4 class="modal-title">Thông tin cán bộ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                    </div>

                    <div class="modal-body">
                        <div class="row ml-1">
                            {{-- <div class="col-md-12"> --}}
                            <div class="col-md-10" style="padding-left: 0px;">
                                <label class="control-label">Văn phòng</label>
                                <select name="vanphong" id="vanphong" class="form-control">
                                    @foreach ($a_vp as $ct)
                                        <option value="{{ $ct }}">{{ $ct }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1" style="padding-left: 0px;">
                                <label class="control-label">&nbsp;&nbsp;&nbsp;</label>
                                <button type="button" class="btn btn-default" data-target="#modal-vanphong"
                                    data-toggle="modal">
                                    <i class="fa fa-plus"></i></button>
                            </div>
                            {{-- </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Họ tên cán bộ</label>
                                <input type="text" name="hoten" id="hoten" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Chức vụ</label>
                                <input type="text" name="chucvu" id="chucvu" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Số điện thoại</label>
                                <input type="text" name="sdt" id="sdt" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Sắp xếp</label>
                                <input type="text" name="stt" id="stt" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="modal-vanphong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin văn phòng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Tên văn phòng<span class="require">*</span></label>
                            <input type="text" name="vanphong_add" id="vanphong_add" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button class="btn btn-primary" onclick="add_vanphong()">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ '/VanPhongHoTro/Xoa' }}" method="POST" id="frm_delete">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Đồng ý xóa?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                    </div>
                    <input type="hidden" name="maso" id="maso">
                    <div class="modal-footer">
                        <button type="submit" class="btn blue" onclick="ClickDelete()">Đồng ý</button>
                        <button type="button" class="btn default" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        function getId(maso) {
            $('#frm_delete').find("[id='maso']").val(maso);
        }

        function ClickDelete() {
            $('#frm_delete').submit();
        }

        function add_vanphong() {
            $('#modal-vanphong').modal('hide');
            var gt = $('#vanphong_add').val();
            $('#vanphong').append(new Option(gt, gt, true, true));
            $('#vanphong').val(gt).trigger('change');
        }

        function new_hs() {
            $('#frm_modify').find("[id='maso']").val('NEW');
            $('#hoten').val(null);
            $('#chucvu').val(null);
            $('#sdt').val(null);
            $('#stt').val(99);
        }

        function change(maso, magoc, capdo) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/VanPhongHoTro/CapNhat',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    maso: maso,
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#frm_modify').find("[id='maso']").val(data.maso);
                    $('#vanphong').val(data.vanphong).trigger('change');
                    $('#hoten').val(data.hoten);
                    $('#chucvu').val(data.chucvu);
                    $('#sdt').val(data.sdt);
                    $('#stt').val(data.stt);
                },
                error: function(message) {
                    toastr.error(message, 'Lỗi!');
                }
            });
        }
    </script>
@stop
