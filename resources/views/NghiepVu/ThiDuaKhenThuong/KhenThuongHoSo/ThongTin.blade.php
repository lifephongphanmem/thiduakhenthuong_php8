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
                window.location.href = '/KhenThuongHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&phamviapdung=' + $('#phamviapdung').val();
            });
            $('#nam').change(function() {
                window.location.href = '/KhenThuongHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&phamviapdung=' + $('#phamviapdung').val();
            });
            $('#phamviapdung').change(function() {
                window.location.href = '/KhenThuongHoSoThiDua/ThongTin?madonvi=' + $('#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&phamviapdung=' + $('#phamviapdung').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách Hồ sơ đề nghị khen thưởng chờ xét khen thưởng trên địa bàn</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <label style="font-weight: bold">Phạm vi phát động</label>
                    {!! Form::select('phamviapdung', setArrayAll($a_phamvi, 'Tất cả', 'ALL'), $inputs['phamviapdung'], [
                        'id' => 'phamviapdung',
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

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" width="2%">STT</th>
                                <th rowspan="2" width="20%">Đơn vị phát động </br>Phạm vị phát động</th>
                                <th rowspan="2">Tên phong trào thi đua</th>
                                <th colspan="{{ count($a_trangthai_hoso) == 0 ? 1 : count($a_trangthai_hoso) }}">Số lượng hồ
                                    sơ</th>
                                <th rowspan="2" style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                            <tr class="text-center">
                                @if (count($a_trangthai_hoso) == 0)
                                    <th width="5%"></th>
                                @else
                                    @foreach ($a_trangthai_hoso as $trangthai_hoso)
                                        <th class="text-center" width="5%">{!! $a_trangthai[$trangthai_hoso] ?? $trangthai_hoso !!}</th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td class="text-center">
                                    {{ $tt->tendonvi }}<br>{{ $a_phamvi[$tt->phamviapdung] ?? '' }}<br>({{ $a_trangthaihoso[$tt->nhanhoso] }})
                                </td>
                                <td>{{ $tt->noidung }}</td>
                                @if (count($a_trangthai_hoso) == 0)
                                    <td></td>
                                @else
                                    @foreach ($a_trangthai_hoso as $trangthai_hoso)
                                        <td class="text-center">{{ dinhdangso($tt->$trangthai_hoso) }}</td>
                                    @endforeach
                                @endif

                                <td style="text-align: center">
                                    <a title="Xem chi tiết"
                                        href="{{ url($inputs['url_qd'] . 'DanhSach?madonvi=' . $inputs['madonvi'] . '&maphongtraotd=' . $tt->maphongtraotd) }}"
                                        class="btn btn-sm btn-clean btn-icon">
                                        <i class="icon-lg la flaticon-folder text-dark icon-2x"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

@stop
