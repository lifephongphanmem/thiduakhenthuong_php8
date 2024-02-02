@if ($tt->trangthaikt == 'CC')
    <td align="center">
        <span class="badge badge-warning">Chờ chuyển</span>
    </td>
@elseif($tt->trangthaikt == 'CD')
    <td align="center">
        <span class="badge badge-info">Chờ duyệt</span>
        <br><span class="text-bold">{{ getDayVn($tt->thoigian) }}</span>
    </td>
@elseif($tt->trangthaikt == 'BTL')
    <td align="center">
        <span class="badge badge-danger">Bị trả<br>lại</span>
    </td>
@elseif($tt->trangthaikt == 'BTLXD')
    <td align="center">
        <span class="badge badge-danger">Trả lại<br>xét duyệt</span>
    </td>
@elseif($tt->trangthaikt == 'CNXKT')
    <td align="center"><span class="badge badge-warning">Chờ nhận để xét khen thưởng</span>
        <br>Thời gian chuyển:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@elseif($tt->trangthaikt == 'CXKT')
    <td align="center"><span class="badge badge-warning">Chờ xét<br>khen thưởng</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@elseif($tt->trangthaikt == 'CXD')
    <td align="center"><span class="badge badge-warning">Chưa có</span>
    </td>
@elseif($tt->trangthaikt == 'DKT')
    <td align="center">
        <span class="badge badge-success">Đã khen<br>thưởng</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->ngayqd ?? '') }}</b>
    </td>
@elseif($tt->trangthaikt == 'DXKT')
    <td align="center"><span class="badge badge-warning">Đang xét<br>khen thưởng</span>
    </td>
@else
    <td align="center">
        <span class="badge badge-success">Đã duyệt</span>
        <br>Thời gian:<br><b>{{ getDayVn($tt->thoigian) }}</b>
    </td>
@endif
