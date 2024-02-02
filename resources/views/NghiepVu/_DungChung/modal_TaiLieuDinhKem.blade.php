    {{-- Tài liệu đính kèm hồ sơ --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemTaiLieu',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="madonvi" value="{{ $model->madonvi }}" />
    <input type="hidden" name="phanloaihoso" value="{{ $inputs['phanloaihoso'] }}" />
    <div class="modal fade bs-modal-lg" id="modal-tailieu" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <!-- Tuỳ chọn theo hồ sơ đề nghị khen thưởng và hồ sơ khen thưởng tại đơn vị -->
                    @if (isset($inputs['phanloaikhenthuong']))
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Phân loại tài liệu</label>
                                {!! Form::select('phanloai', getPhanLoaiTaiLieuDK(), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    @else
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="control-label">Phân loại tài liệu</label>
                                {!! Form::select('phanloai', getPhanLoaiTaiLieuDK('DENGHI'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    @endif


                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Nội dung tóm tắt</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Tài liệu đính kèm: </label>
                            {!! Form::file('tentailieu', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTaiLieu()">Hoàn thành</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Xóa Tài liệu đính kèm --}}
    {!! Form::open([
        'url' => '/DungChung/TaiLieuDinhKem/XoaTaiLieu',
        'id' => 'frm_XoaTaiLieu',
        'class' => 'form',
    ]) !!}
    <div class="modal fade" id="modal-delete-tailieu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa thông tin đối tượng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="id">
                <input type="hidden" name="madonvi" value="{{ $model->madonvi }}" />
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="confirmXoaTaiLieu()">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    <script>
        function delTaiLieu(id) {
            $('#frm_XoaTaiLieu').find("[name='id']").val(id);
        }

        function confirmXoaTaiLieu() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // var form = $('#frm_XoaTaiLieu');
            $.ajax({
                url: '/DungChung/TaiLieuDinhKem/XoaTaiLieu',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: $('#frm_XoaTaiLieu').find("[name='id']").val(),
                    phanloaihoso: "{{ $inputs['phanloaihoso'] }}",
                    madonvi: $('#frm_XoaTaiLieu').find("[name='madonvi']").val(),
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                    $('#dstailieu').replaceWith(data.message);
                    jQuery(document).ready(function() {
                        TableManagedclass.init();
                    });
                }
            });
            $('#modal-delete-tailieu').modal("hide");
        }

        function setTaiLieu() {
            $('#frm_ThemTaiLieu').find("[name='id']").val('-1');
            $('#frm_ThemTaiLieu').find("[name='noidung']").val('');
        }

        function getTaiLieu(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/DungChung/TaiLieuDinhKem/LayTaiLieu",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    phanloaihoso: "{{ $inputs['phanloaihoso'] }}"
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemTaiLieu');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='phanloai']").val(data.phanloai).trigger('change');
                    form.find("[name='noidung']").val(data.noidung);
                }
            });
        }

        function LuuTaiLieu() {
            if (!$('#frm_ThemTaiLieu').find("[name='tentailieu']").val() && $('#frm_ThemTaiLieu').find("[name='id']")
                .val() == '-1') {
                toastr.error("Chưa có tài liệu đính kèm", "Lỗi !!!");
            } else {
                var formData = new FormData($('#frm_ThemTaiLieu')[0]);
                $.ajax({
                    url: "/DungChung/TaiLieuDinhKem/ThemTaiLieu",
                    method: "POST",
                    cache: false,
                    dataType: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data) {
                        // console.log(data);
                        if (data.status == 'success') {
                            $('#dstailieu').replaceWith(data.message);
                            TableManagedclass.init();
                        }
                    }
                });
                $('#modal-tailieu').modal("hide");
            }
        }
    </script>
