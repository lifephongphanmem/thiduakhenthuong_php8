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
            TableManagedclass.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách trưởng cụm, khối</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dstruongcumkhoi', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#modify-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Mô tả</label>
                    <textarea class="form-control" readonly>{{ $m_cumkhoi->mota }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên cụm, khối</th>
                                <th>Tên đơn vị trưởng cụm, khối</th>
                                <th style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td>{{ $a_cumkhoi[$tt->macumkhoi] ?? '' }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td class="text-center">
                                    <button title="Thay đổi" type="button"
                                        onclick="getThongTin('{{ $tt->madonvi }}', '{{ $tt->macumkhoi }}', '{{ $tt->madanhsach }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la fa-edit text-dark"></i>
                                    </button>
                                    <button title="Xóa cụm khối" type="button"
                                        onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'XoaDonVi' }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la fa-trash-alt text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url($inputs['url'] . 'ThongTin') }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    {!! Form::open(['url' => $inputs['url'] . 'LuuTruongCum', 'id' => 'frm_modify']) !!}
    {{ Form::hidden('madanhsach', $inputs['madanhsach'], ['id' => 'madanhsach']) }}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin địa đơn vị</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Cụm, khối thi đua</label>
                                {!! Form::select('macumkhoi', $a_cumkhoi, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div id="dSDonVi"  class="col-md-12">
                                <label class="control-label">Tên đơn vị</label>
                                {!! Form::select('madonvi', [], null, ['class' => 'form-control']) !!}
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

    <script>
        function getThongTin(madonvi, macumkhoi, madanhsach) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ $inputs['url'] }}" + "LayDSDonVi",
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    macumkhoi: macumkhoi,
                    madonvi: madonvi
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#dSDonVi').replaceWith(data.message);
                    }
                }
            });

            $('#frm_modify').find("[name='macumkhoi']").val(macumkhoi).trigger('change');
            $('#frm_modify').find("[name='madanhsach']").val(madanhsach);
        }
    </script>
    @include('includes.modal.modal-delete')
@stop
