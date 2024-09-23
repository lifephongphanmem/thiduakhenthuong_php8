@extends('HeThong.main_baocao')

@section('content')
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        
        <tr>
            <td style="text-align: left;width: 60%">
                <b>Đơn vị: {{ $m_donvi->tendonvi ?? '' }}</b>
            </td>
            <td style="text-align: center; font-style: italic">

            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                <b>Mã đơn vị SDNS: {{ $m_donvi->maqhns ?? '' }}</b>
            </td>

            <td style="text-align: center; font-style: italic">

            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px;text-transform: uppercase">
                DANH SÁCH ĐƠN VỊ TRÊN ĐỊA BÀN
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Địa bàn: 
            </td>
        </tr>
    </table>

    <table id="data_render" cellspacing="0" cellpadding="0" border="1"
        style="margin: 20px auto; border-collapse: collapse;">
        <thead>
            <tr class="text-center">
                <th style="width: 5%" >STT</th>
                <th>Tên tài khoản</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Trạng thái</th>               
            </tr>
           
        </thead>
        <?php $i = 1; ?>
        @foreach ($model_donvi as $donvi)
            <tr>
                <td class="text-bold text-center">{{ $i++ }}</td>
                <td colspan="3" class="text-bold">{{ $donvi->tendonvi }}</td>                
            </tr>
            <?php 
            $dstaikhoan = $model->where('madonvi',$donvi->madonvi); 
           
            ?>
            @foreach ($dstaikhoan as $taikhoan)
            <tr>
                <td class="text-bold text-center">-</td>
                <td class="text-bold">{{ $taikhoan->tentaikhoan }}</td>
                <td>{{ $taikhoan->tendangnhap }}</td>
                <td>{{ $taikhoan->email }}</td>
                <td>{{ $taikhoan->sodienthoai }}</td>
                <td>{{ $taikhoan->trangthai }}</td>
            </tr>

        @endforeach
        @endforeach
    </table>

    {{-- <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%">…………, Ngày…...tháng……năm……</td>
        </tr>
        <tr>
            <td>{{ $m_donvi->cdketoan }}</td>
            <td>{{ $m_donvi->cdlanhdao }}</td>
        </tr>

        <tr>
            <td style="height: 100px">

            </td>
        <tr>
            <td>{{ $m_donvi->ketoan }}</td>
            <td>{{ $m_donvi->lanhdao }}</td>
        </tr>
    </table> --}}
@stop
