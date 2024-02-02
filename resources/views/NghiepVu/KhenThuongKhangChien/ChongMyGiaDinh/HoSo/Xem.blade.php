@extends('BaoCao.main_baocao')

@section('content')
    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td style="text-align: left;width: 60%">
                <b>{{ $m_donvi->tendvcqhienthi }}</b>
            </td>

            <td style="text-align: center; font-weight: bold">
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                <b>{{ $m_donvi->tendvhienthi }}</b>
            </td>

            <td style="text-align: center; font-style: italic">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">
                <h4> THÔNG TIN HỒ SƠ KHEN THƯỞNG KHÁNG CHIẾN CHỐNG MỸ CHO HỘ GIA ĐÌNH </h4>
            </td>
        </tr>
    </table>

    <table id="data_body" class="money" cellspacing="0" cellpadding="0" border="0"
        style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
        <tr>
            <td class="text-left" width="15%">Tên đơn vị nhập liệu: {{ $m_donvi->tendonvi }}</td>
        </tr>        
        <tr>
            <td>Tên đối tượng: {{ $model->tendoituong }}</td>
        </tr>
        <tr>
            <td>Ngày tháng năm sinh: {{  getDayVn($model->namsinh) }}</td>
        </tr>
        <tr>
            <td>Chính quán: {{ $model->chinhquan }}</td>
        </tr>
        <tr>
            <td>Chỗ ở hiện nay: {{ $model->noio }}</td>
        </tr>
        <tr>
            <td>Thời gian tham gia kháng chiến: {{ $model->tgiantgkc }}</td>
        </tr>
        <tr>
            <td>Thời gian kháng chiến quy đổi: {{ $model->tgiankcqd }}</td>
        </tr>
        <tr>
            <td>Loại hình khen thưởng: {{ $a_loaihinhkt[$model->maloaihinhkt] ?? '' }}</td>
        </tr>
        <tr>
            <td>Hình thức khen thưởng: {{ $a_hinhthuckt[$model->mahinhthuckt] ?? '' }}</td>
        </tr>           
        <tr>
            <td>Nơi trình khen thưởng: {{ $model->noitrinhkt }}</td>
        </tr>
        <tr>
            <td>Loại hồ sơ kháng chiến: {{ $model->loaihosokc }}</td>
        </tr>
        <tr>
            <td>Mô tả hồ sơ: {{ $model->noidung }}</td>
        </tr>
        <tr>
            <td>Số quyết định: {{ $model->soqd }}</td>
        </tr>
        <tr>
            <td>Ngày quyết định: {{  getDayVn($model->ngayqd) }}</td>
        </tr>
    </table>
    

    <table id="data_footer" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
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
    </table>
@stop
