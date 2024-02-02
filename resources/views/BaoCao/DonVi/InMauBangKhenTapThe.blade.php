@extends('BaoCao.main_inphoi')

@section('content')
    @foreach ($model as $doituong)
        <img src="{{ url($m_donvi->phoi_bangkhen != '' ? '/data/uploads/' . $m_donvi->phoi_bangkhen : '/assets/media/phoi/bangkhen.png') }}"
            style="height: {{ $m_donvi->chieurong_bangkhen != '' ? $m_donvi->chieurong_bangkhen : '297' }}mm;width: {{ $m_donvi->chieudai_bangkhen != '' ? $m_donvi->chieudai_bangkhen : '420' }}mm;background-repeat: no-repeat;background-size: 100% 100%;" />
        <table cellspacing="0" cellpadding="0" border="0"
            style="height: {{ $m_donvi->chieurong_bangkhen != '' ? $m_donvi->chieurong_bangkhen : '297' }}mm;width: {{ $m_donvi->chieudai_bangkhen != '' ? $m_donvi->chieudai_bangkhen : '420' }}mm;background-repeat: no-repeat;background-size: 100% 100%;">

            <tr>
                <td>
                    <label style="{{ $doituong->toado_pldoituong }}" id="toado_pldoituong"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_pldoituong }}','{{ $doituong->pldoituong }}','{{ $doituong->mahosotdkt }}','toado_pldoituong')">
                        {{ $doituong->pldoituong }}
                    </label>
                </td>

                <td>
                    <label style="{{ $doituong->toado_tendoituongin }}" id="toado_tendoituongin"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_tendoituongin }}','{{ $doituong->tendoituongin }}','{{ $doituong->mahosotdkt }}','toado_tendoituongin')">
                        {{ $doituong->tendoituongin }}
                    </label>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label style="{{ $doituong->toado_chucvudoituong }}" id="toado_chucvudoituong"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_chucvudoituong }}','{{ $doituong->chucvudoituong }}','{{ $doituong->mahosotdkt }}','toado_chucvudoituong')">
                        {!! $doituong->chucvudoituong !!}
                    </label>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label style="{{ $doituong->toado_noidungkhenthuong }}" id="toado_noidungkhenthuong"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_noidungkhenthuong }}','{{ $doituong->noidungkhenthuong }}','{{ $doituong->mahosotdkt }}','toado_noidungkhenthuong')">
                        {!! $doituong->noidungkhenthuong !!}
                    </label>
                </td>
            </tr>

            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <label style="{{ $doituong->toado_ngayqd }}" id="toado_ngayqd"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_ngayqd }}','{{ $doituong->ngayqd }}','{{ $doituong->mahosotdkt }}','toado_ngayqd')">
                        {!! $doituong->ngayqd !!}
                    </label>
                </td>
            </tr>

            <tr>
                <td style="width: 50%;"></td>

                <td style="text-align: center">
                    <label style="{{ $doituong->toado_chucvunguoikyqd }}" id="toado_chucvunguoikyqd"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_chucvunguoikyqd }}','{{ $doituong->chucvunguoikyqd }}','{{ $doituong->mahosotdkt }}','toado_chucvunguoikyqd')">
                        {{ $doituong->chucvunguoikyqd }}
                    </label>
                </td>
            </tr>

            <tr>
                <td style="width: 50%;">
                    <label style="{{ $doituong->toado_quyetdinh }}" style="" id="toado_quyetdinh"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_quyetdinh }}','{{ $doituong->quyetdinh }}','{{ $doituong->mahosotdkt }}','toado_quyetdinh')">
                        {!! $doituong->quyetdinh !!}
                    </label>
                </td>

                <td style="text-align: center">
                    <label style="{{ $doituong->toado_hotennguoikyqd }}" style="" id="toado_hotennguoikyqd"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_hotennguoikyqd }}','{{ $doituong->hotennguoikyqd }}','{{ $doituong->mahosotdkt }}','toado_hotennguoikyqd')">
                        {{ $doituong->hotennguoikyqd }}
                    </label>
                </td>
            </tr>
        </table>
        {{-- <p style="page-break-before: always"> --}}
    @endforeach

@stop
