    {{-- tập thể --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemHoGiaDinh',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahosothamgiapt" value="{{ $model->mahosothamgiapt }}" />
    <input type="hidden" name="maloaihinhkt" value="{{ $model->maloaihinhkt }}" />
    <input type="hidden" name="id" />
    <div class="modal fade bs-modal-lg kt_select2_modal" id="modal-create-hogiadinh" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đối tượng hộ gia đình</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-11">
                            <label class="form-control-label">Tên hộ gia đình</label>
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
                        <div class="col-6">
                            <label class="control-label">Phân loại đối tượng</label>
                            {!! Form::select('maphanloaitapthe', $a_hogiadinh, null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>

                        <div class="col-6">
                            <label class="control-label">Danh hiệu thi đua/Hình thức khen thưởng</label>
                            {!! Form::select('madanhhieukhenthuong', $a_dhkt_hogiadinh, null, [
                                'class' => 'form-control select2_modal',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuHoGiaDinh()">Cập nhật</button>
                    {{-- <button type="submit" class="btn btn-primary">Hoàn thành</button> --}}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        function setHoGiaDinh() {
            $('#frm_ThemHoGiaDinh').find("[name='id']").val('-1');
        }

        function getHoGiaDinh(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "LayHoGiaDinh",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemHoGiaDinh');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='maphanloaitapthe']").val(data.maphanloaitapthe).trigger('change');
                    form.find("[name='madanhhieukhenthuong']").val(data.madanhhieukhenthuong).trigger('change');
                    //form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='tentapthe']").val(data.tentapthe);
                }
            });
        }

        function LuuHoGiaDinh() {
            var formData = new FormData($('#frm_ThemHoGiaDinh')[0]);

            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "ThemHoGiaDinh",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        $('#dskhenthuonghogiadinh').replaceWith(data.message);
                        TableManaged5.init();
                    }
                }
            })
            $('#modal-create-hogiadinh').modal("hide");
        }
    </script>
