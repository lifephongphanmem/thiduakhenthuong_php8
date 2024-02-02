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
            $('#phanloai').change(function() {
                window.location.href = '/TaiKhoan/PhamViDuLieu?tendangnhap=' +
                    "{{ $model_taikhoan->tendangnhap }}" + '&phanloai=' + $(this).val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thiết lập phạm vi dữ liệu cho cán bộ:
                    {{ $model_taikhoan->tentaikhoan }} </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <div class="form-group row">
                    <div class="col-lg-12 text-right">
                        <div class="btn-group" role="group">
                            <button type="button" data-target="#diaban-modal" data-toggle="modal"
                                class="btn btn-light-dark btn-sm">
                                <i class="fa fa-plus"></i>Địa bàn
                            </button>
                            <button onclick="setNhanExcel()" data-target="#cumkhoi-modal" data-toggle="modal" type="button"
                                class="btn btn-info btn-sm"><i class="fas fa-plus"></i>Cụm, khối
                            </button>
                            <button onclick="setNhanExcel()" data-target="#donvi-modal" data-toggle="modal" type="button"
                                class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>Đơn vị
                            </button>
                        </div>
                    </div>
                </div>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Phân loại phạm vị</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloai), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th width="20%">Phân loại phạm vi</th>
                                <th>Tên phạm vi dữ liệu</th>
                                <th width="10%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td class="text-right">{{ $i++ }}</td>
                                    <td>{{ $a_phanloai[$ct->phanloai] ?? $ct->phanloai }}</td>
                                    <td>{{ $ct->tenphamvi }}</td>
                                    <td class="text-center">
                                        <button type="button"
                                            onclick="confirmDelete('{{ $ct->id }}', '/TaiKhoan/XoaPhamViDuLieu' )"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/TaiKhoan/DanhSach?madonvi=' . $model_taikhoan->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    {{-- Phạm vi theo địa bàn hành chính --}}
    {!! Form::open(['url' => $inputs['url'], 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="tendangnhap" value="{{ $model_taikhoan->tendangnhap }}" />
    <input type="hidden" name="phanloai" value="DIABAN" />
    <div id="diaban-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thiết lập phạm vi lọc dữ liệu theo địa bàn</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Tên địa bàn</label>
                            {!! Form::select('maphamvi', $a_diaban, null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Phạm vị theo đơn vị --}}
    {!! Form::open(['url' => $inputs['url'], 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="tendangnhap" value="{{ $model_taikhoan->tendangnhap }}" />
    <input type="hidden" name="phanloai" value="DONVI" />
    <div id="donvi-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thiết lập phạm vi lọc dữ liệu theo đơn vị</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Tên đơn vị</label>
                            {!! Form::select('maphamvi', $a_donvi, null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Phạm vị theo cụm khối thi đua --}}
    {!! Form::open(['url' => $inputs['url'], 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="tendangnhap" value="{{ $model_taikhoan->tendangnhap }}" />
    <input type="hidden" name="phanloai" value="CUMKHOI" />
    <div id="cumkhoi-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thiết lập phạm vi lọc dữ liệu theo cụm khối
                    </h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Tên cụm, khối thi đua</label>
                            {!! Form::select('maphamvi', $a_cumkhoi, null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @include('includes.modal.modal-delete')
@stop
