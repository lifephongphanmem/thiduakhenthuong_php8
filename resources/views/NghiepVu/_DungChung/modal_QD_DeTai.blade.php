    {{-- Cá nhân --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemDeTai',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="id" />
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <div class="modal fade bs-modal-lg" id="modal-detai" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin đề tài, sáng kiến</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="form-control-label">Tên đề tài</label>
                            {!! Form::text('tensangkien', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <label class="form-control-label">Ngày công nhận</label>
                            {!! Form::input('date', 'thoigiancongnhan', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-9">
                            <label class="form-control-label">Đơn vị công nhận</label>
                            {!! Form::text('donvicongnhan', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label class="form-control-label">Thành tích đạt được</label>
                            {!! Form::textarea('thanhtichdatduoc', null, ['class' => 'form-control', 'rows' => '2']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="form-control-label">Tên tác giả</label>
                            {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Tên phòng ban công tác</label>
                            {!! Form::text('tenphongban', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label">Tên đơn vị công tác</label>
                            {!! Form::text('tencoquan', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="LuuDeTai()">Hoàn thành</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Xóa khen thưởng --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_XoaDeTai',
        'class' => 'form',
    ]) !!}
    <div class="modal fade" id="modal-delete-detai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa thông tin đối tượng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" id="iddelete" name="iddelete">
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="button" onclick="confirmXoaDeTai()" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    <script>
        function setDeTai() {
            $('#frm_ThemDeTai').find("[name='id']").val('-1');
        }

        function getDeTai(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "LayDeTai",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemDeTai');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='tendoituong']").val(data.tendoituong);
                    form.find("[name='tenphongban']").val(data.tenphongban);
                    form.find("[name='tencoquan']").val(data.tencoquan);
                    form.find("[name='tensangkien']").val(data.tensangkien);
                    form.find("[name='thoigiancongnhan']").val(data.thoigiancongnhan);
                    form.find("[name='thanhtichdatduoc']").val(data.thanhtichdatduoc);
                    form.find("[name='donvicongnhan']").val(data.donvicongnhan);
                }
            })
        }

        function LuuDeTai() {
            var formData = new FormData($('#frm_ThemDeTai')[0]);

            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "ThemDeTai",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        $('#dsdetai').replaceWith(data.message);
                        TableManaged5.init();
                    }
                }
            })
            $('#modal-detai').modal("hide");
        }

        function delDeTai(id, url) {
            $('#frm_XoaDeTai').attr('action', url);
            $('#frm_XoaDeTai').find("[name='iddelete']").val(id);
        }

        function confirmXoaDeTai() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_XoaDeTai');

            $.ajax({
                url: form.attr('action'),
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: $('#iddelete').val(),
                },
                dataType: 'JSON',
                success: function(data) {
                    toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                    $('#dsdetai').replaceWith(data.message);
                    jQuery(document).ready(function() {
                        TableManaged5.init();
                    });
                }
            });

            $('#modal-delete-detai').modal("hide");
        }
    </script>
