    {{-- Nhận file Excel --}}
    {!! Form::open([
        'url' => $inputs['url'] . 'NhanExcel',
        'method' => 'POST',
        'id' => 'frm_NhanExcel',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahoso" />
    <div class="modal fade bs-modal-lg" id="modal-nhanexcel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nhận dữ liệu từ file</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="control-label">Phân loại đối tượng</label>
                            {!! Form::text('pldoituong', 'B', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong', 'C', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Chức vụ</label>
                            {!! Form::text('chucvu', 'D', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Đơn vị công tác</label>
                            {!! Form::text('tencoquan', 'E', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Phân loại khen thưởng</label>
                            {!! Form::text('phanloaikhenthuong', 'R', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Danh hiệu thi đua/Hình thức khen thưởng</label>
                            {!! Form::text('madanhhieukhenthuong', 'S', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Phân loại đối tượng</label>
                            {!! Form::text('maphanloaidoituong', 'T', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Lĩnh vực hoạt động đơn vị </label>
                            {!! Form::text('linhvuchoatdong', 'U', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="control-label">Nhận từ dòng<span class="require">*</span></label>
                            {!! Form::text('tudong', '2', ['class' => 'form-control']) !!}
                            {{-- {!! Form::text('tudong', '4', ['class' => 'form-control', 'required', 'data-mask' => 'fdecimal']) !!} --}}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Nhận đến dòng</label>
                            {!! Form::text('dendong', '200', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>File danh sách: </label>
                            {!! Form::file('fexcel', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    <hr>
                    <h4>Tham số mặc định</h4>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="control-label">Phân loại đơn vị<span class="require">*</span></label>
                            {!! Form::select('maphanloaidoituong_tt', $a_tapthe, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Hình thức khen thưởng đơn vị </label>
                            {!! Form::select('madanhhieukhenthuong_tt', $a_dhkt_tapthe, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Lĩnh vực hoạt động đơn vị </label>
                            {!! Form::select('linhvuchoatdong_tt', getLinhVucHoatDong(), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Phân loại hộ gia đình<span class="require">*</span></label>
                            {!! Form::select('maphanloaidoituong_hgd', $a_hogiadinh, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Hình thức khen thưởng hộ GĐ </label>
                            {!! Form::select('madanhhieukhenthuong_hgd', $a_dhkt_hogiadinh, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Phân loại cá nhân<span class="require">*</span></label>
                            {!! Form::select('maphanloaidoituong_cn', $a_canhan, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Hình thức khen thưởng cá nhân </label>
                            {!! Form::select('madanhhieukhenthuong_cn', $a_dhkt_canhan, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn
                                thành</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    <script>
        function setNhanExcel(mahoso) {
            if (window.confirm('Bạn có lưu các thay đổi về thông tin hồ sơ ?'))          
            {
                var formData = new FormData($('#frm_ThayDoi')[0]);
                $.ajax({
                    url: "{{ $inputs['url_hs'] }}" + "Sua",
                    method: "POST",
                    cache: false,
                    dataType: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data) {
                        // console.log(data);
                    }
                });
            }

            $('#frm_NhanExcel').find("[name='mahoso']").val(mahoso);
        }
    </script>
