@extends('HeThong.main_baocao')

@section('content')
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td style="text-align: left;width: 60%">
                <b>Đơn vị: {{ $m_donvi['tendonvi'] }}</b>
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
                BÁO CÁO THỐNG KÊ KHEN THƯỞNG phong trào thi đua tại cụm, khối thi đua
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                {{getThoiDiem()[$inputs['thoidiem']] }}
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{ getDayVn($inputs['ngaytu']) }} đến ngày: {{ getDayVn($inputs['ngayden']) }}
            </td>
        </tr>

    </table>

    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <thead>
            <tr class="text-center">
                <th rowspan="2" style="width: 3%">STT</th>
                <th rowspan="2">Tên phong trào thi đua</th>
                <th rowspan="2">Tên cụm, khối thi đua</th>
                <th rowspan="2">Tổng số</th>
                <th colspan="{{ chkSoKhong(count($a_hinhthuckt_xa)) }}">Khen thưởng cấp Xã</th>
                <th colspan="{{ chkSoKhong(count($a_hinhthuckt_huyen)) }}">Khen thưởng cấp Huyện</th>
                <th colspan="{{ chkSoKhong(count($a_hinhthuckt_tinh)) }}">Khen thưởng cấp Tỉnh</th>
            </tr>
            <tr>
                @if (count($a_hinhthuckt_xa) > 0)
                    @foreach ($a_hinhthuckt_xa as $item)
                        <th style="width: 5%" class="text-center">{{ $a_dhkt[$item] ?? $item }}</th>
                    @endforeach
                @else
                    <th style="width: 5%"></th>
                @endif

                @if (count($a_hinhthuckt_huyen) > 0)
                    @foreach ($a_hinhthuckt_huyen as $item)
                        <th style="width: 5%" class="text-center">{{ $a_dhkt[$item] ?? $item }}</th>
                    @endforeach
                @else
                    <th style="width: 5%"></th>
                @endif

                @if (count($a_hinhthuckt_tinh) > 0)
                    @foreach ($a_hinhthuckt_tinh as $item)
                        <th style="width: 5%" class="text-center">{{ $a_dhkt[$item] ?? $item }}</th>
                    @endforeach
                @else
                    <th style="width: 5%"></th>
                @endif
            </tr>
        </thead>
        <?php $i = 1; ?>

        @foreach ($model as $ct)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td>{{ $ct->noidung }}</td>
                <td>{{ $a_cumkhoi[$ct->macumkhoi] ?? '' }}</td>
                <td class="text-center">{{ $ct->tongcong }}</td>
                @if (count($a_hinhthuckt_xa) > 0)
                    @foreach ($a_hinhthuckt_xa as $item)
                        <td class="text-center">{{ $ct->$item }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif

                @if (count($a_hinhthuckt_huyen) > 0)
                    @foreach ($a_hinhthuckt_huyen as $item)
                        <td class="text-center">{{ $ct->$item }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif

                @if (count($a_hinhthuckt_tinh) > 0)
                    @foreach ($a_hinhthuckt_tinh as $item)
                        <td class="text-center">{{ $ct->$item }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif
            </tr>
        @endforeach

    </table>

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%">{{$m_donvi->diadanh}}, Ngày…...tháng …… năm ……</td>
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
