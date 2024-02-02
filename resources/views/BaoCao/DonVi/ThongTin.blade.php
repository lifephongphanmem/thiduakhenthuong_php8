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

        function add() {
            $('#madanhhieutd').val('');
            $('#madanhhieutd').attr('readonly', true);
        }

        function edit(madanhhieutd, tendanhhieutd, phanloai) {
            $('#madanhhieutd').attr('readonly', false);
            $('#madanhhieutd').val(madanhhieutd);
            $('#tendanhhieutd').val(tendanhhieutd);
            $('#phanloai').val(phanloai).trigger('change');
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-1">
            <div class="card-title">
                <h3 class="card-label text-uppercase">DANH SÁCH BÁO CÁO TẠI ĐƠN VỊ</h3>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="separator separator-dashed my-5"></div> --}}
            <div class="form-group row">
                <div class="col-lg-12">
                    <ol>
                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-canhan" data-toggle="modal">
                                Báo cáo thành tích theo cá nhân
                            </button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-tapthe" data-toggle="modal"
                                title="">
                                Báo cáo thành tích theo tập thể
                            </button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-phongtrao" data-toggle="modal">Phong
                                trào thi đua trên địa
                                bàn</button>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <div id="modal-canhan" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '/BaoCao/DonVi/CaNhan',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_canhan',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <p style="color: #0000FF">Đối tượng kết xuất là các cá nhân đã được khen thưởng tại đơn vị.</p>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="control-label"> Chọn đối tượng</label>
                            {!! Form::select('tendoituong', array_column($m_canhan->toarray(), 'tendoituong', 'tendoituong'), null, [
                                'id' => 'tendoituong',
                                'class' => 'form-control',
                            ]) !!}

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label>Thời điểm báo cáo</label>
                            {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                                'class' => 'form-control select2_modal',
                                'onchange' => 'setNgayThang($(this),"frm_canhan")',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label class="control-label">Khen thưởng từ ngày</label>
                            {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-6">
                            <label class="control-label">Khen thưởng đến ngày</label>
                            {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div id="modal-tapthe" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '/BaoCao/DonVi/TapThe',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_tapthe',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <p style="color: #0000FF">Đối tượng kết xuất là các tập thể đã được khen thưởng tại đơn vị.</p>
                    <div class="form-group row">
                        <div class="col-12">
                            <label> Chọn tập thể</label>
                            {!! Form::select('tentapthe', array_column($m_tapthe->toarray(), 'tentapthe', 'tentapthe'), null, [
                                'id' => 'tentapthe',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label>Thời điểm báo cáo</label>
                            {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                                'class' => 'form-control select2_modal',
                                'onchange' => 'setNgayThang($(this),"frm_tapthe")',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label class="control-label">Khen thưởng từ ngày</label>
                            {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-6">
                            <label class="control-label">Khen thưởng đến ngày</label>
                            {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div id="modal-phongtrao" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '/BaoCao/DonVi/PhongTrao',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_phongtrao',
            'class' => 'form-horizontal form-validate ',
        ]) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group row">
                        <div class="col-12">
                            <label style="font-weight: bold">Đơn vị</label>
                            <select class="form-control select2_modal" name="madonvi">
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
                        <div class="col-12">
                            <label>Thời điểm báo cáo</label>
                            {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                                'class' => 'form-control select2_modal',
                                'onchange' => 'setNgayThang($(this),"frm_phongtrao")',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label class="control-label">Từ ngày</label>
                            {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-6">
                            <label class="control-label">Đến ngày</label>
                            {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="control-label"> Tên phong trào</label>
                            {!! Form::select(
                                'maphongtraotd',
                                setArrayAll(array_column($m_phongtrao->toarray(), 'noidung', 'maphongtraotd')),
                                null,
                                [
                                    'id' => 'maphongtraotd',
                                    'class' => 'form-control select2_modal',
                                ],
                            ) !!}
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng
                    ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <script>
        function getThoiGianBaoCao($nam) {
            var a_thoigian = Array();
            a_thoigian['06THANGDAUNAM'] = [$nam + '-01-01', $nam + '-06-30'];
            a_thoigian['06THANGCUOINAM'] = [$nam + '-07-01', $nam + '-12-31'];
            a_thoigian['CANAM'] = [$nam + '-01-01', $nam + '-12-31'];
            a_thoigian['05NAM'] = ['2020-01-01', '2025-12-31'];
            a_thoigian['quy1'] = [$nam + '-01-01', $nam + '-03-31'];
            a_thoigian['quy2'] = [$nam + '-04-01', $nam + '-06-30'];
            a_thoigian['quy3'] = [$nam + '-07-01', $nam + '-09-30'];
            a_thoigian['quy4'] = [$nam + '-10-01', $nam + '-12-31'];
            a_thoigian['thang01'] = [$nam + '-01-01', $nam + '-01-31'];
            a_thoigian['thang02'] = [$nam + '-02-01', $nam + '-02-28'];
            a_thoigian['thang03'] = [$nam + '-03-01', $nam + '-03-31'];
            a_thoigian['thang04'] = [$nam + '-04-01', $nam + '-04-03'];
            a_thoigian['thang05'] = [$nam + '-05-01', $nam + '-05-31'];
            a_thoigian['thang06'] = [$nam + '-06-01', $nam + '-06-30'];
            a_thoigian['thang07'] = [$nam + '-07-01', $nam + '-07-31'];
            a_thoigian['thang08'] = [$nam + '-08-01', $nam + '-08-31'];
            a_thoigian['thang09'] = [$nam + '-09-01', $nam + '-09-30'];
            a_thoigian['thang10'] = [$nam + '-10-01', $nam + '-10-31'];
            a_thoigian['thang11'] = [$nam + '-11-01', $nam + '-11-30'];
            a_thoigian['thang12'] = [$nam + '-12-01', $nam + '-12-31'];
            return a_thoigian;
        }

        function setNgayThang(e, formname) {
            let d = new Date();
            let a_thoigian = getThoiGianBaoCao(d.getFullYear());
            let tungay = a_thoigian[e.val()][0];
            let denngay = a_thoigian[e.val()][1];
            var form = document.getElementById(formname);
            form.elements.ngaytu.value= a_thoigian[e.val()][0];
            form.elements.ngayden.value= a_thoigian[e.val()][1];
        }
    </script>
@stop
