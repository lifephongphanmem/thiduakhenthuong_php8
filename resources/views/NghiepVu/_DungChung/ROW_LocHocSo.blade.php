<div class="form-group row">
    <div class="col-4">
        <label style="font-weight: bold">Đơn vị</label>
        <select class="form-control select2basic" id="madonvi">
            @foreach ($m_diaban as $diaban)
            <optgroup label="{{ $diaban->tendiaban }}">
                <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                @foreach ($donvi as $ct)
                <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }} value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                @endforeach
            </optgroup>
            @endforeach
        </select>
    </div>
    <div class="col-3">
        <label style="font-weight: bold">Phân loại hồ sơ</label>
        {!! Form::select('phanloai', setArrayAll($a_phanloaihs, 'Tất cả', 'ALL'), $inputs['phanloai'], [
        'id' => 'phanloai',
        'class' => 'form-control select2basic',
        ]) !!}
    </div>
    <div class="col-3">
        <label style="font-weight: bold">Trạng thái hồ sơ</label>
        {!! Form::select('trangthaihoso', setArrayAll(getTrangThaiChucNangHoSo('ALL'), 'Tất cả', 'ALL'), $inputs['trangthaihoso'], [
        'id' => 'trangthaihoso',
        'class' => 'form-control select2basic',
        ]) !!}
    </div>
    <div class="col-2">
        <label style="font-weight: bold">Năm</label>
        {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
    </div>
</div>