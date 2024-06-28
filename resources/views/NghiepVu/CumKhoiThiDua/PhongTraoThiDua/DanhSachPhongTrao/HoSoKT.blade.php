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
            $('#madonvi,#nam,#phamviapdung,#maphongtraotd').change(function() {
                window.location.href = "{{ $inputs['url_qd'] }}" + 'ThongTin?madonvi=' + $('#madonvi')
                    .val() +
                    '&nam=' + $('#nam').val()+'&maphongtraotd='+$('#maphongtraotd').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ khen thưởng</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="form-group row"> --}}
                {{-- <div class="col-md-4">
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
                <div class="col-md-2">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div> --}}

            {{-- <div class="form-group row">
                <div class="col-md-12">
                    <label style="font-weight: bold">Tên phong trào</label>
                    {!! Form::select('maphongtraotd', $a_phongtraotd, $inputs['maphongtraotd'], ['id' => 'maphongtraotd', 'class' => 'form-control select2basic']) !!}
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Đơn vị đề nghị</th>
                                <th>Nội dung hồ sơ</th>
                                <th>Trạng thái<br>hồ sơ</th>
                                <th width="8%">Quyết định<br>khen thưởng</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>                                
                                <td>{{ $tt->noidung }}</td>                               
                                @include('includes.td.td_trangthai_hoso')
                                <td class="text-center">{{ $tt->soqd }}<br>{{ getDayVn($tt->ngayqd) }}</td>
                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosothamgiapt }}','{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthai_kt }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        {{-- onclick="get_attack('{{ $tt->mahosotdkt }}', '/XetDuyetHoSoThiDua/TaiLieuDinhKem')" --}}
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoCumKhoi')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    {{-- @include('includes.modal.modal_unapprove_hs')
    @include('NghiepVu._DungChung.modal_QD_PheDuyet') --}}
    @include('NghiepVu.ThiDuaKhenThuong._DungChung.InDuLieu_CumKhoi')
    @include('includes.modal.modal_attackfile')
@stop
