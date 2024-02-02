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
            $('#phanloai, #madonvi, #nam').change(function() {
                window.location.href = "{{ $inputs['url'] }}" + 'ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&phanloai=' + $('#phanloai').val()+ '&macumkhoi=' + $('#macumkhoi').val();
            });

        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi'))
                    <a href="{{ url($inputs['url'] . 'Them?madonvi=' . $inputs['madonvi'] . '&nam=' . $inputs['nam']) }}"
                        class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                    {{-- <a href="{{ url($inputs['url'] . 'Them?madonvi=' . $inputs['madonvi'] . '&macumkhoi=' . $inputs['macumkhoi']) }}"
                        class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a> --}}
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-5">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
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
                <div class="col-4">
                    <label style="font-weight: bold">Hình thức tổ chức</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloai, 'Tất cả', 'ALL'), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-2">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label style="font-weight: bold">Cụm, khối thi đua</label>
                    <select class="form-control select2basic" id="macumkhoi">
                        @foreach ($m_cumkhoi as $cumkhoi)
                            <option {{ $cumkhoi->macumkhoi == $inputs['macumkhoi'] ? 'selected' : '' }}
                                value="{{ $cumkhoi->macumkhoi }}">{{ $cumkhoi->tencumkhoi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            {{-- <div class="form-group row">
                <div class="col-md-4">
                    <label style="font-weight: bold">Phạm vi phát động</label>
                    {!! Form::select('phamviapdung', setArrayAll($a_phamvi, 'Tất cả', 'ALL'), $inputs['phamviapdung'], [
                        'id' => 'phamviapdung',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>

            </div> --}}

            <hr>
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Nội dung phong trào</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                <th>Ngày quyết định</th>
                                {{-- <th width="15%">Phạm vi phát động</th> --}}
                                <th width="15%">Hình thức tổ chức</th>
                                <th>Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td class="active">{{ $tt->noidung }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                <td class="text-center">{{ getDayVn($tt->ngayqd) }}</td>
                                {{-- <td>{{ $a_phamvi[$tt->phamviapdung] ?? '' }}</td> --}}
                                <td>{{ $a_phanloai[$tt->phanloai] ?? '' }}</td>
                                @include('includes.td.td_trangthai_phongtrao')
                                <td class=" text-center">
                                    <a title="Xem chi tiết"
                                        href="{{ url($inputs['url'] . 'Xem?maphongtraotd=' . $tt->maphongtraotd) }}"
                                        class="btn btn-sm btn-clean btn-icon" target="_blank">
                                        <i class="icon-lg la fa-eye text-dark icon-2x"></i>
                                    </a>
                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->maphongtraotd }}','{{ $inputs['url'] . 'TaiLieuDinhKem' }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark icon-2x"></i></button>
                                    @if (chkPhanQuyen('dsphongtraothiduacumkhoi', 'thaydoi'))
                                        @if ($tt->trangthai == 'CC')
                                            <a title="Chỉnh sửa"
                                                href="{{ url($inputs['url'] . 'Sua?maphongtraotd=' . $tt->maphongtraotd) }}"
                                                class="btn btn-sm btn-clean btn-icon"><i
                                                    class="icon-lg la fa-edit text-success icon-2x"></i>
                                            </a>

                                            <button title="Xóa hồ sơ" type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . '/Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash-alt text-danger icon-2x"></i>
                                            </button>
                                        @endif
                                        <button title="Thiết lập phong trào" type="button"
                                            onclick="setKetQua('{{ $tt->maphongtraotd }}','{{ $tt->trangthai }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-KetThuc"
                                            data-toggle="modal">
                                            <i class="icon-lg la flaticon-calendar-3 text-warning"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <!--Modal kết thúc nhận hồ sơ để khen thưởng-->
    <div class="modal fade" id="modal-KetThuc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open([
                    'url' => '/CumKhoiThiDua/PhongTraoThiDua/GanTrangThai',
                    'method' => 'post',
                    'files' => true,
                    'id' => 'frm_KetThuc',
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="modal-header">

                    <h4 class="modal-title">Thiết lập trạng thái phong trào thi đua</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" name="maphongtraotd" id="maphongtraotd">
                <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">Trạng thái phong trào</label>
                                {!! Form::select(
                                    'trangthai',
                                    ['CC' => 'Nhận hồ sơ', 'CXKT' => 'Chờ khen thưởng', 'DKT' => 'Đã kết thúc'],
                                    null,
                                    ['class' => 'form-control select2_modal'],
                                ) !!}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        function setKetQua(maphongtraotd, trangthai) {
            $('#frm_KetThuc').find("[name='maphongtraotd']").val(maphongtraotd);
            $('#frm_KetThuc').find("[name='trangthai']").val(trangthai).trigger('change');
        }
    </script>

    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_attackfile')
@stop
