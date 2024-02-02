@extends('BaoCao.main_baocao')

@section('content')
    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td colspan="2" style="font-weight: bold;">
                <h4> THÔNG TIN KẾT QUẢ TÌM KIẾM KẾT QUẢ KHEN THƯỞNG CHO TẬP THỂ</h4>
            </td>
        </tr>
    </table>



    @if (count($model_khenthuong) > 0)
        <p style="text-left: center; font-size: 18px;">Danh sách khen thưởng</p>
        <table id="data_body1" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th rowspan="2" width="5%">STT</th>
                    <th rowspan="2" width="8%">Tờ trình</th>
                    <th colspan="2">Quyết định</th>
                    <th rowspan="2" width="15%">Tên tập thể</th>
                    <th rowspan="2">Phân loại đối tượng</th>
                    <th rowspan="2">Lĩnh vực hoạt động</th>
                    <th rowspan="2">Danh hiệu thi đua</br>/Hình thức khen thưởng</th>
                    <th rowspan="2">Loại hình khen thưởng</th>

                </tr>
                <tr class="text-center">
                    <th width="8%">Số quyết định</th>
                    <th width="10%">Cấp độ khen thưởng</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($model_khenthuong as $key => $tt)
                    <tr class="odd gradeX">
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">Số: {{ $tt->sototrinh }}</br> ngày {{ getDayVn($tt->ngayhoso) }}
                        </td>
                        <td class="text-center">Số: {{ $tt->soqd }} </br> ngày {{ getDayVn($tt->ngayqd) }}
                        </td>
                        <td class="text-center">{{ $phamvi[$tt->capkhenthuong] ?? $tt->capkhenthuong }}</td>
                        <td>{{ $tt->tentapthe }}</td>
                        <td>{{ $a_tapthe[$tt->maphanloaitapthe] ?? '' }}</td>
                        <td>{{ $a_linhvuc[$tt->linhvuchoatdong] ?? $tt->linhvuchoatdong }}</td>
                        <td>{{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}</td>
                        <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- <table id="data_footer" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:20px auto; text-align: center;">
        <tr>
            <td style="text-align: left;" width="50%"></td>
            <td style="text-align: center; font-style: italic" width="50%">
                {{ $m_donvi->diadanh . ', ' . Date2Str($model->ngayhoso) }}</td>
        </tr>
        <tr style="font-weight: bold">
            <td style="text-align: center;" width="50%">Người lập biểu</td>
            <td style="text-align: center;" width="50%">{{ $m_donvi->cdlanhdao }}</td>
        </tr>
        <tr style="font-style: italic">
            <td style="text-align: center;" width="50%">(Ghi rõ họ tên)</td>
            <td style="text-align: center;" width="50%">(Ký tên, đóng dấu)</td>
        </tr>
        <tr>
            <td style="border-top: 100px"></td>
        </tr>

        <tr>
            <td style="text-align: center;" width="50%">{{ $m_donvi->nguoilapbieu }}</td>
            <td style="text-align: center;" width="50%">{{ $m_donvi->lanhdao }}</td>
        </tr>
    </table> --}}
@stop
