    {{-- tập thể --}}
    {!! Form::open([
        'url' => '',
        'id' => 'frm_ThemTapThe',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="id" />
    <div class="modal fade bs-modal-lg" id="modal-create-tapthe" tabindex="-1" role="dialog" aria-hidden="true">
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
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Phân loại đơn vị</label>
                            {!! Form::select('maphanloaitapthe', $a_tapthe, null, [
                                'class' => 'form-control',
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
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Kết quả khen thưởng</label>
                            {!! Form::select('ketqua', ['0' => 'Không khen thưởng', '1' => 'Có khen thưởng'], null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Nội dung khen thưởng / Lý do không khen thưởng</label>
                            {!! Form::textarea('noidungkhenthuong', null, [
                                'class' => 'form-control',
                                'rows' => '2',
                            ]) !!}
                        </div>
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

    {{-- tập thể --}}
    {!! Form::open([
        'url' => $inputs['url_qd'] . '/GanSoQDTapThe',
        'id' => 'frm_SoQDTapThe',
        'class' => 'form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="id" />
    <div class="modal fade bs-modal-lg" id="modal-soqdtapthe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gán thông tin số quyết định khen thưởng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label">Số quyết định khen thưởng</label>
                            {!! Form::text('soqdkhenthuong', null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="col-md-6">
                            <label>Ngày ra quyết định</label>
                            {!! Form::input('date', 'ngayqdkhenthuong', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover dulieubang">
                                <thead>
                                    <tr class="text-center">
                                        <th width="2%">STT</th>
                                        <th>Tên tập thể</th>
                                        <th>Phân loại<br>đối tượng</th>
                                        <th>Danh hiệu thi đua/<br>Hình thức khen thưởng </th>
                                        {{-- <th>Loại hình khen thưởng</th> --}}
                                        {{-- <th>Kết quả<br>khen thưởng</th> --}}
                                        {{-- <th>Lý do không khen/</br>Nội dung khen thưởng</th> --}}
                                        <th width="10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($model_tapthe as $key => $tt)
                                        <tr class="odd gradeX">
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $tt->tentapthe }}</td>
                                            <td>{{ $a_tapthe[$tt->maphanloaitapthe] ?? '' }}</td>
                                            <td class="text-center">
                                                {{ $a_dhkt_tapthe[$tt->madanhhieukhenthuong] ?? '' }}
                                            </td>
                                            {{-- <td class="text-center">
                                                {{ $a_loaihinhkt[$model->maloaihinhkt] ?? '' }}
                                            </td> --}}
                                            {{-- @if ($tt->ketqua == 1)
                                                <td class="text-center">
                                                    <a class="btn btn-sm btn-clean btn-icon">
                                                        <i class="icon-lg la fa-check text-primary icon-2x"></i>
                                                    </a>
                                                @else
                                                <td class="text-center">
                                                    <a class="btn btn-sm btn-clean btn-icon">
                                                        <i class="icon-lg la fa-times-circle text-danger icon-2x"></i>
                                                    </a>
                                                </td>
                                            @endif
                                            <td>{{ $tt->noidungkhenthuong }}</td> --}}
                                            <td class="text-center">
                                                @if ($tt->ketqua == 1)
                                                    <input type="checkbox" name="{{ 'hoso[' . $tt->mahosotdkt . ']' }}"
                                                        class="btn btn-sm icon-2x" checked />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
            $('#frm_ThemTapThe').find("[name='ketqua']").val('1').trigger('change');
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ $inputs['url_hs'] }}" + "LayTapThe",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='id']").val(data.id);
                    form.find("[name='maphanloaitapthe']").val(data.maphanloaitapthe).trigger('change');
                    // form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
                    // form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='madanhhieukhenthuong']").val(data.madanhhieukhenthuong).trigger('change');
                    form.find("[name='noidungkhenthuong']").val(data.noidungkhenthuong);
                    form.find("[name='tentapthe']").val(data.tentapthe);
                    form.find("[name='ketqua']").val(data.ketqua).trigger('change');
                }
            });
        }

        function LuuTapThe() {
            var formData = new FormData($('#frm_ThemTapThe')[0]);

            $.ajax({
                url: "{{ $inputs['url'] }}" + "ThemTapThe",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        TableManaged4.init();
                    }
                }
            })
            $('#modal-create-tapthe').modal("hide");
        }
    </script>
