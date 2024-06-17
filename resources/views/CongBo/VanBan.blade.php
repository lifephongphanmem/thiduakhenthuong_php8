@extends('CongBo.maincongbo')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {{-- <script src="/assets/js/pages/select2.js"></script>
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    <script src="/assets/js/pages/table-lifesc.js"></script> --}}
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        jQuery(document).ready(function() {
            TableManaged3.init();
            $('#phannhom').change(function() {
                window.location.href = "/CongBo/VanBan?phannhom="+$('#phannhom').val();
            });
        });

    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom mt-10" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">danh sách VĂN BẢN QUẢN LÝ NHÀ NƯỚC VỀ THI ĐUA KHEN THƯỞNG</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->

                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Phân nhóm</label>
                    {!! Form::select('phannhom', getPhanNhomTL('ALL'), $inputs['phannhom'], ['id' => 'phannhom', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="sample_3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center">Đơn vị ban hành</th>
                                <th style="text-align: center" width="5%">Số hiệu <br>văn bản</th>
                                <th style="text-align: center">Nội dung</th>
                                <th style="text-align: center">Ngày <br>áp dụng</th>
                                <th style="text-align: center" width="5%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td class="active">{{ $tt->dvbanhanh }}</td>
                                    <td class="success">{{ $tt->kyhieuvb }}</td>
                                    <td>{{ $tt->tieude }}</td>
                                    <td style="text-align: center">{{ getDayVn($tt->ngayapdung) }}
                                    </td>
                                    <td>
                                        <button type="button" title="Tải tệp"
                                            onclick="get_attack('{{ $tt->mavanban }}','{{ '/CongBo/TaiLieuVanBan' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                            data-toggle="modal"><i class="icon-lg la flaticon-download text-dark"></i>
                                        </button>
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

    <div id="dinhkem-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => '', 'id' => 'frm_dinhkem']) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Danh sách tài liệu đính kèm</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body" id="dinh_kem">

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        function get_attack(mahs, url) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    mahs: mahs
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data)
                    if (data.status == 'success') {
                        $('#dinh_kem').replaceWith(data.message);
                    }
                },
                error: function(message) {
                    toastr.error(message, 'Lỗi!');
                }
            });
        }
    </script>
@stop
