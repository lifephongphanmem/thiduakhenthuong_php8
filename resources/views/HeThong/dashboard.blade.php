@extends('HeThong.main')

@section('custom-style')
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
        .marquee-container {
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .marquee {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
    </style>
@stop
@section('custom-script-footer')
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
    @if ($thongtin_email)
        <div class="row">
            <div class="col-lg-6 col-xl-12 mb-5">
                <!--begin::Iconbox-->
                <div class="card card-custom mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <div class="mr-6">
                                <span class="svg-icon svg-icon-4x">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path
                                                d="M3,13.5 L19,12 L3,10.5 L3,3.7732928 C3,3.70255344 3.01501031,3.63261921 3.04403925,3.56811047 C3.15735832,3.3162903 3.45336217,3.20401298 3.70518234,3.31733205 L21.9867539,11.5440392 C22.098181,11.5941815 22.1873901,11.6833905 22.2375323,11.7948177 C22.3508514,12.0466378 22.2385741,12.3426417 21.9867539,12.4559608 L3.70518234,20.6826679 C3.64067359,20.7116969 3.57073936,20.7267072 3.5,20.7267072 C3.22385763,20.7267072 3,20.5028496 3,20.2267072 L3,13.5 Z"
                                                fill="#000000"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>

                            <div class="d-flex flex-column">
                                <span class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">LỜI CẢM
                                    ƠN!</span>
                                <div class="text-dark-75">
                                    <p>
                                        <span class="label label-danger label-dot mr-2"></span>
                                        Công ty TNHH phát triển phần mềm cuộc sống (LifeSoft) chân thành cảm ơn quý khách
                                        hàng
                                        đã tin tưởng sử dụng phần mềm của công ty. Thay mặt toàn bộ cán bộ nhân viên trong
                                        công
                                        ty gửi đến khách hàng lời chúc sức khỏe- thành công
                                    </p>
                                    <p>
                                        <span class="label label-danger label-dot mr-2"></span>
                                        Nhằm chăm sóc, hỗ trợ khách hàng nhanh chóng và tiện dụng nhất công ty xin cung cấp
                                        thông tin các cán bộ hỗ trợ khách hàng trong quá trình sử dụng. Mọi vấn đề khúc mắc
                                        khách hàng có thể liên hệ trực tiếp cho cán bộ để được hỗ trợ!
                                    </p>
                                    <p>
                                        <span class="label label-danger label-dot mr-2"></span>
                                        Phụ trách khối kỹ thuật: <span style="color:blue">Phó giám đốc:</span> Trần Ngọc
                                        Hiếu
                                        <span style="color:blue">- Số điện thoại:</span> 096 8206844
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!--end::Iconbox-->
            </div>
            @foreach ($a_vp as $vp)
                <?php $vanphong = $model_vp->where('vanphong', $vp); ?>
                <div class="col-lg-6 col-xl-12 mb-5">
                    <div class="card card-custom mb-8 mb-lg-0">
                        <div class="card-header">
                            <div class="card-title p-5 ml-20">
                                <h3 class="card-label text-uppercase font-weight-bold font-size-h4">
                                    {{ $vp }}
                                </h3>
                            </div>
                        </div>

                        <!--begin::Iconbox-->
                        <div class="card-body">
                            <div class="text-dark-75 p-5 ml-19">
                                @foreach ($vanphong as $ct)
                                    <p class="col-xl-6 float-left">
                                        {{-- <span class="label label-danger label-dot mr-2"></span> --}}
                                        <span><i class='fas fa-user-tie mr-2'></i></span>
                                        <span style="color:blue">{{ $ct->hoten }}</span>- Số điện thoại:
                                        <span style="color:blue">{{ $ct->sdt }}</span>
                                    </p>
                                @endforeach

                            </div>
                        </div>
                        <!--end::Iconbox-->
                    </div>
                </div>
            @endforeach
        @else
            <div class="card card-custom" style="min-height:300px">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label text-uppercase text-danger">Cập nhật Email</h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <!--end::Button-->
                    </div>
                </div>

                <form action="{{ '/TaiKhoan/CapNhatEmail' }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="marquee-container text-center">
                            <div class=" text-danger">
                                Việc cập nhật địa chỉ Email sẽ hỗ trợ cho việc lấy lại mật khẩu khi quên mật khẩu. Vui lòng cập nhật địa chỉ Email !!!
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                                <label>Email</label>
                                {!! Form::text('email', null, [
                                    'id' => 'email',
                                    'class' => 'form-control',
                                    'placeholder' => 'Nhập địa chỉ Email',
                                ]) !!}
                                <span id="emailError" class="error"></span>
                            </div>
                            <div class="col-lg-4"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn
                                    thành</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
    @endif
@stop
