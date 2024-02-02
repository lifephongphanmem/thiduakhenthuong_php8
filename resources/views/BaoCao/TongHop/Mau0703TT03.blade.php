@extends('HeThong.main_baocao')

@section('content')
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td style="text-align: left; font-weight: bold">
                Biểu số: 0703.N/BNV-TĐKT
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
                SỐ LƯỢNG KHEN THƯỞNG CẤP BỘ, BAN, NGÀNH, ĐOÀN THỂ TRUNG ƯƠNG VÀ TỈNH, THÀNH PHỐ TRỰC THUỘC TRUNG ƯƠNG
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{ getDayVn($inputs['ngaytu']) }} đến ngày: {{ getDayVn($inputs['ngayden']) }}
            </td>
        </tr>

    </table>

    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <tr class="text-center">
            <th rowspan="2" style="width: 25%"></th>
            <th style="width: 5%" rowspan="2">Mã số</th>
            <th style="width: 5%" rowspan="2">Đơn<br>vị<br>tính</th>
            <th style="width: 5%" rowspan="2">Tổng số</th>
            <th colspan="4">Chia ra</th>
        </tr>
        <tr class="text-center">
            <th style="width: 10%">Bằng khen</th>
            <th style="width: 10%">Chiến sĩ thi đua cấp bộ, cấp tỉnh</th>
            <th style="width: 10%">Cờ thi đua của bộ, ban, ngành, đoàn thể Trung ương, tỉnh, thành phố trực thuộc Trung ương</th>
            <th style="width: 10%">Huy hiệu (kỷ niệm chương) của bộ, ban, ngành, đoàn thể Trung ương, tỉnh, thành phố trực thuộc Trung ương</th>            
        </tr>
        <tr class="text-center">
            <td>A</td>
            <td>B</td>
            <td>C</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
        </tr>
        <tr class="font-weight-bold">
            <td>Tổng số</td>
            <td class="text-center">01</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr class="font-weight-bold">
            <td>1. Chia theo đối tượng khen thưởng</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>- Tập thể</td>
            <td class="text-center">02</td>
            <td>Tập thể</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td class="font-italic">Trong đó: Doanh nghiệp</td>
            <td class="text-center">03</td>
            <td>Doanh nghiệp</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Hộ gia đình</td>
            <td class="text-center">04</td>
            <td>Hộ</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Cá nhân</td>
            <td class="text-center">05</td>
            <td>Người</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>+ Lãnh đạo cấp bộ, cấp tỉnh và tương đương trở lên</td>
            <td class="text-center">06</td>
            <td>Người</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>+ Lãnh đạo cấp vụ, sở, ngành và tương đương</td>
            <td class="text-center">07</td>
            <td>Người</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>+ Doanh nhân</td>
            <td class="text-center">08</td>
            <td>Người</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>+ Các cấp lãnh đạo khác từ phó phòng trở lên</td>
            <td class="text-center">09</td>
            <td>Người</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>+ Người trực tiếp công tác, lao động, học tập, chiến đấu và phục vụ chiến đấu (công nhân, nông dân,...)</td>
            <td class="text-center">10</td>
            <td>Người</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>


        <tr class="font-weight-bold">
            <td>2. Chia theo phương thức khen thưởng</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Thường xuyên</td>
            <td class="text-center">11</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Chuyên đề</td>
            <td class="text-center">12</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Đột xuất</td>
            <td class="text-center">13</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Đối ngoại</td>
            <td class="text-center">14</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Cống hiến.</td>
            <td class="text-center">15</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Niên hạn</td>
            <td class="text-center">16</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>- Kháng chiến</td>
            <td class="text-center">17</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>     

    </table>

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%">…………, Ngày…...tháng …… năm ……</td>
        </tr>
        <tr class="font-weight-bold">
            <td>Người lập biểu</td>
            <td>Thủ trưởng đơn vị</td>
        </tr>
        <tr class="font-italic">
            <td>(Ký, họ tên)</td>
            <td>(Ký, họ tên, đóng dấu)</td>
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
