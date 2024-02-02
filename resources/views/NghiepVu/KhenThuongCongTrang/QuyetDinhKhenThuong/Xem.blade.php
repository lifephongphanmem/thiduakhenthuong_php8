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
                <h4> THÔNG TIN HỒ SƠ PHÊ DUYỆT KHEN THƯỞNG CÔNG TRẠNG VÀ THÀNH TÍCH </h4>
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
        <table id="data_body1" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th width="5%">STT</th>
                    <th>Tên tập thể</th>
                    <th>Phân loại tập thể</th>
                    <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                    <th>Kết quả</br>khen thưởng</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_tapthe as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $tt->tentapthe }}</td>
                    <td>{{ $a_phanloaidt[$tt->maphanloaitapthe] ?? '' }}</td>
                    <td>{{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}</td>
                    {{-- <td>{{ $a_danhhieutd[$tt->madanhhieutd] ?? '' }}</td> --}}
                    <td class="text-center">{{ $tt->ketqua == '1' ? 'Có' : 'Không' }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    @if (isset($model_hogiadinh)&&count($model_hogiadinh) > 0)
        <p style="text-left: center; font-size: 18px;">Thông tin khen thưởng hộ gia đình</p>
        <table id="data_body3" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th width="10%">STT</th>
                    <th>Tên hộ gia đình</th>
                    <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_hogiadinh as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $tt->tentapthe }}</td>
                    <td>{{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    @if (count($model_canhan) > 0)
        <p style="text-left: center; font-size: 18px;">Thông tin khen thưởng cá nhân</p>
        <table id="data_body2" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th width="5%">STT</th>
                    <th>Tên đối tượng</th>
                    <th>Phân loại cán bộ</th>
                    <th>Thông tin công tác</th>
                    <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                    <th>Kết quả</br>khen thưởng</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_canhan as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $tt->tendoituong }}</td>
                    <td>{{ $a_phanloaidt[$tt->maphanloaicanbo] ?? '' }}</td>
                    <td>{{ $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}</td>
                    <td>{{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}</td>
                    {{-- <td>{{ $a_danhhieutd[$tt->madanhhieutd] ?? '' }}</td> --}}
                    <td class="text-center">{{ $tt->ketqua == '1' ? 'Có' : 'Không' }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    @if (isset($model_detai)&& count($model_detai) > 0)
        <p style="text-left: center; font-size: 18px;">Thông tin đề tài sáng kiến</p>
        <table id="data_body2" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th width="10%">STT</th>
                    <th>Tên đề tài, sáng kiến</th>
                    <th>Thông tin tác giả</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_detai as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $tt->tensangkien }}</td>
                    <td>{{ $tt->tendoituong . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}</td>
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
