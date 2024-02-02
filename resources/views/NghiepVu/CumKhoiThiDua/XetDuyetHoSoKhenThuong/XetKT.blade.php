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

        function confirmDoiTuong(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "LayDoiTuong",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemCaNhan');
                    form.find("[name='tendoituong']").val(data.tendoituong);
                    form.find("[name='ngaysinh']").val(data.ngaysinh);
                    form.find("[name='gioitinh']").val(data.gioitinh).trigger('change');;
                    form.find("[name='chucvu']").val(data.chucvu);
                    form.find("[name='maccvc']").val(data.maccvc);
                    form.find("[name='lanhdao']").val(data.lanhdao).trigger('change');
                }
            })
            $('#modal-doituong').modal("hide");
        }

        function confirmTapThe(tentapthe) {
            var form = $('#frm_ThemTapThe');
            form.find("[name='tentapthe']").val(tentapthe);
            $('#modal-tapthe').modal("hide");
        }


        function delKhenThuong(id, url, phanloai) {
            $('#frm_XoaDoiTuong').attr('action', url);
            $('#frm_XoaDoiTuong').find("[name='iddelete']").val(id);
            $('#frm_XoaDoiTuong').find("[name='phanloaixoa']").val(phanloai);
        }

        function confirmXoaKhenThuong() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_XoaDoiTuong');
            var phanloai = form.find("[name='phanloaixoa']").val();

            if (phanloai == 'TAPTHE')
                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: {
                        _token: CSRF_TOKEN,
                        id: $('#iddelete').val(),
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });

                    }
                });
            else
                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: {
                        _token: CSRF_TOKEN,
                        id: $('#iddelete').val(),
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                        $('#dskhenthuongcanhan').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });

                    }
                });

            $('#modal-delete-khenthuong').modal("hide");
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
                <h3 class="card-label text-uppercase">Thông tin hồ sơ đề nghị khen thưởng theo cụm, khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => $inputs['url_qd'] . 'Sua',
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
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_detai">
                                            <span class="nav-icon">
                                                <i class="far fa-newspaper"></i>
                                            </span>
                                            <span class="nav-text">Đề tài sáng kiến</span>
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
                                                    class="btn btn-info btn-icon btn-sm"><i
                                                        class="fas flaticon-list"></i></button>
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
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
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
                                                                {{ $a_dhkt_tapthe[$tt->madanhhieukhenthuong] ?? '' }}</td>

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
                                                    class="btn btn-info btn-icon btn-sm"><i
                                                        class="fas flaticon-list"></i></button>
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
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
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
                                                                {{ $a_dhkt_canhan[$tt->madanhhieukhenthuong] ?? '' }}</td>
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
                                <div class="tab-pane fade" id="kt_detai" role="tabpanel" aria-labelledby="kt_detai">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button type="button" onclick="setDeTai()" data-target="#modal-detai"
                                                    data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm">
                                                    <i class="fa fa-plus"></i></button>
                                                <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-info btn-icon btn-sm"><i
                                                        class="fas fa-file-import"></i></button>
                                                <a target="_blank" title="Tải file mẫu" href="/data/download/DeTai.xlsx"
                                                    class="btn btn-primary btn-icon btn-sm"><i
                                                        class="fa flaticon-download"></i></button></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dsdetai">
                                        <div class="col-md-12">
                                            <table id="sample_5" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="5%">STT</th>
                                                        <th>Tên đề tài, sáng kiến</th>
                                                        <th>Thông tin tác giả</th>
                                                        <th width="10%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_detai as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tensangkien }}</td>
                                                            <td class="text-center">
                                                                {{ $tt->tendoituong . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- <button title="Sửa thông tin" type="button"
                                                                    onclick="getDeTai('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-detai"
                                                                    data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button> --}}
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
                    <a href="{{ url($inputs['url_xd'] . 'DanhSach?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

    @include('NghiepVu._DungChung.modal_QD_GanKT')
    @include('NghiepVu._DungChung.modal_QD_CaNhan')
    @include('NghiepVu._DungChung.modal_QD_TapThe')
@stop
