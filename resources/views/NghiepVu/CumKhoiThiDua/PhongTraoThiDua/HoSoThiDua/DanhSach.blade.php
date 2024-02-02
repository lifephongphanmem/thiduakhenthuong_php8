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
            $('#madonvi,#nam, #phanloai, #phamviapdung').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + 'ThongTin?madonvi=' + $('#madonvi')
                    .val() +
                    '&nam=' + $('#nam').val() + '&phanloai=' + $('#phanloai').val() + '&phamviapdung=' + $(
                        '#phamviapdung').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ tham gia phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">

            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
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

            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <label style="font-weight: bold">Phạm vi phát động</label>
                    {!! Form::select('phamviapdung', setArrayAll($a_phamvi, 'Tất cả', 'ALL'), $inputs['phamviapdung'], [
                        'id' => 'phamviapdung',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-md-4">
                    <label style="font-weight: bold">Hình thức tổ chức</label>
                    {!! Form::select('phanloai', setArrayAll($a_phanloai, 'Tất cả', 'ALL'), $inputs['phanloai'], [
                        'id' => 'phanloai',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Cụm, khối thi đua</label>
                    <select class="form-control select2basic" id="macumkhoi">
                        @foreach ($m_cumkhoi as $cumkhoi)
                            <option {{ $cumkhoi->macumkhoi == $inputs['macumkhoi'] ? 'selected' : '' }}
                                value="{{ $cumkhoi->macumkhoi }}">{{ $cumkhoi->tencumkhoi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" width="2%">STT</th>
                                <th rowspan="2">Đơn vị phát động</th>
                                <th rowspan="2">Nội dung hồ sơ</th>
                                <th colspan="3">Thông tin phong trào</th>
                                <th rowspan="2">Hồ sơ của đơn vị</th>
                                <th rowspan="2" width="15%">Thao tác</th>
                            </tr>
                            <tr class="text-center">
                                <th width="10%">Thời gian</th>
                                <th width="8%">Trạng thái</th>
                                <th width="8%">Số hồ sơ<br>đã nhận</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td>{{ $tt->tendonvi }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">Từ {{ getDayVn($tt->tungay) }}</br> đến
                                    {{ getDayVn($tt->denngay) }}</td>
                                <td class="text-center">{{ $a_trangthaihoso[$tt->nhanhoso] ?? '' }}</td>
                                <td class="text-center">{{ chkDbl($tt->sohoso) }}</td>
                                @include('includes.td.td_trangthai_hoso')

                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahoso }}','{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthai }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahoso }}', '/DungChung/DinhKemHoSoThamGia')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>

                                    @if ($tt->nhanhoso == 'DANGNHAN')
                                        @if (chkPhanQuyen('dshosothiduacumkhoi', 'thaydoi'))
                                            @if (in_array($tt->trangthai, ['CC', 'BTL']))
                                                <a title="Sửa hồ sơ đăng ký phong trào"
                                                    href="{{ url($inputs['url_hs'] . 'Sua?mahoso=' . $tt->mahoso) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i></a>
                                            @elseif (in_array($tt->trangthai, ['CXD']))
                                                <a title="Tạo hồ sơ đăng ký phong trào"
                                                    href="{{ url($inputs['url_hs'] . 'Them?maphongtraotd=' . $tt->maphongtraotd . '&madonvi=' . $inputs['madonvi'] . '&macumkhoi=' . $inputs['macumkhoi']) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i></a>
                                            @endif
                                        @endif

                                        @if ($tt->hosodonvi > 0 && in_array($tt->trangthai, ['CC', 'BTL']) && chkPhanQuyen('dshosothiduacumkhoi', 'hoanthanh'))
                                            <button title="Trình hồ sơ đăng ký" type="button"
                                                onclick="confirmChuyen('{{ $tt->mahoso }}','{{ $inputs['url_hs'] . 'ChuyenHoSo' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#chuyen-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-share-square text-primary"></i></button>
                                        @endif

                                        @if (in_array($tt->trangthai, ['CC', 'BTL']) && chkPhanQuyen('dshosothiduacumkhoi', 'thaydoi'))
                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash text-danger"></i></button>
                                        @endif
                                    @endif


                                    @if ($tt->trangthai == 'BTL')
                                        <button title="Lý do hồ sơ bị trả lại" type="button"
                                            onclick="viewLyDo('{{ $tt->mahoso }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_hs'] . 'LayLyDo' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-archive text-dark"></i></button>
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

    <!--Modal Nhận hồ sơ-->
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => $inputs['url_hs'] . 'Them', 'id' => 'frm_hoso']) !!}
        <input type="hidden" name="madonvi" />
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ đăng ký?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên đơn vị quyết định khen thưởng</label>
                            {!! Form::text('donvikhenthuong', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Cấp độ khen thưởng</label>
                            {!! Form::select('capkhenthuong', getPhamViApDung(), 'T', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Ngày ra quyết định</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Chức vụ người ký</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Họ tên người ký</label>
                            {!! Form::text('hotennguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickKhenThuong()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- In dữ liệu --}}
    <div id="indulieu-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => '', 'id' => 'frm_InDuLieu']) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <input type="hidden" name="phanloaihoso" value="{{ $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong' }}" />
        <input type="hidden" name="mahosotdkt" />
        <input type="hidden" name="maphongtraotd" />
        <input type="hidden" name="mahosothamgiapt" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin in dữ liệu</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInPT($(this), '/CumKhoiThiDua/PhongTraoThiDua/')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Thông tin phong trào thi đua
                            </a>
                        </div>
                    </div>

                    <div id="div_inHoSo">
                        <div class="row">
                            <div class="col-lg-12">
                                <a onclick="setInHS($(this), '/CumKhoiThiDua/ThamGiaThiDua/')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>Thông tin hồ sơ tham gia thi đua
                                </a>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>


    <script>
        function setInDuLieu(mahosothamgiapt, mahosotdkt, maphongtraotd, trangthai, inphoi = false) {
            $('#div_inDuLieu').hide();
            $('#div_inHoSo').hide();
            $('#div_inHoSoDN').hide();
            $('#frm_InDuLieu').find("[name='mahosotdkt']").val(mahosotdkt);
            $('#frm_InDuLieu').find("[name='maphongtraotd']").val(maphongtraotd);
            $('#frm_InDuLieu').find("[name='mahosothamgiapt']").val(mahosothamgiapt);
            if (mahosothamgiapt != '-1')
                $('#div_inHoSo').show();

            if (trangthai == 'DKT') {
                $('#div_inDuLieu').show();
                if (inphoi)
                    $('#div_inPhoi').show();
            }

            if (['DD', 'DTN', 'CXKT', 'DKT'].includes(trangthai)) {
                $('#div_inHoSoDN').show();
            }
        }

        function setInQD(e, url) {
            e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']")
                .val());
        }

        function setInHS(e, url) {
            e.prop('href', url + 'Xem?mahosothamgiapt=' + $('#frm_InDuLieu').find("[name='mahosothamgiapt']").val());
        }        
    </script>


    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_approve_hs')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop
