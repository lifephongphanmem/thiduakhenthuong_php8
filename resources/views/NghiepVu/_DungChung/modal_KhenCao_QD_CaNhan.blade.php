{{-- Cá nhân --}}
{!! Form::open([
    'url' => '',
    'id' => 'frm_ThemCaNhan',
    'class' => 'form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
<input type="hidden" name="id" />
<input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
<div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin đối tượng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="form-control-label">Tên đối tượng</label>
                        {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                    </div>
                   
                    <div class="col-md-3">
                        <label class="form-control-label">Ngày sinh</label>
                        {!! Form::input('date', 'ngaysinh', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-3">
                        <label class="form-control-label">Giới tính</label>
                        {!! Form::select('gioitinh', getGioiTinh(), null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="form-control-label">Địa chỉ</label>
                        {!! Form::text('diachi', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">Phân loại cán bộ</label>
                        {!! Form::select('maphanloaicanbo', $a_canhan, null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="form-control-label">Chức vụ/Chức danh</label>
                        {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-3">
                        <label class="form-control-label">Tên phòng ban công tác</label>
                        {!! Form::text('tenphongban', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-6">
                        <label class="form-control-label">Tên đơn vị công tác</label>
                        {!! Form::text('tencoquan', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Danh hiệu thi đua/Hình thức khen thưởng</label>
                        {!! Form::select('madanhhieukhenthuong', $a_dhkt_canhan, null, [
                            'class' => 'form-control select2_modal'
                        ]) !!}
                    </div>                   
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Kết quả khen thưởng</label>
                        {!! Form::select('ketqua', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label>Nội dung khen thưởng / Lý do không khen thưởng</label>
                        {!! Form::textarea('noidungkhenthuong', null, [
                            'class' => 'form-control',
                            'rows' => '2',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                <button type="button" class="btn btn-primary" onclick="LuuCaNhan()">Hoàn thành</button>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
{!! Form::close() !!}

<script>
    function setCaNhan() {
        $('#frm_ThemCaNhan').find("[name='id']").val('-1');
        $('#frm_ThemCaNhan').find("[name='ketqua']").val('1').trigger('change');
    }

    function getCaNhan(id) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ $inputs['url_hs'] }}" + "LayCaNhan",
            type: 'GET',
            data: {
                _token: CSRF_TOKEN,
                id: id,
            },
            dataType: 'JSON',
            success: function(data) {
                var form = $('#frm_ThemCaNhan');
                form.find("[name='id']").val(data.id);
                form.find("[name='tendoituong']").val(data.tendoituong);
                form.find("[name='ngaysinh']").val(data.ngaysinh);
                form.find("[name='gioitinh']").val(data.gioitinh).trigger('change');
                form.find("[name='chucvu']").val(data.chucvu);
                form.find("[name='tenphongban']").val(data.tenphongban);
                form.find("[name='tencoquan']").val(data.tencoquan);
                form.find("[name='maphanloaicanbo']").val(data.maphanloaicanbo).trigger('change');
                form.find("[name='madanhhieukhenthuong']").val(data.madanhhieukhenthuong).trigger('change');
                // form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                // form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
                
                form.find("[name='noidungkhenthuong']").val(data.noidungkhenthuong);
                form.find("[name='ketqua']").val(data.ketqua).trigger('change');
            }
        });
    }
    function LuuCaNhan() {
            var formData = new FormData($('#frm_ThemCaNhan')[0]);

            $.ajax({
                url: "{{ $inputs['url'] }}" + "ThemCaNhan",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        $('#dskhenthuongcanhan').replaceWith(data.message);
                        TableManaged3.init();
                    }
                }
            })
            $('#modal-create').modal("hide");
        }
</script>
