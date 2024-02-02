<h4 class="text-dark font-weight-bold mb-5">Thông tin quyết định khen thưởng</h4>
<div class="form-group row">
    <div class="col-6">
        <label>Tên đơn vị quyết định khen thưởng</label>
        {!! Form::select('donvikhenthuong', $a_donvikt, null, ['class' => 'form-control select2basic']) !!}
    </div>
    <div class="col-6">
        <label>Cấp độ khen thưởng</label>
        {!! Form::select('capkhenthuong', getPhamViKhenThuong('{{$model->capkhenthuong}}'), null, ['class' => 'form-control']) !!}
        {!! Form::hidden('capkhenthuong', null) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label>Số quyết định</label>
        {!! Form::text('soqd', null, ['class' => 'form-control']) !!}
    </div>

    <div class="col-6">
        <label>Ngày ra quyết định</label>
        {!! Form::input('date', 'ngayqd', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label>Chức vụ người ký</label>
        <div class="input-group">
            {!! Form::select(
                'chucvunguoikyqd',
                array_unique(array_merge([$model->chucvunguoikyqd => $model->chucvunguoikyqd], getChucVuKhenThuong())),
                null,
                ['class' => 'form-control', 'id' => 'chucvunguoikyqd'],
            ) !!}
            <div class="input-group-prepend">
                <button type="button" data-target="#modal-chucvu" data-toggle="modal"
                    class="btn btn-light-dark btn-icon">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="col-6">
        <label>Họ tên người ký</label>
        {!! Form::text('hotennguoikyqd', null, ['class' => 'form-control']) !!}
    </div>
</div>

{{-- <div class="form-group row">
    <div class="col-6">
        <label>Quyết định khen thưởng: </label>
        {!! Form::file('quyetdinh', null, ['id' => 'quyetdinh', 'class' => 'form-control']) !!}
        @if ($model->quyetdinh != '')
            <span class="form-control" style="border-style: none">
                <a href="{{ url('/data/tailieudinhkem/' . $model->quyetdinh) }}" target="_blank">{{ $model->quyetdinh }}</a>
            </span>
        @endif
        {!! Form::hidden('phanloaitailieu', 'QDKT',) !!}
    </div>
</div> --}}
