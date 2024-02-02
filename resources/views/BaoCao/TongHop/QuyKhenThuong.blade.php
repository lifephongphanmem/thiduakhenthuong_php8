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
                TỔNG HỢP TRÍCH LẬP VÀ SỬ DỤNG QUỸ THI ĐUA, KHEN THƯỞNG NĂM {{ $inputs['nam'] }}
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Thời điểm báo cáo: {{ getThoiDiem()[$inputs['thoidiem']] }}
            </td>
        </tr>

        {{-- <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{ getDayVn($inputs['ngaytu']) }} đến ngày: {{ getDayVn($inputs['ngayden']) }}
            </td>
        </tr> --}}

    </table>

    <table id="data_render" cellspacing="0" cellpadding="0" border="1"
        style="margin: 20px auto; border-collapse: collapse;">
        <thead>
            <tr class="text-center">
                <th style="width: 3%" rowspan="3">STT</th>
                <th rowspan="3">Nội dung</th>
                @foreach ($a_thu as $key => $val)
                    <th rowspan="3" style="width: 5%">{{ $val }}</th>
                @endforeach
                <th colspan="{{ 1 + $col_chikt + $col_chikhac }}">Số đã chi trong năm</th>
                <th rowspan="3" style="width: 5%">Ghi chú</th>

            </tr>
            <tr class="text-center">
                <th rowspan="2" style="width: 5%">Tổng cộng</th>
                <th colspan="{{ $col_chikt }}">Chi khen thưởng</th>
                @foreach ($a_chikhac as $key => $val)
                    <th rowspan="2" style="width: 5%">{{ $val }}</th>
                @endforeach
            </tr>
            <tr class="text-center">
                @foreach ($a_chikt as $key => $val)
                    <th style="width: 5%">{{ $val }}</th>
                @endforeach
            </tr>

            <tr class="text-center">
                @for ($i = 1; $i <= 4 + $col_thu + $col_chikt + $col_chikhac; $i++)
                    <th style="width: 5%">{{ $i }}</th>
                @endfor
            </tr>
            {{-- <tr class="text-center">
            @foreach ($a_danhhieutd as $k => $v)
                <th style="width: 10%">{{ $v }}</th>
            @endforeach
        </tr> --}}
        </thead>
        <?php $i = 1; ?>
        @foreach ($model as $chitiet)
            <tr>
                <td class="text-bold text-center">{{ $i++ }}</td>
                <td class="text-bold">{{ $chitiet->tenquy }}</td>
                @foreach ($a_thu as $key => $val)
                    <td class="text-right">{{ dinhdangso($chitiet->$key) }}</td>
                @endforeach
                <td class="text-right">{{ dinhdangso($chitiet->tongchi) }}</td>
                @foreach ($a_chikt as $key => $val)
                    <td class="text-right">{{ dinhdangso($chitiet->$key) }}</td>
                @endforeach

                @foreach ($a_chikhac as $key => $val)
                    <td class="text-right">{{ dinhdangso($chitiet->$key) }}</td>
                @endforeach
                <td class="text-center"></td>
            </tr>
        @endforeach
        <tr class="font-weight-boldest">
            <td class="text-center" colspan="2">Tổng cộng</td>

            @foreach ($a_thu as $key => $val)
                <td class="text-right">{{ dinhdangso($model->sum($key)) }}</td>
            @endforeach
            <td class="text-right">{{ dinhdangso($model->sum('tongchi')) }}</td>
            @foreach ($a_chikt as $key => $val)
                <td class="text-right">{{ dinhdangso($model->sum($key)) }}</td>
            @endforeach

            @foreach ($a_chikhac as $key => $val)
                <td class="text-right">{{ dinhdangso($model->sum($key)) }}</td>
            @endforeach
            <td class="text-center"></td>
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
