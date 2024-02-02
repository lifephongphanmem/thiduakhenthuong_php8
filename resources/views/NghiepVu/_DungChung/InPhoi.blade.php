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
                    {!! Form::select('phanloai', getPhanLoaiHoSo(), null, ['class' => 'form-control', 'disabled']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2, 'readonly' => 'true']) !!}
                </div>
            </div>

            <div class="form-group row muted">
                <div class="col-6">
                    <label>Số quyết định</label>
                    {!! Form::text('soqd', null, ['class' => 'form-control muted', 'readonly' => 'true']) !!}
                </div>

                <div class="col-6">
                    <label>Ngày ra quyết định</label>
                    {!! Form::input('date', 'ngayqd', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-6">
                    <label>Chức vụ người ký</label>
                    {!! Form::text('chucvunguoikyqd', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>
                <div class="col-6">
                    <label>Họ tên người ký</label>
                    {!! Form::text('hotennguoikyqd', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
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
                                                {{-- <a target="_blank" title="In phôi bằng khen"
                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InDanhSachBangKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=TAPTHE&mahoso=' . $inputs['mahosotdkt'] . '&madonvi=' . $inputs['madonvi']) }}"
                                                    class="btn btn-light-dark btn-sm">
                                                    <i class="icon-lg la la-file-invoice"></i>Phôi BK
                                                </a> --}}

                                                <button onclick="setBangKhen('KHENTHUONG','TAPTHE')"
                                                    title="In danh sách bằng khen" data-target="#modal-danhsach"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-light-dark btn-sm mr-2">
                                                    <i class="icon-lg la la-file-invoice"></i>Bằng khen
                                                </button>

                                                <button onclick="setGiayKhen('KHENTHUONG','TAPTHE')"
                                                    title="In danh sách giấy khen" data-target="#modal-danhsach-giaykhen"
                                                    data-toggle="modal" type="button" class="btn btn-light-dark btn-sm">
                                                    <i class="icon-lg la la-file-invoice"></i>Giấy khen
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dskhenthuongtapthe">
                                        <div class="col-md-12">
                                            <table id="sample_4" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="2%">STT</th>
                                                        <th>Tên tập thể</th>
                                                        <th>Nôi dung khen thưởng</th>
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                                                        <th width="25%">Thao tác</th>
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
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button> --}}

                                                                <a target="_blank" title="In phôi bằng khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InBangKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=TAPTHE&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs">
                                                                    <i class="icon-lg la la-file-invoice text-dark"></i>Phôi
                                                                    BK
                                                                </a>

                                                                <a target="_blank" title="In phôi bằng khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InMauBangKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=TAPTHE&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs mr-1 mb-1 mt-1">
                                                                    <i class="icon-lg la la-file-invoice text-dark"></i>Màu
                                                                    BK
                                                                </a>

                                                                <a target="_blank" title="In phôi giấy khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InGiayKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=TAPTHE&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs mr-1 mb-1 mt-1">
                                                                    <i
                                                                        class="icon-lg la la-file-contract text-dark"></i>Phôi
                                                                    GK
                                                                </a>
                                                                <a target="_blank" title="In phôi giấy khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InMauGiayKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=TAPTHE&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs mr-1 mb-1 mt-1">
                                                                    <i class="icon-lg la la-file-contract text-dark"></i>Màu
                                                                    GK
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
                                                <button onclick="setBangKhen('KHENTHUONG','CANHAN')"
                                                    title="In danh sách bằng khen" data-target="#modal-danhsach"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-light-dark btn-sm mr-2">
                                                    <i class="icon-lg la la-file-invoice"></i>Bằng khen
                                                </button>

                                                <button onclick="setGiayKhen('KHENTHUONG','CANHAN')"
                                                    title="In danh sách giấy khen" data-target="#modal-danhsach-giaykhen"
                                                    data-toggle="modal" type="button" class="btn btn-light-dark btn-sm">
                                                    <i class="icon-lg la la-file-invoice"></i>Giấy khen
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dskhenthuongcanhan">
                                        <div class="col-md-12">
                                            <table id="sample_3" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>STT</th>
                                                        <th>Tên đối tượng</th>
                                                        <th>Nôi dung khen thưởng</th>
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                                                        <th width="30%">Thao tác</th>
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
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button> --}}
                                                                <a target="_blank" title="In phôi bằng khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InBangKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=CANHAN&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs">
                                                                    <i
                                                                        class="icon-lg la la-file-invoice text-dark"></i>Phôi
                                                                    BK
                                                                </a>

                                                                <a target="_blank" title="In phôi bằng khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InMauBangKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=CANHAN&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs mr-1 mb-1 mt-1">
                                                                    <i class="icon-lg la la-file-invoice text-dark"></i>Màu
                                                                    BK
                                                                </a>

                                                                <a target="_blank" title="In phôi giấy khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InGiayKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=CANHAN&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs mr-1 mb-1 mt-1">
                                                                    <i
                                                                        class="icon-lg la la-file-contract text-dark"></i>Phôi
                                                                    GK
                                                                </a>
                                                                <a target="_blank" title="In phôi giấy khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InMauGiayKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=CANHAN&id=' . $tt->id . '&madonvi=' . $inputs['madonvi']) }}"
                                                                    class="btn btn-xs mr-1 mb-1 mt-1">
                                                                    <i
                                                                        class="icon-lg la la-file-contract text-dark"></i>Màu
                                                                    GK
                                                                </a>


                                                                {{-- <a target="_blank" title="In phôi bằng khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InBangKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=CANHAN&id=' . $tt->id) }}"
                                                                    class="btn btn-sm btn-clean btn-icon">
                                                                    <i class="icon-lg la la-file-invoice text-dark"></i>
                                                                </a>
                                                                <a target="_blank" title="In phôi giấy khen"
                                                                    href="{{ url('/DungChung/InPhoiKhenThuong/InGiayKhen?phanloaikhenthuong=KHENTHUONG&phanloaidoituong=CANHAN&id=' . $tt->id) }}"
                                                                    class="btn btn-sm btn-clean btn-icon">
                                                                    <i class="icon-lg la la-file-contract text-dark"></i>
                                                                </a> --}}
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

    <!-- In danh sách bằng khen -->
    {!! Form::open([
        'url' => '/DungChung/InPhoiKhenThuong/InDanhSachBangKhen',
        'target' => '_blank',
        'id' => 'frm_PhoiDanhSachBK',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="phanloaikhenthuong" />
    <input type="hidden" name="phanloaidoituong" />
    <input type="hidden" name="mahoso" value="{{ $inputs['mahosotdkt'] }}" />
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div class="modal fade bs-modal-lg" id="modal-danhsach" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin chi tiết</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Nội dung khen thưởng</label>
                            {!! Form::textarea('noidungkhenthuong', null, [
                                'class' => 'form-control',
                                'rows' => '2',
                                'placeholder' => 'Nội dung khen thưởng thay nội dung theo từng đối tượng',
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

    <!-- In danh sách giấy khen -->
    {!! Form::open([
        'url' => '/DungChung/InPhoiKhenThuong/InDanhSachGiayKhen',
        'target' => '_blank',
        'id' => 'frm_PhoiDanhSachGK',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="phanloaikhenthuong" />
    <input type="hidden" name="phanloaidoituong" />
    <input type="hidden" name="mahoso" value="{{ $inputs['mahosotdkt'] }}" />
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div class="modal fade bs-modal-lg" id="modal-danhsach-giaykhen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin chi tiết</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Nội dung khen thưởng</label>
                            {!! Form::textarea('noidungkhenthuong', null, [
                                'class' => 'form-control',
                                'rows' => '2',
                                'placeholder' => 'Nội dung khen thưởng thay nội dung theo từng đối tượng',
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
        function setBangKhen(phanloaikhenthuong, phanloaidoituong) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_PhoiDanhSachBK');
            form.find("[name='phanloaikhenthuong']").val(phanloaikhenthuong);
            form.find("[name='phanloaidoituong']").val(phanloaidoituong);
        }

        function setGiayKhen(phanloaikhenthuong, phanloaidoituong) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_PhoiDanhSachGK');
            form.find("[name='phanloaikhenthuong']").val(phanloaikhenthuong);
            form.find("[name='phanloaidoituong']").val(phanloaidoituong);
        }

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
