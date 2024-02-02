<!--Modal Nhận và trình khen thưởng hồ sơ hồ sơ-->
<div id="nhanvatkt-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_nhanvatkt']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý trình hồ sơ đề nghị khen thưởng?
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ trình xét duyệt kết quả giải quyết. Bạn cần liên hệ đơn vị tiếp
                    nhận để chỉnh sửa hồ sơ nếu cần!</p>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Cơ quan tiếp nhận<span class="require">*</span></label>
                        {!! Form::select('madonvi_nhan', $a_donviql, null, ['class' => 'form-control select2_modal']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickNhanvaTKT()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickNhanvaTKT() {
        $('#frm_nhanvatkt').submit();
    }

    function confirmNhanvaTKT(mahs, url, madonvi) {
        $('#frm_nhanvatkt').attr('action', url);
        $('#frm_nhanvatkt').find("[name='mahoso']").val(mahs);
        $('#frm_nhanvatkt').find("[name='madonvi']").val(madonvi);
    }
</script>
