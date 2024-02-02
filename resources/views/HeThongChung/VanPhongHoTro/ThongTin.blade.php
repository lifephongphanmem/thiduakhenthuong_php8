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
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách văn phòng hỗ trợ</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsvanphonghotro', 'thaydoi'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#modify-modal"
                        data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($a_vp as $vp)
                    <?php $vanphong = $model->where('vanphong', $vp)->sortby('stt'); ?>
                    <div class="col-md-{{ $col }}">
                        <!-- BEGIN PORTLET -->
                        <div class="card card-custom" style="min-height: 600px">
                            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label text-uppercase">{{ $vp }}</h3>
                                </div>
                                <div class="card-toolbar">
                                    <!--begin::Button-->
                                    <!--end::Button-->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-scrollable table-scrollable-borderless">
                                    <table class="table table-hover table-light">
                                        <thead>
                                            <tr class="uppercase">
                                                <th width="40%">
                                                    Cán bộ hỗ trợ
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
                                                <tr>
                                                    <td>{{ $ct->hoten }}</td>
                                                    <td>{{ $ct->sdt }}</td>
                                                    <td>
                                                        <button type="button" onclick="change('{{ $ct->maso }}')"
                                                            class="btn btn-default btn-xs mbs" data-target="#edit-modal"
                                                            data-toggle="modal">
                                                            <i class="fa fa-edit"></i> Sửa</button>

                                                        <button type="button" onclick="getId('{{ $ct->maso }}')"
                                                            class="btn btn-default btn-xs mbs" data-target="#delete-modal"
                                                            data-toggle="modal">
                                                            <i class="fa fa-trash-o"></i>&nbsp;Xóa</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--end::Card-->


    <!--Modal thông tin chi tiết -->
    {!! Form::open(['url' => 'VanPhongHoTro/Them', 'id' => 'frm_modify']) !!}
    <input type="hidden" name="id" />
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin địa bàn quản lý</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">

                        <div class="form-group row">
                            <div class="col-10">
                                <label class="control-label">Văn phòng</label>
                                {!! Form::select('vanphong', $a_vp, null, ['id' => 'vanphong', 'class' => 'form-control']) !!}
                            </div>
                            <div class="col-2">
                                <label class="control-label">Thêm</label>
                                <button type="button" class="btn btn-default btn-icon" data-target="#modal-vanphong"
                                    data-toggle="modal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Họ tên cán bộ</label>
                                {!! Form::text('hoten', null, ['id' => 'hoten', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Chức vụ</label>
                                {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label class="control-label">Số điện thoại</label>
                                {!! Form::text('sdt', null, ['id' => 'sdt', 'class' => 'form-control']) !!}
                            </div>

                            <div class="col-6">
                                <label class="control-label">Sắp xếp</label>
                                {!! Form::text('stt', null, ['id' => 'stt', 'class' => 'form-control']) !!}
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

    <div id="modal-vanphong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin văn phòng</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">Tên văn phòng<span class="require">*</span></label>
                            {!! Form::text('vanphong_add', null, [
                                'id' => 'vanphong_add',
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
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
                {!! Form::open(['url' => '/van_phong/delete', 'id' => 'frm_delete']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Đồng ý xóa?</h4>
                </div>
                <input type="hidden" name="maso" id="maso">
                <div class="modal-footer">
                    <button type="submit" class="btn blue" onclick="ClickDelete()">Đồng ý</button>
                    <button type="button" class="btn default" data-dismiss="modal">Hủy</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        function add() {
            $('#frm_modify').find("[id='id']").val('-1');
            $('#hoten').val(null);
            $('#chucvu').val(null);
            $('#sdt').val(null);
            $('#stt').val(99);
        }

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

        function change(maso, magoc, capdo) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/van_phong/get_chucnang',
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
