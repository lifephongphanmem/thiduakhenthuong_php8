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
                <h3 class="card-label text-uppercase">Thông tin tài liệu, văn bản pháp lý</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['method' => 'POST', 'url' => $inputs['url'].'Sua', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{-- {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }} --}}
        {{ Form::hidden('mavanban', null, ['id' => 'mavanban']) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-3">
                    <label class="control-label">Loại văn bản</label>
                    {!! Form::select('loaivb', getLoaiVanBan(), null, ['class' => 'form-control select2basic']) !!}
                </div>
                <div class="col-lg-9">
                    <label class="control-label">Đơn vị ban hành<span class="require">*</span></label>
                    {!! Form::text('dvbanhanh', null, ['id' => 'dvbanhanh', 'class' => 'form-control required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3">
                    <label class="control-label">Ký hiệu văn bản<span class="require">*</span></label>
                    {!! Form::text('kyhieuvb', null, ['id' => 'kyhieuvb', 'class' => 'form-control required']) !!}
                </div>
                <div class="col-lg-3">
                    <label class="control-label">Ngày ban hành</label>
                    {!! Form::input('date', 'ngayqd', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <!--/span-->
                <div class="col-lg-3">
                    <label class="control-label">Ngày áp dụng</label>
                    {!! Form::input('date', 'ngayapdung', null, ['class' => 'form-control', 'required']) !!}
                </div>
               
                <!--/span-->
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Mô tả văn bản</label>
                    {!! Form::textarea('tieude', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-3">
                    <label class="control-label">Tình trạng văn bản</label>
                    {!! Form::select('tinhtrang', getTrangThaiVanBan(), null, ['class' => 'form-control select2basic']) !!}
                </div>

                <div class="col-9">
                    <label>Văn bản bổ sung, thế thế</label>
                    {!! Form::text('vanbanbosung', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Tài liệu đính kèm: </label>
                    {!! Form::file('ipf1', null, ['id' => 'ipf1', 'class' => 'form-control']) !!}
                    @if ($model->ipf1 != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/vanban/' . $model->ipf1) }}"
                                target="_blank">{{ $model->ipf1 }}</a>
                        </span>
                    @endif
                </div>                
            </div>
        </div>
        
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/QuanLyVanBan/VanBanPhapLy/ThongTin') }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

@stop
