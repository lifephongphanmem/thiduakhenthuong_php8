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
                <h4> THÔNG TIN HỒ SƠ PHÊ DUYỆT KHEN THƯỞNG </h4>
            </td>
        </tr>
    </table>

    <table id="data_body" class="money" cellspacing="0" cellpadding="0" border="0"
        style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
        <tr>
            <td class="text-left" width="15%">Tên đơn vị: {{ $m_donvi->tendonvi }}</td>
        </tr>
        <tr>
            <td>Loại hình khen thưởng: {{ $a_loaihinhkt[$model->maloaihinhkt] ?? '' }}</td>
        </tr>
        {{-- <tr>
            <td>Tên phong trào thi đua: {{ $model->tenphongtraotd }}</td>
        </tr> --}}
        <tr>
            <td>Số tờ trình: {{ $model->sototrinh }}</td>
        </tr>
        <tr>
            <td>Ngày tháng trình: {{ getDayVn($model->ngayhoso) }}</td>
        </tr>
        <tr>
            <td>Mô tả hồ sơ: {{ $model->noidung }}</td>
        </tr>


        <tr>
            <td>Tên đơn vị quyết định khen thưởng: {{ $model->tendvcqhienthi }}</td>
        </tr>
        <tr>
            <td>Cấp độ khen thưởng: {{ getPhamViApDung()[$model->capkhenthuong] ?? $model->capkhenthuong }}</td>
        </tr>
        <tr>
            <td>Số quyết định: {{ $model->soqd }}</td>
        </tr>
        <tr>
            <td>Ngày ra quyết định: {{ getDayVn($model->ngayqd) }}</td>
        </tr>
        <tr>
            <td>Chức vụ người ký: {{ $model->chucvunguoikyqd }}</td>
        </tr>
        <tr>
            <td>Họ tên người ký: {{ $model->hotennguoikyqd }}</td>
        </tr>
    </table>


    
    @if (count($model_tapthe) > 0)
        <p style="text-left: center; font-size: 18px;">Thông tin khen thưởng tập thể</p>
        <table id="data_body2" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <tr class="text-center">
                        <th width="5%">STT</th>
                        <th>Tên tập thể</th>
                        <th>Phân loại<br>đối tượng</th>
                        <th>Danh hiệu thi đua/<br>Hình thức khen thưởng </th>
                        <th>Loại hình khen thưởng</th>
                        <th>Kết quả<br>khen thưởng</th>
                        <th>Lý do không khen/</br>Nội dung khen thưởng</th>
                        <th width="10%">Thao tác</th>
                    </tr>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_tapthe as $key => $tt)
            <tr class="odd gradeX">
                <td class="text-center">{{ $i++ }}</td>
                <td>{{ $tt->tentapthe }}</td>
                <td>{{ $a_tapthe[$tt->maphanloaitapthe] ?? '' }}</td>
                <td class="text-center">
                    {{ $a_dhkt_tapthe[$tt->madanhhieukhenthuong] ?? '' }}
                </td>
                <td class="text-center">
                    {{ $a_loaihinhkt[$model->maloaihinhkt] ?? '' }}
                </td>
                @if ($tt->ketqua == 1)
                    <td class="text-center">
                        <a class="btn btn-sm btn-clean btn-icon">
                            <i class="icon-lg la fa-check text-primary icon-2x"></i>
                        </a>
                    @else
                    <td class="text-center">
                        <a class="btn btn-sm btn-clean btn-icon">
                            <i
                                class="icon-lg la fa-times-circle text-danger icon-2x"></i>
                        </a>
                    </td>
                @endif
                <td>{{ $tt->noidungkhenthuong }}</td>
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
