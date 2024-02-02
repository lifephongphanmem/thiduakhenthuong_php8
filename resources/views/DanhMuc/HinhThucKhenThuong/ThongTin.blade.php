@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    <script src="/assets/js/pages/table-lifesc.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        jQuery(document).ready(function() {
            TableManaged3.init();
            $('#phanloai, #phamviapdung').change(function() {
                window.location.href = "{{ $inputs['url'] }}" + 'ThongTin?phanloai=' + $('#phanloai')
                .val() + '&phamviapdung=' + $('#phamviapdung').val();
            });
        });

        function add(phanloai) {
            $('#frm_modify').find("[name='mahinhthuckt']").attr('readonly', true);
            $('#frm_modify').find("[name='mahinhthuckt']").val(null);
            $('#frm_modify').find("[name='phanloai']").val(phanloai);
        }

        function edit(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ $inputs['url'] }}" + "LayChiTiet",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_modify');
                    form.find("[name='mahinhthuckt']").attr('readonly', false);
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt);
                    form.find("[name='tenhinhthuckt']").val(data.tenhinhthuckt);
                    form.find("[name='phanloai']").val(data.phanloai).trigger('change');
                    form.find("[name='muckhencanhan']").val(data.muckhencanhan);
                    form.find("[name='muckhentapthe']").val(data.muckhentapthe);
                    form.find("[name='phamviapdung[]']").val(data.phamviapdung.split(';')).trigger('change');
                    form.find("[name='doituongapdung[]']").val(data.doituongapdung.split(';')).trigger(
                    'change');
                }
            });
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách: danh hiệu thi đua, hình thức khen thưởng </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dmhinhthuckhenthuong', 'thaydoi'))
                    <button type="button" onclick="add('{{ $inputs['phanloai'] }}')" class="btn btn-success btn-xs"
                        data-target="#modify-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Phân loại</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloai), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>

                <div class="col-lg-6">
                    <label>Phạm vi áp dụng</label>
                    {!! Form::select('phamviapdung', setArrayAll($a_phamvi), $inputs['phamviapdung'], [
                        'id' => 'phamviapdung',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%" rowspan="2">STT</th>
                                <th rowspan="2">Tên hình thức khen thưởng</th>
                                <th rowspan="2">Phạm vi áp dụng</th>
                                <th rowspan="2">Đối tượng áp dụng</th>
                                <th colspan="2">Hệ số khen thưởng</th>
                                <th width="10%" rowspan="2">Thao tác</th>
                            </tr>
                            <tr class="text-center">
                                <th width="8%">Cá nhân</th>
                                <th width="8%">Tập thể</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $ct->tenhinhthuckt }}</td>
                                    <td>{{ $ct->tenphamviapdung }}</td>
                                    <td>{{ $ct->tendoituongapdung }}</td>
                                    @if ($ct->canhan_ad)
                                        <td class="text-center">{{ dinhdangso($ct->muckhencanhan, 2) }}</td>
                                    @else
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-times-circle text-danger text-primary icon-2x"></i>
                                            </a>
                                        </td>
                                    @endif

                                    @if ($ct->tapthe_ad)
                                        <td class="text-center">{{ dinhdangso($ct->muckhentapthe, 2) }}</td>
                                    @else
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-times-circle text-danger text-primary icon-2x"></i>
                                            </a>
                                        </td>
                                    @endif

                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dmhinhthuckhenthuong', 'thaydoi'))
                                            <button type="button" title="Chỉnh sửa" onclick="edit('{{ $ct->id }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-success"></i></button>

                                            <button title="Xóa thông tin" type="button"
                                                onclick="confirmDelete('{{ $ct->id }}','{{ '/HinhThucKhenThuong/Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash-alt text-danger"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <!--Modal thông tin chi tiết -->
    {!! Form::open(['url' => '/HinhThucKhenThuong/Them', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin hình thức khen thưởng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('mahinhthuckt', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Tên hình thức khen thưởng<span class="require">*</span></label>
                                {!! Form::text('tenhinhthuckt', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Phân loại</label>
                                {!! Form::select('phanloai', $a_phanloai, null, ['class' => 'form-control select2_modal']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Phạm vi áp dụng</label>
                                {!! Form::select('phamviapdung[]', getPhamViApDung(), null, [
                                    'class' => 'form-control select2_modal',
                                    'multiple',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Đối tượng áp dụng</label>
                                {!! Form::select('doituongapdung[]', getDoiTuongApDung(), null, [
                                    'class' => 'form-control select2_modal',
                                    'multiple',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label class="control-label">Mức khen cá nhân</label>
                                {!! Form::number('muckhencanhan', 0, ['class' => 'form-control', 'step' => '0.1']) !!}
                            </div>
                            <div class="col-6">
                                <label class="control-label">Mức khen tập thể</label>
                                {!! Form::number('muckhentapthe', 0, ['class' => 'form-control', 'step' => '0.1']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng
                        ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('includes.modal.modal-delete')
@stop
