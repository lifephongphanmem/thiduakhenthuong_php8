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
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-style: italic">
                Phân loại hồ sơ: {{ $inputs['phanloaihoso']  ?? ''}}
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
                <th rowspan="2">Danh hiệu thi đua/Hình thức khen thưởng</th>
                <th rowspan="2" style="width: 3%">Tổng số tờ trình đề nghị khen thưởng</th>
                <th colspan="2">Tổng số tập thể, cá nhân đã được trình đề nghị khen thưởng</th>
                <th colspan="2">Tổng số tập thể, cá nhân đã có quyết định khen thưởng</th>
                <th colspan="4">Khen thưởng theo công trạng thành tích đạt được</th>
                <th colspan="4">Khen thưởng chuyên đề</th>
                <th colspan="2">Khen thưởng đột xuất</th>
                <th colspan="2">Khen thưởng đối ngoại</th>
                <th colspan="2">Khen thưởng cho doanh nghiệp</th>
                {{-- <th colspan="{{ count($a_danhhieutd) }}">Hình thức khen thưởng</th> --}}
            </tr>
            <tr class="text-center">
                <th style="width: 2%">SL tập thể</th>
                <th style="width: 2%">SL cá nhân</th>

                <th style="width: 2%">SL tập thể</th>
                <th style="width: 2%">SL cá nhân</th>

                <th style="width: 2%">SL tập thể</th>
                <th style="width: 2%">SL là cá nhân là lãnh đạo tỉnh, lãnh đạo các sở ban, ngành và tương đương </th>
                <th style="width: 2%">Số lượng cá nhân là lãnh đạo từ phó phòng trở lên</th>
                <th style="width: 2%">Số lượng cá nhân lao động trực tiếp, công nhân, nông nhân </th>

                <th style="width: 2%">SL tập thể</th>
                <th style="width: 2%">SL là cá nhân là lãnh đạo tỉnh, lãnh đạo các sở ban, ngành và tương đương </th>
                <th style="width: 2%">Số lượng cá nhân là lãnh đạo từ phó phòng trở lên</th>
                <th style="width: 2%">Số lượng cá nhân lao động trực tiếp, công nhân, nông nhân </th>

                <th style="width: 2%">SL tập thể</th>
                <th style="width: 2%">SL cá nhân</th>

                <th style="width: 2%">SL tập thể</th>
                <th style="width: 2%">SL cá nhân</th>

                <th style="width: 2%">SL tập thể</th>
                <th style="width: 2%">SL cá nhân</th>
            </tr>

            <tr class="text-center">
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
                <th>14</th>
                <th>15</th>
                <th>16</th>
                <th>17</th>
                <th>18</th>
                <th>19</th>
                <th>20</th>
                <th>21</th>
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
                <td class="text-bold">{{ $chitiet->tendanhhieukhenthuong }}</td>

                <td class="text-center"></td>
                {{-- <td class="text-center">{{ dinhdangso($chitiet->tongtotrinh) }}</td> --}}

                <td class="text-center">{{ dinhdangso($chitiet->tongtotrinh_tapthe) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->tongtotrinh_canhan) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->tongtotrinh_tapthe_kt) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->tongtotrinh_canhan_kt) }}</td>

                <td class="text-center">{{ dinhdangso($chitiet->tongso_tapthe_cotr) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->canhan_lada_cotr) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->canhan_pp_cotr) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->canhan_lado_cotr) }}</td>

                <td class="text-center">{{ dinhdangso($chitiet->tongso_tapthe_cd) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->canhan_lada_cd) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->canhan_pp_cd) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->canhan_lado_cd) }}</td>

                <td class="text-center">{{ dinhdangso($chitiet->tongso_tapthe_dx) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->tongso_canhan_dx) }}</td>

                <td class="text-center">{{ dinhdangso($chitiet->tongso_tapthe_dongo) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->tongso_canhan_dongo) }}</td>

                <td class="text-center">{{ dinhdangso($chitiet->tongso_tapthe_dn) }}</td>
                <td class="text-center">{{ dinhdangso($chitiet->tongso_canhan_dn) }}</td>
            </tr>
        @endforeach
        <tr class="font-weight-boldest">
            <td class="text-center" colspan="2">Tổng cộng</td>

            <td class="text-center"></td>
            {{-- <td class="text-center">{{ dinhdangso($model->sum('tongtotrinh')) }}</td> --}}

            <td class="text-center">{{ dinhdangso($model->sum('tongtotrinh_tapthe')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('tongtotrinh_canhan')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('tongtotrinh_tapthe_kt')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('tongtotrinh_canhan_kt')) }}</td>

            <td class="text-center">{{ dinhdangso($model->sum('tongso_tapthe_cotr')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('canhan_lada_cotr')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('canhan_pp_cotr')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('canhan_lado_cotr')) }}</td>

            <td class="text-center">{{ dinhdangso($model->sum('tongso_tapthe_cd')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('canhan_lada_cd')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('canhan_pp_cd')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('canhan_lado_cd')) }}</td>

            <td class="text-center">{{ dinhdangso($model->sum('tongso_tapthe_dx')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('tongso_canhan_dx')) }}</td>

            <td class="text-center">{{ dinhdangso($model->sum('tongso_tapthe_dongo')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('tongso_canhan_dongo')) }}</td>

            <td class="text-center">{{ dinhdangso($model->sum('tongso_tapthe_dn')) }}</td>
            <td class="text-center">{{ dinhdangso($model->sum('tongso_canhan_dn')) }}</td>
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
