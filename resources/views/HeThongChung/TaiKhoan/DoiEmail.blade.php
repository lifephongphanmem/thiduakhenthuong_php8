@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            if (emailInput != null) {
                emailInput.addEventListener('input', function() {
                    const emailValue = emailInput.value;
                    if (validateEmail(emailValue)) {
                        emailError.textContent = ''; // Clear any previous error message
                    } else {
                        emailError.textContent = 'Email không hợp lệ.';
                    }
                });
            }

            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::model($model, [
        'method' => 'POST',
        '/TaiKhoan/LuuEmail',
        'class' => 'horizontal-form',
        'id' => 'frm_DoiMatKhau',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    {{-- {{ Form::hidden('id', null) }} --}}
    {{ Form::hidden('madonvi', null) }}
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                {{-- <h3 class="card-label text-uppercase">Thông tin thay đổi mật khẩu truy cập</h3> --}}
                <h3 class="card-label text-uppercase">Thông tin thay đổi</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Đơn vị quản lý</label>
                    {!! Form::select('madonvi', $a_donvi, null, ['class' => 'form-control select2basic', 'disabled']) !!}
                </div>
                <div class="col-lg-4">
                    <label>Email<span class="require">*</span></label>
                    {!! Form::text('email', null, ['id'=>'email','class' => 'form-control', 'required','placeholder'=>'Nhập địa chỉ email']) !!}
                    <span id="emailError" class="error text-danger"></span>
                </div>

            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    {{-- <a href="{{ url('/TaiKhoan/DanhSach?madonvi=' . $model->madonvi) }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a> --}}
                    <button type="submit" class="btn btn-primary" onclick="validateForm()"><i class="fa fa-check"></i>Hoàn
                        thành</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->

    <script type="text/javascript">
        function validateForm() {
            var chk = true;
            var str = '';
                $("#frm_DoiMatKhau").unbind('submit').submit();
            }
    </script>
@stop
