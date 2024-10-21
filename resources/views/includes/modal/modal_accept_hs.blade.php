<!--Modal Nhận hồ sơ-->
<div id="nhan-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_nhan']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi_nhan" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tiếp nhận hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ sẽ được tiếp nhận và được xét duyệt dự thảo khen thưởng.</p>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickNhan()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<!--Modal Nhận hồ sơ-->
<div id="nhan-modal-dvthammuu-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_nhan_hs']) !!}
    <input type="hidden" name="maphongtraotd" />
    <input type="hidden" name="madonvi" />
    <input type="hidden" name="mahoso" />
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Danh sách hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row" id="hsthamgia"></div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickNhanHS()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickNhan() {
        $('#frm_nhan').submit();
    }
    function clickNhanHS() {
        $('#frm_nhan_hs').submit();
    }

    function confirmNhan(mahs, url, madonvi) {
        $('#frm_nhan').attr('action', url);
        $('#frm_nhan').find("[name='mahoso']").val(mahs);
        $('#frm_nhan').find("[name='madonvi_nhan']").val(madonvi);
    }

    function confirmNhanHS(mahs, url, madonvi,maphongtrao){
        $('#frm_nhan_hs').find("[name='maphongtraotd']").val(maphongtrao);
        $('#frm_nhan_hs').find("[name='madonvi']").val(madonvi);
        $('#frm_nhan_hs').find("[name='mahoso']").val(mahs);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url_hs='/HoSoDeNghiKhenThuongThiDua/NhanHoSo'
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                _token: CSRF_TOKEN,
                mahs: mahs,
                madonvi: madonvi
            },
            dataType: 'JSON',
            success: function (data) {
                // console.log(data);
                if (data.status == 'success') {
                    $('#hsthamgia').replaceWith(data.message);
                    TableManagedclass.init();
                    TableManaged3.init();
                    $('#frm_nhan_hs').attr('action', url_hs);
                }
            },
            error: function (message) {
                toastr.error(message, 'Lỗi!');
            }
        });
    }
</script>
