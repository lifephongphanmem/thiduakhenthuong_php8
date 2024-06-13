    <!--Modal Nhận hồ sơ-->
    {!! Form::open(['url' => $inputs['url_hs'] . 'Them', 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ đề nghị khen thưởng?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Loại hình khen thưởng</label>
                            {!! Form::select('maloaihinhkt', $a_loaihinhkt, $inputs['maloaihinhkt'], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-4">
                            <label>Phân loại hồ sơ</label>
                            {!! Form::select('phanloai', getPhanLoaiHoSo(isset($inputs['khangchien'])?'KHANGCHIEN':getDVPhanLoaiHsDeNghi($inputs['madonvi'])), null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-4">
                            <label>Trạng thái hồ sơ</label>
                            {!! Form::select('trangthai', getTrangThaiChucNangHoSo($inputs['trangthai']), $inputs['trangthai'], [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    @if (!in_array($inputs['trangthai'], ['CC', 'CD']))
                        <div class="form-group row">
                            <div id="donvixetduyet" class="col-6">
                                <label>Đơn vị xét duyệt</label>
                                {!! Form::select('madonvi_xd', setArrayAll($a_donviql, 'Chọn đơn vị', 'ALL'), 'ALL', [
                                    'onchange' => 'getDonViKhenThuong_ThemHS($(this))',
                                    'id' => 'madonvi_xd_themhs',
                                    'class' => 'form-control select2_modal',
                                    'required',
                                ]) !!}
                            </div>

                            <div id="donvikhenthuong" class="col-6">
                                <label>Đơn vị khen thưởng</label>
                                {!! Form::select('madonvi_kt', ['ALL' => 'Chọn đơn vị'], null, [
                                    'id' => 'madonvi_kt_themhs',
                                    'class' => 'form-control select2_modal',
                                ]) !!}
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-6">
                            <label>Số tờ trình</label>
                            {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label>Chức vụ người ký tờ trình</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
                            <label>Họ tên người ký tờ trình</label>
                            {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label>Nội dung trình khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <div class="col-12">
                            <label>Tờ trình: </label>
                            {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                        </div>

                    </div> --}}
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
            var madonvi_xd_themhs = document.getElementById('madonvi_xd_themhs');
            if (typeof(madonvi_xd_themhs) != 'undefined' && madonvi_xd_themhs != null && $('#madonvi_xd_themhs').val() ==
                'ALL') {
                ok = false;
                message += 'Đơn vị xét duyệt đề nghị không được bỏ trống. \n';
            }
            var madonvi_kt_themhs = document.getElementById('madonvi_kt_themhs');
            if (typeof(madonvi_kt_themhs) != 'undefined' && madonvi_kt_themhs != null && $('#madonvi_kt_themhs').val() ==
                'ALL') {
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
