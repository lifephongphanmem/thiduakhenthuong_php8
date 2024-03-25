<!--Modal Chuyển hồ sơ theo địa bàn quản lý-->
<div id="chuyen-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_chuyen']) !!}
    <input type="hidden" name="mahoso" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý hoàn thành hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ đã hoàn thành sẽ được chuyển lên đơn vị tiếp nhận. Bạn cần liên hệ đơn
                    vị tiếp nhận để chỉnh sửa hồ sơ nếu cần!</p>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="control-label">Cơ quan tiếp nhận<span class="require">*</span></label>
                            {!! Form::select('madonvi_nhan', $a_donviql, null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickChuyen()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<!--Modal Chuyển hồ sơ theo ngành-->
<div id="chuyen_nganh-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true"
    class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_chuyen_nganh']) !!}
    <input type="hidden" name="mahoso" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý hoàn thành hồ sơ?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Hồ sơ đã hoàn thành sẽ được chuyển lên đơn vị tiếp nhận. Bạn cần liên hệ đơn
                    vị tiếp nhận để chỉnh sửa hồ sơ nếu cần!</p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Cơ quan tiếp nhận<span class="require">*</span></label>
                            {!! Form::select('madonvi_nhan', $a_donvinganh, null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickChuyenNganh()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<!--Modal Xử lý hồ sơ-->
<div id="modal-xulyhoso" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_xulyhoso']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin xử lý hồ sơ</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Cán bộ chuyển hồ sơ</label>
                        {{-- {!! Form::select('tendangnhap_xl', $a_taikhoanchuyenvien, null, ['class' => 'form-control select2_modal']) !!} --}}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Cán bộ tiếp nhận hồ sơ</label>
                        {{-- {!! Form::select('tendangnhap_tn', $a_taikhoanchuyenvien, null, ['class' => 'form-control select2_modal']) !!} --}}
                    </div>
                </div>
                <!-- Tài khoản quản lý + SSA: có thông tin trạng thái hồ sơ -->
                {{-- @if (getPhanLoaiTaiKhoanTiepNhan()) --}}
                    <div class="form-group row" id="dieukien_hs">
                        <div class="col-md-12">
                            <label class="control-label">Trạng thái hồ sơ</label>
                            {!! Form::select('trangthai', getTrangThaiXuLyHoSo(), null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                {{-- @endif --}}

                <div class="form-group row">
                    <div class="col-md-12">
                        <label class=" control-label">Diễn giải nội dung</label>
                        {!! Form::textarea('noidungxuly_xl', null, ['rows' => 3, 'cols' => 10, 'class' => 'form-control']) !!}
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickXuLyHoSo()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script>
    function clickChuyen() {
        var str = '';
        var ok = true;
        var madonvi_nhan = $('#frm_chuyen').find("[name='madonvi_nhan']").val();
        if (madonvi_nhan == null) {
            str += '  - Cơ quan tiếp nhận. \n';
            $('#frm_chuyen').find("[name='madonvi_nhan']").parent().addClass('has-error');
            ok = false;
        }

        if (ok == false) {
            //alert('Các trường: \n' + str + 'Không được để trống');
            toastr.error('Thông tin: \n' + str + 'Không hợp lệ', 'Lỗi!.');
            $("frm_chuyen").submit(function(e) {
                e.preventDefault();
            });
        } else {
            $("frm_chuyen").unbind('submit').submit();
            $('#frm_chuyen').submit();
        }
        //$('#frm_chuyen').submit();
    }

    function clickChuyenNganh() {
        var str = '';
        var ok = true;
        var madonvi_nhan = $('#frm_chuyen_nganh').find("[name='madonvi_nhan']").val();
        if (madonvi_nhan == null) {
            str += '  - Cơ quan tiếp nhận. \n';
            $('#frm_chuyen_nganh').find("[name='madonvi_nhan']").parent().addClass('has-error');
            ok = false;
        }

        if (ok == false) {
            toastr.error('Thông tin: \n' + str + 'Không hợp lệ', 'Lỗi!.');
            $("frm_chuyen_nganh").submit(function(e) {
                e.preventDefault();
            });
        } else {
            $("frm_chuyen_nganh").unbind('submit').submit();
            $('#frm_chuyen_nganh').submit();
        }

    }

    function confirmChuyen(mahs, url, phanloaihs, madonvi = '') {
        var arNhom = ['KHENTHUONG', 'KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC', ];
        if (arNhom.includes(phanloaihs)) {
            $('#frm_chuyen').attr('action', url);
            $('#frm_chuyen').find("[name='mahoso']").val(mahs);
            $('#frm_chuyen').find("[name='madonvi_nhan']").val(madonvi);
            $('#chuyen-modal-confirm').modal("show");
        } else {
            $('#frm_chuyen_nganh').attr('action', url);
            $('#frm_chuyen_nganh').find("[name='mahoso']").val(mahs);
            $('#frm_chuyen_nganh').find("[name='madonvi_nhan']").val(madonvi);
            $('#chuyen_nganh-modal-confirm').modal("show");
        }
    }
</script>
