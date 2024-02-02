@extends('HeThong.main_baocao')

@section('content')
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td style="text-align: left;width: 60%">
                <b>Đơn vị: {{ $m_donvi->tendonvi }}</b>
            </td>
            <td style="text-align: center; font-style: italic">

            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                <b>Mã đơn vị SDNS: {{ $m_donvi->maqhns }}</b>
            </td>

            <td style="text-align: center; font-style: italic">

            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px;text-transform: uppercase">
                DANH SÁCH DANH HIỆU THI ĐUA
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{ getDayVn($inputs['ngaytu']) }} đến ngày: {{ getDayVn($inputs['ngayden']) }}
            </td>
        </tr>

    </table>

    <table id="data_render" cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <tr class="text-center">
            <th style="width: 3%" rowspan="2">STT</th>
            <th rowspan="2">Tên đơn vị</th>
            <th colspan="{{ count($a_danhhieutd) }}">Danh hiệu thi đua/Hình thức khen thưởng</th>
        </tr>
        <tr class="text-center">
            @foreach ($a_danhhieutd as $k => $v)
                <th style="width: 10%">{{ $v }}</th>
            @endforeach
        </tr>
        <?php $i = 1; ?>
        @foreach ($a_diaban as $k_diaban => $v_diaban)
            <?php
                $chitiet = $model->where('madiaban', (string) $k_diaban);
                $k = 1;
                ?>
            <tr class="font-weight-boldest">
                <td class="text-bold text-center">{{ IntToRoman($i++) }}</td>
                <td class="text-bold">{{ $v_diaban }}</td>
                @foreach ($a_danhhieutd as $k_lh => $v_lh)
                <td class="text-center">{{ dinhdangso($chitiet->sum($k_lh)) }}</td>
            @endforeach
            </tr>           
            
            @foreach ($chitiet as $ct)
                <tr>
                    <td class="text-right">{{ $k++ }}</td>
                    <td>{{ $ct->tendonvi }}</td>
                    @foreach ($a_danhhieutd as $k_lh => $v_lh)
                        <td class="text-center">{{ dinhdangso($ct->$k_lh) }}</td>
                    @endforeach
                </tr>
            @endforeach
        @endforeach
        <tr class="font-weight-boldest">
            <td class="text-center" colspan="2">Tổng cộng</td>
            @foreach ($a_danhhieutd as $k_lh => $v_lh)
                <td class="text-center">{{dinhdangso($model->sum($k_lh)) }}</td>
            @endforeach
        </tr>

    </table>

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
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
    </table>
@stop
