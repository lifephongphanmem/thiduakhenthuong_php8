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
                <h3 class="card-label text-uppercase">Thông tin hồ sơ khen thưởng theo chuyên đề</h3>
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
        {{ Form::hidden('maloaihinhkt', null, ['id' => 'maloaihinhkt']) }}
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Thông tin chung </h4>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tên đơn vị</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>
            </div>

            @if (session('admin')->hskhenthuong_totrinh)
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
            @endif

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            {{-- <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tờ trình: </label>
                    {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                    @if ($model->baocao != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/totrinh/' . $model->totrinh) }}"
                                target="_blank">{{ $model->totrinh }}</a>
                        </span>
                    @endif
                </div>

                <div class="col-lg-6">
                    <label>Báo cáo thành tích: </label>
                    {!! Form::file('baocao', null, ['id' => 'baocao', 'class' => 'form-control']) !!}
                    @if ($model->baocao != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/baocao/' . $model->baocao) }}" target="_blank">{{ $model->baocao }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Biên bản cuộc họp: </label>
                    {!! Form::file('bienban', null, ['id' => 'bienban', 'class' => 'form-control']) !!}
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
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
            </div> --}}

            @if ($model->trangthai == 'DKT')
                @include('NghiepVu._DungChung.HoSo_ThongTinQD')
            @endif

            @include('NghiepVu._DungChung.HoSo_DanhSachKhenThuong')
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
    @include('NghiepVu._DungChung.modal_CaNhan')
    @include('NghiepVu._DungChung.modal_TapThe')
    @include('NghiepVu._DungChung.modal_HoGiaDinh')
    @include('NghiepVu._DungChung.modal_TaiLieuDinhKem')
    {{-- chưa dùng tiêu chuẩn --}}
    @include('NghiepVu._DungChung.modal_TieuChuan')
    @include('NghiepVu._DungChung.modal_XoaDoiTuong')
    @include('NghiepVu._DungChung.modal_Excel')
    @include('NghiepVu._DungChung.modal_ThemDanhMuc')
    @include('NghiepVu._DungChung.modal_ThemPLDoiTuong')
    {{-- @include('NghiepVu._DungChung.modal_DoiTuong') --}}

@stop
