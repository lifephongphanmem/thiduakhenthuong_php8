@extends('HeThong.main')

@section('custom-style')

@stop


@section('custom-script')

@stop

@section('content')
<!--begin::Card-->
<div class="card card-custom" style="min-height: 600px">
    <div class="card-header flex-wrap border-1 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label text-uppercase">Thông tin cấu hình hệ thống</h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="{{url('/HeThongChung/ThayDoi')}}" class="btn btn-primary btn-sm">
                <i class="fa fa-edit"></i> Thay đổi </a>
                @if(session('admin')->level=='SSA')
                    <a href="{{url('/HeThongChung/ThietLap')}}" class="btn btn-default btn-sm">
                        <i class="icon-settings"></i> Thiết lập</a>
                @endif
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">       

        <div class="row">
            <div class="col-md-12">
                <table id="user" class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td style="width:15%">
                            <b>Bản quyền thuộc về</b>
                        </td>
                        <td style="width:35%">
                            <span class="text-muted"><b style="color: blue">CÔNG TY TRÁCH NHIỆM HỮU HẠN PHÁT TRIỂN PHẦN MỀM CUỘC SỐNG</b>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <b>Số đăng ký kinh doanh</b>
                        </td>
                        <td style="width:35%">
                            <span class="text-muted" style="color: #0000ff">Số: 0106070279 - Cấp ngày 27/12/2012
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <b>Số đăng ký bản quyền</b>
                        </td>
                        <td style="width:35%">
                            <span class="text-muted" style="color: #0000ff">Số: 164/2016/QTG - Cấp ngày 22/04/2016
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <b>Cấp cho đơn vị</b>
                        </td>
                        <td style="width:35%">
                            <span class="text-muted" style="color: #0000ff">{{isset($model) ? $model->tendonvi : ''}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <b>Địa chỉ</b>
                        </td>
                        <td style="width:35%">
                            <span class="text-muted" style="color: #0000ff">{{isset($model) ? $model->diachi : ''}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <b>Thông tin liên hệ</b>
                        </td>
                        <td style="width:35%">
                            <span class="text-muted" style="color: #0000ff">{{isset($model) ? $model->tel : ''}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%">
                            <b>Thông tin hợp đồng</b>
                        </td>
                        <td style="width:35%">
                            <span class="text-muted"><p style="color: #0000ff">{{isset($model) ? $model->thongtinhd : ''}}</p>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--end::Card-->

@stop