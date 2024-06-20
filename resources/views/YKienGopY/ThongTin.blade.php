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
                <a href="{{ '/YKienGopY/Them?madonvi=' . $inputs['madonvi'] }}" class="btn btn-success btn-xs">
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
                                <th width="10%">Thời gian</th>
                                <th width="8%">Trạng thái</th>
                                <th>Đơn vị tiếp nhận</th>
                                <th>Thời gian tiếp nhận</th>
                                <th>Thời gian phản hồi</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $tt->madonvi }}</td>
                                <td>{{ $tt->tieude }}</td>
                                <td>{{ $tt->noidung }}</td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $tt->thoigiangopy }}</td>
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>
                                <td>{{ $tt->thoigiantiepnhan }}</td>
                                <td>{{ $tt->thoigianphanhoi }}</td>
                                <td style="text-align: center">
                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->magopy }}', '{{ $inputs['url_tailieudinhkem'] }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark icon-2x"></i>
                                    </button>
                                    <a href="{{ url($inputs['url'] . 'Sua?magopy=' . $tt->magopy) }}"
                                        class="btn btn-sm btn-clean btn-icon" title="Sửa thông tin">
                                        <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                    </a>
                                    @if ($tt->trangthai == 0)
                                    <button title="Tiếp nhận hồ sơ" type="button"
                                    onclick="confirmNhan('{{ $tt->magopy }}','{{ $inputs['url'] . 'NhanYKien' }}')"
                                    class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm"
                                    data-toggle="modal">
                                    <i class="icon-lg flaticon-interface-5 text-success"></i>
                                </button>     
                                    @endif

                                    <button title="Thông tin phản hồi" type="button"
                                    onclick="viewLyDo('{{ $tt->magopy }}','{{ $inputs['madonvi'] }}','/HoSoThiDua/LayLyDo')"
                                    class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                    data-toggle="modal">
                                    <i class="icon-lg la fa-archive text-dark"></i></button>

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

    <!--Modal Nhận hồ sơ-->
    <div id="nhan-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => '', 'id' => 'frm_nhan']) !!}
        <input type="hidden" name="magopy" />
        <input type="hidden" name="madonvi_nhan" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tiếp nhận hồ sơ?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">
                    <p style="color: #0000FF">Ý kiến góp ý sẽ được tiếp nhận và được phản hồi.</p>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickNhan()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <script>
        function clickNhan() {
            $('#frm_nhan').submit();
        }

        function confirmNhan(mahs, url, madonvi) {
            $('#frm_nhan').attr('action', url);
            $('#frm_nhan').find("[name='magopy']").val(mahs);
            // $('#frm_nhan').find("[name='madonvi_nhan']").val(madonvi);
        }
    </script>
    @include('includes.modal.modal-delete')

@stop
