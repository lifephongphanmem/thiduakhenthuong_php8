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
        '/CumKhoiThiDua/CumKhoi/Them',
        'class' => 'horizontal-form',
        'id' => 'update_dmdonvi',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    {{-- {{ Form::hidden('id', null) }} --}}
    {{ Form::hidden('macumkhoi', null) }}
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
                <div class="col-3">
                    <label>Ngày tạo</label>
                    {!! Form::input('date', 'ngaythanhlap', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-9">
                    <label>Tên cụm, khối thi đua<span class="require">*</span></label>
                    {!! Form::text('tencumkhoi', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-4">
                    <label>Đơn vị quản lý hồ sơ</label>
                    {!! Form::select('madonviql', $a_donviql, null,  ['class' => 'form-control select2basic']) !!}
                </div>

                <div class="col-4">
                    <label>Đơn vị xét duyệt hồ sơ<span class="require">*</span></label>
                    {!! Form::select('madonvixd', $a_donvixd, null, ['class' => 'form-control select2basic', 'required']) !!}
                </div>
                <div class="col-4">
                    <label>Đơn vị phê duyệt khen thưởng<span class="require">*</span></label>
                    {!! Form::select('madonvikt', $a_donvikt, null, ['class' => 'form-control select2basic', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Quyết định phân cụm, khối </label>
                    {!! Form::file('ipf1', null, ['id' => 'ipf1', 'class' => 'form-control']) !!}
                    @if ($model->ipf1 != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/quyetdinh/' . $model->ipf1) }}" target="_blank">{{ $model->ipf1 }}</a>
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
                            <a href="{{ url('/data/tailieukhac/' . $model->ipf2) }}" target="_blank">{{ $model->ipf2 }}</a>
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
