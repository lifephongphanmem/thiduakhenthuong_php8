@extends('HeThong.main_baocao')

@section('content')
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td style="text-align: left; font-weight: bold">
                Biểu số: 0701.N/BNV-TĐKT
            </td>
            <td style="text-align: right;width: 50%">
                <b>Đơn vị báo cáo: {{ $m_donvi['tendonvi'] }}</b>
            </td>

        </tr>
        <tr>


            <td style="text-align: left; font-style: italic">
                Ban hành theo Thông tư số 03/2018/TT-BNV ngày 06/3/2018
            </td>
            <td style="text-align: right;width: 50%">
                {{-- <b>Mã đơn vị SDNS: {{ $m_donvi->maqhns }}</b> --}}
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px;text-transform: uppercase">
                số phong trào thi đua khen thưởng
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Thời điểm báo cáo: {{ getThoiDiem()[$inputs['thoidiem']] }}
            </td>
        </tr>
        {{-- <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Phạm vị thống kê: {{ getPhamViApDung()[$inputs['phamvithongke']] ?? 'Tất cả' }}
            </td>
        </tr> --}}
        <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{ getDayVn($inputs['ngaytu']) }} đến ngày: {{ getDayVn($inputs['ngayden']) }}
            </td>
        </tr>

    </table>

    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <tr class="text-center">
            <th rowspan="2" style="width: 40%"></th>
            <th rowspan="2">Mã số</th>
            <th rowspan="2">Tổng số</th>
            <th colspan="2">Số phong trào thi đua chia theo cấp chủ trì phát động thi đua</th>
        </tr>
        <tr class="text-center">
            <th style="width: 20%">Cấp Trung ương (Hội đồng Thi đua - Khen thưởng Trung ương)</th>
            <th style="width: 20%">Cấp bộ, ban ngành đoàn thể trung ương, tỉnh, thành phố trực thuộc Trung ương</th>
        </tr>
        <tr class="text-center">
            <td>A</td>
            <td>B</td>
            <td>1=(2+3)</td>
            <td>2</td>
            <td>3</td>
        </tr>
        <tr class="font-weight-bold">
            <td>Tổng số</td>
            <td class="text-center">01</td>
            <td class="text-center">{{ dinhdangso($model->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        <tr class="font-weight-bold">
            <td class="text-left">1. Chia theo phạm vi đối tượng thi đua</td>
            <td></td>
            <td class="text-center">{{ dinhdangso($model->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['T','SBN',])->count()) }}</td>
        </tr>
        <tr>
            <td class="text-left">- Toàn quốc</td>
            <td class="text-center">02</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td></td>
        </tr>
        <tr>
            <td class="text-left">- Bộ, ban, ngành đoàn thể trung ương, tỉnh, thành phố trực thuộc Trung ương</td>
            <td class="text-center">03</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td></td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        <tr class="font-weight-bold">
            <td class="text-left">2. Chia theo thời hạn thi đua</td>
            <td></td>
            <td class="text-center">{{ dinhdangso($model->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        <tr>
            <td class="text-left">- Dưới 1 năm</td>
            <td class="text-center">06</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['DUOIMOTNAM'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['DUOIMOTNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['DUOIMOTNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        </tr>
        <tr>
            <td class="text-left">- 1 năm</td>
            <td class="text-center">07</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAM'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        <tr>
            <td class="text-left">- Từ 1 năm đến dưới 3 năm</td>
            <td class="text-center">08</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAMDENBANAM'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAMDENBANAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAMDENBANAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        <tr>
            <td class="text-left">- Từ 3 năm trở lên</td>
            <td class="text-center">09</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['BANAMDENNAMNAM','TRENNAMNAM'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['BANAMDENNAMNAM','TRENNAMNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('thoihanthidua',['BANAMDENNAMNAM','TRENNAMNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        <tr class="font-weight-bold">
            <td class="text-left">3. Chia theo phương thức tổ chức phong trào thi đua</td>
            <td></td>
            <td class="text-center">{{ dinhdangso($model->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        <tr>
            <td class="text-left">- Thi đua theo chuyên đề</td>
            <td class="text-center">10</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phuongthuctochuc',['CHUYENDE'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phuongthuctochuc',['CHUYENDE'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phuongthuctochuc',['CHUYENDE'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        </tr>
        <tr>
            <td class="text-left">- Thi đua thường xuyên hàng năm</td>
            <td class="text-center">11</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phuongthuctochuc',['HANGNAM'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phuongthuctochuc',['HANGNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td class="text-center">{{ dinhdangso($model->wherein('phuongthuctochuc',['HANGNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
        </tr>
        </tr>       
    </table>

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%">…………, Ngày…...tháng …… năm ……</td>
        </tr>
        <tr class="font-weight-bold">
            <td>Người lập biểu</td>
            <td>{{ $m_donvi->cdlanhdao }}</td>
        </tr>
        <tr class="font-italic">
            <td>(Ký, họ tên)</td>
            <td>(Ký, họ tên, đóng dấu)</td>
        </tr>
        <tr>
            <td style="height: 100px">

            </td>
        <tr>
            <td>{{ $m_donvi->nguoilapbieu }}</td>
            <td>{{ $m_donvi->lanhdao }}</td>
        </tr>
    </table>
@stop
