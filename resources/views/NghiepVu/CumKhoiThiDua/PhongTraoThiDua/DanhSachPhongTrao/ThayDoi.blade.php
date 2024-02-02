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

        function ThemTieuChuan() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var batbuoc = $("#batbuoc").is(":checked");
            $.ajax({
                url: "{{ $inputs['url'] }}" + 'ThemTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    batbuoc: batbuoc,
                    matieuchuandhtd: $('#frmThemTieuChuan').find("[name='matieuchuandhtd']").val(),
                    tentieuchuandhtd: $('#frmThemTieuChuan').find("[name='tentieuchuandhtd']").val(),
                    phanloaidoituong: $('#frmThemTieuChuan').find("[name='phanloaidoituong']").val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.success("Bổ xung thông tin thành công!");
                        $('#dstieuchuan').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                    }
                }
            });
            $('#modal-tieuchuan').modal("hide");
        }

        function setTieuChuan() {
            $('#frmThemTieuChuan').find("[name='matieuchuandhtd']").val('-1');
        }

        function getTieuChuan(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ $inputs['url'] }}" + 'LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#frmThemTieuChuan').find("[name='tentieuchuandhtd']").val(data.tentieuchuandhtd);
                    $('#frmThemTieuChuan').find("[name='matieuchuandhtd']").val(data.matieuchuandhtd)
                    $('#frmThemTieuChuan').find("[name='phanloaidoituong']").val(data.phanloaidoituong).trigger(
                        'change');
                    if (data.batbuoc == 1) {
                        $('#frmThemTieuChuan').find("[name='batbuoc']").prop('checked', true);
                    } else
                        $('#frmThemTieuChuan').find("[name='batbuoc']").prop('checked', false);
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
                <h3 class="card-label text-uppercase">Thông tin chi tiết phong trào thi đua trong cụm, khối</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            $inputs['url'] . 'Them',
            'class' => 'form',
            'id' => 'frm_ThayDoi',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('madonvi', null) }}
        {{ Form::hidden('maphongtraotd', null) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Đơn vị phát động</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control text-success text-bold', 'readonly']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Cụm, khối thi đua</label>
                    {!! Form::select('macumkhoi', $a_cumkhoi, null, ['class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3">
                    <label>Số quyết định<span class="require">*</span></label>
                    {!! Form::text('soqd', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Ngày ra quyết định<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayqd', null, ['class' => 'form-control', 'required']) !!}
                </div>


                <div class="col-lg-3">
                    <label>Ngày nhận hồ sơ<span class="require">*</span></label>
                    {!! Form::input('date', 'tungay', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Ngày kết thúc<span class="require">*</span></label>
                    {!! Form::input('date', 'denngay', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control select2basic']) !!}
                </div>
                
                <div class="col-lg-3">
                    <label>Đợt xét khen thưởng</label>
                    {!! Form::select('dotxetkhenthuong', getPhanLoaiDotXetKhenThuong(), null, ['class' => 'form-control select2basic']) !!}
                </div>
            
                <div class="col-lg-3">
                    <label>Thời hạn thi đua</label>
                    {!! Form::select('thoihanthidua', getThoiHanThiDua(), null, ['class' => 'form-control select2basic']) !!}
                </div>
                
                <div class="col-lg-3">
                    <label>Phương thức tổ chức</label>
                    {!! Form::select('phuongthuctochuc', getPhuongThucToChucPhongTrao(), null, ['class' => 'form-control select2basic']) !!}
                </div>
            </div>           

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Nội dung phong trào</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Khẩu hiệu phong trào</label>
                    {!! Form::textarea('khauhieu', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Quyết định: </label>
                    {!! Form::file('qdkt', null, ['id' => 'qdkt', 'class' => 'form-control']) !!}
                    @if ($model->qdkt != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/qdkt/' . $model->qdkt) }}" target="_blank">{{ $model->qdkt }}</a>
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
            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách tiêu chuẩn khen thưởng</h4>

            <div class="form-group row">
                <div class="col-lg-12">
                    <button onclick="setTieuChuan()" type="button" data-target="#modal-tieuchuan" data-toggle="modal"
                        class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i>&nbsp;Thêm</button>
                </div>
            </div>

            <div class="form-group row" id="dstieuchuan">
                <div class="col-lg-12">
                    <table id="sample_3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center" width="10%">STT</th>
                                <th style="text-align: center">Đối tượng áp dụng</th>
                                <th style="text-align: center">Tên tiêu chuẩn xét khen thưởng</th>
                                <th style="text-align: center" width="10%">Tiêu chuẩn</br>Bắt buộc</th>
                                <th style="text-align: center" width="12%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_tieuchuan as $key => $tt)
                                <tr class="odd gradeX">
                                    <td style="text-align: center">{{ $i++ }}</td>
                                    <td>{{ $a_phanloaidt[$tt->phanloaidoituong] ?? $tt->phanloaidoituong }}</td>
                                    <td>{{ $tt->tentieuchuandhtd }}</td>
                                    @if ($tt->batbuoc == 0)
                                        <td class="text-center"></td>
                                    @else
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-check text-success"></i></button>
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        <button title="Tiêu chuẩn" type="button"
                                            onclick="getTieuChuan('{{ $tt->id }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-edit text-dark"></i></button>
                                        <button title="Xóa" type="button" onclick="getId('{{ $tt->id }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash-alt text-danger"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

    {!! Form::open(['url' => '', 'files' => true, 'id' => 'frmThemTieuChuan', 'class' => 'horizontal-form']) !!}
    {{ Form::hidden('matieuchuandhtd', null) }}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin tiêu chuẩn khen thưởng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="control-label">Mô tả tiêu chuẩn</label>
                            {!! Form::select('phanloaidoituong', $a_phanloaidt, null, [
                                'id' => 'phanloaidoituong',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="control-label">Mô tả tiêu chuẩn</label>
                            {!! Form::textarea('tentieuchuandhtd', null, [
                                'id' => 'tentieuchuandhtd',
                                'class' => 'form-control',
                                'rows' => 3,
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-offset-4 col-lg-3">
                            <div class="md-checkbox">
                                <input type="checkbox" id="batbuoc" name="batbuoc" class="md-check">
                                <label for="batbuoc">
                                    <span></span><span class="check"></span><span class="box"></span>Tiêu chuẩn bắt
                                    buộc</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="ThemTieuChuan()">Cập nhật</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url' => $inputs['url'].'XoaTieuChuan', 'id' => 'frm_delete']) !!}
    <div id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý xoá?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    <input type="hidden" name="id" />
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickdelete()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        function getId(id) {
            $('#frm_delete').find("[name='id']").val(id);
        }

        function clickdelete() {
            $('#frm_delete').submit();
        }
    </script>
    <!--end::Card-->
@stop
