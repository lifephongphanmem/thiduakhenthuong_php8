@extends('BaoCao.main_inphoi')

@section('content')
    @foreach ($model as $doituong)
        <img src="{{ url($m_donvi->phoi_giaykhen != '' ? '/data/uploads/' . $m_donvi->phoi_giaykhen : '/assets/media/phoi/GiayKhen1.jpg') }}"
            style="height: {{ $m_donvi->chieurong_giaykhen != '' ? $m_donvi->chieurong_giaykhen : '297' }}mm;width: {{ $m_donvi->dodai_giaykhen != '' ? $m_donvi->dodai_giaykhen : '420' }}mm;background-repeat: no-repeat;background-size: 100% 100%;>
            
        <table cellspacing="0"
            cellpadding="0" border="0"
            style="height: {{ $m_donvi->chieurong_giaykhen != '' ? $m_donvi->chieurong_giaykhen : '297' }}mm;width: {{ $m_donvi->dodai_giaykhen != '' ? $m_donvi->dodai_giaykhen : '420' }}mm;background-repeat: no-repeat;background-size: 100% 100%;">

        <tr>
            <td>
                <button style="{{ $doituong->toado_pldoituong }}" id="toado_pldoituong"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_pldoituong }}','{{ $doituong->pldoituong }}','{{ $doituong->mahosotdkt }}','toado_pldoituong')">
                    {!! $doituong->pldoituong !!}
                </button>
            </td>

            <td>
                <button style="{{ $doituong->toado_tendoituongin }}" id="toado_tendoituongin"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_tendoituongin }}','{{ $doituong->tendoituongin }}','{{ $doituong->mahosotdkt }}','toado_tendoituongin')">
                    {!! $doituong->tendoituongin !!}
                </button>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <button style="{{ $doituong->toado_chucvudoituong }}" id="toado_chucvudoituong"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_chucvudoituong }}','{{ $doituong->chucvudoituong }}','{{ $doituong->mahosotdkt }}','toado_chucvudoituong')">
                    {!! $doituong->chucvudoituong !!}
                </button>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <button style="{{ $doituong->toado_noidungkhenthuong }}" id="toado_noidungkhenthuong"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_noidungkhenthuong }}','{{ $doituong->noidungkhenthuong }}','{{ $doituong->mahosotdkt }}','toado_noidungkhenthuong')">
                    {!! $doituong->noidungkhenthuong !!}
                </button>
            </td>
        </tr>

        <tr>
            <td style="width: 60%;"></td>
            <td>
                <button style="{{ $doituong->toado_ngayqd }}" id="toado_ngayqd"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_ngayqd }}','{{ $doituong->ngayqd }}','{{ $doituong->mahosotdkt }}','toado_ngayqd')">
                    {!! $doituong->ngayqd !!}
                </button>
            </td>
        </tr>

        <tr>
            <td style="width: 50%;"></td>

            <td style="text-align: center">
                <button style="{{ $doituong->toado_chucvunguoikyqd }}" id="toado_chucvunguoikyqd"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_chucvunguoikyqd }}','{{ $doituong->chucvunguoikyqd }}','{{ $doituong->mahosotdkt }}','toado_chucvunguoikyqd')">
                    {{ $doituong->chucvunguoikyqd }}
                </button>
            </td>
        </tr>

        <tr>
            <td style="width: 50%;">
                <button style="{{ $doituong->toado_quyetdinh }}" id="toado_quyetdinh"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_quyetdinh }}','{{ $doituong->quyetdinh }}','{{ $doituong->mahosotdkt }}','toado_quyetdinh')">
                    {!! $doituong->quyetdinh !!}
                </button>
            </td>

            <td style="text-align: center">
                <button style="{{ $doituong->toado_hotennguoikyqd }}" id="toado_hotennguoikyqd"
                    ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_hotennguoikyqd }}','{{ $doituong->hotennguoikyqd }}','{{ $doituong->mahosotdkt }}','toado_hotennguoikyqd')">
                    {{ $doituong->hotennguoikyqd }}
                </button>
            </td>
        </tr>
        </table>
        {{-- <p style="page-break-before: always"> --}}
    @endforeach

@stop
