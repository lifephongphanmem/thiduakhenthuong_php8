<h4 class="text-dark font-weight-bold mb-5">Thông tin chung</h4>
<div class="form-group row">
    <div class="col-lg-6">
        <label>Tên đơn vị</label>
        {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
    </div>

    <div class="col-lg-6">
        <label>Loại hình khen thưởng</label>
        {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control', 'disabled' => 'true']) !!}
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
