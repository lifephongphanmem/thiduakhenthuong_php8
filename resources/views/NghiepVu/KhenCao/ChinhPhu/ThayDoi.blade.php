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
                <h3 class="card-label text-uppercase">Thông tin hồ sơ khen cao của chính phủ</h3>
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
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-12">
                    <label>Tên đơn vị đề nghị khen thưởng</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>


            </div>

            {{-- <div class="form-group row">
                <div class="col-11">
                    <label>Tên phong trào thi đua</label>
                    {!! Form::select('maphongtraotd', setArrayAll($a_phongtraotd, 'Không chọn', 'null'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-1">
                    <label class="text-center">Chọn</label>
                    <button type="button" class="btn btn-default" data-target="#modal-phongtraotd" data-toggle="modal">
                        <i class="fa fa-plus"></i></button>
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-6">
                    <label>Cấp độ khen thưởng</label>
                    {!! Form::select('capkhenthuong', getPhamViKhenCao('TW'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-6">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-3">
                    <label>Số tờ trình</label>
                    {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    <label>Ngày tháng trình<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
                </div>
           
                <div class="col-3">
                    <label>Chức vụ người ký tờ trình</label>
                    {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    <label>Họ tên người ký tờ trình</label>
                    {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>            

            @include('NghiepVu._DungChung.HoSo_KhenCao_DanhSachKhenThuong')
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
    @include('NghiepVu._DungChung.modal_KhenCao_QD_CaNhan')
    @include('NghiepVu._DungChung.modal_KhenCao_QD_TapThe')
    @include('NghiepVu._DungChung.modal_KhenCao_QD_HoGiaDinh')
    @include('NghiepVu._DungChung.modal_TaiLieuDinhKem')
    {{-- chưa dùng tiêu chuẩn --}}
    {{-- @include('NghiepVu._DungChung.modal_TieuChuan') --}}
    @include('NghiepVu._DungChung.modal_XoaDoiTuong')
    @include('NghiepVu._DungChung.modal_QD_Excel')
    {{-- @include('NghiepVu._DungChung.modal_DoiTuong') --}}

@stop
