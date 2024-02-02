@if ($tt->trangthai == 'CC')
    <td align="center"><span class="badge badge-success">Nhận<br>hồ sơ</span></td>
@elseif ($tt->trangthai == 'CXKT')
    <td align="center"><span class="badge badge-info">Chờ khen<br>thưởng</span></td>
@elseif ($tt->trangthai == 'DXKT')
    <td align="center"><span class="badge badge-primary">Xét khen<br>thưởng</span></td>
@else
    <td align="center">
        <span class="badge badge-success">Đã<br>kết thúc</span>
    </td>
@endif
