

<?php $a_trangthai_td = getTrangThai_TD_HoSo($tt->trangthai); ?>
@switch($tt->trangthai)
    @case('CC')
    @case('CXD')
    @case('KHS')
    @case('CD')
    @case('BTL')
    @case('CNXKT')
    @case('CXKT')
    @case('DTN')
    @case('DKT')
    @case('DXKT')
    @case('DD')
    @case('BTLXD')
    <td align="center">
        <span class="{{ $a_trangthai_td['class'] }}">{!! $a_trangthai_td['trangthai'] !!}</span>
    </td>
@break
    @break
    @default
        <td align="center">
            <span class="badge badge-info">{{$tt->trangthai}}</span>
        </td>
@endswitch
