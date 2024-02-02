@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script>
        jQuery(document).ready(function() {

            $('#madonvi').change(function() {
                window.location.href = "/ThongTinDonVi?madonvi=" + $('#madonvi').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::model($model, [
        'method' => 'POST',
        '/ThongTinDonVi',
        'class' => 'horizontal-form',
        'id' => 'update_dmdonvi',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    {{-- {{ Form::hidden('madonvi', null) }} --}}
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin chi tiết đơn vị</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" name="madonvi" id="madonvi">
                        @foreach ($a_diaban as $key => $val)
                            <optgroup label="{{ $val }}">
                                <?php $donvi = $m_donvi->where('madiaban', $key); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $model->madonvi ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Mã quan hệ ngân sách</label>
                    {!! Form::text('maqhns', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Tên đơn vị<span class="require">*</span></label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'required', 'autofocus']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Tên đơn vị hiển thị báo cáo<span class="require">*</span></label>
                    {!! Form::text('tendvhienthi', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Tên đơn vị cấp trên</label>
                    {!! Form::text('tendvcqhienthi', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Địa chỉ trụ sở</label>
                    {!! Form::text('diachi', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Địa danh</label>
                    {!! Form::text('diadanh', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Chức vụ người ký</label>
                    {!! Form::text('chucvuky', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Họ tên người ký</label>
                    {!! Form::text('nguoiky', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Chức vụ người ký thay</label>
                    {!! Form::text('chucvukythay', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Địa bàn quản lý</label>
                    {!! Form::select('madiaban', getDiaBan_All(), null, ['class' => 'form-control select2basic']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Ngành, lĩnh vực</label>
                    {!! Form::select('linhvuchoatdong', setArrayAll(getNganhLinhVuc(), 'Không chọn', ''), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-lg-2">
                    <label>Số chữ trên dòng</label>
                    {!! Form::number('sochu', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Thông tin liên hệ</label>
                    {!! Form::text('ttlienhe', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <h4>Thiết lập bằng khen</h4>
            <div class="form-group row">
                <div class="col-lg-2">
                    <label>Chiều dài(mm)</label>
                    {!! Form::number('dodai_bangkhen', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-2">
                    <label>Chiều rộng(mm)</label>
                    {!! Form::number('chieurong_bangkhen', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-8">
                    <label>Đường dẫn</label>
                    {!! Form::file('phoi_bangkhen', null, ['class' => 'form-control']) !!}
                    @if ($model->phoi_bangkhen != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/uploads/' . $model->phoi_bangkhen) }}"
                                target="_blank">{{ $model->phoi_bangkhen }}</a>
                        </span>
                    @endif
                </div>
            </div>



            <h4>Thiết lập giấy khen</h4>
            <div class="form-group row">
                <div class="col-lg-2">
                    <label>Chiều dài(mm)</label>
                    {!! Form::number('dodai_giaykhen', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-2">
                    <label>Chiều rộng(mm)</label>
                    {!! Form::number('chieurong_giaykhen', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-8">
                    <label>Đường dẫn</label>
                    {!! Form::file('phoi_giaykhen', null, ['class' => 'form-control']) !!}
                    @if ($model->phoi_giaykhen != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/uploads/' . $model->phoi_giaykhen) }}"
                                target="_blank">{{ $model->phoi_giaykhen }}</a>
                        </span>
                    @endif
                </div>
            </div>


        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->
@stop
