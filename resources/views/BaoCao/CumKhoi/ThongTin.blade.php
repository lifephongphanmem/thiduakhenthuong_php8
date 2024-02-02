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
            $('#madonvi').change(function() {
                window.location.href = "{{ $inputs['url'] }}" + "ThongTin?madonvi=" + $('#madonvi').val();
            });
            //Xét giá trị cho các ô select
            //frm_hoso
            var phanloai = "{{ implode(';', array_keys(getPhanLoaiHoSo())) }}";
            $('#frm_hoso').find("[name='phanloai[]']").val(phanloai.split(';')).trigger('change');
        });

        function setURL(url) {
            $('#thoai_thongtu03').attr('action', url);
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-1">
            <div class="card-title">
                <h3 class="card-label text-uppercase">DANH SÁCH BÁO CÁO TỔNG HỢP THEO CỤM, khối thi đua</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-6">
                    <label>Đơn vị báo cáo</label>
                    {!! Form::select('madonvi', $a_donvi, $inputs['madonvi'], [
                        'id' => 'madonvi',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>
            <div class="separator separator-solid mb-5"></div>
            <div class="form-group row">
                <div class="col-12">
                    <ol>
                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-phongtrao" data-toggle="modal">Báo
                                cáo số lượng phong trào thi đua</button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-hosotdkt" data-toggle="modal">Báo
                                cáo số lượng hồ sơ thi đua, khen thưởng</button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" title="Thống kê tất cả các loại hình khen thưởng"
                                onclick="setBaoCaoKT('frm_htkt','/BaoCao/CumKhoi/HinhThucKhenThuong', 'ALL')"
                                data-target="#modal-khenthuong" data-toggle="modal">Báo cáo hình thức khen thưởng</button>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {{-- Phong trào thi đua --}}
    <div id="modal-phongtrao" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => 'BaoCao/CumKhoi/PhongTraoThiDua',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_phongtrao',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất phong trào thi đua</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Thống kê các hình thức khen thưởng đã được phê duyệt theo phong trào thi đua.</p>
                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, [
                            'madiaban' => 'madt',
                            'class' => 'form-control select2_modal',
                        ]) !!}
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                            'class' => 'form-control select2_modal',
                            'onchange' => 'setNgayThang($(this),"frm_phongtrao")',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Hồ sơ đăng ký thi đua, khen thưởng --}}
    <div id="modal-hosotdkt" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => 'BaoCao/CumKhoi/HoSoKhenThuong',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_hoso',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="modal-dialog modal-content modal-lg">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất hồ sơ đăng ký thi đua, khen
                    thưởng</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Thống kê các hồ sơ khen thưởng đã được phê duyệt hoặc khen thưởng theo địa bàn.
                </p>
                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, [
                            'class' => 'form-control select2_modal',
                            'disabled',
                        ]) !!}
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phạm vị thống kê</label>
                        {!! Form::select('macumkhoi', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phân loại hồ sơ</label>
                        {!! Form::select('phanloai[]', getPhanLoaiHoSo(), null, [
                            'class' => 'form-control select2_modal',
                            'multiple' => 'multiple',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                            'class' => 'form-control select2_modal',
                            'onchange' => 'setNgayThang($(this),"frm_hoso")',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            <label class="checkbox checkbox-outline checkbox-success">
                                <input type="checkbox" name="indonvidulieu">
                                <span></span>Chỉ in các đơn vị có số liệu khen thưởng</label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Hình thức khen thưởng --}}
    <div id="modal-khenthuong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_htkt',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="modal-dialog modal-content modal-lg">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất hình thức khen thưởng trên địa
                    bàn Tỉnh</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <p style="color: #0000FF">Thống kê các danh hiệu thi đua và hình thức khen thưởng đã được phê duyệt theo hồ
                    sơ khen thưởng và hồ sơ đề nghị khen thưởng.</p>
                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, [
                            'madiaban' => 'madt',
                            'class' => 'form-control select2_modal', 'disabled',
                        ]) !!}
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phạm vị thống kê</label>
                        {!! Form::select('phamvithongke', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phân loại hồ sơ</label>
                        {!! Form::select('phanloai[]', getPhanLoaiHoSo('BAOCAOKHENTINH'), null, [
                            'class' => 'form-control select2_modal',
                            'multiple' => 'multiple',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Đơn vị phê duyệt khen thưởng</label>
                        {!! Form::select('madonvi_kt', setArrayAll($a_donvi_ql), 'ALL', [
                            'class' => 'form-control select2_modal',
                        ]) !!}
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                            'class' => 'form-control select2_modal',
                            'onchange' => 'setNgayThang($(this),"frm_htkt")',                            
                        ]) !!}
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Loại hình khen thưởng</label>
                        {!! Form::select('loaihinhkhenthuong', setArrayAll($a_loaihinhkt), null, ['class' => 'form-control select2_modal', 'multiple']) !!}
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            <label class="checkbox checkbox-outline checkbox-success">
                                <input type="checkbox" name="indonvidulieu" checked>
                                <span></span>Chỉ in các đơn vị có số liệu khen thưởng</label>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
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
            form.elements.ngaytu.value = a_thoigian[e.val()][0];
            form.elements.ngayden.value = a_thoigian[e.val()][1];
        }

        function setBaoCaoKT(formname, url, a_loaihinh) {
            var form = document.getElementById(formname);
            form.action = url;
        }
    </script>
@stop
