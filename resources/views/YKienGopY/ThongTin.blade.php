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
            TableManagedclass.init();
            $('#madonvi').change(function() {
                window.location.href = "/YKienGopY/ThongTin?madonvi=" + $(
                    '#madonvi').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                {{-- <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng chuyên đề</h3> --}}
                <h3 class="card-label text-uppercase">Ý kiến đóng góp</h3>
            </div>
            <div class="card-toolbar">
                {{-- @if (chkPhanQuyen('dshosodenghikhenthuongchuyende', 'thaydoi')) --}}
                    <a  href="{{'/YKienGopY/Them?madonvi='.$inputs['madonvi']}}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</a>
                {{-- @endif --}}
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-5">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($a_diaban as $key => $val)
                            <optgroup label="{{ $val }}">
                                <?php $donvi = $m_donvi->where('madiaban', $key); ?>
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
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th width="20%">Đơn vị góp ý</th>
                                <th>Tiêu đề </th>
                                <th width="10%">Nội dung góp ý</th>
                                <th width="8%">Trạng thái</th>
                                <th>Đơn vị tiếp nhận</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $tt->madonvi}}</td>
                                <td>{{ $tt->tieude}}</td>
                                <td>{{ $tt->noidung }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    <a href="{{ url($inputs['url'] . 'Sua?magopy=' . $tt->magopy) }}"
                                        class="btn btn-sm btn-clean btn-icon" title="Sửa thông tin">
                                        <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                    </a>

                                    <button type="button"
                                        onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                        data-toggle="modal" title="Xóa văn bản">
                                        <i class="icon-lg la flaticon-delete text-danger"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('includes.modal.modal-delete')

@stop
