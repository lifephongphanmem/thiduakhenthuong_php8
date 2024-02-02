<div class="form-group row">
    <div class="col-lg-6">
        <label>Tờ trình: </label>
        {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
        @if ($model->totrinh != '')
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
</div>
