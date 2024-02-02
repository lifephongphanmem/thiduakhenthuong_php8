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
                <h4> THÔNG TIN PHONG TRÀO THI ĐUA </h4>
            </td>
        </tr>
    </table>

    <table id="data_body" class="money" cellspacing="0" cellpadding="0" border="0"
        style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
        <tr>
            <td class="text-left" width="15%">Tên đơn vị: {{ $m_donvi->tendonvi }}</td>
        </tr>
        {{-- <tr>
            <td>Hình thức tổ chức: {{ $a_phanloai[$model->phanloai] ?? '' }}</td>
        </tr> --}}
        <tr>
            <td>Phạm vi phát động: {{ $a_phamvi[$model->phamviapdung] ?? '' }}</td>
        </tr>
        <tr>
            <td>Số văn bản: {{ $model->soqd }} </td>
        </tr>
        <tr>
            <td>Ngày ban hành: {{ getDayVn($model->ngayqd) }} </td>
        </tr>
        <tr>
            <td>Ngày bắt đầu nhận hồ sơ tham gia: {{ getDayVn($model->tungay) }}</td>
        </tr>
        <tr>
            <td>Ngày kết thúc nhận hồ sơ tham gia: {{ getDayVn($model->denngay) }}</td>
        </tr>
        <tr>
            <td>Tên phong trào: {{ $model->noidung }}</td>
        </tr>
        <tr>
            <td>Nội dung phong trào: {{ $model->khauhieu }}</td>
        </tr>
    </table>

    @if (count($model_tieuchi) > 0)
        <p style="text-left: center; font-size: 18px;">Thông tin tiêu chí xét khen thưởng</p>
        <table id="data_body1" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th width="5%">STT</th>
                    <th>Đối tượng áp dụng</th>
                    <th>Tên tiêu chuẩn xét khen thưởng</th>
                    <th width="25%">Mở rộng tiêu chuẩn</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_tieuchi as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{$a_phanloaidt[$tt->phanloaidoituong] ?? $tt->phanloaidoituong}}</td>
                    <td>{{ $tt->tentieuchuandhtd }}</td>
                    <td>{{ $tt->ghichu }}</td>
                </tr>
            @endforeach
        </table>
    @endif    

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
