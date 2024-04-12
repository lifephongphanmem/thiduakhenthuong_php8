<!--Modal Nhận và trình khen thưởng hồ sơ hồ sơ-->
<div id="trinhhs-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_trinhhs']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý trình kết quả giải quyết?
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ trình xét duyệt kết quả khen thưởng. Bạn cần liên hệ đơn vị tiếp
                    nhận để chỉnh sửa hồ sơ nếu cần!</p>
                {{-- <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Cơ quan tiếp nhận<span class="require">*</span></label>
                        {!! Form::select('madonvi_nhan', $a_donviql, null, ['class' => 'form-control select2_modal']) !!}
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickTrinhHS()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickTrinhHS() {
        $('#frm_trinhhs').submit();
    }

    function confirmTrinhHS(mahs, url, madonvi) {
        $('#frm_trinhhs').attr('action', url);
        $('#frm_trinhhs').find("[name='mahoso']").val(mahs);
        $('#frm_trinhhs').find("[name='madonvi']").val(madonvi);
    }
</script>
