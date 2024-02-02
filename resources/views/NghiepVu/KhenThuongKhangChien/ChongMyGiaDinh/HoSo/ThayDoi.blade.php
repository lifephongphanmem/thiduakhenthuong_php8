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
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin hồ sơ khen thưởng kháng chiến chống Mỹ cho hộ gia đình</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['method' => 'POST','url'=> $inputs['url'].'Them', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosokt', null, ['id' => 'mahosokt']) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tên đơn vị nhập liệu</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly']) !!}
                </div>

                <div class="col-lg-6">
                    <label>Ngày tạo hồ sơ<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Thời gian tham gia kháng chiến<span class="require">*</span></label>
                    {!! Form::input('date', 'tgiantgkc', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Thời gian kháng chiến quy đổi</label>
                    {!! Form::text('tgiankcqd', null, ['class' => 'form-control']) !!}
                </div>
            </div>


            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="control-label">Số quyết định</label>
                    {!! Form::text('soqd', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label class="control-label">Số được duyệt</label>
                    {!! Form::text('sodd', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="control-label">Tên đối tượng</label>
                    {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label class="control-label">Ngày tháng năm sinh</label>
                    {!! Form::input('date', 'namsinh', null, ['class' => 'form-control']) !!}
                </div>                
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="control-label">Loại khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label class="control-label">Hình thức khen thưởng</label>
                    {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, [ 'class' => 'form-control']) !!}
                </div>

            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="control-label">Nơi trình khen thưởng</label>
                    {!! Form::text('noitrinhkt', null, ['class' => 'form-control required']) !!}
                </div>
                <div class="col-lg-6">
                    <label class="control-label">Chính quán</label>
                    {!! Form::text('chinhquan', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="control-label">Chỗ ở hiện nay</label>
                    {!! Form::text('noio', null, [ 'class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label class="control-label">Loại hồ sơ kháng chiến(theo phần mềm cũ)</label>
                    {!! Form::text('loaihosokc', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
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
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/KhenThuongKhangChien/ChongPhapCaNhan/ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->


@stop
