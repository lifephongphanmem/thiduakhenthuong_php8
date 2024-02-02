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
            $('#frm_khenthuongnhanuoc').find("[name='phanloai[]']").val(phanloai.split(';')).trigger('change');
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-1">
            <div class="card-title">
                <h3 class="card-label text-uppercase">DANH SÁCH BÁO CÁO TỔNG HỢP theo địa bàn hành chính</h3>
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
                                cáo khen thưởng theo phong trào thi đua</button>
                        </li>
                        {{-- báo cáo chi tiết --}}
                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-hosotdkt" data-toggle="modal">Báo
                                cáo số lượng hồ sơ thi đua, khen thưởng</button>
                        </li>

                        {{-- <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-danhhieutd" data-toggle="modal">Danh
                                hiệu thi đua trên địa
                                bàn</button>
                        </li> --}}

                        <li>
                            <button class="btn btn-clean text-dark" title="Thống kê tất cả các loại hình khen thưởng"
                                onclick="setBaoCaoKT('frm_htkt','/BaoCao/TongHop/KhenThuong_m1', 'ALL')"
                                data-target="#modal-khenthuong" data-toggle="modal">Báo
                                cáo hình thức khen thưởng trên địa bàn (Mẫu 01)</button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark"
                                title="Thống kê các loại hình khen thưởng: Công trạng; Chuyên đề; Đối ngoại; Đột xuất"
                                onclick="setBaoCaoKT('frm_htkt','/BaoCao/TongHop/KhenThuong_m2')"
                                data-target="#modal-khenthuong" data-toggle="modal">Báo
                                cáo hình thức khen thưởng trên địa bàn (Mẫu 02)</button>
                        </li>
                        <li>
                            <button class="btn btn-clean text-dark"
                                title="Thống kê các loại hình khen thưởng: Công trạng; Chuyên đề; Đối ngoại; Đột xuất"
                                onclick="setBaoCaoKT('frm_htkt','/BaoCao/TongHop/KhenThuong_m3')"
                                data-target="#modal-khenthuong" data-toggle="modal">Báo
                                cáo hình thức khen thưởng trên địa bàn (Mẫu 03)</button>
                        </li>
                        <li>
                            <button class="btn btn-clean text-dark"
                                onclick="setBaoCaoKT('frm_khenthuongnhanuoc','/BaoCao/TongHop/KhenCao_m1')"
                                data-target="#modal-khenthuongnhanuoc" data-toggle="modal">Báo
                                cáo hình thức khen thưởng (Khen thưởng cấp nhà nước - Mẫu 01)</button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark"
                                onclick="setBaoCaoKT('frm_khenthuongnhanuoc','/BaoCao/TongHop/KhenCao_m2')"
                                data-target="#modal-khenthuongnhanuoc" data-toggle="modal">Báo
                                cáo hình thức khen thưởng (Khen thưởng cấp nhà nước - Mẫu 02)</button>
                        </li>
                        {{-- <li>
                            <button type="button" onclick="setBaoCaoKT('frm_quykhenthuong','/BaoCao/TongHop/QuyKhenThuong')"
                                class="btn btn-clean text-dark" data-target="#modal-quykhenthuong" data-toggle="modal">
                                Tổng hợp trích lập và sử dụng quỹ thi đua, khen thưởng</button>
                        </li> --}}
                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu03','/BaoCao/TongHop/Mau0701')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu03" data-toggle="modal">Số
                                phong trào thi đua (mẫu 0701.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu03','/BaoCao/TongHop/Mau0702')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu03" data-toggle="modal">Số
                                lượng khen thưởng cấp nhà nước (mẫu 0702.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu03','/BaoCao/TongHop/Mau0703')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu03" data-toggle="modal">Số
                                lượng khen thưởng cấp ban ngành đoàn thể trung ương (mẫu 0703.N/BNV-TĐKT)</button>
                        </li>

                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu02','/BaoCao/TongHop/Mau0601')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu02" data-toggle="modal">Số
                                phong trào thi đua (mẫu 0601.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu02','/BaoCao/TongHop/Mau0602')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu02" data-toggle="modal">Số
                                lượng khen thưởng cấp nhà nước (mẫu 06702.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu02','/BaoCao/TongHop/Mau0603')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu02" data-toggle="modal">Số
                                lượng khen thưởng cấp ban ngành đoàn thể trung ương (mẫu 0603.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu02','/BaoCao/TongHop/Mau0604')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu02" data-toggle="modal">Số
                                lượng tổ chức làm công tác thi đua, khen thưởng (mẫu 0604.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setBaoCaoKT('frm_thongtu02','/BaoCao/TongHop/Mau0605')"
                                class="btn btn-clean text-dark" data-target="#modal-thongtu02" data-toggle="modal">Số
                                lượng công chức làm công tác thi đua, khen thưởng (mẫu 0605.N/BNV-TĐKT)</button>
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
            'url' => 'BaoCao/TongHop/PhongTrao',
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
            'url' => 'BaoCao/TongHop/HoSo',
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

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phạm vị thống kê</label>
                        {!! Form::select('phamvithongke', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
                    </div>
                </div>

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

    {{-- Danh hiệu thi đua trên địa bàn --}}
    <div id="modal-danhhieutd" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => 'BaoCao/TongHop/DanhHieu',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_dhtd',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất danh hiệu thi đua</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, [
                            'madiaban' => 'madt',
                            'class' => 'form-control select2_modal',
                            'disabled',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                            'class' => 'form-control select2_modal',
                            'onchange' => 'setNgayThang($(this),"frm_dhtd")',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phạm vị thống kê</label>
                        {!! Form::select('phamvithongke', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
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

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phạm vị thống kê</label>
                        {!! Form::select('phamvithongke', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
                    </div>
                </div>

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

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Đơn vị phê duyệt khen thưởng</label>
                        {!! Form::select('madonvi_kt', setArrayAll($a_donvi_ql), 'ALL', [
                            'class' => 'form-control select2_modal',
                        ]) !!}
                    </div>
                </div>

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

    {{-- Hình thức khen thưởng cấp nhà nước --}}
    <div id="modal-khenthuongnhanuoc" tabindex="-1" role="dialog" aria-hidden="true"
        class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_khenthuongnhanuoc',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="modal-dialog modal-content modal-lg">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất hình thức khen thưởng cấp nhà
                    nước</h4>
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
                            'class' => 'form-control select2_modal',
                            'disabled',
                        ]) !!}
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                            'class' => 'form-control select2_modal',
                            'onchange' => 'setNgayThang($(this),"frm_khenthuongnhanuoc")',
                        ]) !!}
                    </div>

                    <div class="col-lg-6">
                        <label>Phạm vị thống kê</label>
                        {!! Form::select('phamvithongke', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phân loại hồ sơ</label>
                        {!! Form::select('phanloai[]', getPhanLoaiHoSo('ALL'), null, [
                            'class' => 'form-control select2_modal',
                            'multiple' => 'multiple',
                            'required' => 'required',
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

    {{-- Mẫu thông tu 03 / 2018 --}}
    <div id="modal-thongtu03" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_thongtu03',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất báo cáo thông tư 03/2018/TT-BNV
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
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
                            'onchange' => 'setNgayThang($(this),"frm_thongtu03")',
                        ]) !!}
                    </div>
                </div>

                {{-- <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Phạm vị thống kê</label>
                            {!! Form::select('phamvithongke', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
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

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Mẫu thông tu 02 / 2023 --}}
    <div id="modal-thongtu02" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_thongtu02',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất báo cáo thông tư 02/2023/TT-BNV
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
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
                            'onchange' => 'setNgayThang($(this),"frm_thongtu02")',
                        ]) !!}
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phạm vị thống kê</label>
                        {!! Form::select('phamvithongke', setArrayAll($a_phamvithongke), null, ['class' => 'form-control']) !!}
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

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Quy khen thưởng --}}
    <div id="modal-quykhenthuong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open([
            'url' => '',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'frm_quykhenthuong',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất hình thức khen thưởng</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Năm báo cáo</label>
                        {!! Form::select('nam', getNam(), date('Y'), [
                            'class' => 'form-control select2_modal',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), 'CANAM', [
                            'class' => 'form-control select2_modal',
                            'onchange' => 'setNgayThang($(this),"frm_quykhenthuong")',
                        ]) !!}
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div> --}}

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
