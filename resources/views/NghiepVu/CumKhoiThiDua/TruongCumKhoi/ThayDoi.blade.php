@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::model($model, [
        'method' => 'POST',
        $inputs['url'] . 'Them',
        'class' => 'horizontal-form',
        'id' => 'update_dmdonvi',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    {{-- {{ Form::hidden('id', null) }} --}}
    {{ Form::hidden('madanhsach', null) }}
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin chi tiết cụm, khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Mô tả<span class="require">*</span></label>
                    {!! Form::text('mota', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Từ ngày</label>
                    {!! Form::input('date', 'ngaytu', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <div class="col-lg-6">
                    <label>Đến ngày</label>
                    {!! Form::input('date', 'ngayden', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Quyết định: </label>
                    {!! Form::file('ipf1', null, ['id' => 'ipf1', 'class' => 'form-control']) !!}
                    @if ($model->ipf1 != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/quyetdinh/' . $model->ipf1) }}"
                                target="_blank">{{ $model->ipf1 }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Tài liệu khác: </label>
                    {!! Form::file('ipf2', null, ['id' => 'ipf2', 'class' => 'form-control']) !!}
                    @if ($model->ipf2 != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->ipf2) }}"
                                target="_blank">{{ $model->ipf2 }}</a>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/CumKhoiThiDua/CumKhoi/ThongTin') }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->
@stop
