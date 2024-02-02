    <!--Modal Nhận hồ sơ-->
    {!! Form::open(['url' => $inputs['url_hs'] . 'Them', 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ khen thưởng ?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-6">
                            <label>Loại hình khen thưởng</label>
                            {!! Form::select('maloaihinhkt', $a_loaihinhkt, $inputs['maloaihinhkt'], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-3">
                            <label>Trạng thái hồ sơ</label>
                            {!! Form::select('trangthai', getTrangThaiChucNangHoSo($inputs['trangthai']), $inputs['trangthai'], [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-3">
                            <label>Ngày quyết định</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    @if ($inputs['taototrinh'])
                        <div class="form-group row">
                            <div class="col-4">
                                <label>Số tờ trình</label>
                                {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="col-4">
                                <label>Chức vụ người ký tờ trình</label>
                                {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-4">
                                <label>Họ tên người ký tờ trình</label>
                                {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-12">
                            <label>Nội dung quyết định khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" onclick="chkThongTinHoSo()" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <script>
        function getDonViKhenThuong_ThemHS(e) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/DungChung/getDonViKhenThuong_ThemHS",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madonvi: e.val(),
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#donvikhenthuong').replaceWith(data.message);
                    }
                }
            });
        }

        function chkThongTinHoSo() {
            var ok = true,
                message = '';

            if ($('#madonvi_xd_themhs')[0] && $('#madonvi_xd_themhs').val() == 'ALL') {
                ok = false;
                message += 'Đơn vị xét duyệt đề nghị không được bỏ trống. \n';
            }

            if ($('#madonvi_kt_themhs')[0] && $('#madonvi_kt_themhs').val() == 'ALL') {
                ok = false;
                message += 'Đơn vị phê duyệt đề nghị không được bỏ trống. \n';
            }

            //Kết quả
            if (ok == false) {
                toastr.error(message, "Lỗi!");
                $("#frm_hoso").submit(function(e) {
                    e.preventDefault();
                });
            } else {
                $("#frm_hoso").unbind('submit').submit();
            }
        }
    </script>
