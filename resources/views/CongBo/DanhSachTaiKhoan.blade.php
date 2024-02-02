@extends('CongBo.maincongbo')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
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
            // $('#madiaban').change(function() {
            //     alert(11);
            //     window.location.href = '/DanhSachTaiKhoan?madiaban=' + $('#madiaban').val();
            // });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom mt-10" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">danh sách tài khoản đăng nhập phần mềm</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->

                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="form-group row">
                <div class="col-lg-6">
                    <label>Địa bàn</label>
                    {!! Form::select('madiaban', $a_diaban, $inputs['madiaban'], [
                        'id' => 'madiaban',
                        'class' => 'form-control select2basic',
                        'onchange' => 'genderChanged(this)',
                    ]) !!}
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-12">
                    <table id="sample_3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center" width="5%">STT</th>
                                <th style="text-align: center">Tên đơn vị</th>
                                <th style="text-align: center">Tên tài khoản</th>
                                <th style="text-align: center">Tên đăng nhập</th>
                                <th style="text-align: center" width="8%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="active">{{ $tt->tendonvi }}</td>
                                    <td class="success">{{ $tt->tentaikhoan }}</td>
                                    <td>{{ $tt->tendangnhap }}</td>
                                    <td>
                                        <a title="Đăng nhập" href="{{ url('/DangNhap?tendangnhap=' . $tt->tendangnhap) }}"
                                            class="btn btn-sm btn-primary">Đăng nhập
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <script>
        function genderChanged(obj) {
            window.location.href = '/DanhSachTaiKhoan?madiaban=' + obj.value;
        }
    </script>
@stop
