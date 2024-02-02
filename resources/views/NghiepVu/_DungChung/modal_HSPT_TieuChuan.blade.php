    {{-- Thông tin tiêu chuẩn --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_DSTieuChuan',
        'class' => 'form',
    ]) !!}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <input type="hidden" id="iddoituong" name="iddoituong" />
        <input type="hidden" id="phanloaidoituong" name="iddoituong" />
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin tiêu chuẩn của đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-8">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            <label class="form-control-label">Phân loại</label>
                            {!! Form::select('phanloaidoituong', getPhanLoaiTDKT(), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <hr>
                    <div class="row" id="dstieuchuan">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {{-- Thay đổi tiêu chuẩn --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_TieuChuan',
        'class' => 'form',
    ]) !!}
    <div id="modal-luutieuchuan" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <input type="hidden"name="id" />
        <input type="hidden"name="matieuchuandhtd" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="form-control-label">Tên tiêu chuẩn</label>
                            {!! Form::textarea('tentieuchuandhtd', null, [
                                'id' => 'tentieuchuandhtd',
                                'class' => 'form-control',
                                'rows' => '3',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-offset-4 col-md-8">
                            <div class="md-checkbox">
                                <input type="checkbox" id="dieukien_ltc" name="dieukien_ltc" class="md-check">
                                <label for="dieukien_ltc">
                                    <span></span><span class="check"></span><span class="box"></span>Đủ điều
                                    kiện</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTieuChuan()">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        function getTieuChuan(iddoituong, phanloaidoituong, tendoituong) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#frm_DSTieuChuan').find("[name='iddoituong']").val(iddoituong);
            $('#frm_DSTieuChuan').find("[name='tendoituong']").val(tendoituong);
            $('#frm_DSTieuChuan').find("[name='phanloaidoituong']").val(phanloaidoituong).trigger('change');
            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + 'LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    iddoituong: iddoituong,
                    phanloaidoituong: phanloaidoituong,
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosothamgiapt: $('#frm_ThayDoi').find("[name='mahosothamgiapt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
        }

        function ThayDoiTieuChuan(matieuchuandhtd, id, tentieuchuandhtd) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#frm_TieuChuan').find("[name='tentieuchuandhtd']").val(tentieuchuandhtd);
            $('#frm_TieuChuan').find("[name='matieuchuandhtd']").val(matieuchuandhtd);
            $('#frm_TieuChuan').find("[name='id']").val(id);
        }

        function LuuTieuChuan() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + 'LuuTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    iddoituong: $('#frm_DSTieuChuan').find("[name='iddoituong']").val(),
                    id: $('#frm_TieuChuan').find("[name='id']").val(),
                    matieuchuandhtd: $('#frm_TieuChuan').find("[name='matieuchuandhtd']").val(),
                    madonvi: $('#madonvi').val(),
                    phanloaidoituong: $('#frm_DSTieuChuan').find("[name='phanloaidoituong']").val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosothamgiapt: $('#frm_ThayDoi').find("[name='mahosothamgiapt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
            $('#modal-luutieuchuan').modal("hide");
        }
    </script>
