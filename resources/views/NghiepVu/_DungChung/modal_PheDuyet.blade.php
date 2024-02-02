<!--Modal phê duyệt hồ sơ khen thưởng trong "ThongTinHoSo"-->
<div class="modal fade" id="modal-PheDuyet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open([
                'url' => $inputs['url_qd'] . 'PheDuyet',
                'method' => 'post',
                'files' => true,
                'id' => 'frm_PheDuyet',
            ]) !!}
            <div class="modal-header">

                <h4 class="modal-title">Đồng ý phê duyệt hồ sơ khen thưởng?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <input type="hidden" name="mahosotdkt" />
            <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12 text-info font-weight-bold">
                        Bạn đồng ý phê duyệt hồ sơ khen thưởng và gửi kết quả đến các đơn vị tham gia.
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Tên đơn vị quyết định khen thưởng</label>
                        {!! Form::text('donvikhenthuong', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Cấp độ khen thưởng</label>
                        {!! Form::select('capkhenthuong', getPhamViApDung(), null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-4">
                        <label>Số quyết định</label>
                        {!! Form::text('soqd', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-4">
                        <label>Ngày ra quyết định</label>
                        {!! Form::input('date', 'ngayqd', date('Y-m-d'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Chức vụ người ký</label>
                        {!! Form::text('chucvunguoikyqd', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-6">
                        <label>Họ tên người ký</label>
                        {!! Form::text('hotennguoikyqd', null, ['class' => 'form-control']) !!}
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
