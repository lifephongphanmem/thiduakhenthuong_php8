<!--Modal Nhận hồ sơ-->
<div id="modal-thamdinhhoso" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_thamdinh_hs']) !!}
    <input type="hidden" name="madonvi" />
    <input type="hidden" name="mahoso" />
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Danh sách hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row" id="hsthamdinh"></div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickthamdinhHS()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script>
        function clickthamdinhHS() {
        $('#frm_thamdinh_hs').submit();
    }
        function confirmThamDinhHoSo(mahs,url){
        // $('#frm_nhan_hs').find("[name='maphongtraotd']").val(maphongtrao);
        // $('#frm_nhan_hs').find("[name='madonvi']").val(madonvi);
        // $('#frm_nhan_hs').find("[name='mahoso']").val(mahs);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url_hs='/KhenThuongCongTrang/TiepNhan/ThamDinhHoSo'
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                _token: CSRF_TOKEN,
                mahoso: mahs,
            },
            dataType: 'JSON',
            success: function (data) {
                // console.log(data);
                if (data.status == 'success') {
                    $('#hsthamdinh').replaceWith(data.message);
                    TableManagedclass.init();
                    // TableManaged4.init();
                    $('#frm_thamdinh_hs').attr('action', url_hs);
                }
            },
            // error: function (message) {
            //     toastr.error(message, 'Lỗi!');
            // }
        });
    }
</script>