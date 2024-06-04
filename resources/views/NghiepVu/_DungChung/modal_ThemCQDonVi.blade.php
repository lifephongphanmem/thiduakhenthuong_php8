<div class="modal fade" id="modal-themdonvi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm đơn vị công tác</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <label class="form-control-label">Đơn vị công tác</label>
                        {!!Form::text('tencoquan_add', null, array('id' => 'tencoquan_add','class' => 'form-control','required'=>'required'))!!}
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                <button class="btn btn-primary" onclick="ThemDVCongTac()">Đồng ý</button>
                {{-- <button type="button" class="btn btn-primary" onclick="LuuCaNhan()">Hoàn thành</button> --}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<script>
    function ThemDVCongTac(){

        $('#modal-themdonvi').modal('hide');
        var gt = $('#tencoquan_add').val();
        $('#tencoquan_canhan').append(new Option(gt, gt, true, true));
        $('#tencoquan_canhan').val(gt).trigger('change');
        $('#tencoquan_tapthe').append(new Option(gt, gt, true, true));
        $('#tencoquan_tapthe').val(gt).trigger('change');
        
    }
</script>