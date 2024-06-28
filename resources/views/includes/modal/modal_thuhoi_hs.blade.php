<!--Modal Chuyển hồ sơ theo địa bàn quản lý-->
<div id="thuhoi-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_thu']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="phanloai" />
    <input type="hidden" name="url_return" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý thu hồi hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            {{-- <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ đã hoàn thành sẽ được thu hồi!</p>

            </div> --}}
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickThu()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickThu() {

        $("frm_thu").unbind('submit').submit();
        $('#frm_thu').submit();
        //$('#frm_chuyen').submit();
    }



    function confirmThuHoi(mahs, url, phanloai,url_return) {
        $('#frm_thu').attr('action', url);
        $('#frm_thu').find("[name='mahoso']").val(mahs);
        $('#frm_thu').find("[name='phanloai']").val(phanloai);
        $('#frm_thu').find("[name='url_return']").val(url_return);
        $('#thuhoi-modal-confirm').modal("show");
    }
</script>
