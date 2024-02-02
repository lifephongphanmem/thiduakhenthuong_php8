@extends('BaoCao.main_inphoi')

@section('content')
    @foreach ($model as $doituong)
        {{-- <table cellspacing="0" cellpadding="0" border="0" background="{{ url('/assets/media/phoi/GiayKhen1.jpg') }}"
            style="height: 297mm;width: 420mm;background-repeat: no-repeat;background-size: 100% 105%;"> --}}
            <table cellspacing="0" cellpadding="0" border="0" background="{{  url( $m_donvi->phoi_giaykhen != '' ?('/data/uploads/'. $m_donvi->phoi_giaykhen) :'/assets/media/phoi/GiayKhen1.jpg') }}"
                style="height: 297mm;width: 420mm;background-repeat: no-repeat;background-size: 100% 105%;">
                {{-- style="height: {{$m_donvi->chieurong_giaykhen != '' ? $m_donvi->chieurong_giaykhen : '210mm'}};width: {{$m_donvi->chieudai_giaykhen != '' ? $m_donvi->chieudai_giaykhen : '297mm'}};background-repeat: no-repeat;background-size: 100% 100%;"> --}}
    
            <tr>
                <td colspan="2">
                    <label style="{{ $doituong->toado_tendoituongin }}" id="toado_tendoituongin"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_tendoituongin }}','{{ $doituong->tendoituongin }}','{{ $doituong->mahosotdkt }}','toado_tendoituongin')">
                        {{ $doituong->tendoituongin }}
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
                {{-- <td colspan="2">
                    <button style="{{ $doituong->toado_noidungkhenthuong }}" id="toado_noidungkhenthuong"
                        ondblclick="setNoiDung('{{ $doituong->id }}','{{ $doituong->toado_noidungkhenthuong }}','{{ $doituong->noidungkhenthuong }}','{{ $doituong->mahosotdkt }}','toado_noidungkhenthuong')">
                        {!! $doituong->noidungkhenthuong !!}
                    </button>
                </td> --}}
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
                <td style="width: 50%;"></td>

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
