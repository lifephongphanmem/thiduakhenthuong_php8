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
                <h4> THÔNG TIN PHONG TRÀO THI ĐUA KHEN THƯỞNG</h4>
            </td>
        </tr>
    </table>

    <table id="data_body" class="money" cellspacing="0" cellpadding="0" border="1"
        style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
        <thead>
            <tr class="text-center">
                <th width="2%">STT</th>
                <th>Nội dung phong trào</th>
                <th>Loại hình khen thưởng</th>
                <th>Ngày quyết định</th>
                <th>Phạm vi phát động</th>
                <th>Hình thức tổ chức</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        @foreach ($model as $key => $tt)
            <tr>
                <td style="text-align: center">{{ $i++ }}</td>
                <td class="active">{{ $tt->noidung }}</td>
                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                <td class="text-center">{{ getDayVn($tt->ngayqd) }}</td>
                <td>{{ $a_phamvi[$tt->phamviapdung] ?? '' }}</td>
                <td>{{ $a_phanloai[$tt->phanloai] ?? '' }}</td>
                <td>{{ getDayVn($tt->tungay) }}</td>
                <td>{{ getDayVn($tt->denngay) }}</td>
                <td>{{ getTenTrangThaiPT($tt->trangthai) }}</td>
            </tr>
        @endforeach
    </table>


    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%">…………, Ngày…...tháng……năm……</td>
        </tr>
        <tr>
            <td>Người lập biểu</td>
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
