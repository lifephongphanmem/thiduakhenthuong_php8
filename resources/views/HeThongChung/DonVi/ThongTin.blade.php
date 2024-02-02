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

        function setDiaBan(madiaban, tendiaban, madonviQL, madonviKT) {
            var form = $('#frm_modify');
            form.find("[name='madiaban']").val(madiaban);
            form.find("[name='tendiaban']").val(tendiaban);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/DiaBan/LayDonVi",
                type: "GET",
                data: {
                    _token: CSRF_TOKEN,
                    madiaban: form.find("[name='madiaban']").val(),
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#donviql').replaceWith(data.message);
                        form.find("[name='madonviQL']").val(madonviQL).trigger('change');
                        form.find("[name='madonviKT']").val(madonviKT).trigger('change');
                    }
                }
            });
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách đơn vị</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th colspan="3">STT</th>
                                <th rowspan="2">Tên địa bàn</th>
                                <th rowspan="2" width="25%">Đơn vị phê<br>duyệt khen thưởng</th>
                                <th rowspan="2" width="25%">Đơn vị xét<br>duyệt hồ sơ</th>
                                <th rowspan="2" width="10%">Thao tác</th>
                            </tr>
                            <tr>
                                <th width="3%">T</th>
                                <th width="3%">H</th>
                                <th width="3%">X</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $model_t = $model->where('capdo', 'T');
                            ?>
                            @foreach ($model_t as $ct_t)
                                <tr class="success">
                                    <td class="text-center text-uppercase">{{ toAlpha($i++) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="font-weight-bold">{{ $ct_t->tendiaban }}</td>
                                    <td>{{ $a_donvi[$ct_t->madonviQL] ?? '' }}</td>
                                    <td>{{ $a_donvi[$ct_t->madonviKT] ?? '' }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('dsdonvi', 'thaydoi'))
                                            <button
                                                onclick="setDiaBan('{{ $ct_t->madiaban }}','{{ $ct_t->tendiaban }}','{{ $ct_t->madonviQL }}','{{ $ct_t->madonviKT }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                title="Thay đổi thông tin địa bàn" data-toggle="modal">
                                                <i class="icon-lg flaticon-edit-1 text-primary"></i>
                                            </button>

                                            <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_t->madiaban }}"
                                                class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                title="Danh sách đơn vị">
                                                <span class="svg-icon svg-icon-xl">
                                                    <i class="icon-lg flaticon-list-2 text-dark"></i>
                                                </span>
                                                <span
                                                    class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $ct_t->sodonvi }}</span>
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                                <?php
                                $j = 1;
                                $model_h = $model->where('madiabanQL', $ct_t->madiaban);
                                ?>
                                @foreach ($model_h as $ct_h)
                                    <tr class="info">
                                        <td></td>
                                        <td style="text-align: center">{{ romanNumerals($j++) }}</td>
                                        <td></td>
                                        <td>{{ $ct_h->tendiaban }}</td>
                                        <td>{{ $a_donvi[$ct_h->madonviQL] ?? '' }}</td>
                                        <td>{{ $a_donvi[$ct_h->madonviKT] ?? '' }}</td>
                                        <td style="text-align: center">
                                            @if (chkPhanQuyen('dsdonvi', 'thaydoi'))
                                                <button
                                                    onclick="setDiaBan('{{ $ct_h->madiaban }}','{{ $ct_h->tendiaban }}','{{ $ct_h->madonviQL }}','{{ $ct_h->madonviKT }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                    title="Thay đổi thông tin địa bàn" data-toggle="modal">
                                                    <i class="icon-lg flaticon-edit-1 text-primary"></i>
                                                </button>

                                                <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_h->madiaban }}"
                                                    class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                    title="Danh sách đơn vị">
                                                    <span class="svg-icon svg-icon-xl">
                                                        <i class="icon-lg flaticon-list-2 text-dark"></i>
                                                    </span>
                                                    <span
                                                        class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $ct_h->sodonvi }}</span>
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                    <?php
                                    $k = 1;
                                    $model_x = $model->where('madiabanQL', $ct_h->madiaban);
                                    ?>
                                    @foreach ($model_x as $ct_x)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center">{{ $k++ }}</td>
                                            <td class="em" style="font-style: italic;">{{ $ct_x->tendiaban }}</td>
                                            <td>{{ $a_donvi[$ct_x->madonviQL] ?? '' }}</td>
                                            <td>{{ $a_donvi[$ct_x->madonviKT] ?? '' }}</td>
                                            <td style="text-align: center">
                                                @if (chkPhanQuyen('dsdonvi', 'thaydoi'))
                                                    <button
                                                        onclick="setDiaBan('{{ $ct_x->madiaban }}','{{ $ct_x->tendiaban }}','{{ $ct_x->madonviQL }}','{{ $ct_x->madonviKT }}')"
                                                        class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                        title="Thay đổi thông tin địa bàn" data-toggle="modal">
                                                        <i class="icon-lg flaticon-edit-1 text-primary"></i>
                                                    </button>

                                                    <a href="{{ '/DonVi/DanhSach?madiaban=' . $ct_x->madiaban }}"
                                                        class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                        title="Danh sách đơn vị">
                                                        <span class="svg-icon svg-icon-xl">
                                                            <i class="icon-lg flaticon-list-2 text-dark"></i>
                                                        </span>
                                                        <span
                                                            class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $ct_x->sodonvi }}</span>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <!--Modal thông tin đơn vị quản lý -->
    {!! Form::open(['url' => '/DonVi/QuanLy', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đơn vị địa bàn quản lý</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-3">
                                <label class="control-label">Mã số</label>
                                {!! Form::text('madiaban', null, ['id' => 'madiaban', 'class' => 'form-control', 'readonly' => 'true']) !!}
                            </div>

                            <div class="col-9">
                                <label class="control-label">Tên địa bàn</label>
                                {!! Form::text('tendiaban', null, ['id' => 'tendiaban', 'class' => 'form-control', 'readonly' => 'true']) !!}
                            </div>
                        </div>

                        <div id="donviql" class="form-group row">
                            <div class="col6">
                                <label class="control-label">Đơn vị phê duyệt khen thưởng</label>
                                {!! Form::select('madonviQL', [], null, ['id' => 'madonviQL', 'class' => 'form-control select2_modal']) !!}
                            </div>
                            <div class="col6">
                                <label class="control-label">Đơn vị xét duyệt hồ sơ</label>
                                {!! Form::select('madonviKT', [], null, ['id' => 'madonviKT', 'class' => 'form-control select2_modal']) !!}
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
@stop
