{{-- @if ($tt->trangthai == 'CC')
    <td align="center">
        <span class="badge badge-warning">Chờ chuyển</span>
    </td>
@elseif($tt->trangthai == 'CD')
    <td align="center">
        <span class="badge badge-info">Chờ duyệt</span>
        <br><span class="text-bold">{{ getDayVn($tt->thoigian) }}</span>
    </td>
@elseif($tt->trangthai == 'BTL')
    <td align="center">
        <span class="badge badge-danger">Bị trả<br>lại</span>
    </td>
@elseif($tt->trangthai == 'BTLXD')
    <td align="center">
        <span class="badge badge-danger">Trả lại<br>xét duyệt</span>
    </td>
@elseif($tt->trangthai == 'CNXKT')
    <td align="center"><span class="badge badge-warning">Chờ nhận để xét khen thưởng</span>
        <br>Thời gian chuyển:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@elseif($tt->trangthai == 'CXKT')
    <td align="center"><span class="badge badge-warning">Chờ xét<br>khen thưởng</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@elseif($tt->trangthai == 'DKT')
    <td align="center">
        <span class="badge badge-success">Đã khen<br>thưởng</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->ngayqd ?? '') }}</b>
    </td>
@elseif($tt->trangthai == 'DXKT')
    <td align="center"><span class="badge badge-warning">Đang xét<br>khen thưởng</span>
    </td>
@else
    <td align="center">
        <span class="badge badge-success">Đã duyệt</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@endif --}}

<?php $a_trangthai_td = getTrangThai_TD_HoSo($tt->trangthai); ?>
@switch($tt->trangthai)
    @case('CC')
    @case('CXD')

    @case('KHS')
    @case('CD')

    @case('BTL')
    @case('BTLXD')
        <td align="center">
            <span class="{{ $a_trangthai_td['class'] }}">{!! $a_trangthai_td['trangthai'] !!}</span>
        </td>
    @break

    @case('CNXKT')
    @case('CXKT')

    @case('DTN')
    @case('DKT')

    @case('DXKT')
    @case('DDK')

    @case('KDK')
    @case('DD')

    @case('DTH')
        <td align="center">
            <span class="{{ $a_trangthai_td['class'] }}">{!! $a_trangthai_td['trangthai'] !!}</span>
            <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
        </td>
    @break

    @case('DCCVXD')
        <td align="center">
            <span class="{{ $a_trangthai_td['class'] }}">{!! $a_trangthai_td['trangthai'] !!}</span>
            {{-- <br>Chuyên viên:<br><b>{{ $tt->tendangnhap_xd }}</b> --}}
        </td>
    @break

    @case('DCCVKT')
        <td align="center">
            <span class="{{ $a_trangthai_td['class'] }}">{!! $a_trangthai_td['trangthai'] !!}</span>
            {{-- <br>Chuyên viên:<br><b>{{ $tt->tendangnhap_kt }}</b> --}}
        </td>
    @break

    @default
        <td align="center">
            <span class="badge badge-info">{{ $tt->trangthai }}</span>
        </td>
@endswitch
