{{-- Gán giá trị khen thưởng --}}
{!! Form::open([
    'url' => '',
    'id' => 'frm_GanKhenThuong',
    'class' => 'form',
]) !!}
<div class="modal fade" id="modal-GanKhenThuong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Gán thông tin khen thưởng cho cả danh sách</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Nhóm đối tượng</label>
                        {!! Form::select('phanloai', ['TAPTHE' => 'Tập thể', 'CANHAN' => 'Cá nhân','HOGIADINH'=>'Hộ gia đình'], null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>

                    <div class="col-md-6">
                        <label>Kết quả khen thưởng</label>
                        {!! Form::select('ketqua', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label>Nội dung khen thưởng / Lý do không khen thưởng </label>
                        <span>(Nội dung in trên phôi bằng khen)</span>
                        {!! Form::textarea('noidungkhenthuong', $model->noidung, [
                            'class' => 'form-control',
                            'rows' => '6',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                <button type="button" onclick="confirmKhenThuongTatCa()" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{!! Form::close() !!}

<script>
    function setKhenThuongTatCa(phanloai) {
        $('#frm_GanKhenThuong').find("[name='phanloai']").val(phanloai).trigger('change');
    }

    function confirmKhenThuongTatCa() {
        var formData = new FormData($('#frm_GanKhenThuong')[0]);
        $.ajax({
            url: "{{ $inputs['url'] }}" + "GanKhenThuong",
            method: "POST",
            cache: false,
            dataType: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function(data) {
                console.log(data);               
                if (data.status == 'success') {
                    if (formData.get('phanloai') == 'TAPTHE') {
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        TableManaged4.init();
                    }
                    if (formData.get('phanloai') == 'CANHAN') {
                        $('#dskhenthuongcanhan').replaceWith(data.message);
                        TableManaged3.init();
                    }
                    if (formData.get('phanloai') == 'HOGIADINH') {
                        $('#dskhenthuonghogiadinh').replaceWith(data.message);
                        TableManaged5.init();
                    }
                }
            }
        })

        $('#modal-GanKhenThuong').modal("hide");
    }
</script>
