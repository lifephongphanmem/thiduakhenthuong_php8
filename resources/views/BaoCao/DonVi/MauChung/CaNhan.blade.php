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
        <h4> THÔNG TIN THI ĐUA KHEN THƯỞNG CỦA CÁN BỘ</h4>
    </td>
</tr>
</table>

    <table id="data_body" class="money" cellspacing="0" cellpadding="0" border="0"
        style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
        
        <tr>
            <td>Họ và tên: {{ $model->tendoituong }}</td>
        </tr>

        <tr>
            <td>Ngày sinh: {{ getDayVn($model->ngaysinh) }}</td>
        </tr>

        <tr>
            <td>Giới tính: {{ $model->gioitinh == 'NAM' ? 'Nam' : 'Nữ' }}</td>
        </tr>

        <tr>
            <td>Chức vụ (chức danh): {{ $model->chucvu }}</td>
        </tr>

        <tr>
            <td>Phân loại cán bộ: {{ $model->maphanloaicanhan}}</td>
        </tr>

        <tr>
            <td>Phòng ban làm việc: {{ $model->tenphongban}}</td>
        </tr>

        <tr>
            <td>Đơn vị làm việc: {{ $model->tencoquan}}</td>
        </tr>
    </table>

    @if (count($model_khenthuong) > 0)
        <p style="text-left: center; font-size: 18px;">Thông tin kết quả thi đua khen thưởng của cán bộ từ
            {{ getDayVn($inputs['ngaytu']) }} đến {{ getDayVn($inputs['ngayden']) }}</p>
        <table id="data_body1" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th rowspan="2" width="5%">STT</th>
                    <th colspan="3">Quyết định</th>
                    <th colspan="2">Tờ trình</th>
                    <th rowspan="2">Họ tên cán bộ</th>
                    <th rowspan="2">Phân loại cán bộ</th>
                    <th rowspan="2">Thông tin công tác</th>
                    <th rowspan="2">Loại hình khen thưởng</th>
                    <th rowspan="2">Danh hiệu thi đua/<br>Hình thức khen thưởng</th>

                </tr>
                <tr class="text-center">
                    <th>Số QĐ</th>
                    <th>Ngày tháng</th>
                    <th>Cấp độ</th>
                    <th>Số TT</th>
                    <th>Ngày tháng</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_khenthuong as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center">{{ $tt->soqd }}</td>
                    <td class="text-center">{{ getDayVn($tt->ngayqd) }}</td>
                    <td class="text-center">{{ $tt->capkhenthuong }}</td>
                    <td class="text-center">{{ $tt->sototrinh }}</td>
                    <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                    <td>{{ $tt->tendoituong }}</td>
                    <td>{{ $a_canhan[$tt->maphanloaicanbo] ?? '' }}</td>
                    <td>{{ $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}</td>
                    <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                    <td class="text-center">{{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%">&nbsp;</td>
            <td style="width: 50%">…………, Ngày…...tháng……năm……</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Họ và tên cán bộ</td>
        </tr>

        <tr>
            <td>
                <br><br><br><br>
            </td>
        <tr>
            <td>&nbsp;</td>
            <td>{{ $model->tendoituong }}</td>
        </tr>
    </table>
@stop
