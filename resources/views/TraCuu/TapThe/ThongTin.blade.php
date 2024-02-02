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

    </script>
@stop

@section('content')
    <!--begin::Card-->

    {!! Form::open(['method' => 'POST', 'url' => '/TraCuu/TapThe/ThongTin', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin tìm kiếm theo tập thể</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        
        <div class="card-body">
            <div class="form-group row">
                <div class="col-6">
                    <label>Đơn vị</label>
                    {!! Form::select('madonvi', $a_donvi, $inputs['madonvi'], [
                        'id' => 'madonvi',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>                
            </div>

            <div class="form-group row">                
                <div class="col-6">
                    <label>Tên đơn vị</label>
                    {!! Form::text('tentapthe', null, ['id'=>'tentapthe','class' => 'form-control']) !!}
                </div>
            
                <div class="col-lg-3">
                    <label>Khen thưởng - Từ</label>
                    {!! Form::input('date', 'ngaytu', null, ['class' => 'form-control', 'title'=>'Căn cứ ngày quyết định khen thưởng']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Khen thưởng - Đến</label>
                    {!! Form::input('date', 'ngayden', null, ['class' => 'form-control', 'title'=>'Căn cứ ngày quyết định khen thưởng']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <label class="form-control-label">Phân loại tập thể</label>
                    {!! Form::select('maphanloaitapthe', setArrayAll($a_tapthe, 'Tất cả', 'ALL'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>

                <div class="col-md-4">
                    <label class="form-control-label">Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', setArrayAll($a_loaihinhkt, 'Tất cả', 'ALL'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>

                <div class="col-md-4">
                    <label class="form-control-label">Lĩnh vực hoạt động</label>
                    {!! Form::select('linhvuchoatdong', setArrayAll(getLinhVucHoatDong(), 'Tất cả', 'ALL'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Tìm kiếm</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->
   

    {{-- Thong tin đối tượng --}}
    <div id="modal-donvi" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đơn vị</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row" id="dskhenthuongtapthe">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover dulieubang">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%">STT</th>
                                        <th>Đơn vị</th>
                                        <th width="10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($m_tapthe as $key => $tt)
                                        <tr class="odd gradeX">
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $tt->tentapthe }}</td>
                                            <td class="text-center">
                                                <button title="Chọn đối tượng" type="button"
                                                    onclick="confirmTapThe('{{ $tt->tentapthe }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-toggle="modal">
                                                    <i class="icon-lg la fa-check text-success"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmTapThe(tendoituong) {
            $('#tentapthe').val(tendoituong);
            $('#modal-donvi').modal('hide');
        }
    </script>
@stop
