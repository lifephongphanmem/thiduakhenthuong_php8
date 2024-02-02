<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$pageTitle}}</title>
    <style type="text/css">
        body {
            font: normal 14px/16px time, serif;
        }

        table, p {
            width: 98%;
            /*margin: auto;*/
        }

        td, th {
            padding: 5px;
        }
        p{
            padding: 5px;
        }
        span{
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>
<body style="font:normal 14px Times, serif;">
<table class="header" width="96%" border="0" cellspacing="0" cellpadding="8" style="margin:0 auto 25px; text-align: center;">

    <tr>
        <td style="text-align: left;width: 60%">
            <b>Đơn vị: {{$m_donvi['tendonvi']}}</b>
        </td>
        <td style="text-align: center; font-style: italic">

        </td>
    </tr>
    <tr>
        <td style="text-align: left;width: 60%">
            <b>Mã đơn vị SDNS: {{$m_donvi->maqhns}}</b>
        </td>

        <td style="text-align: center; font-style: italic">

        </td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: center; font-weight: bold; font-size: 20px;text-transform: uppercase">
            DANH SÁCH Khen thưởng của {{$model->tentapthe}}
        </td>
    </tr>

        <tr>
            <td colspan="2" style="text-align: center; font-style: italic">
                Từ ngày: {{getDayVn($inputs['ngaytu'])}} đến ngày: {{getDayVn($inputs['ngayden'])}}
            </td>
        </tr>

</table>

<table id="data_body1" class="money" cellspacing="0" cellpadding="0" border="1"
style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
<thead>
    <tr class="text-center">
        <th rowspan="2" width="5%">STT</th>
        <th colspan="3">Quyết định</th>
        <th colspan="2">Tờ trình</th>
        <th rowspan="2">Tên cơ quan, tập thể</th>
        <th rowspan="2">Phân loại cơ quan, tập thể</th>
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
<tbody>
    <?php $i = 1; ?>
    @foreach ($model_khenthuong as $key => $tt)
        <tr class="odd gradeX">
            <td class="text-center">{{ $i++ }}</td>
            <td class="text-center">{{ $tt->soqd }}</td>
            <td class="text-center">{{ getDayVn($tt->ngayqd) }}</td>
            <td class="text-center">{{ $tt->capkhenthuong }}</td>
            <td class="text-center">{{ $tt->sototrinh }}</td>
            <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
            <td>{{ $tt->tentapthe }}</td>
            <td>{{ $a_canhan[$tt->maphanloaitapthe] ?? '' }}</td>
            <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
            <td class="text-center">{{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}</td>
        </tr>
    @endforeach
</tbody>
</table>

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%">&nbsp;</td>
            <td style="width: 50%">…………, Ngày…...tháng……năm……</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Họ và tên người lập</td>
        </tr>

        <tr>
            <td>
                <br><br><br><br>
            </td>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <p style="page-break-before: always">

</body>
</html>