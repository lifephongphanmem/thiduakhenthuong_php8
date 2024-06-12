@extends('CongBo.maincongbo')

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
    </script>

@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom mt-10" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách tài liệu hướng dẫn</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th  width="5%">STT</th>
                                <th>Tên tài liệu</th>
                                <th>Diễn giải</th>
                                <th width="20%" >Thao tác</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>

                                <td style="text-align: center" name="stt">{{ $tt->stt }}</td>
                                <td class="active" name="tentailieu">{{ $tt->tentailieu }}</td>
                                <td name="noidung">{{ $tt->noidung }}</td>

                                <td class=" text-center">
                                    <a target="_blank"  title="Tải file đính kèm"
                                        href="{{'/data/tailieuhuongdan/' . $tt->file}}"
                                        class="btn btn-clean btn-icon btn-sm"><i
                                            class="fa flaticon-download text-info"></i></a>
                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->


@stop
