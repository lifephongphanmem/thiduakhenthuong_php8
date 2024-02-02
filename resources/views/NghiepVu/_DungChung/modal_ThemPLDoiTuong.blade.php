<div class="modal fade" id="modal-pldoituong" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Phân loại đối tượng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <label class="form-control-label">Đối tượng</label>
                        {!!Form::text('pldoituong_add', null, array('id' => 'pldoituong_add','class' => 'form-control','required'=>'required'))!!}
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                <button class="btn btn-primary" onclick="ThemPlDoiTuong()">Đồng ý</button>
                {{-- <button type="button" class="btn btn-primary" onclick="LuuCaNhan()">Hoàn thành</button> --}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<script>
    function ThemPlDoiTuong(){
        $('#modal-pldoituong').modal('hide');
        var gt = $('#pldoituong_add').val();
        $('#pldoituong').append(new Option(gt, gt, true, true));
        $('#pldoituong').val(gt).trigger('change');
    }
</script>