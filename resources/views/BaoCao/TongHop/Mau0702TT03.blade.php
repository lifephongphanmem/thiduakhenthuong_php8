@extends('HeThong.main_baocao')

@section('content')
    <table class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td style="text-align: left; font-weight: bold">
                Biểu số: 0702.N/BNV-TĐKT
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
                SỐ LƯỢNG KHEN THƯỞNG CẤP NHÀ NƯỚC
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Thời điểm báo cáo: {{ getThoiDiem()[$inputs['thoidiem']] }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                {{-- Phạm vị thống kê: {{ getPhamViApDung()[$inputs['phamvithongke']] ?? 'Tất cả' }} --}}
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
            <th colspan="{{ count($a_hinhthuckt) }}">Chia ra</th>
        </tr>
        <tr class="text-center">
            @foreach ($a_hinhthuckt as $key => $val)
                <th style="width: 5%">{!! $val !!}</th>
            @endforeach

        </tr>
        <tr class="text-center">
            <td>A</td>
            <td>B</td>
            <td>C</td>
            <td>1</td>
            @for ($i = 0; $i < count($a_hinhthuckt); $i++)
                <td>{{ $i + 2 }}</td>
            @endfor

        </tr>
        <tr class="font-weight-bold text-center">
            <td>Tổng số</td>
            <td class="text-center">01</td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('madanhhieukhenthuong', $key)->count()) }}</td>
            @endforeach
        </tr>
        <tr class="font-weight-bold text-center">
            <td class="text-left">1. Chia theo đơn vị ban hành tờ trình Thủ tướng Chính phủ về khen thưởng</td>
            <td class="text-center"></td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('madanhhieukhenthuong', $key)->count()) }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Bộ, ban, ngành, đoàn thể Trung ương</td>
            <td class="text-center">02</td>
            <td>Bộ, ngành</td>
            <td></td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td></td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Tỉnh, thành phố trực thuộc Trung ương</td>
            <td class="text-center">03</td>
            <td>Tỉnh, thành phố</td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('madanhhieukhenthuong', $key)->count()) }}</td>
            @endforeach
        </tr>
        <tr class="font-weight-bold text-center">
            <td class="text-left">2. Chia theo đối tượng khen thưởng</td>
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('madanhhieukhenthuong', $key)->count()) }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Tập thể</td>
            <td class="text-center">06</td>
            <td>Tập thể</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="font-italic text-left">Trong đó: Doanh nghiệp</td>
            <td class="text-center">07</td>
            <td>Doanh nghiệp</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maphanloai', '1660638247')->count()) }}
            </td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maphanloai', '1660638247')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Hộ gia đình</td>
            <td class="text-center">08</td>
            <td>Hộ</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'HOGIADINH')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'HOGIADINH')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Cá nhân</td>
            <td class="text-center">09</td>
            <td>Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">+ Lãnh đạo cấp bộ, cấp tỉnh và tương đương trở lên</td>
            <td class="text-center">10</td>
            <td>Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638808')->count()) }}
            </td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638808')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">+ Lãnh đạo cấp vụ, sở, ngành và tương đương</td>
            <td class="text-center">11</td>
            <td>Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638843')->count()) }}
            </td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638843')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">+ Doanh nhân</td>
            <td class="text-center">12</td>
            <td>Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638864')->count()) }}
            </td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638864')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">+ Các cấp lãnh đạo khác từ phó phòng trở lên</td>
            <td class="text-center">13</td>
            <td>Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638930')->count()) }}
            </td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638930')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">+ Người trực tiếp công tác, lao động, học tập, chiến đấu và phục vụ chiến đấu (công nhân,
                nông dân,...)</td>
            <td class="text-center">14</td>
            <td>Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638976')->count()) }}
            </td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638976')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="font-weight-bold text-center">
            <td class="text-left">3. Chia theo phương thức khen thưởng</td>
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('madanhhieukhenthuong', $key)->count()) }}</td>
            @endforeach
        </tr>
        <tr class="text-center">
            <!-- Công trạng, thành tích -->
            <td class="text-left">- Thường xuyên</td>
            <td>15</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358223')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Chuyên đề</td>
            <td>16</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358255')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Đột xuất</td>
            <td class="text-center">17</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358265')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Đối ngoại</td>
            <td class="text-center">18</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358310')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Cống hiến.</td>
            <td class="text-center">19</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358282')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Niên hạn</td>
            <td class="text-center">20</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358297')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
        </tr>
        <tr class="text-center">
            <td class="text-left">- Kháng chiến</td>
            <td class="text-center">21</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', 'KHANGCHIEN')->count()) }}</td>
            @foreach ($a_hinhthuckt as $key => $val)
                <td>{{ dinhdangso($model->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', $key)->count()) }}
                </td>
            @endforeach
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
