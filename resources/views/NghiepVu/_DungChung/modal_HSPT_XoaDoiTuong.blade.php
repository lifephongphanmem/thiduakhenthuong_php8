    {{-- Xóa khen thưởng --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_XoaDoiTuong',
        'class' => 'form',
    ]) !!}
    <div class="modal fade" id="modal-delete-khenthuong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa thông tin đối tượng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" id="iddelete" name="iddelete">
                <input type="hidden" id="phanloaixoa" name="phanloaixoa">
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="confirmXoaKhenThuong()">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    <script>
        function delKhenThuong(id, url, phanloai) {
            $('#frm_XoaDoiTuong').attr('action', url);
            $('#frm_XoaDoiTuong').find("[name='iddelete']").val(id);
            $('#frm_XoaDoiTuong').find("[name='phanloaixoa']").val(phanloai);
        }

        function confirmXoaKhenThuong() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_XoaDoiTuong');
            var phanloai = form.find("[name='phanloaixoa']").val();
            var id = form.find("[name='iddelete']").val();

            if (phanloai == 'TAPTHE') {
                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id,
                        maloaihinhkt:"{{$model->maloaihinhkt}}",
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                    }
                });
            }
            
            if (phanloai == 'HOGIADINH') {
                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id,
                        maloaihinhkt:"{{$model->maloaihinhkt}}",
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                        $('#dskhenthuonghogiadinh').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged5.init();
                        });
                    }
                });
            }

            if (phanloai == 'CANHAN') {
                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id,
                        maloaihinhkt:"{{$model->maloaihinhkt}}",
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                        $('#dskhenthuongcanhan').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });

                    }
                });
            }
            $('#modal-delete-khenthuong').modal("hide");
        }
    </script>
