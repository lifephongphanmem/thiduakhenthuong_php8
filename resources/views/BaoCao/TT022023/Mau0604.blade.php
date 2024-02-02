@extends('HeThong.main_baocao')

@section('content')

    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;font-size:12px">
        <tr>
            <td style="text-align: left;width: 60%">
               <b> Biểu số: 0604.N/BNV-TĐKT</b>
            </td>
            <td style="text-align: center;">
                Đơn vị báo cáo:
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                Ban hành theo Thông tư số 2/2023/TT-BNV ngày 23/3/2023
            </td>
            <td style="text-align: center;">
            </td>
        </tr>
        {{-- <tr>
            <td style="text-align: left;width: 60%">
                Ngày nhận báo cáo:<br/>
                Ngày 15 tháng 12 năm báo cáo
                
            </td>
            <td style="text-align: center; font-style: italic">
               
            </td>
        </tr> --}}
    </table>
    <p id="data_body" style="text-align: center; font-weight: bold; font-size: 20px;">SỐ LƯỢNG TỔ CHỨC LÀM CÔNG TÁC THI ĐUA, KHEN THƯỞNG CỦA BỘ, BAN, NGÀNH, ĐOÀN THỂ TRUNG ƯƠNG, TỈNH, THÀNH PHỐ TRỰC THUỘC TRUNG ƯƠNG </p>
    {{-- <p id="data_body1" style="text-align: center; font-style: italic">(Ban hành kèm theo Thông tư số 67/2017/TT-BTC)</p> --}}
    <p id="data_body1" style="text-align: center; font-style: italic">Năm...</p>
    {{-- <p id="data_body2" style="text-align: right; font-style: italic">Đơn vị tính: Phong trào</p> --}}
    <table id="data_body3" cellspacing="0" cellpadding="0" border="1"
        style="margin: 20px auto; border-collapse: collapse;">
        <tr style="padding-left: 2px;padding-right: 2px">
            <th style="width: 10%;padding-left: 2px;padding-right: 2px"></th>
            <th style="width:2%">Mã số </th>
            <th style="width:2%">Đơn vị tính </th>
            <th style="width: 2%;padding-left: 2px;padding-right: 2px">Số lượng</th>

        </tr>


        <tr style="font-weight: bold;text-align:center">
            <td>A</td>
            <td>B</td>
            <td>C</td>
            <td>1</td>
        </tr>
        <tr style="font-weight: bold;text-align:left">
            <td  style="text-align:left">Tổng số</td>
            <td style="text-align:center">01</td>
            <td style="text-align:center">Tổ chức</td>
            <td></td>
                          
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">Chia theo cơ cấu tổ chức bộ máy</td>
            <td></td>
            <td></td>
            <td></td>
               
        </tr>
        <tr>
            <td style="text-align:left">- Cấp Vụ thuộc bộ, ban, ngành, đoàn thể Trung ương</td>
            <td style="text-align:center">02</td>
            <td style="text-align:center">Vụ</td>
            <td ></td>            
        <tr>
            <td style="text-align:left">- Cấp phòng, ban hoặc bộ phận thuộc Vụ</td>
            <td style="text-align:center">03</td>
            <td style="text-align:center">Phòng</td>
            <td ></td>  
        </tr>
        <tr>
            <td style="text-align:left">- Cấp ban thuộc Sở Nội vụ
                </td>
            <td style="text-align:center">04</td>
            <td style="text-align:center">Ban</td>
            <td ></td> 
        </tr>
        <tr>
            <td style="text-align:left">- Cấp phòng thuộc Sở Nội vụ
                </td>
            <td style="text-align:center">05</td>
            <td style="text-align:center">Phòng</td>
            <td ></td>    
        </tr>    
    </table>
@stop
