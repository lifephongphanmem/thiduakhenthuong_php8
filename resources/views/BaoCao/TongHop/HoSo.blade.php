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
                BÁO CÁO SỐ LƯỢNG HỒ SƠ KHEN THƯỞNG TRÊN ĐỊA BÀN
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Thời điểm báo cáo: {{ getThoiDiem()[$inputs['thoidiem']] }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Phạm vị thống kê: {{ getPhamViApDung()[$inputs['phamvithongke']] ?? 'Tất cả' }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Phân loại hồ sơ: {{ $inputs['phanloaihoso'] }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{ getDayVn($inputs['ngaytu']) }} đến ngày: {{ getDayVn($inputs['ngayden']) }}
            </td>
        </tr>

    </table>

    <table id="data_render" cellspacing="0" cellpadding="0" border="1"
        style="margin: 20px auto; border-collapse: collapse;">
        <thead>
            <tr class="text-center">
                <th style="width: 3%" rowspan="2">STT</th>
                <th rowspan="2">Tên đơn vị</th>
                <th rowspan="2" style="width: 8%">Tổng số hồ sơ</th>
                <th colspan="{{ count($a_loaihinhkt) }}">Loại hình khen thưởng</th>
            </tr>
            <tr class="text-center">
                @foreach ($a_loaihinhkt as $k => $v)
                    <th style="width: 8%">{{ $v }}</th>
                @endforeach
            </tr>
        </thead>
        <?php $i = 1; ?>
        @foreach ($a_diaban as $k_diaban => $v_diaban)
            <?php
            $chitiet = $model->where('madiaban', (string) $k_diaban);
            $k = 1;
            ?>
            <tr class="font-weight-boldest">
                <td class="text-bold text-center">{{ IntToRoman($i++) }}</td>
                <td class="text-bold">{{ $v_diaban }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->sum('tongso'))}}</td>
                @foreach ($a_loaihinhkt as $k_lh => $v_lh)
                    <td class="text-center">{{ dinhdangso($chitiet->sum($k_lh)) }}</td>
                @endforeach
            </tr>

            @foreach ($chitiet as $ct)
                @if ($ct->tongso <= 0 && isset($inputs['indonvidulieu']))
                    @continue;
                @endif
                <tr>
                    <td class="text-right">{{ $k++ }}</td>
                    <td>{{ $ct->tendonvi }}</td>
                    <td class="text-center">{{ dinhdangso($ct->tongso)}}</td>
                    @foreach ($a_loaihinhkt as $k_lh => $v_lh)
                        <td class="text-center">{{ dinhdangso($ct->$k_lh) }}</td>
                    @endforeach
                </tr>
            @endforeach
        @endforeach
        <tr class="font-weight-boldest">
            <td class="text-center" colspan="2">Tổng cộng</td>
            <td class="text-center">{{ dinhdangso($model->sum('tongso'))}}</td>
            @foreach ($a_loaihinhkt as $k_lh => $v_lh)
                <td class="text-center">{{ dinhdangso($model->sum($k_lh)) }}</td>
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
