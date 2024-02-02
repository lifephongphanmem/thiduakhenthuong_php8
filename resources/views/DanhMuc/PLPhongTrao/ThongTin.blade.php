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
        });

        function add() {
            $('#frm_modify').find("[name='maplphongtrao']").attr('readonly', true);
            $('#frm_modify').find("[name='maplphongtrao']").val(null);
            $('#frm_modify').find("[name='tenplphongtrao']").val('');
        }

        function edit(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/PLPhongTraoThiDua/LayChiTiet",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_modify');
                    form.find("[name='maplphongtrao']").attr('readonly', false);
                    form.find("[name='maplphongtrao']").val(data.maplphongtrao);                  
                    form.find("[name='tenplphongtrao']").val(data.tenplphongtrao);                  
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
                <h3 class="card-label text-uppercase">Danh mục phân loại phong trào thi đua </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dmphongtraothidua', 'thaydoi'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs"
                        data-target="#modify-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">            

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th width="20%">Mã số</th>
                                <th>Tên phong trào thi đua</th>                              
                                <th width="10%" >Thao tác</th>
                            </tr>                            
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $ct->maplphongtrao }}</td>
                                    <td>{{ $ct->tenplphongtrao }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dmphongtraothidua', 'thaydoi'))
                                            <button type="button" title="Chỉnh sửa" onclick="edit('{{ $ct->id }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-success"></i></button>

                                            <button title="Xóa thông tin" type="button"
                                                onclick="confirmDelete('{{ $ct->id }}','{{ '/PLPhongTraoThiDua/Xoa' }}')"
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
    {!! Form::open(['url' => '/PLPhongTraoThiDua/Them', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin chi tiết</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('maplphongtrao', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label class="control-label">Tên phong trào thi đua<span class="require">*</span></label>
                                {!! Form::text('tenplphongtrao', null, ['class' => 'form-control', 'required' => 'required']) !!}
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
