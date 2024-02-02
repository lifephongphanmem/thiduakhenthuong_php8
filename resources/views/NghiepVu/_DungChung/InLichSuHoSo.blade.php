@extends('HeThong.main_baocao')

@section('content')
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px;text-transform: uppercase">
                DANH SÁCH LỊCH SỬ HỒ SƠ
            </td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <thead>
            <tr class="text-center">
                <th style="width: 10%">STT</th>
                <th>Đơn vị thực hiện</th>
                <th>Nội dung thực hiện</th>
                <th>Thời gian thực hiện</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <?php $i = 1; ?>

        @foreach ($model as $ct)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td>{{ $a_donvi[$ct->madonvi] ?? '' }}</td>
                <td>{{ $ct->thongtin }}</td>
                <td class="text-center">{{ $ct->thoigian }}</td>
                <td></td>
            </tr>
        @endforeach

    </table>


@stop
