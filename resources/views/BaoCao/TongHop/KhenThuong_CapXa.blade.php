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
                TÔNG HỢP CÁC HÌNH THỨC KHEN THƯỞNG TRÊN ĐỊA BÀN
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
        {{-- <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Phân loại hồ sơ: {{ $inputs['phanloaihoso']  ?? ''}}
            </td>
        </tr> --}}
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
                <th colspan="{{ count($a_hinhthuckt) + 1 }}">Danh hiệu thi đua/Hình thức khen thưởng</th>
            </tr>
            <tr class="text-center">
                <th style="width: 8%">Tổng số</th>
                @foreach ($a_hinhthuckt as $k => $v)
                    <th style="width: 5%">{!! $v !!}</th>
                @endforeach
            </tr>
        </thead>
        <?php $i = 0; ?>

        @foreach ($a_huyen as $k_huyen => $v_huyen)
            <?php
            $i_diaban = 0;
            //$diaban = a_getelement($a_diaban, ['capdo' => $k_capdo]);
            $donvi = $model->where('madiabanQL', (string) $k_huyen);
            ?>
            @if ($donvi->count() > 0 && $donvi->sum('tongso') > 0)
                <tr class="font-weight-boldest">
                    <td class="text-bold text-center">{{ IntToRoman(++$i) }}</td>
                    <td class="text-bold">{{ $v_huyen }}</td>
                </tr>

                @foreach ($donvi as $ct)
                    @if ($ct->tongso <= 0 && isset($inputs['indonvidulieu']))
                        @continue;
                    @endif
                    <tr>
                        <td class="text-right">{{ ++$i_diaban }}</td>
                        <td>{{ $ct->tendonvi }}</td>
                        <td class="text-center">{{ dinhdangso($ct->tongso) }}</td>
                        @foreach ($a_hinhthuckt as $k_lh => $v_lh)
                            <td class="text-center">{{ dinhdangso($ct->$k_lh) }}</td>
                        @endforeach
                    </tr>
                @endforeach

                <tr class="font-weight-boldest">
                    <td class="text-center" colspan="2">Cộng</td>
                    <td class="text-center">{{ dinhdangso($donvi->sum('tongso')) }}</td>
                    @foreach ($a_hinhthuckt as $k_lh => $v_lh)
                        <td class="text-center">{{ dinhdangso($donvi->sum($k_lh)) }}</td>
                    @endforeach
                </tr>
            @endif
        @endforeach
        @if ($i > 1)
            <tr class="font-weight-boldest">
                <td class="text-center" colspan="2">Tổng cộng</td>
                <td class="text-center">{{ dinhdangso($model->sum('tongso')) }}</td>
                @foreach ($a_hinhthuckt as $k_lh => $v_lh)
                    <td class="text-center">{{ dinhdangso($model->sum($k_lh)) }}</td>
                @endforeach
            </tr>
        @endif

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
