    <!--Modal hủy phê duyệt hồ sơ khen thưởng-->
    <div class="modal fade" id="modal-HuyPheDuyet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open([
                    'url' => $inputs['url_qd'] . 'HuyPheDuyet',
                    'method' => 'post',
                    'files' => true,
                    'id' => 'frm_HuyPheDuyet',
                ]) !!}
                <div class="modal-header">

                    <h4 class="modal-title">Đồng ý hủy phê duyệt hồ sơ khen thưởng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="mahosotdkt" />
                <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12 text-info font-weight-bold">
                            Bạn đồng ý hủy phê duyệt hồ sơ khen thưởng và chuyển hồ sơ về chờ xét khen thưởng.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Đồng ý</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

<script>
     function setPheDuyet(mahosotdkt) {
            $('#frm_PheDuyet').find("[name='mahosotdkt']").val(mahosotdkt);
        }

        function setHuyPheDuyet(mahosotdkt) {
            $('#frm_HuyPheDuyet').find("[name='mahosotdkt']").val(mahosotdkt);
        }
</script>