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
            $('#phanloai, #phanloai_chitiet').change(function() {
                window.location.href = '/ThongBao/ThongTin?phanloai=' + $('#phanloai').val() + '&phanloai_ct='+$('#phanloai_chitiet').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">thông tin thông báo</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                {{-- @if (chkPhanQuyen('quykhenthuong', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif --}}
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">

                <div class="col-md-6">
                    <label style="font-weight: bold">Phân loại</label>
                    {{-- {!! Form::select('phanloai',$phanloai, $inputs['phanloai'], ['id' => 'phanloai', 'class' => 'form-control select2basic']) !!}                     --}}
                    <select name="phanloai" id="phanloai" class="form-control">
                        @foreach ($phanloai as $key => $ct)
                            <option value="{{ $key }}" {{$inputs['phanloai'] == $key?'selected':''}}>{{ $ct }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6" id='phanloai_ct'>
                    <label style="font-weight: bold">Phân loại</label>
                    {{-- {!! Form::select('phanloai',$phanloai, $inputs['phanloai'], ['id' => 'phanloai', 'class' => 'form-control select2basic']) !!}                     --}}
                    <select name="phanloai_ct" id="phanloai_chitiet" class="form-control">
                        <option value="ALL">--- Chọn phân loại ---</option>
                        @foreach ($chucnang as $key => $ct)
                            <option value="{{ $key }}" {{$inputs['phanloai_ct'] == $key?'selected':''}}>{{ $ct }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Phân loại</th>
                                <th>Đơn vị</th>
                                <th>Nội dung</th>
                                {{-- <th>Phạm vi</th> --}}
                                <th>Thông Tin</th>
                                {{-- <th width="20%">Thao tác</th> --}}
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center" class="{{$tt->class}}" >{{ $i++ }}</td>
                                <td style="text-align: center" class="{{$tt->class}}">
                                    {{ ChucNang()[$tt->chucnang] }}
                                </td>
                                <td class="active {{$tt->class}}">{{ $a_donvi[$tt->madonvi_thongbao] ?? '' }}</td>
                                <td class="{{$tt->class}}">{{ $tt->noidung }}</td>
                                {{-- <td class="text-center ">{{ getPhamViApDung()[$tt->phamvi] ?? $dscumkhoi[$tt->phamvi] }}</td> --}}
                                <td class="text-center {{$tt->class}}">
                                    <a title="Xem thông tin " style="cursor: pointer"
                                        onclick="doctin('{{ $tt->mathongbao }}')">
                                        <i class="icon-lg la fa-eye"></i></a>
                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    <script>
        function doctin(mathongbao) {
            // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/ThongBao/DocTin",
                type: 'GET',
                data: {
                    // _token: CSRF_TOKEN,
                    mathongbao: mathongbao,
                },
                dataType: 'JSON',
                success: function(data) {
                    // console.log(1234);
                    // location.reload();
                    window.location.href=data.url;
                }
            });
        }

    </script>
@stop
