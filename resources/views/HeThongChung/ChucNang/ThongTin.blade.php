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

        function confirmDelete(id, url) {
            var form = $('#frm_delete');
            form.attr('action', url);
            form.find("[name='iddelete']").val(id);
        }

        function ClickDelete() {
            $('#frm_delete').submit();
        }

        function add() {
            var form = $('#frm_modify');
            form.find("[name='machucnang']").val('');
            form.find("[name='tenchucnang']").val('');
            form.find("[name='sapxep']").val('{{ count($model) + 1 }}');
            form.find("[name='capdo']").val(1).trigger('change');
            form.find("[name='machucnang_goc']").val('ALL').trigger('change');
            form.find("[name='sudung']").val('1').trigger('change');
            form.find("[name='tenbang']").val('');
            form.find("[name='api']").val('');
        }

        function getChucNang(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/ChucNang/LayChucNang',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_modify');
                    form.find("[name='machucnang']").val(data.machucnang);
                    form.find("[name='tenchucnang']").val(data.tenchucnang);
                    form.find("[name='sapxep']").val(data.sapxep);
                    form.find("[name='capdo']").val(data.capdo).trigger('change');
                    form.find("[name='machucnang_goc']").val(data.machucnang_goc).trigger('change');
                    form.find("[name='sudung']").val(data.sudung).trigger('change');
                    form.find("[name='tenbang']").val(data.tenbang);
                    form.find("[name='api']").val(data.api);
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='maloaihinhkt']").val(data.maloaihinhkt).trigger('change');
                    form.find("[name='trangthai']").val(data.trangthai).trigger('change');
                }
            });
        }

        function addChucNang(machucnang_goc, capdo, sapxep) {
            var form = $('#frm_modify');
            form.find("[name='machucnang']").val('');
            form.find("[name='tenchucnang']").val('');
            form.find("[name='sapxep']").val(sapxep);
            form.find("[name='capdo']").val(capdo).trigger('change');
            form.find("[name='machucnang_goc']").val(machucnang_goc).trigger('change');
            form.find("[name='sudung']").val('1').trigger('change');
            form.find("[name='tenbang']").val('');
            form.find("[name='api']").val('');
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách chức năng hệ thống</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('hethongchung_chucnang', 'thaydoi'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#modify-modal"
                        data-toggle="modal">
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
                                <th rowspan="2" width="10%">STT</th>
                                <th rowspan="2">Mã số</th>
                                <th rowspan="2">Tên chức năng</th>
                                <th colspan="3">Tham số mặc định</th>
                                <th rowspan="2" width="10%">Thao tác</th>
                            </tr>
                            <tr class="text-center">
                                <th width="12%">Hình thức</br>khen thưởng</th>
                                <th width="12%">Loại hình</br>khen thưởng</th>
                                <th width="12%">Trạng thái</br>hồ sơ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $c1)
                                <?php
                                $model_c2 = $m_chucnang->where('machucnang_goc', $c1->machucnang)->sortby('sapxep');
                                ?>
                                <tr>
                                    <td class="text-uppercase font-weight-bold text-info {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">{{ romanNumerals($c1->sapxep) }}</td>
                                    <td class="font-weight-bold {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">{{ $c1->machucnang }}</td>
                                    <td class="font-weight-bold {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">{{ $c1->tenchucnang }}</td>
                                    <td class="font-weight-bold {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">
                                        {{ $a_hinhthuckt[$c1->mahinhthuckt] ?? '' }}
                                    </td>
                                    <td class="font-weight-bold {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">
                                        {{ $a_loaihinhkt[$c1->maloaihinhkt] ?? '' }}
                                    </td>
                                    <td class="font-weight-bold {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">
                                        {{ $a_trangthaihs[$c1->trangthai] ?? '' }}
                                    </td>
                                    <td style="text-decoration: none;text-align: center">
                                        @if (chkPhanQuyen('hethongchung_chucnang', 'thaydoi'))
                                            <button onclick="getChucNang({{ $c1->id }})"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                title="Thay đổi thông tin" data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-primary"></i></button>
                                            {{-- chỉ để quyền SSA thêm chức năng mới --}}
                                            @if (session('admin')->capdo == 'SSA' && $c1->sudung == '1')
                                                <button
                                                    onclick="addChucNang('{{ $c1->machucnang }}','2','{{ count($model_c2) + 1 }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                    title="Thêm chức năng" data-toggle="modal">
                                                    <i class="icon-lg la fa-plus text-primary"></i>
                                                </button>
                                                <button title="Xóa thông tin" type="button"
                                                    onclick="confirmDelete('{{ $c1->id }}','/ChucNang/Xoa')"
                                                    class="btn btn-sm btn-clean btn-icon"
                                                    data-target="#delete-modal-confirm" data-toggle="modal">
                                                    <i class="icon-lg la fa-trash-alt text-danger"></i>
                                                </button>
                                            @endif
                                        @endif

                                    </td>
                                </tr>

                                @foreach ($model_c2 as $c2)
                                    <?php
                                    $sudung_c2 = $c2->sudung == 0 || $c1->sudung == 0 ? 0 : 1;
                                    $model_c3 = $m_chucnang->where('machucnang_goc', $c2->machucnang)->sortby('sapxep');
                                    ?>
                                    <tr>
                                        <td class="text-uppercase text-warning {{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">
                                            {{ romanNumerals($c1->sapxep) }}--{{ $c2->sapxep }}</td>
                                        <td class="{{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">{{ $c2->machucnang }}</td>
                                        <td class="{{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">{{ $c2->tenchucnang }}</td>
                                        <td class="{{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">{{ $a_hinhthuckt[$c2->mahinhthuckt] ?? '' }}</td>
                                        <td class="{{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">{{ $a_loaihinhkt[$c2->maloaihinhkt] ?? '' }}</td>
                                        <td class="{{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">{{ $a_trangthaihs[$c2->trangthai] ?? '' }}</td>
                                        <td style="text-decoration: none;text-align: center">
                                            @if (chkPhanQuyen('hethongchung_chucnang', 'thaydoi'))
                                                <button onclick="getChucNang({{ $c2->id }})"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                    title="Thay đổi thông tin" data-toggle="modal">
                                                    <i class="icon-lg la fa-edit text-dark"></i>
                                                </button>
                                                @if (session('admin')->capdo == 'SSA' && $sudung_c2 == '1')
                                                    <button
                                                        onclick="addChucNang('{{ $c2->machucnang }}','3','{{ count($model_c3) + 1 }}')"
                                                        class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                        title="Thêm chức năng" data-toggle="modal">
                                                        <i class="icon-lg la fa-plus text-dark"></i></button>
                                                    <button title="Xóa thông tin" type="button"
                                                        onclick="confirmDelete('{{ $c2->id }}','/ChucNang/Xoa')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#delete-modal-confirm" data-toggle="modal">
                                                        <i class="icon-lg la fa-trash-alt text-danger"></i>
                                                    </button>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>

                                    @foreach ($model_c3 as $c3)
                                        <?php
                                        $sudung_c3 = $c3->sudung == 0 || $sudung_c2 == 0 ? 0 : 1;
                                        $model_c4 = $m_chucnang->where('machucnang_goc', $c3->machucnang)->sortby('sapxep');
                                        ?>
                                        <tr>
                                            <td class="text-uppercase {{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">
                                                {{ romanNumerals($c1->sapxep) }}--{{ $c2->sapxep }}--{{ $c3->sapxep }}
                                            </td>
                                            <td class="{{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">{{ $c3->machucnang }}</td>
                                            <td class="{{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">{{ $c3->tenchucnang }}</td>
                                            <td class="{{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">{{ $a_hinhthuckt[$c3->mahinhthuckt] ?? '' }}</td>
                                            <td class="{{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">{{ $a_loaihinhkt[$c3->maloaihinhkt] ?? '' }}</td>
                                            <td class="{{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">{{ $a_trangthaihs[$c3->trangthai] ?? '' }}</td>
                                            <td style="text-align: center">
                                                @if (chkPhanQuyen('hethongchung_chucnang', 'thaydoi'))
                                                    <button onclick="getChucNang({{ $c3->id }})"
                                                        class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                        title="Thay đổi thông tin" data-toggle="modal">
                                                        <i class="icon-lg la fa-edit text-dark"></i></button>
                                                    @if (session('admin')->capdo == 'SSA' && $sudung_c3 == '1')
                                                        <button
                                                            onclick="addChucNang('{{ $c3->machucnang }}','4','{{ count($model_c4) + 1 }}')"
                                                            class="btn btn-sm btn-clean btn-icon"
                                                            data-target="#modify-modal" title="Thêm chức năng"
                                                            data-toggle="modal">
                                                            <i class="icon-lg la fa-plus text-dark"></i>
                                                        </button>
                                                        <button title="Xóa thông tin" type="button"
                                                            onclick="confirmDelete('{{ $c3->id }}','/ChucNang/Xoa')"
                                                            class="btn btn-sm btn-clean btn-icon"
                                                            data-target="#delete-modal-confirm" data-toggle="modal">
                                                            <i class="icon-lg la fa-trash-alt text-danger"></i>
                                                        </button>
                                                    @endif
                                                @endif

                                            </td>
                                        </tr>

                                        @foreach ($model_c4 as $c4)
                                            <?php
                                            $sudung_c4 = $c4->sudung == 0 || $sudung_c3 == 0 ? 0 : 1;
                                            ?>
                                            <tr>
                                                <td class="text-uppercase {{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">
                                                    {{ romanNumerals($c1->sapxep) }}--{{ $c2->sapxep }}--{{ $c3->sapxep }}--{{ $c4->sapxep }}
                                                </td>
                                                <td class="{{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">{{ $c4->machucnang }}</td>
                                                <td class="{{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">{{ $c4->tenchucnang }}</td>
                                                <td class="{{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">{{ $a_hinhthuckt[$c4->mahinhthuckt] ?? '' }}</td>
                                                <td class="{{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">{{ $a_loaihinhkt[$c4->maloaihinhkt] ?? '' }}</td>
                                                <td class="{{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">{{ $a_trangthaihs[$c4->trangthai] ?? '' }}</td>
                                                <td style="text-align: center">
                                                    @if (chkPhanQuyen('hethongchung_chucnang', 'thaydoi'))
                                                        <button onclick="getChucNang({{ $c4->id }})"
                                                            class="btn btn-sm btn-clean btn-icon"
                                                            data-target="#modify-modal" title="Thay đổi thông tin"
                                                            data-toggle="modal">
                                                            <i class="icon-lg la fa-edit text-dark"></i>
                                                        </button>
                                                        @if (session('admin')->capdo == 'SSA' && $sudung_c4 == '1')
                                                            <button title="Xóa thông tin" type="button"
                                                                onclick="confirmDelete('{{ $c4->id }}','/ChucNang/Xoa')"
                                                                class="btn btn-sm btn-clean btn-icon"
                                                                data-target="#delete-modal-confirm" data-toggle="modal">
                                                                <i class="icon-lg la fa-trash-alt text-danger"></i>
                                                            </button>
                                                        @endif
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
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
    {!! Form::open(['url' => '/ChucNang/ThongTin', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin chức năng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('machucnang', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="col-lg-8">
                                <label class="control-label">Tên chức năng<span class="require">*</span></label>
                                {!! Form::text('tenchucnang', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label class="control-label">Cấp độ</label>
                                {!! Form::select('capdo', ['1' => '1', '2' => '2', '3' => '3', '4' => '4'], null, [
                                    'class' => 'form-control select2_modal',
                                ]) !!}
                            </div>

                            <div class="col-lg-6">
                                <label class="control-label">Số thứ tự</label>
                                {!! Form::text('sapxep', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label class="control-label">Chức năng gốc</label>
                                {!! Form::select('machucnang_goc', setArrayAll($a_chucnanggoc, 'Không chọn'), null, [
                                    'class' => 'form-control select2_modal',
                                ]) !!}
                            </div>
                        </div>

                        @if (session('admin')->capdo == 'SSA')
                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label class="control-label">Tên bảng dữ liệu</label>
                                    {!! Form::text('tenbang', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="col-lg-8">
                                    <label class="control-label">Link API</label>
                                    {!! Form::text('api', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label class="control-label">Trạng thái</label>
                                    {!! Form::select('sudung', ['0' => 'Khóa chức năng', '1' => 'Đang sử dụng'], null, [
                                        'class' => 'form-control select2_modal',
                                    ]) !!}
                                </div>
                            </div>
                        @endif
                        <hr>
                        <h4>Tham số mặc định</h4>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label class="control-label">Hình thức khen thưởng</label>
                                {!! Form::select('mahinhthuckt', setArrayAll($a_hinhthuckt, 'Không chọn'), null, [
                                    'class' => 'form-control select2_modal',
                                ]) !!}
                            </div>

                            <div class="col-lg-4">
                                <label class="control-label">Loại hình khen thưởng</label>
                                {!! Form::select('maloaihinhkt', setArrayAll($a_loaihinhkt, 'Không chọn'), null, [
                                    'class' => 'form-control select2_modal',
                                ]) !!}
                            </div>

                            <div class="col-lg-4">
                                <label class="control-label">Trạng thái hồ sơ</label>
                                {!! Form::select('trangthai', setArrayAll($a_trangthaihs, 'Không chọn'), null, [
                                    'class' => 'form-control select2_modal',
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

    <div class="modal fade" id="delete-modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => '', 'id' => 'frm_delete']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <input type="hidden" name="iddelete" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" onclick="ClickDelete()">Đồng ý</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




@stop
