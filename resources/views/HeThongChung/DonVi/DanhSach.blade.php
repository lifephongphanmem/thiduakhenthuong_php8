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
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">danh sách&nbsp;đơn vị - {{ $inputs['tendiaban'] }}</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsdonvi', 'thaydoi'))
                    <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                        onclick="setDiaBanExCel('{{ $m_diaban->madiaban }}')" data-toggle="modal" type="button"
                        class="btn btn-info btn-sm mr-5"><i class="fas fa-file-import"></i>Nhận Excel
                    </button>

                    <a href="{{ url('DonVi/Them?madiaban=' . $inputs['madiaban']) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Địa bàn</label>
                    {!! Form::select('madiaban', getDiaBan_All(), $inputs['madiaban'], [
                        'id' => 'madiaban',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th width="75%">Tên đơn vị</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="active">{{ $tt->tendonvi }}</td>
                                    <td class="text-center">
                                        <a title="Sửa thông tin" href="{{ url('/DonVi/Sua?madonvi=' . $tt->madonvi) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la flaticon-edit-1 text-primary"></i>
                                        </a>
                                        <a href="{{ url('/TaiKhoan/DanhSach?madonvi=' . $tt->madonvi) }}"
                                            class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                            title="Danh sách tài khoản">
                                            <span class="svg-icon svg-icon-xl">
                                                <i class="icon-lg flaticon-list-2 text-dark"></i>
                                            </span>
                                            <span
                                                class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->sotaikhoan }}</span>
                                        </a>

                                        <button title="Xóa thông tin" type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg flaticon-delete text-danger"></i>
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

    {{-- Nhận file Excel --}}
    <div class="modal fade bs-modal-lg" id="modal-nhanexcel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nhận dữ liệu địa bàn cấp dưới từ file</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#excel_tapthe">
                                            <span class="nav-icon">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <span class="nav-text">Thông tin nhận File</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="excel_tapthe" role="tabpanel"
                                    aria-labelledby="excel_tapthe">

                                    {!! Form::open([
                                        'url' => $inputs['url'] . 'NhanExcel',
                                        'method' => 'POST',
                                        'id' => 'frm_NhanExcel',
                                        'class' => 'form',
                                        'files' => true,
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="madiaban" />

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Tên đơn vi</label>
                                            {!! Form::text('tendonvi', 'B', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tài khoản đăng nhập</label>
                                            {!! Form::text('tendangnhap', 'C', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Sheet nhận dữ liệu<span
                                                    class="require">*</span></label>
                                            {!! Form::text('sheet', '0', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Nhận từ dòng<span class="require">*</span></label>
                                            {!! Form::text('tudong', '4', ['class' => 'form-control']) !!}
                                            {{-- {!! Form::text('tudong', '4', ['class' => 'form-control', 'required', 'data-mask' => 'fdecimal']) !!} --}}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Nhận đến dòng</label>
                                            {!! Form::text('dendong', '200', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>File danh sách: </label>
                                            {!! Form::file('fexcel', null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <h4>Tham số mặc định</h4>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label class="control-label">Nhóm chức năng<span
                                                    class="require">*</span></label>
                                            {!! Form::select('manhomchucnang', $a_nhomchucnang, null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>

                                        <div class="col-md-4">
                                            <label class="control-label">Cụm, khối thi đua<span
                                                    class="require">*</span></label>
                                            {!! Form::select('macumkhoi', setArrayAll($a_cumkhoi, 'Không chọn', 'NULL'), null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-check"></i>Hoàn thành</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <script>
        function setDiaBanExCel(madiaban) {
            var form = $('#frm_NhanExcel');
            form.find("[name='madiaban']").val(madiaban);
        }
    </script>
    @include('includes.modal.modal-delete')
@stop
