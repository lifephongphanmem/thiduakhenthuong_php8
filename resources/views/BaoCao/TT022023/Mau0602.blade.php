@extends('HeThong.main_baocao')

@section('content')

    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;font-size:12px">
        <tr>
            <td style="text-align: left;width: 60%">
                <b> Biểu số: 0602.N/BNV-TĐKT</b>
            </td>
            <td style="text-align: center;">
                Đơn vị báo cáo: <b>{{ $m_donvi['tendvhienthi'] }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                Ban hành theo Thông tư số 2/2023/TT-BNV ngày 23/3/2023
            </td>
            <td style="text-align: center;">
                Đơn vị nhận báo cáo:
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
                SỐ LƯỢNG KHEN THƯỞNG CẤP NHÀ NƯỚC
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-style: italic;" colspan="2">
                Thời điểm báo cáo:{{ getThoiDiem()[$inputs['thoidiem']] }}
            </td>
        </tr>

    </table>

    <table id="data_body" cellspacing="0" cellpadding="0" border="1"
        style="margin: 20px auto; border-collapse: collapse;">
        <tr class="text-center">
            <th style="width: 10%;padding-left: 2px;padding-right: 2px" rowspan="4"></th>
            <th style="width:2%" rowspan="4">Mã số </th>
            <th style="width:2%" rowspan="4">Đơn vị tính </th>
            <th style="width: 2%;padding-left: 2px;padding-right: 2px" rowspan="4">Tổng số</th>
            <th colspan="20" style="width: 6%;padding-left: 2px;padding-right: 2px">Chia ra</th>
        </tr>
        <tr class="text-center">

            <th colspan="{{ ($m_huanhuychuong->count() == 0 ? 1 : $m_huanhuychuong->count()) * 2 }}">
                Các loại huân chương, huy chương
            </th>
            <th rowspan="2">Giải thưởng Hồ Chí Minh</th>
            <th rowspan="2">Giải thưởng Nhà nước</th>
            <th colspan="{{ ($m_vinhdunhanuoc->count() == 0 ? 1 : $m_vinhdunhanuoc->count()) * 2 }}">Danh hiệu vinh dự nhà
                nước</th>
            <th rowspan="2">Cờ thi đua của Chính phủ</th>
            <th rowspan="2" colspan="2">Bằng khen của Thủ tướng Chính phủ</th>
            <th rowspan="2">Chiến sĩ thi đua Toàn quốc</th>
            <th colspan="{{ ($m_khenthuongkhac->count() == 0 ? 1 : $m_khenthuongkhac->count()) * 2 }}">
                Các hình thức khen thưởng khác

            </th>
        </tr>
        <tr class="text-center">
            @if ($m_huanhuychuong->count() == 0)
                <th colspan="2"></th>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <th colspan="2">{{ $ct->tenhinhthuckt }}</th>
                @endforeach
            @endif


            @if ($m_vinhdunhanuoc->count() == 0)
                <th colspan="2"></th>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <th colspan="2">{{ $ct->tenhinhthuckt }}</th>
                @endforeach
            @endif

            @if ($m_khenthuongkhac->count() == 0)
                <th colspan="2"></th>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <th colspan="2">{{ $ct->tenhinhthuckt }}</th>
                @endforeach
            @endif
        </tr>
        <tr class="text-center">
            @if ($m_huanhuychuong->count() == 0)
                <th>Tập thể</th>
                <th>Cá nhân</th>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <th>Tập thể</th>
                    <th>Cá nhân</th>
                @endforeach
            @endif
            <th>Cá nhân</th>
            <th>Cá nhân</th>
            @if ($m_vinhdunhanuoc->count() == 0)
                <th>Tập thể</th>
                <th>Cá nhân</th>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <th>Tập thể</th>
                    <th>Cá nhân</th>
                @endforeach
            @endif
            <th>Cá nhân</th>
            <th>Tập thể</th>
            <th>Cá nhân</th>
            <th>Cá nhân</th>
            @if ($m_khenthuongkhac->count() == 0)
                <th>Tập thể</th>
                <th>Cá nhân</th>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <th>Tập thể</th>
                    <th>Cá nhân</th>
                @endforeach
            @endif
        </tr>
        <tr class="text-center font-weight-bold">
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>1</th>
            @if ($m_huanhuychuong->count() == 0)
                <th colspan="2">2</th>
            @else
                <th colspan="{{ $m_huanhuychuong->count() * 2 }}">2</th>
            @endif
            <th>3</th>
            <th>4</th>

            @if ($m_vinhdunhanuoc->count() == 0)
                <th colspan="2">5</th>
            @else
                <th colspan="{{ $m_vinhdunhanuoc->count() * 2 }}">5</th>
            @endif
            <th>6</th>
            <th colspan="2">7</th>
            <th>8</th>
            @if ($m_khenthuongkhac->count() == 0)
                <th colspan="2">9</th>
            @else
                <th colspan="{{ $m_khenthuongkhac->count() * 2 }}">9</th>
            @endif
        </tr>
        <tr class="text-center font-weight-bold">
            <td>Tổng số</td>
            <td>1</td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        <tr class="text-center font-weight-bold">
            <td style="font-weight: bold;text-align:left">1. Chia theo đơn vị ban hành tờ trình
                Thủ tướng Chính phủ về khen thưởng
            </td>
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center">
            <td style="text-align:left">- Bộ, ban, ngành, đoàn thể Trung ương</td>
            <td style="text-align:center">2</td>
            <td style="text-align:center">Bộ, ngành</td>
            <td></td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td> </td>
                    <td> </td>
                @endforeach
            @endif
            <td></td>
            <td></td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td></td>
                    <td></td>
                @endforeach
            @endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td></td>
                    <td></td>
                @endforeach
            @endif
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Tỉnh, thành phố trực thuộc Trung ương</td>
            <td style="text-align:center">3</td>
            <td style="text-align:center">Tỉnh,TP</td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        <tr class="text-center font-weight-bold">
            <td style="text-align:left">2. Chia theo đối tượng khen thưởng</td>
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Tập thể</td>
            <td style="text-align:center">6</td>
            <td style="text-align:center">Tập thể</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
            <td></td>
            <td></td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td></td>
            <td></td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center font-italic">
            <td style="text-align:left">Trong đó: Doanh nghiệp
            </td>
            <td style="text-align:center">7</td>
            <td style="text-align:center">Doanh nghiệp</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maphanloai', '1660638247')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maphanloai', '1660638247')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
            <td></td>
            <td></td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maphanloai', '1660638247')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->where('maphanloai', '1660638247')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maphanloai', '1660638247')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td></td>
            <td></td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maphanloai', '1660638247')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Hộ gia đình
            </td>
            <td style="text-align:center">8</td>
            <td style="text-align:center">Hộ</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'HOGIADINH')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'HOGIADINH')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
            <td></td>
            <td></td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'HOGIADINH')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'HOGIADINH')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td></td>
            <td></td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'HOGIADINH')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td></td>
                @endforeach
            @endif
        </tr>
        <tr class="text-center">
            <td style="text-align:left">- Cá nhân
            </td>
            <td style="text-align:center">9</td>
            <td style="text-align:center">Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>                   
                @endforeach
            @endif
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        <tr class="text-center">
            <td style="text-align:left">+ Lãnh đạo cấp bộ, cấp tỉnh và tương đương trở lên
            </td>
            <td style="text-align:center">10</td>
            <td style="text-align:center">Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638808')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638808')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->where('maphanloai', '1660638808')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->where('maphanloai', '1660638808')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638808')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>                   
                @endforeach
            @endif
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638808')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->where('maphanloai', '1660638808')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638808')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center">
            <td style="text-align:left">+ Lãnh đạo cấp vụ, sở, ngành và tương đương
            </td>
            <td style="text-align:center">11</td>
            <td style="text-align:center">Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638843')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638843')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->where('maphanloai', '1660638843')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->where('maphanloai', '1660638843')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638843')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>                   
                @endforeach
            @endif
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638843')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->where('maphanloai', '1660638843')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638843')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center">
            <td style="text-align:left">+ Doanh nhân
            </td>
            <td style="text-align:center">12</td>
            <td style="text-align:center">Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638864')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638864')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->where('maphanloai', '1660638864')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->where('maphanloai', '1660638864')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638864')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>                   
                @endforeach
            @endif
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638864')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->where('maphanloai', '1660638864')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638864')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center">
            <td style="text-align:left">+ Các cấp lãnh đạo khác từ phó phòng trở lên
            </td>
            <td style="text-align:center">13</td>
            <td style="text-align:center">Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638930')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638930')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->where('maphanloai', '1660638930')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->where('maphanloai', '1660638930')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638930')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>                   
                @endforeach
            @endif
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638930')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->where('maphanloai', '1660638930')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638930')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center">
            <td style="text-align:left">+ Người trực tiếp công tác, lao động, học tập, chiến đấu và phục vụ chiến đấu (công
                nhân, nông dân,...)
            </td>
            <td style="text-align:center">14</td>
            <td style="text-align:center">Người</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638976')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638976')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->where('maphanloai', '1660638976')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->where('maphanloai', '1660638976')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638976')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>                   
                @endforeach
            @endif
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638976')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->where('maphanloai', '1660638976')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td></td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maphanloai', '1660638976')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center font-weight-bold">
            <td style="text-align:left">3. Chia theo phương thức khen thưởng</td>
            <td></td>
            <td></td>
            <td>{{ dinhdangso($model->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center">
             <!-- Công trạng, thành tích -->
            <td style="text-align:left">- Thường xuyên
            </td>
            <td style="text-align:center">15</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358223')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358223')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>

        <tr class="text-center">
            <td style="text-align:left">- Chuyên đề
            </td>
            <td style="text-align:center">16</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358255')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358255')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        
        <tr class="text-center">
            <td style="text-align:left">- Đột xuất
            </td>
            <td style="text-align:center">17</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358265')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358265')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        
        <tr class="text-center">
            <td style="text-align:left">- Đối ngoại
            </td>
            <td style="text-align:center">18</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358310')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358310')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        
        <tr class="text-center">
            <td style="text-align:left">- Cống hiến.
            </td>
            <td style="text-align:center">19</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358282')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358282')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        
        <tr class="text-center">
            <td style="text-align:left">- Niên hạn
            </td>
            <td style="text-align:center">20</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358297')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', '1650358297')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
        </tr>
        
        <tr class="text-center">
            <td style="text-align:left">- Kháng chiến
            </td>
            <td style="text-align:center">21</td>
            <td></td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', 'KHANGCHIEN')->count()) }}</td>
            @if ($m_huanhuychuong->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_huanhuychuong as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', '1671247920')->count()) }}</td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', '1671247953')->count()) }}</td>
            @if ($m_vinhdunhanuoc->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_vinhdunhanuoc as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
            <td>{{ dinhdangso($model->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', '1647933079')->count()) }}</td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', '1671247716')->count()) }}
            </td>
            <td>{{ dinhdangso($model->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', '1647933381')->count()) }}</td>
            @if ($m_khenthuongkhac->count() == 0)
                <td></td>
                <td></td>
            @else
                @foreach ($m_khenthuongkhac as $ct)
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'TAPTHE')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                    <td>{{ dinhdangso($model->where('phanloaidoituong', 'CANHAN')->where('maloaihinhkt', 'KHANGCHIEN')->where('madanhhieukhenthuong', $ct->mahinhthuckt)->count()) }}
                    </td>
                @endforeach
            @endif
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
