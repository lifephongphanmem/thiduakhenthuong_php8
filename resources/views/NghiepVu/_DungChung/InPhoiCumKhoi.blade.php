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
                <h3 class="card-label text-uppercase">Thông tin hồ sơ khen thưởng</h3>
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
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosotdkt', null, ['id' => 'mahosotdkt']) }}
        <input type="hidden" name="mahoso" value="{{ $inputs['mahosotdkt'] }}" />
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Tên đơn vị</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control', 'disabled']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Phân loại hồ sơ</label>
                    {!! Form::select('phanloai', getPhanLoaiHoSo(), null, ['class' => 'form-control']) !!}
                </div>
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
                            <div class="card-toolbar"></div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="kt_tapthe" role="tabpanel"
                                    aria-labelledby="kt_tapthe">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                {{-- <button type="button" onclick="setTapThe()"
                                                    data-target="#modal-create-tapthe" data-toggle="modal"
                                                    class="btn btn-light-dark btn-icon btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                </button> --}}

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
                                                        <th>Nôi dung khen thưởng</th>
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                                                        <th width="15%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_tapthe as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tentapthe }}</td>
                                                            <td>{{ $tt->noidungkhenthuong }}</td>
                                                            <td class="text-center">
                                                                {{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- <button title="Sửa thông tin" type="button"
                                                                    onclick="getTapThe('{{ $tt->id }}', 'TAPTHE')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-thaydoi" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary icon-2x"></i>
                                                                </button> --}}
                                                                <a target="_blank" title="In phôi bằng khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InBangKhen?phanloaikhenthuong=CUMKHOI&phanloaidoituong=TAPTHE&id=' . $tt->id.'&madonvi='.$inputs['madonvi']) }}"
                                                                    class="btn btn-sm btn-clean btn-icon">
                                                                    <i
                                                                        class="icon-lg la la-file-invoice text-dark icon-2x"></i>
                                                                </a>
                                                                <a target="_blank" title="In phôi giấy khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InGiayKhen?phanloaikhenthuong=CUMKHOI&phanloaidoituong=TAPTHE&id=' . $tt->id.'&madonvi='.$inputs['madonvi']) }}"
                                                                    class="btn btn-sm btn-clean btn-icon">
                                                                    <i
                                                                        class="icon-lg la la-file-contract text-dark icon-2x"></i>
                                                                </a>
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
                                                {{-- <button title="Thêm đối tượng" type="button" data-target="#modal-create"
                                                    data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm"
                                                    onclick="setCaNhan()">
                                                    <i class="fa fa-plus"></i>
                                                </button> --}}


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
                                                        <th>Nôi dung khen thưởng</th>
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                                                        <th width="10%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_canhan as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tendoituong }}</td>
                                                            <td>{{ $tt->noidungkhenthuong }}</td>
                                                            <td class="text-center">
                                                                {{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- <button title="Sửa thông tin" type="button"
                                                                    onclick="getCaNhan('{{ $tt->id }}', 'CANHAN')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-thaydoi" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary icon-2x"></i>
                                                                </button> --}}
                                                                <a target="_blank" title="In phôi bằng khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InBangKhen?phanloaikhenthuong=CUMKHOI&phanloaidoituong=CANHAN&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-sm btn-clean btn-icon">
                                                                    <i
                                                                        class="icon-lg la la-file-invoice text-dark icon-2x"></i>
                                                                </a>
                                                                <a target="_blank" title="In phôi giấy khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InGiayKhen?phanloaikhenthuong=CUMKHOI&phanloaidoituong=CANHAN&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-sm btn-clean btn-icon">
                                                                    <i
                                                                        class="icon-lg la la-file-contract text-dark icon-2x"></i>
                                                                </a>
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
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

    {!! Form::open([
        'url' => '/DungChung/NoiDungKhenThuong',
        'id' => 'frm_ThayDoi',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="phanloai" />
    <div class="modal fade bs-modal-lg" id="modal-thaydoi" tabindex="-1" role="dialog" aria-hidden="true">
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
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Nội dung khen thưởng</label>
                            {!! Form::textarea('noidungkhenthuong', null, [
                                'class' => 'form-control',
                                'rows' => '2',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="submit" class="btn btn-primary">Hoàn thành</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        function getCaNhan(id, phanloai) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/DungChung/LayKhenThuongCaNhan",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThayDoi');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='tendoituong']").val(data.tendoituong);
                    form.find("[name='noidungkhenthuong']").val(data.noidungkhenthuong);
                    form.find("[name='phanloai']").val(phanloai);
                }
            })
        }

        function getTapThe(id, phanloai) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/DungChung/LayKhenThuongTapThe",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThayDoi');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='tendoituong']").val(data.tentapthe);
                    form.find("[name='noidungkhenthuong']").val(data.noidungkhenthuong);
                    form.find("[name='phanloai']").val(phanloai);
                }
            })
        }
    </script>
@stop
