<div class="modal fade" id="modal-chucvu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm chức vụ người ký</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <label class="form-control-label">Chức vụ người ký</label>
                        {!!Form::text('chucvunguoikyqd_add', null, array('id' => 'chucvunguoikyqd_add','class' => 'form-control','required'=>'required'))!!}
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                <button class="btn btn-primary" onclick="ThemChucVu()">Đồng ý</button>
                {{-- <button type="button" class="btn btn-primary" onclick="LuuCaNhan()">Hoàn thành</button> --}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<script>
    function ThemChucVu(){
        $('#modal-chucvu').modal('hide');
        var gt = $('#chucvunguoikyqd_add').val();
        $('#chucvunguoikyqd').append(new Option(gt, gt, true, true));
        $('#chucvunguoikyqd').val(gt).trigger('change');
    }
</script>