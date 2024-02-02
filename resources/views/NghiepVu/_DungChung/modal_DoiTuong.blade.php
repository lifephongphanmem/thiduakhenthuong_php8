{{-- Thong tin đối tượng --}}
<div id="modal-doituong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover dulieubang">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%">STT</th>
                                    <th>Đơn vị công tác</th>
                                    <th>Tên đối tượng</th>
                                    <th>Chức vụ</th>
                                    <th width="10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($m_canhan as $key => $tt)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $tt->tendonvi }}</td>
                                        <td>{{ $tt->tendoituong }}</td>
                                        <td>{{ $tt->chucvu }}</td>
                                        <td class="text-center">
                                            <button title="Chọn đối tượng" type="button"
                                                onclick="confirmDoiTuong('{{ $tt->id }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-toggle="modal">
                                                <i class="icon-lg la fa-check text-success"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
            </div>
        </div>
    </div>
</div>

{{-- Thông tin đối tượng là tập thể --}}
<div id="modal-tapthe" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover dulieubang">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%">STT</th>
                                    <th>Tên đơn vị</th>
                                    <th width="10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($m_tapthe as $key => $tt)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $tt->tentapthe }}</td>
                                        <td class="text-center">
                                            <button title="Chọn đối tượng" type="button"
                                                onclick="confirmTapThe('{{ $tt->matapthe }}','{{ $tt->tentapthe }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-toggle="modal">
                                                <i class="icon-lg la fa-check text-success"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    function confirmDoiTuong(id, url) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ $inputs['url_hs'] }}" + "LayCaNhan",
            type: 'GET',
            data: {
                _token: CSRF_TOKEN,
                id: id,
            },
            dataType: 'JSON',
            success: function(data) {
                var form = $('#frm_ThemCaNhan');
                form.find("[name='tendoituong']").val(data.tendoituong);
                form.find("[name='ngaysinh']").val(data.ngaysinh);
                form.find("[name='gioitinh']").val(data.gioitinh).trigger('change');
                form.find("[name='chucvu']").val(data.chucvu);
                form.find("[name='tenphongban']").val(data.tenphongban);
                form.find("[name='tencoquan']").val(data.tencoquan);
                form.find("[name='maphanloaicanbo']").val(data.maphanloaicanbo).trigger('change');
                form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
            }
        })
        $('#modal-doituong').modal("hide");
    }

    function confirmTapThe(tentapthe) {
        var form = $('#frm_ThemTapThe');
        form.find("[name='tentapthe']").val(tentapthe);
        $('#modal-tapthe').modal("hide");
    }
</script>
