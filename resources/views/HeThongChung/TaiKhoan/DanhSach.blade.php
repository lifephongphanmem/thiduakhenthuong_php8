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

            $('#madonvi').change(function() {
                window.location.href = '/TaiKhoan/DanhSach?madonvi=' + $(this).val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách tài khoản</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dstaikhoan', 'thaydoi'))
                    <a href="{{ url('/TaiKhoan/Them?&madonvi=' . $inputs['madonvi']) }}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" name="madonvi" id="madonvi">
                        @foreach ($m_diaban as $diaban)
                            <optgroup label="{{ $diaban->tendiaban }}">
                                <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Phân loại tài khoản</th>
                                <th>Tên tài khoản</th>
                                <th width="15%">Tài khoản<br>truy cập</th>
                                <th width="8%">Trạng thái</th>
                                <th width="20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td>{{ $a_phanloaitk[$tt->phanloai] ?? $tt->phanloai }}</td>
                                    <td>{{ $tt->tentaikhoan }}</td>
                                    <td class="text-center">{{ $tt->tendangnhap }}</td>

                                    @if ($tt->trangthai == 1)
                                        <td class="text-center">
                                            <button title="Tài khoản đang được kích hoạt"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-check text-primary icon-2x"></i></button>
                                        @else
                                        <td class="text-center">
                                            <button title="Tài khoản đang được kích hoạt"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-times-circle text-danger icon-2x"></i>
                                            </button>
                                        </td>
                                    @endif

                                    <td class="text-center">
                                        @if (chkPhanQuyen('dstaikhoan', 'thaydoi'))
                                            <a title="Sửa thông tin"
                                                href="{{ url('/TaiKhoan/Sua?tendangnhap=' . $tt->tendangnhap) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la flaticon-edit-1 text-primary "></i>
                                            </a>
                                            @if ($tt->trangthai == 1)
                                                <a title="Phân quyền"
                                                    href="{{ url('/TaiKhoan/PhanQuyen?tendangnhap=' . $tt->tendangnhap) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg la flaticon-user-settings text-primary icon-2x"></i></a>

                                                <button type="button" onclick="setPerGroup('{{ $tt->manhomchucnang }}','{{ $tt->tendangnhap }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modify-nhomchucnang"
                                                    data-toggle="modal" title="Đặt lại quyền theo nhóm chức năng">
                                                    <i class="icon-lg la flaticon-network text-primary icon-2x"></i>
                                                </button>                                               

                                                <a href="{{ url('/TaiKhoan/PhamViDuLieu?tendangnhap='.$tt->tendangnhap) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg la flaticon-list text-dark"></i>
                                                </a>

                                                <button title="Xóa thông tin" type="button"
                                                    onclick="confirmDelete('{{ $tt->id }}','/TaiKhoan/Xoa')"
                                                    class="btn btn-sm btn-clean btn-icon"
                                                    data-target="#delete-modal-confirm" data-toggle="modal">
                                                    <i class="icon-lg la fa-trash-alt text-danger icon-2x"></i>
                                                </button>

                                            @endif
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

    <!--Modal Nhận và trình khen thưởng hồ sơ hồ sơ-->
<div id="modify-nhomchucnang" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '/TaiKhoan/NhomChucNang', 'id' => 'frm_nhomchucnang']) !!}
    <input type="hidden" name="tendangnhap" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tải lại phân quyền của tài khoản?
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Các phân quyền của tài khoản sẽ được tải lại theo nhóm chức năng và không thể khôi phục lại</p>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Tên nhóm chức năng<span class="require">*</span></label>
                        {!! Form::select('manhomchucnang', $a_nhomtk, null, ['class' => 'form-control select2_modal', 'required'=>'true']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickNhanvaTKT()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickNhanvaTKT() {
        $('#frm_nhomchucnang').submit();
    }

    function setPerGroup(manhomchucnang, tendangnhap) {
        $('#frm_nhomchucnang').find("[name='manhomchucnang']").val(manhomchucnang);
        $('#frm_nhomchucnang').find("[name='tendangnhap']").val(tendangnhap);
    }
</script>

    @include('includes.modal.modal-delete')
@stop
