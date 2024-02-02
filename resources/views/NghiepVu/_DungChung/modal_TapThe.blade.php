    {{-- tập thể --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemTapThe',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="maloaihinhkt" value="{{ $model->maloaihinhkt }}" />
    <input type="hidden" name="id" />
    <div class="modal fade bs-modal-lg kt_select2_modal" id="modal-create-tapthe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đối tượng tập thể</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Tên tập thể</label>
                            {!! Form::text('tentapthe', null, ['class' => 'form-control']) !!}
                        </div>
                        {{-- <div class="col-lg-1">
                            <label class="text-center">Chọn</label>
                            <button type="button" class="btn btn-default btn-icon" data-target="#modal-tapthe"
                                data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div> --}}
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Tên đơn vị / cơ quan</label>
                            {!! Form::text('tencoquan', null, ['class' => 'form-control']) !!}
                        </div>                        
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label class="control-label">Phân loại đối tượng</label>
                            {!! Form::select('maphanloaitapthe', $a_tapthe, null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>

                        <div class="col-6">
                            <label class="control-label">Lĩnh vực hoạt động</label>
                            {!! Form::select('linhvuchoatdong', getLinhVucHoatDong(), null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Danh hiệu thi đua/Hình thức khen thưởng</label>
                            {!! Form::select('madanhhieukhenthuong', $a_dhkt_tapthe, null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>
                        {{-- <div class="col-md-6">
                            <label class="control-label">Danh hiệu thi đua</label>
                            {!! Form::select('madanhhieutd', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Hình thức khen thưởng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, $inputs['mahinhthuckt'], ['class' => 'form-control']) !!}
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTapThe()">Cập nhật</button>
                    {{-- <button type="submit" class="btn btn-primary">Hoàn thành</button> --}}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        function setTapThe() {
            $('#frm_ThemTapThe').find("[name='id']").val('-1');
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ $inputs['url'] }}" + "LayTapThe",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='maphanloaitapthe']").val(data.maphanloaitapthe).trigger('change');
                    form.find("[name='linhvuchoatdong']").val(data.linhvuchoatdong).trigger('change');
                    form.find("[name='madanhhieukhenthuong']").val(data.madanhhieukhenthuong).trigger('change');
                    form.find("[name='tentapthe']").val(data.tentapthe);
                    form.find("[name='tencoquan']").val(data.tencoquan);
                }
            });
        }

        function LuuTapThe() {
            var formData = new FormData($('#frm_ThemTapThe')[0]);

            $.ajax({
                url: "{{ $inputs['url'] }}" + "ThemTapThe",
                // url: "{{ $inputs['url_hs'] }}" + "ThemTapThe",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        TableManaged4.init();
                    }
                }
            })
            $('#modal-create-tapthe').modal("hide");
        }
    </script>
