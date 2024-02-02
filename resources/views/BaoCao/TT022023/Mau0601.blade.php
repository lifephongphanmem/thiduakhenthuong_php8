@extends('HeThong.main_baocao')

@section('content')

    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 10px; text-align: center;font-size:12px">
        <tr>
            <td style="text-align: left;width: 60%">
                <b> Biểu số: 0601.N/BNV-TĐKT</b>
            </td>
            <td style="text-align: center;">
                Đơn vị báo cáo: <b>{{ $m_donvi['tendvhienthi'] }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                Ban hành theo Thông tư số 02/2023/TT-BNV ngày 23/3/2023
            </td>
            <td style="text-align: center;">
                Đơn vị nhận báo cáo: <b>{{ $m_donvi['tendvcqhienthi'] }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                Ngày nhận báo cáo:<br />
                Ngày 15 tháng 12 năm báo cáo

            </td>
            <td style="text-align: center; font-style: italic"></td>
        </tr>

        <tr>
            <td style="text-align: center;font-weight: bold; font-size: 20px;" colspan="2">
                SỐ PHONG TRÀO THI ĐUA
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-style: italic;" colspan="2">
                Thời điểm báo cáo:{{ getThoiDiem()[$inputs['thoidiem']] }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right;font-style: italic;" colspan="2">
                Đơn vị tính: Phong trào
            </td>
        </tr>
    </table>
    
    <table id="data_body" cellspacing="0" cellpadding="0" border="1"
        style="margin: 10px auto; border-collapse: collapse;">
        <tr class="text-center" style="padding-left: 2px;padding-right: 2px">
            <th style="width: 10%;padding-left: 2px;padding-right: 2px" rowspan="2"></th>
            <th style="width:2%" rowspan="2">Mã số </th>
            <th style="width: 6%;padding-left: 2px;padding-right: 2px" rowspan="2">Tổng số</th>
            <th colspan="3" style="width: 6%;padding-left: 2px;padding-right: 2px">Số phong trào thi đua chia theo cấp
                chủ trì phát động thi đua</th>
        </tr>
        <tr class="text-center">
            <th>
                Cấp Trung ương (Hội đồng Thi đua - Khen thưởng Trung ương)
            </th>
            <th>Cấp bộ, ban ngành đoàn thể trung ương, tỉnh, thành phố trực thuộc Trung ương</th>
            <th>Cơ quan, tổ chức, đơn vị</th>
        </tr>
        <tr style="font-weight: bold;text-align:center">
            <td>A</td>
            <td>B</td>
            <td>1=(2+3+4)</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
        </tr>
        <tr class="text-center" style="font-weight: bold;">
            <td>Tổng số</td>
            <td>01</td>
            <td>{{ dinhdangso($model->count()) }}</td>
            <td>{{ dinhdangso($model->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td>{{ dinhdangso($model->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td>{{ dinhdangso($model->wherein('phamviapdung',['H','X'])->count()) }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">1. Chia theo phạm vi tổ chức thi đua</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Toàn quốc</td>
            <td style="text-align:center">02</td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','')->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','')->wherein('phamviapdung',['TW',])->count()) }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Bộ, ban, ngành đoàn thể, địa phương</td>
            <td>03</td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','')->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td></td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','')->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td></td>
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Cụm, khối thi đua do Hội đồng Thi đua - Khen thưởng các cấp tổ chức</td>
            <td>04</td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','<>','')->count()) }}</td>
            <td></td>
            <td></td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','<>','')->count()) }}</td>
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Cơ quan, tổ chức, đơn vị</td>
            <td style="text-align:center">05</td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','')->wherein('phamviapdung',['H','X'])->count()) }}</td>
            <td></td>
            <td></td>
            <td style="text-align:center">{{ dinhdangso($model->where('macumkhoi','')->wherein('phamviapdung',['H','X'])->count()) }}</td>
        </tr>
        <tr class="text-center">
            <td style="font-weight: bold;text-align:left">2. Chia theo thời hạn thi đua</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Dưới 1 năm</td>
            <td style="text-align:center">06</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['DUOIMOTNAM'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['DUOIMOTNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['DUOIMOTNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['DUOIMOTNAM'])->wherein('phamviapdung',['H','X'])->count()) }}</td>            
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- 1 năm</td>
            <td style="text-align:center">07</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAM'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAM'])->wherein('phamviapdung',['H','X'])->count()) }}</td>
        </tr>
        <tr>
            <td style="text-align:left">- Từ 1 năm đến dưới 3 năm</td>
            <td style="text-align:center">08</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAMDENBANAM'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAMDENBANAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAMDENBANAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['MOTNAMDENBANAM'])->wherein('phamviapdung',['H','X'])->count()) }}</td>
        </tr>
        <tr>
            <td style="text-align:left">- Từ 3 năm đến dưới 5 năm</td>
            <td style="text-align:center">09</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['BANAMDENNAMNAM'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['BANAMDENNAMNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['BANAMDENNAMNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['BANAMDENNAMNAM'])->wherein('phamviapdung',['H','X'])->count()) }}</td>
        </tr>
        <tr>
            <td style="text-align:left">- Từ 5 năm trở lên</td>
            <td style="text-align:center">10</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['TRENNAMNAM'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['TRENNAMNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['TRENNAMNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('thoihanthidua',['TRENNAMNAM'])->wherein('phamviapdung',['H','X'])->count()) }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">3. Chia theo phương thức tổ chức phong trào thi đua</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align:left">- Thi đua theo chuyên đề</td>
            <td style="text-align:center">11</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['CHUYENDE'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['CHUYENDE'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['CHUYENDE'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['CHUYENDE'])->wherein('phamviapdung',['H','X'])->count()) }}</td>
        </tr>
        <tr>
            <td style="text-align:left">- Thi đua thường xuyên hàng năm</td>
            <td style="text-align:center">12</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['HANGNAM'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['HANGNAM'])->wherein('phamviapdung',['TW'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['HANGNAM'])->wherein('phamviapdung',['T','SBN'])->count()) }}</td>
            <td style="text-align:center">{{ dinhdangso($model->wherein('phuongthuctochuc',['HANGNAM'])->wherein('phamviapdung',['H','X'])->count()) }}</td>
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
