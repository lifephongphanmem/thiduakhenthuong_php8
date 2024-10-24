<?php

use App\Models\DanhMuc\dmcoquandonvi;
use App\Models\DanhMuc\dmhinhthuckhenthuong;
use App\Models\DanhMuc\dscumkhoi_chitiet;
use App\Models\DanhMuc\dsdiaban;
use App\Models\DanhMuc\dsdonvi;
use App\Models\DanhMuc\dstaikhoan;
use App\Models\DanhMuc\dstaikhoan_phamvi;
use App\Models\HeThong\trangthaihoso;
use App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly;
use App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Models\ThongBao\taikhoan_nhanthongbao;
use App\Models\ThongBao\thongbao;
use App\Models\View\view_dscumkhoi;

use App\Models\View\viewdiabandonvi;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

// function getQuyetDinhCKE($maso)
// {
//     $a_qd = [];
//     $a_qd['QUYETDINH'] = "<figure class=&#34;table&#34;><table>
//             <tbody>
//                 <tr><td><strong>ỦY BAN NHÂN DÂN</strong></td><td><p style=&#34;text-align:center;&#34;><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></p></td></tr>
//                 <tr><td><strong>TỈNH QUẢNG BÌNH</strong></td><td><p style=&#34;text-align:center;&#34;><strong>Độc lập - Tự do - Hạnh phúc</strong></p></td></tr>
//                 <tr><td>Số: .....&nbsp;</td><td><p style=&#34;text-align:right;&#34;><i>Quảng Bình, ngày..... tháng ...... năm ........</i></p></td></tr>
//                 </tbody>
//             </table></figure>
//             <h2 style=&#34;text-align:center;&#34;><strong>QUYẾT ĐỊNH</strong></h2>
//             <h4 style=&#34;text-align:center;&#34;>[noidung]</h4>
//             <p style=&#34;text-align:center;&#34;><strong>CHỦ TỊCH ỦY BAN NHÂN DÂN TỈNH QUẢNG BÌNH</strong></p>
//             <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Luật Tổ chức Chính quyền địa phương ngày 19/6/2015;</p>
//             <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Luật Thi đua, Khen thưởng ngày 26/11/2003 và Luật sửa đổi, bổ sung một số Điều của Luật Thi đua, Khen thưởng ngày 16/11 /2013;</p>
//             <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Nghị định số 91/2017/NĐ-CP ngày 31/7/2017 của Chính phủ quy định chi tiết thi hành một số Điều của Luật thi đua, khen thưởng;</p>
//             <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Quyết định số 35/2019/QĐ-UBND ngày 11/11/2019 của UBND Tỉnh ban hành quy chế Quy chế Thi đua, khen thưởng Tỉnh Quảng Bình;</p>
//             <p style=&#34;margin-left:40px;text-align:justify;&#34;>Xét đề nghị của ………………………………………………………; đề nghị của Trưởng Ban Thi đua Khen thưởng tỉnh tại Tờ trình số ……….. &nbsp;ngày ………………….,&nbsp;</p>
//             <p style=&#34;margin-left:25px;text-align:center;&#34;><strong>QUYẾT ĐỊNH:</strong></p>
//             <p style=&#34;margin-left:25px;&#34;><strong>Điều 1.</strong></p>
//             <p style=&#34;margin-left:25px;&#34;><strong>Điều 2.</strong></p>
//             <figure class=&#34;table newpage&#34;><table class=&#34;table newpage&#34;>
//                 <tbody>
//                     <tr><td rowspan=&#34;4&#34;><p style=&#34;margin-left:25px;&#34;>Nơi nhận:</p><p style=&#34;margin-left:40px;&#34;>- Như điều 2</p><p style=&#34;margin-left:40px;&#34;>- Lưu VT, NC</p></td><td><p style=&#34;text-align:center;&#34;><strong>[chucvunguoiky]</strong></p></td></tr>
//                     <tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
//                     <tr><td><p style=&#34;text-align:center;&#34;><strong>[hotennguoiky]</strong></p></td></tr>
//                 </tbody></table></figure>
//                 <p>[sangtrangmoi]</p>
//                 <h3 style=&#34;margin-left:25px;text-align:center;&#34;>DANH SÁCH</h3>
//                 <p style=&#34;margin-left:25px;text-align:center;&#34;>(<i>Kèm theo quyết định số .... ngày .... tháng ..... năm..... của .....</i>)</p>
//                 <h4 style=&#34;margin-left:25px;&#34;>I. Cá nhân</h4>
//                 <p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>
//                 <h4 style=&#34;margin-left:25px;&#34;>II. Tập thể</h4>
//                 <p style=&#34;margin-left:25px;&#34;>[khenthuongtapthe]</p>
//                 <p style=&#34;margin-left:65px;&#34;>&nbsp;</p>";

//     return $a_qd[$maso];
// }

function setThongTinHoSo(&$inputs)
{
    switch ($inputs['trangthai']) {
            //Chờ xét khen thưởng =>tự động gán đơn vị xét duyệt
        case 'CXKT':
            //Đã xét khen thưởng
        case 'DKT': {
                $inputs['madonvi_nhan'] = $inputs['madonvi_xd'];
                $inputs['trangthai_xd'] = $inputs['trangthai'];
                $inputs['thoidiem_xd'] = $inputs['ngayhoso'];
                $inputs['madonvi_nhan_xd'] = $inputs['madonvi_kt'];
                $inputs['trangthai_kt'] = $inputs['trangthai'];
                $inputs['thoidiem_kt'] = $inputs['ngayhoso'];

                //Gán thông tin đơn vị khen thưởng
                $donvi_kt = App\Models\View\viewdiabandonvi::where('madonvi', $inputs['madonvi_kt'])->first();
                $inputs['capkhenthuong'] =  $donvi_kt->capdo ?? '';
                $inputs['donvikhenthuong'] =  $donvi_kt->tendvhienthi ?? '';
                break;
            }
    }
}

function setThongTinHoSoKT(&$inputs)
{
    //Khen thưởng tại đơn vị
    switch ($inputs['trangthai']) {
            //Chờ xét khen thưởng =>tự động gán đơn vị xét duyệt
        case 'CXKT':
            //Đã xét khen thưởng
        case 'DKT': {
                $inputs['madonvi_xd'] = $inputs['madonvi'];
                $inputs['madonvi_kt'] = $inputs['madonvi'];
                $inputs['madonvi_nhan'] = $inputs['madonvi'];
                $inputs['trangthai_xd'] = $inputs['trangthai'];
                $inputs['thoidiem_xd'] = $inputs['ngayhoso'];
                $inputs['madonvi_nhan_xd'] = $inputs['madonvi'];
                $inputs['trangthai_kt'] = $inputs['trangthai'];
                $inputs['thoidiem_kt'] = $inputs['ngayhoso'];
                $inputs['ngayqd'] = $inputs['ngayhoso'];

                //Gán thông tin đơn vị khen thưởng
                $donvi_kt = App\Models\View\viewdiabandonvi::where('madonvi', $inputs['madonvi_kt'])->first();
                $inputs['capkhenthuong'] =  $donvi_kt->capdo ?? '';
                //Nếu đơn vị tạo hồ sơ là đơn vị cấp T thì chỉ có Uỷ ban mới để khen thưởng cấp tỉnh còn lại là cấp SBN
                if ($inputs['capkhenthuong'] == 'T' && $inputs['madonvi'] != $donvi_kt->madonviQL) {
                    $inputs['capkhenthuong'] = 'SBN';
                }
                $inputs['donvikhenthuong'] =  $donvi_kt->tendvhienthi ?? '';
                break;
            }
    }
}

function setHuyKhenThuong(&$model, $inputs)
{
    $model->donvikhenthuong = null;
    $model->capkhenthuong = null;
    $model->soqd = null;
    $model->ngayqd = null;

    $model->chucvunguoikyqd = null;
    $model->hotennguoikyqd = null;
    $model->thongtinquyetdinh = null;

    $model->trangthai = $inputs['trangthai'];
    $model->trangthai_xd = $model->trangthai;
    $model->trangthai_kt = $model->trangthai;
    $model->thoigian_kt = null;
    $a_update = [
        'toado_tendoituongin' => '',
        'toado_noidungkhenthuong' => '',
        'toado_quyetdinh' => '',
        'toado_ngayqd' => '',
        'toado_chucvunguoikyqd' => '',
        'toado_hotennguoikyqd' => '',
        'toado_donvikhenthuong' => '',
        'toado_sokhenthuong' => '',
        'toado_chucvudoituong' => '',
        'toado_pldoituong' => '',

        'tendoituongin' => '',
        'noidungkhenthuong' => '',
        'quyetdinh' => '',
        'ngayqd' => '',
        'chucvunguoikyqd' => '',
        'hotennguoikyqd' => '',
        'donvikhenthuong' => '',
        'sokhenthuong' => '',
        'chucvudoituong' => '',
        'pldoituong' => '',
    ];

    App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->update($a_update);
    App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->update($a_update);
    App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->update($a_update);

    // 'toado_tendoituongin',
    // 'toado_noidungkhenthuong',
    // 'toado_quyetdinh',
    // 'toado_ngayqd',
    // 'toado_chucvunguoikyqd',
    // 'toado_hotennguoikyqd',
    // 'toado_donvikhenthuong',
    // 'toado_sokhenthuong',
    // 'toado_chucvudoituong',
    // 'toado_pldoituong',

    // 'tendoituongin',
    //'noidungkhenthuong'
    // 'quyetdinh',
    // 'ngayqd',
    // 'chucvunguoikyqd',
    // 'hotennguoikyqd',
    // 'donvikhenthuong',
    // 'sokhenthuong',
    // 'chucvudoituong',
    //'pldoituong'


    //dd($model);
    $model->save();
    trangthaihoso::create([
        'mahoso' => $inputs['mahosotdkt'],
        'phanloai' => 'dshosothiduakhenthuong',
        'trangthai' => $model->trangthai,
        'thoigian' => $inputs['thoigian'],
        'madonvi' => $inputs['madonvi'],
        'thongtin' => 'Hủy phê duyệt đề nghị khen thưởng.',
    ]);
}

function getHeThongChung()
{
    return  \App\Models\HeThong\hethongchung::all()->first() ?? new \App\Models\HeThong\hethongchung();
}

function getDanhHieuKhenThuong($capdo, $phanloai)
{
    $a_ketqua = [];
    /*
    Ngày 03/01/2022 Gộp 2 bảng dmdanhhieuthidua và dmhinhthuckhenthuong vào thành => dmhinhthuckhenthuong
    if ($capdo == 'ALL')
        $m_danhhieu = App\Models\DanhMuc\dmdanhhieuthidua::all();
    else {
        $m_danhhieu = App\Models\DanhMuc\dmdanhhieuthidua::where('phanloai', $phanloai)->get();
        // if ($phanloai == 'CANHAN')
        //     $m_danhhieu = App\Models\DanhMuc\dmdanhhieuthidua::where('phanloai', $phanloai)->get();
        // else {
        //     $m_danhhieu = App\Models\DanhMuc\dmdanhhieuthidua::where('phanloai', '<>', 'CANHAN')->get();
        // }
    }
    foreach ($m_danhhieu as $danhhieu) {
        if ($capdo == 'ALL')
            $a_ketqua[$danhhieu->madanhhieutd] = $danhhieu->tendanhhieutd;
        elseif (in_array($capdo, explode(';', $danhhieu->phamviapdung)))
            $a_ketqua[$danhhieu->madanhhieutd] = $danhhieu->tendanhhieutd;
    }
    */
    foreach (App\Models\DanhMuc\dmhinhthuckhenthuong::all() as $danhhieu) {
        $doituong = explode(';', $danhhieu->doituongapdung);
        if (!in_array($phanloai, $doituong) && $phanloai != 'ALL') {
            continue;
        }

        // $a_phamvi=explode(';', $danhhieu->phamviapdung);
        if ($capdo == 'ALL')
            $a_ketqua[$danhhieu->mahinhthuckt] = $danhhieu->tenhinhthuckt;
        elseif (in_array($capdo, explode(';', $danhhieu->phamviapdung)))
            $a_ketqua[$danhhieu->mahinhthuckt] = $danhhieu->tenhinhthuckt;
        // elseif(in_array($capdo,['T','H','SBN']) && in_array('B',$a_phamvi))
        // $a_ketqua[$danhhieu->mahinhthuckt] = $danhhieu->tenhinhthuckt;
    }
    return $a_ketqua;
}

function DHKT_BaoCao($a_danhsach = null)
{
    $ketqua = new Collection();
    foreach (App\Models\DanhMuc\dmhinhthuckhenthuong::all() as $danhhieu) {
        $danhhieu->madanhhieukhenthuong = $danhhieu->mahinhthuckt;
        $danhhieu->tendanhhieukhenthuong = $danhhieu->tenhinhthuckt;
        $ketqua->add($danhhieu);
    }
    if ($a_danhsach != null) {
        $ketqua = $ketqua->wherein('madanhhieukhenthuong', $a_danhsach);
    }
    return $ketqua;
}

function getDiaBan_All($all = false)
{
    $a_diaban = array_column(\App\Models\DanhMuc\dsdiaban::all()->toarray(), 'tendiaban', 'madiaban');
    if ($all) {
        $a_kq = ['null' => '-- Chọn địa bàn --'];
        foreach ($a_diaban as $k => $v) {
            $a_kq[$k] = $v;
        }
        return $a_kq;
    }
    return $a_diaban;
}

//Hàm lấy danh sách đơn vị quản lý địa bàn cùng cấp và cấp trên
function getDonViKhenThuong($donvi = null)
{
    $m_diaban = \App\Models\DanhMuc\dsdiaban::all();
    $a_donvi = array_column($m_diaban->toarray(), 'madonviQL');
    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();
    return array_column($model->toarray(), 'tendonvi', 'tendonvi');
}

//Hàm lấy danh sách đơn vị quản lý địa bàn cùng cấp và cấp trên
function getDonViQuanLyDiaBan($donvi, $kieudulieu = 'ARRAY')
{
    // dd($donvi);
    $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
    $a_donvi = [$m_diaban->madonviQL, $donvi->madonvi];
    $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();
    if ($m_diabanQL != null)
        $a_donvi = array_merge($a_donvi, [$m_diabanQL->madonviQL]);

    //2023.05.25 thêm điều kiện đơn vị không gửi đc cho chính mính (kể cả đơn vị quản lý ở cấp H)
    if ($donvi->capdo != 'T') {
        $a_donvi = array_diff($a_donvi, [$donvi->madonvi]);
    }
    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

//Hàm lấy danh sách đơn vị quản lý địa bàn và các đơn vị quản lý địa bàn ở cấp dưới (Kết xuất báo cáo)
function getDonViQL_BaoCao($a_donvi)
{
    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();
    return array_column($model->toarray(), 'tendonvi', 'madonvi');
}

//Lấy địa bàn, cụm khối để lọc dữ liệu
function getDiaBanCumKhoi($tendangnhap)
{
    if (session('admin')->capdo == 'SSA') {
        return [];
    }
    //Lấy đơn vị quản lý theo đơn vi
    $model = dstaikhoan_phamvi::where('tendangnhap', $tendangnhap)->get();
    $a_kq = array_column($model->wherein('phanloai', ['DONVI', 'CUMKHOI', 'DIABAN'])->toarray(), 'maphamvi');
    //Lấy thông tin theo cụm khối
    $a_cumkhoi = array_column(view_dscumkhoi::wherein('macumkhoi', array_column($model->where('phanloai', 'CUMKHOI')->toarray(), 'maphamvi'))->get()->toArray(), 'madonvi');
    $a_kq = array_merge($a_kq, $a_cumkhoi);
    //Lấy thông tin theo địa bàn
    $a_diaban = array_column(viewdiabandonvi::wherein('madiaban', array_column($model->where('phanloai', 'DIABAN')->toarray(), 'maphamvi'))->get()->toArray(), 'madonvi');
    $a_kq = array_merge($a_kq, $a_diaban);
    return $a_kq;
}

//Lấy tài khoản lọc dữ liệu
function getLocTaiKhoanXetDuyet($tendangnhap_xd)
{
    if (session('admin')->capdo == 'SSA' || $tendangnhap_xd == session('admin')->tendangnhap)
        return true;
    else
        return false;
}

//Lấy tài khoản lọc dữ liệu
function getPhanLoaiTaiKhoanTiepNhan()
{
    if (session('admin')->capdo == 'SSA' || session('admin')->phanloai == 'QUANLY' || session('admin')->phanloai == '')
        return true;
    else
        return false;
}

//Lấy danh sách cụm, khối lọc
function getCumKhoiLocDuLieu($tendangnhap)
{
    if (session('admin')->capdo == 'SSA') {
        return [];
    }
    $model = dstaikhoan_phamvi::where('tendangnhap', $tendangnhap)->where('phanloai', 'CUMKHOI')->get();
    return array_column($model->toarray(), 'maphamvi');
}

//Hàm lấy danh sách đơn vị xét duyệt trên địa bàn cùng cấp và cấp trên
function getDonViXetDuyetDiaBan_Tam($donvi, $kieudulieu = 'ARRAY')
{
    //Lấy đơn vị quản lý địa bàn và đơn vi
    $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
    $a_donvi = [$m_diaban->madonviKT, $donvi->madonvi, $m_diaban->madonviQL];
    //$a_donvi = [$m_diaban->madonviKT];
    $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();

    if ($m_diabanQL != null)
        $a_donvi = array_merge($a_donvi, [$m_diabanQL->madonviKT]);

    //2023.05.25 thêm điều kiện đơn vị không gửi đc cho chính mính (kể cả đơn vị quản lý ở cấp H)
    if ($donvi->capdo != 'T') {
        $a_donvi = array_diff($a_donvi, [$donvi->madonvi]);
    }

    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();

    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViXetDuyetDiaBan($donvi, $kieudulieu = 'ARRAY')
{
    //Lấy đơn vị quản lý địa bàn và đơn vi
    $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
    //$a_donvi = [$m_diaban->madonviKT, $donvi->madonvi]; 2023.05.25 bỏ chức năng tự gửi hồ sơ đề nghị lên đơn mình do đã tách hồ sơ khen thưởng tại đơn vị
    $a_donvi = [$m_diaban->madonviKT];
    $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();

    if ($m_diabanQL != null)
        $a_donvi = array_merge($a_donvi, [$m_diabanQL->madonviKT]);

    //2023.05.25 thêm điều kiện đơn vị không gửi đc cho chính mính (kể cả đơn vị quản lý ở cấp H)
    // if ($donvi->capdo != 'T') {
    //     $a_donvi = array_diff($a_donvi, [$donvi->madonvi]);
    // }

    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();

    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViXDDiaBan($donvi, $kieudulieu = 'ARRAY')
{
    /*
    Lấy thông tin đơn vị theo Đơn vị QL để thực hiện quy trình cán bộ tdkt huyện-> UBND huyện
    */
    //Lấy đơn vị quản lý địa bàn và đơn vi
    $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
    //$a_donvi = [$m_diaban->madonviKT, $donvi->madonvi]; 2023.05.25 bỏ chức năng tự gửi hồ sơ đề nghị lên đơn mình do đã tách hồ sơ khen thưởng tại đơn vị
    $a_donvi = [$m_diaban->madonviKT, $m_diaban->madonviQL];
    // dd($a_donvi);
    // $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();
    // dd($m_diaban);
    // if ($m_diabanQL != null)
    //     $a_donvi = array_merge($a_donvi, [$m_diabanQL->madonviQL]);

    //2023.05.25 thêm điều kiện đơn vị không gửi đc cho chính mính (kể cả đơn vị quản lý ở cấp H)
    // if ($donvi->capdo != 'T') {
    //     $a_donvi = array_diff($a_donvi, [$donvi->madonvi]);
    // }
    // dd($a_donvi);
    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();

    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}
function getDonViXetDuyetPhongTrao($donvi, $phongtrao, $kieudulieu = 'ARRAY')
{
    /*
    Thông tin đơn vị xét duyệt
    1.Đơn vị phát động: Đơn vị phát động xét duyệt
    2.Phong trào cấp trên phát động: Đơn vị xét duyệt khen thưởng theo địa bàn
    */

    if ($phongtrao->madonvi == $donvi->madonvi) {
        $a_donvi = [$donvi->madonvi];
    } else {
        $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
        $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();
        $a_donvi = [$m_diabanQL->madonviKT ?? ''];
    }

    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();

    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViPheDuyetPhongTrao($donvi, $phongtrao, $kieudulieu = 'ARRAY')
{
    /*
    Thông tin đơn vị xét duyệt
    1.Đơn vị phát động: Đơn vị phát động xét duyệt
    2.Phong trào cấp trên phát động: Đơn vị xét duyệt khen thưởng theo địa bàn
    */

    if ($phongtrao->madonvi == $donvi->madonvi) {
        $a_donvi = [$donvi->madonvi];
    } else {
        $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
        // $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();
        // $a_donvi = [$m_diabanQL->madonviQL ?? ''];
        $a_donvi = [$m_diaban->madonviQL ?? ''];
    }

    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();

    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViQuanLyNganh($donvi, $kieudulieu = 'ARRAY')
{
    //dd($donvi);
    $linhvuchoatdong = $donvi->linhvuchoatdong == '' ? 'KHONGCHON' : $donvi->linhvuchoatdong;

    //X => lấy ds huyện có cùng ngành, lĩnh vực
    //H => lấy ds tỉnh có cùng ngành, lĩnh vực
    //T => lấy ds đơn vị cùng ngành lĩnh vực
    switch ($donvi->capdo) {
        case 'X': {
                $model = \App\Models\View\viewdiabandonvi::where('linhvuchoatdong', $linhvuchoatdong)->where('capdo', 'H')->get();
                break;
            }
            //mặc định cấp tỉnh
        default:
            $model = \App\Models\View\viewdiabandonvi::where('linhvuchoatdong', $linhvuchoatdong)->where('capdo', 'T')->get();
    }
    //dd($model);
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViCK($capdo, $chucnang = null, $kieudulieu = 'ARRAY')
{
    // $model = \App\Models\View\view_dscumkhoi::all();
    // switch ($kieudulieu) {
    //     case 'MODEL': {
    //             return $model;
    //             break;
    //         }
    //     default:
    //         return array_column($model->toarray(), 'tendonvi', 'madonvi');
    // }
    if ($capdo == 'SSA' || $capdo == 'ADMIN') {
        $m_donvi = App\Models\View\view_dscumkhoi::all();
    } else {
        $m_donvi = App\Models\View\view_dscumkhoi::where('madonvi', session('admin')->madonvi)->get();
    }
    // dd($m_donvi);
    if ($chucnang != null) {
        $a_tk = App\Models\DanhMuc\dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get('tendangnhap');
        $a_tk_pq = App\Models\DanhMuc\dstaikhoan_phanquyen::where('machucnang', $chucnang)->where('phanquyen', '1')
            ->wherein('tendangnhap', $a_tk)->get('tendangnhap');
        $m_donvi = App\Models\View\viewdiabandonvi::wherein('madonvi', function ($qr) use ($a_tk_pq) {
            $qr->select('madonvi')->from('dstaikhoan')->wherein('tendangnhap', $a_tk_pq)->distinct();
        })->get();
    }
    // if(count($m_donvi) == 0){
    //     return redirect('/DangNhap');
    // }
    return $m_donvi;
}

function getDonViXetDuyetCumKhoi($macumkhoi = null, $kieudulieu = 'ARRAY')
{
    if ($macumkhoi == null) {
        $m_diaban = \App\Models\DanhMuc\dsdiaban::select('madonviKT')->distinct()->get();
        $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $m_diaban->toarray())->get();
        //--22

    } else {
        $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', function ($qr) use ($macumkhoi) {
            $qr->select('madonvixd')->from('dscumkhoi')->where('macumkhoi', $macumkhoi)->get();
        })->get();
    }
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViPheDuyetCumKhoi($macumkhoi = null, $kieudulieu = 'ARRAY')
{
    if ($macumkhoi == null) {
        $m_diaban = \App\Models\DanhMuc\dsdiaban::select('madonviQL')->distinct()->get();
        $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $m_diaban->toarray())->get();
    } else {
        $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', function ($qr) use ($macumkhoi) {
            $qr->select('madonvikt')->from('dscumkhoi')->where('macumkhoi', $macumkhoi)->get();
        })->get();
    }
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViQuanLyCumKhoi($macumkhoi, $kieudulieu = 'ARRAY')
{
    $m_donvi = \App\Models\View\view_dscumkhoi::where('macumkhoi', $macumkhoi)->wherein('phanloai', ['TRUONGKHOI'])->first();
    $m_donvi = \App\Models\View\view_dscumkhoi::where('macumkhoi', $macumkhoi)->wherein('phanloai', ['TRUONGKHOI'])->first();
    //dd(\App\Models\View\view_dscumkhoi::where('macumkhoi', $macumkhoi)->get());
    $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_donvi->madiaban)->first();
    // $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviQL, $m_donvi->madonvi])->get();
    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviQL])->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViQuanLyTinh($kieudulieu = 'ARRAY')
{
    $m_diaban = \App\Models\DanhMuc\dsdiaban::where('capdo', 'T')->first();
    $model = \App\Models\DanhMuc\dsdonvi::where('madonvi', $m_diaban->madonviQL)->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}


function getDonViTruongCumKhoi($kieudulieu = 'ARRAY')
{
    $model = \App\Models\View\view_dstruongcumkhoi::all();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

//lây các đơn vị có chức năng quản lý địa bàn
function getDonViXetDuyetHoSo($madonvi = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    //Lấy đơn vị có thông tin đơn vị
    $m_donvi = \App\Models\View\viewdiabandonvi::where('madonvi', $madonvi)->get();

    //Lấy đơn vị quản lý địa bàn
    $model = \App\Models\View\viewdiabandonvi::where('madonvi', $m_donvi->first()->madonviQL)->get();
    if ($chucnang != null) {
        $a_tk = App\Models\DanhMuc\dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get('tendangnhap');
        $a_tk_pq = App\Models\DanhMuc\dstaikhoan_phanquyen::where('machucnang', $chucnang)->where('phanquyen', '1')
            ->wherein('tendangnhap', $a_tk)->get('tendangnhap');
        $m_donvi = App\Models\View\viewdiabandonvi::wherein('madonvi', function ($qr) use ($a_tk_pq) {
            $qr->select('madonvi')->from('dstaikhoan')->wherein('tendangnhap', $a_tk_pq)->distinct();
        })->get();
    }

    foreach ($m_donvi as $donvi) {
        $model->add($donvi);
    }

    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

//Lấy các đơn vị có chức năng xét duyệt hồ sơ cụm, khối
function getDonViXetDuyetHoSoCumKhoi($capdo, $kieudulieu = 'ARRAY')
{
    $model = \App\Models\View\viewdiabandonvi::wherein('madonvi', function ($qr) {
        $qr->select('madonvixd')->from('dscumkhoi')->get();
    })->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDiaBanXetDuyetHoSo($capdo, $madiaban = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    $model = \App\Models\DanhMuc\dsdiaban::wherein('capdo', ['T', 'H', 'X'])->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendiaban', 'madiaban');
    }
}

function getThongTinDonVi($madonvi, $tentruong)
{
    $model = \App\Models\View\viewdiabandonvi::where('madonvi', $madonvi)->first();
    return $model->$tentruong ?? '';
}

function chkPhanQuyen($machucnang = null, $tenphanquyen = null)
{
    //return true;
    //Kiểm tra giao diện (danhmucchucnang)
    if (!chkGiaoDien($machucnang)) {
        return false;
    }
    $capdo = session('admin')->capdo;
    if (in_array($capdo, ['SSA', 'ssa',])) {
        return true;
    }
    // dd(session('phanquyen'));
    return session('phanquyen')[$machucnang][$tenphanquyen] ?? 0;
}

function chkGiaoDien($machucnang, $tentruong = 'sudung')
{
    $chk = session('chucnang')[$machucnang] ?? ['sudung' => 0, 'tenchucnang' => $machucnang . '()'];
    // if($machucnang == 'quantrihethong'){
    //     dd($chk);
    // }
    return $chk[$tentruong];
}

function getDonVi($capdo, $chucnang = null, $tenquyen = null)
{
    if ($capdo == 'SSA' || $capdo == 'ADMIN') {
        $m_donvi = App\Models\View\viewdiabandonvi::all();
    } else {
        $m_donvi = App\Models\View\viewdiabandonvi::where('madonvi', session('admin')->madonvi)->get();
    }
    if ($chucnang != null) {
        $a_tk = App\Models\DanhMuc\dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get('tendangnhap');
        $a_tk_pq = App\Models\DanhMuc\dstaikhoan_phanquyen::where('machucnang', $chucnang)->where('phanquyen', '1')
            ->wherein('tendangnhap', $a_tk)->get('tendangnhap');
        // dd($a_tk_pq);
        $m_donvi = App\Models\View\viewdiabandonvi::wherein('madonvi', function ($qr) use ($a_tk_pq) {
            $qr->select('madonvi')->from('dstaikhoan')->wherein('tendangnhap', $a_tk_pq)->distinct();
        })->get();
    }
    return $m_donvi;
}

//Lấy danh sách địa bàn theo đơn vị để kết xuất báo cáo tổng hợp
function getDiaBanBaoCaoTongHop($donvi)
{
    $m_donvi = App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->get();
    //Nếu đơn vị quản lý địa bàn (madonviQL) hoặc đơn vị khen thưởng (madonviKT) thì mới xem đc địa bàn cấp dưới
    if ($donvi->madonvi == $donvi->madonviQL || $donvi->madonvi == $donvi->madonviKT) {
        $dsdiaban = App\Models\DanhMuc\dsdiaban::where('madiaban', '<>', $donvi->madiaban)->get();
        //2023.08.01 chỉ kết xuất các đơn vị trên địa bàn ko lấy đơn vị trực thuộc
        getDiaBanTrucThuoc($dsdiaban, $donvi->madiaban, $m_donvi);
    }

    return $m_donvi;
}

//Lấy danh sách địa bàn theo đơn vị để tra cứu tìm kiếm
function getDiaBanTraCuu($donvi)
{
    $m_donvi = App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->get();
    //nếu đơn vị là đơn vị khen thưởng và quản lý => tìm kiếm đc tất cả đơn vị trong địa bàn
    //nếu đơn vị là đơn vị nhập liệu => chỉ tìm được dữ liêu đơn vị mình
    $diaban = $m_donvi->where('madiaban', $donvi->madiaban)->first();
    //dd($diaban);
    //Lấy địa bàn trực thuộc
    if ($donvi->madonvi == $diaban->madonviQL || $donvi->madonvi == $diaban->madonviKT) {
        $dsdiaban = App\Models\DanhMuc\dsdiaban::where('madiaban', '<>', $donvi->madiaban)->get();
        getDiaBanTrucThuoc($dsdiaban, $donvi->madiaban, $m_donvi);
    }
    return $m_donvi;
}

//Chức năng
function getDiaBan($capdo, $chucnang = null, $tenquyen = null)
{
    if ($capdo == 'SSA' || $capdo == 'ADMIN') {
        $m_donvi = App\Models\DanhMuc\dsdiaban::all();
    } else {
        $m_donvi = App\Models\DanhMuc\dsdiaban::where('madiaban', session('admin')->madiaban)->get();
        //Lấy địa bàn trực thuộc
        $dsdiaban = App\Models\DanhMuc\dsdiaban::where('madiaban', '<>', session('admin')->madiaban)->get();
        getDiaBanTrucThuoc($dsdiaban, session('admin')->madiaban, $m_donvi);
    }

    return $m_donvi;
}

function getDiaBanTrucThuoc(&$dsdiaban, $madiabanQL, &$ketqua)
{
    foreach ($dsdiaban as $key => $val) {
        if ($val->madiabanQL == $madiabanQL) {
            $ketqua->add($val);
            $dsdiaban->forget($key);
            getDiaBanTrucThuoc($dsdiaban, $val->madiaban, $ketqua);
        }
    }
}

function getDSPhongTrao($donvi)
{
    /* 2024.01.15 Chưa rõ cách lấy phong trào
    
    $m_phongtrao = App\Models\View\viewdonvi_dsphongtrao::wherein('phamviapdung', ['T', 'TW'])->orderby('tungay')->get();
    switch ($donvi->capdo) {
        case 'X': {
                //đơn vị cấp xã => chỉ các phong trào trong huyện, xã
                $model_xa = App\Models\View\viewdonvi_dsphongtrao::wherein('madiaban', [$donvi->madiaban, $donvi->madiabanQL])->orderby('tungay')->get();
                break;
            }
        case 'H': {
                //đơn vị cấp huyện =>chỉ các phong trào trong huyện
                $model_xa = App\Models\View\viewdonvi_dsphongtrao::where('madiaban', $donvi->madiaban)->orderby('tungay')->get();
                break;
            }
        case 'T': {
                //Phong trào theo SBN
                $model_xa = App\Models\View\viewdonvi_dsphongtrao::where('phamviapdung', 'SBN')->orderby('tungay')->get();
                break;
            }
    }
    foreach ($model_xa as $ct) {
        $m_phongtrao->add($ct);
    }
    return $m_phongtrao;
    */

    return App\Models\View\viewdonvi_dsphongtrao::all();
}

function getDSPhongTraoCumKhoi($donvi)
{
    $m_phongtrao = App\Models\View\view_dsphongtrao_cumkhoi::all();
    return $m_phongtrao;
}

//Làm sẵn hàm sau lọc theo truonq theodoi = 1
function getLoaiHinhKhenThuong()
{
    return App\Models\DanhMuc\dmloaihinhkhenthuong::where('theodoi', '1')->get();
}

function setArrayAll($array, $noidung = 'Tất cả', $giatri = 'ALL')
{
    $a_kq = [$giatri => $noidung];
    foreach ($array as $k => $v) {
        $a_kq[(string)$k] = $v;
    }
    return $a_kq;
}

function setChuyenXetDuyet($hoso, $a_hoanthanh)
{
    if (isset($a_hoanthanh['madonvi']))
        $hoso->madonvi_xd = $a_hoanthanh['madonvi'];
    if (isset($a_hoanthanh['trangthai']))
        $hoso->trangthai_xd = $a_hoanthanh['trangthai'];
    if (isset($a_hoanthanh['lydo']))
        $hoso->lydo_xd = $a_hoanthanh['lydo'];
    if (isset($a_hoanthanh['thoigian']))
        $hoso->thoigian_xd = $a_hoanthanh['thoigian'];
}

function setChuyenKhenThuong($hoso, $a_hoanthanh)
{
    if (isset($a_hoanthanh['madonvi']))
        $hoso->madonvi_kt = $a_hoanthanh['madonvi'];
    if (isset($a_hoanthanh['trangthai']))
        $hoso->trangthai_kt = $a_hoanthanh['trangthai'];
    if (isset($a_hoanthanh['lydo']))
        $hoso->lydo_kt = $a_hoanthanh['lydo'];
    if (isset($a_hoanthanh['thoigian']))
        $hoso->thoigian_kt = $a_hoanthanh['thoigian'];
}

function setChuyenHoSo($capdo, $hoso, $a_hoanthanh)
{
    if ($capdo == 'H') {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_h = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($capdo == 'T') {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_t = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($capdo == 'TW') {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_tw = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}



//Nhận và trả lại
function setNhanHoSo($madonvi_nhan, $hoso, $a_hoanthanh)
{
    if ($madonvi_nhan == $hoso->madonvi_nhan) {
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian = $a_hoanthanh['thoigian'];
    }

    if ($madonvi_nhan == $hoso->madonvi_nhan_h) {
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_h = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($madonvi_nhan == $hoso->madonvi_nhan_t) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_t = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($madonvi_nhan == $hoso->madonvi_nhan_tw) {
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_tw = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}

function setTraLaiHoSo_Nhan($madonvi, $hoso, $a_hoanthanh)
{
    if ($madonvi == $hoso->madonvi_h) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_h = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_h = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_t) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_t = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_t = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_tw) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_tw = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_tw = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}

function setTrangThaiHoSo($madonvi, $hoso, $a_hoanthanh)
{
    // if ($madonvi == $hoso->madonvi) {
    //     if (isset($a_hoanthanh['madonvi']))
    //         $hoso->madonvi = $a_hoanthanh['madonvi'];
    //     if (isset($a_hoanthanh['madonvi_nhan']))
    //         $hoso->madonvi_nhan = $a_hoanthanh['madonvi_nhan'];
    //     if (isset($a_hoanthanh['trangthai']))
    //         $hoso->trangthai = $a_hoanthanh['trangthai'];
    //     if (isset($a_hoanthanh['lydo']))
    //         $hoso->lydo = $a_hoanthanh['lydo'];
    //     if (isset($a_hoanthanh['thoigian']))
    //         $hoso->thoigian = $a_hoanthanh['thoigian'];
    // }

    if ($madonvi == $hoso->madonvi_h) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_h = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_h = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_t) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_t = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_t = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_tw) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_tw = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_tw = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}

function getDonViChuyen($madonvi_nhan, $hoso)
{
    //dd($macqcq);
    if ($madonvi_nhan == $hoso->madonvi) {
        $hoso->madonvi_hoso = $hoso->madonvi;
        $hoso->trangthai_hoso = $hoso->trangthai;
        $hoso->thoigian_hoso = $hoso->thoigian;
        $hoso->lydo_hoso = $hoso->lydo;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan;
    }
    if ($madonvi_nhan == $hoso->madonvi_h) {
        $hoso->madonvi_hoso = $hoso->madonvi_h;
        $hoso->trangthai_hoso = $hoso->trangthai_h;
        $hoso->thoigian_hoso = $hoso->thoigian_h;
        $hoso->lydo_hoso = $hoso->lydo_h;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_h;
    }
    if ($madonvi_nhan == $hoso->madonvi_t) {
        $hoso->madonvi_hoso = $hoso->madonvi_t;
        $hoso->trangthai_hoso = $hoso->trangthai_t;
        $hoso->thoigian_hoso = $hoso->thoigian_t;
        $hoso->lydo_hoso = $hoso->lydo_t;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_t;
    }
    if ($madonvi_nhan == $hoso->madonvi_tw) {
        $hoso->madonvi_hoso = $hoso->madonvi_tw;
        $hoso->trangthai_hoso = $hoso->trangthai_tw;
        $hoso->thoigian_hoso = $hoso->thoigian_tw;
        $hoso->lydo_hoso = $hoso->lydo_tw;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_tw;
    }
}

//chưa dùng
function setHoanThanhCQ($level, $hoso, $a_hoanthanh)
{
    if ($level == 'T') {
        $hoso->madonvi_t = $a_hoanthanh['madonvi'] ?? null;
        $hoso->thoigian_t = $a_hoanthanh['thoigian'] ?? null;
        $hoso->trangthai_t = $a_hoanthanh['trangthai'] ?? 'CHT';
    }

    if ($level == 'TW') {
        $hoso->madonvi_ad = $a_hoanthanh['madonvi'] ?? null;
        $hoso->thoidiem_ad = $a_hoanthanh['thoidiem'] ?? null;
        $hoso->trangthai_ad = $a_hoanthanh['trangthai'] ?? 'CHT';
    }

    if ($level == 'H') {
        $hoso->madonvi_h = $a_hoanthanh['madonvi'] ?? null;
        $hoso->thoidiem_h = $a_hoanthanh['thoidiem'] ?? null;
        $hoso->trangthai_h = $a_hoanthanh['trangthai'] ?? 'CHT';
    }
}
//chưa dùng
function setHoanThanhDV($madonvi, $hoso, $a_hoanthanh)
{
    if ($madonvi == $hoso->madonvi) {
        $hoso->macqcq = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo = $a_hoanthanh['lydo'] ?? null;
    }

    if ($madonvi == $hoso->madonvi_h) {
        $hoso->macqcq_h = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai_h = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo_h = $a_hoanthanh['lydo'] ?? null;
    }

    if ($madonvi == $hoso->madonvi_t) {
        $hoso->macqcq_t = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai_t = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo_t = $a_hoanthanh['lydo'] ?? null;
    }

    if ($madonvi == $hoso->madonvi_ad) {
        $hoso->macqcq_ad = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai_ad = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo_ad = $a_hoanthanh['lydo'] ?? null;
    }
}

//Làm cho chức năng trạng thái == CC
function setTraLaiXD(&$model, &$inputs)
{

    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];
    $model->lydo = $inputs['lydo'];

    //Xét có tồn tại các trường trong db không để cập nhật
    $a_keys = array_keys($model->toarray());
    if (in_array('trangthai_xd', $a_keys))
        $model->trangthai_xd = $inputs['trangthai'];
    if (in_array('thoigian_xd', $a_keys))
        $model->thoigian_xd = $model->thoigian;
    if (in_array('trangthai_xl', $a_keys))
        $model->trangthai_xl = null;
    if (in_array('tendangnhap_xl', $a_keys))
        $model->tendangnhap_xl = null;

    $model->save();

    //Lưu trạng thái
    trangthaihoso::create([
        'mahoso' => $inputs['mahoso'],
        'phanloai' => 'dshosothiduakhenthuong',
        'trangthai' => $inputs['trangthai'],
        'thoigian' => $model->thoigian,
        'madonvi_nhan' => $model->madonvi,
        'madonvi' => $model->madonvi_xd,
        'thongtin' => 'Trả lại hồ sơ đề nghị khen thưởng.',
    ]);
}
//Trả lại theo quy trình tài khoản
function setTraLai($model, $inputs)
{
    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];
    $model->ykiendonggop = null;


    $model->trangthai_xd = $model->trangthai;
    $model->thoigian_xd = $model->thoigian;
    $model->lydo_xd = $inputs['lydo'];
    if ($inputs['trangthai'] == 'BTLXD') {
        $model->trangthai_xl = 'KDK';
        $model->lydo_xd = $inputs['lydo'];
    } else {
        $model->lydo = $inputs['lydo'];
        $model->trangthai_xl = null;
        $model->tendangnhap_xl = null;
        // $model->lydo_xd=null;
        if ($inputs['trangthai'] == 'BTL') {
            dshosothiduakhenthuong_xuly::where('mahosotdkt', $model->mahosotdkt)->delete();
        }
    }
    $model->save();
    //Xóa trạng thái xử lý hồ sơ


    //Lưu trạng thái
    trangthaihoso::create([
        'mahoso' => $inputs['mahoso'],
        'phanloai' => 'dshosothiduakhenthuong',
        'trangthai' => $model->trangthai,
        'thoigian' => $model->thoigian,
        'madonvi_nhan' => $model->madonvi,
        'madonvi' => $model->madonvi_xd,
        'thongtin' => 'Trả lại hồ sơ đề nghị khen thưởng.',
    ]);
}

function setTraLai_TL($mahosotdkt, $chucnang)
{


    switch ($chucnang) {
        case 'trinhdenghi':
            $a_dieukien = ['TOTRINHKQ', 'YKIEN'];
            break;
        default:
            $a_dieukien = array();
            break;
    }


    $model_tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $mahosotdkt)->wherein('phanloai', $a_dieukien)->get();
    foreach ($model_tailieu as $tl) {
        if (file_exists('/data/tailieudinhkem/' . $tl->tentailieu)) {
            File::Delete('/data/tailieudinhkem/' . $tl->tentailieu);
        }
        $tl->delete();
    }
}

function setChuyenChuyenVienXD(&$model, &$inputs, $phanloai)
{
    //dd($inputs);
    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];

    $model->trangthai_xl = $inputs['trangthai'];
    $model->tendangnhap_xl = $inputs['tendangnhap_tn'];
    $model->trangthai_xd = $model->trangthai;
    $model->thoigian_xd = $model->thoigian;
    $model->save();

    switch ($phanloai) {
        case 'dshosotdktcumkhoi': {
                App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_xuly::create([
                    'mahosotdkt' => $inputs['mahoso'],
                    'trangthai_xl' => $inputs['trangthai'],
                    'tendangnhap_xl' => $inputs['tendangnhap_xl'], //Thông tin tài khoản xử lý hồ sơ
                    'tendangnhap_tn' => $inputs['tendangnhap_tn'], //Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
                    'noidung_xl' => $inputs['noidungxuly_xl'],
                    'ngaythang_xl' => $inputs['thoigian'],
                ]);
                break;
            }
        case 'dshosokhencao': {
                App\Models\NghiepVu\KhenCao\dshosokhencao_xuly::create([
                    'mahosotdkt' => $inputs['mahoso'],
                    'trangthai_xl' => $inputs['trangthai'],
                    'tendangnhap_xl' => $inputs['tendangnhap_xl'], //Thông tin tài khoản xử lý hồ sơ
                    'tendangnhap_tn' => $inputs['tendangnhap_tn'], //Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
                    'noidung_xl' => $inputs['noidungxuly_xl'],
                    'ngaythang_xl' => $inputs['thoigian'],
                ]);
                break;
            }
        default: {
                //dshosothiduakhenthuong
                App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly::create([
                    'mahosotdkt' => $inputs['mahoso'],
                    'trangthai_xl' => $inputs['trangthai'],
                    'tendangnhap_xl' => $inputs['tendangnhap_xl'], //Thông tin tài khoản xử lý hồ sơ
                    'tendangnhap_tn' => $inputs['tendangnhap_tn'], //Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
                    'noidung_xl' => $inputs['noidungxuly_xl'],
                    'ngaythang_xl' => $inputs['thoigian'],
                ]);
            }
    }
    //Lưu trạng thái
    trangthaihoso::create([
        'mahoso' => $inputs['mahoso'],
        'phanloai' => 'dshosothiduakhenthuong',
        'trangthai' => $model->trangthai,
        'thoigian' => $model->thoigian,
        'madonvi_nhan' => $model->madonvi_xd,
        'madonvi' => $model->madonvi_xd,
        'thongtin' => 'Chuyển hồ sơ đề nghị khen thưởng cho chuyên viên xử lý.',
        'tendangnhap' => $inputs['tendangnhap_xl']
    ]);
}

function setXuLyHoSo(&$model, &$inputs, $phanloai)
{
    //dd($inputs);
    $model->trangthai_xl = $inputs['trangthai'];
    $model->tendangnhap_xl = $inputs['tendangnhap_tn'];
    $model->thoigian_xd = $inputs['thoigian'];
    $model->save();

    //gán thông tin vào bảng xử lý hồ sơ
    switch ($phanloai) {
        case 'dshosotdktcumkhoi': {
                App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_xuly::create([
                    'mahosotdkt' => $inputs['mahoso'],
                    'trangthai_xl' => $inputs['trangthai'],
                    'tendangnhap_xl' => $inputs['tendangnhap_xl'], //Thông tin tài khoản xử lý hồ sơ
                    'tendangnhap_tn' => $inputs['tendangnhap_tn'], //Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
                    'noidung_xl' => $inputs['noidungxuly_xl'],
                    'ngaythang_xl' => $inputs['thoigian'],
                ]);
                break;
            }
        case 'dshosokhencao': {
                App\Models\NghiepVu\KhenCao\dshosokhencao_xuly::create([
                    'mahosotdkt' => $inputs['mahoso'],
                    'trangthai_xl' => $inputs['trangthai'],
                    'tendangnhap_xl' => $inputs['tendangnhap_xl'], //Thông tin tài khoản xử lý hồ sơ
                    'tendangnhap_tn' => $inputs['tendangnhap_tn'], //Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
                    'noidung_xl' => $inputs['noidungxuly_xl'],
                    'ngaythang_xl' => $inputs['thoigian'],
                ]);
                break;
            }
        default: {
                //dshosothiduakhenthuong
                App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly::create([
                    'mahosotdkt' => $inputs['mahoso'],
                    'trangthai_xl' => $inputs['trangthai'],
                    'tendangnhap_xl' => $inputs['tendangnhap_xl'], //Thông tin tài khoản xử lý hồ sơ
                    'tendangnhap_tn' => $inputs['tendangnhap_tn'], //Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
                    'noidung_xl' => $inputs['noidungxuly_xl'],
                    'ngaythang_xl' => $inputs['thoigian'],
                ]);
            }
    }

    //Lưu trạng thái
    trangthaihoso::create([
        'mahoso' => $inputs['mahoso'],
        'phanloai' => 'dshosothiduakhenthuong',
        'trangthai' => $model->trangthai,
        'thoigian' => $model->thoigian,
        'madonvi_nhan' => $model->madonvi_xd,
        'madonvi' => $model->madonvi_xd,
        'thongtin' => $inputs['noidungxuly_xl'],
        'tendangnhap' => $inputs['tendangnhap_xl']
    ]);
}

//Làm cho chức năng trạng thái == CC
function setTraLaiPD(&$model, &$inputs)
{
    //Tạo nhật ký trc do hồ sơ xoá madonvi_kt
    $a_nhatky = [
        'mahoso' => $inputs['mahoso'],
        'phanloai' => 'dshosothiduakhenthuong',
        'trangthai' => $model->trangthai,
        'thoigian' => $model->thoigian,
        'madonvi_nhan' => $model->madonvi_xd,
        'madonvi' => $model->madonvi_kt,
        'thongtin' => 'Trả lại hồ sơ đề nghị khen thưởng.',
    ];

    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];
    $model->lydo = $inputs['lydo'];

    $model->lydo_xd = $inputs['lydo'];
    $model->trangthai_xd = $inputs['trangthai'];
    $model->thoigian_xd = $inputs['thoigian'];

    $model->madonvi_kt = null;
    $model->trangthai_kt = null;
    $model->thoigian_kt = null;
    $model->save();

    //Lưu trạng thái
    trangthaihoso::create($a_nhatky);
}

//Làm cho chức năng trạng thái == CC
function setTraLaiXDCK(&$model, &$inputs)
{
    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];
    $model->lydo = $inputs['lydo'];

    $model->trangthai_xd = $model->trangthai;
    $model->thoigian_xd = $model->thoigian;
    $model->save();

    //Lưu trạng thái
    trangthaihoso::create([
        'mahoso' => $inputs['mahoso'],
        'phanloai' => 'dshosotdktcumkhoi',
        'trangthai' => $model->trangthai,
        'thoigian' => $model->thoigian,
        'madonvi_nhan' => $model->madonvi,
        'madonvi' => $model->madonvi_xd,
        'thongtin' => 'Trả lại hồ sơ đề nghị khen thưởng.',
    ]);
}

//Làm cho chức năng trạng thái == CC
function setChuyenDV(&$model, &$inputs)
{
    //dd($inputs);
    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];
    $model->lydo = $inputs['lydo'];
    $model->madonvi_nhan = $inputs['madonvi_nhan'];



    $model->trangthai_xd = $model->trangthai;
    $model->thoigian_xd = $model->thoigian;
    $model->madonvi_xd = $model->madonvi_nhan;
    //dd($model);
    $model->save();

    //Lưu trạng thái
    $trangthai = new trangthaihoso();
    $trangthai->trangthai = $inputs['trangthai'];
    $trangthai->madonvi = $model->madonvi;
    $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
    $trangthai->phanloai = 'dshosothiduakhenthuong';
    $trangthai->mahoso = $model->mahosotdkt;
    $trangthai->thoigian = $model->thoigian;
    $trangthai->thongtin = 'Chuyển hồ sơ đề nghị khen thưởng đã chỉnh sửa lại theo yêu cầu.';
    $trangthai->save();
}

//Chuyển hồ sơ trong Huyện
function setChuyenDV_Huyen($model, $inputs, $phamviapdung = null)
{
    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];
    // $model->lydo = $inputs['lydo'];
    // $model->madonvi_nhan = $inputs['madonvi_nhan'];
    $model->lydo_h = $inputs['lydo'];
    $model->madonvi_nhan_h = $inputs['madonvi_nhan'];
    if ($phamviapdung == 'H') {
        $model->trangthai_xd = 'CD';
    }
    // $model->thoigian_xd = $model->thoigian;
    // $model->madonvi_xd = $model->madonvi_nhan;
    //dd($model);
    $model->save();

    //Lưu trạng thái
    $trangthai = new trangthaihoso();
    $trangthai->trangthai = $inputs['trangthai'];
    $trangthai->madonvi = $model->madonvi;
    $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
    $trangthai->phanloai = 'dshosothiduakhenthuong';
    $trangthai->mahoso = $model->mahosotdkt;
    $trangthai->thoigian = $model->thoigian;
    $trangthai->thongtin = 'Chuyển hồ sơ đề nghị khen thưởng đã chỉnh sửa lại theo yêu cầu.';
    $trangthai->save();
}

//Làm cho chức năng trạng thái == CC
function setChuyenDV_CumKhoi(&$model, &$inputs)
{
    //dd($inputs);
    $model->trangthai = $inputs['trangthai'];
    $model->thoigian = $inputs['thoigian'];
    $model->lydo = $inputs['lydo'];
    $model->madonvi_nhan = $inputs['madonvi_nhan'];

    $model->trangthai_xd = $model->trangthai;
    $model->thoigian_xd = $model->thoigian;
    $model->madonvi_xd = $model->madonvi_nhan;
    $model->save();

    //Lưu trạng thái
    $trangthai = new trangthaihoso();
    $trangthai->trangthai = $inputs['trangthai'];
    $trangthai->madonvi = $model->madonvi;
    $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
    $trangthai->phanloai = 'dshosotdktcumkhoi';
    $trangthai->mahoso = $model->mahosotdkt;
    $trangthai->thoigian = $model->thoigian;
    $trangthai->thongtin = 'Chuyển hồ sơ đề nghị khen thưởng đã chỉnh sửa lại theo yêu cầu.';
    $trangthai->save();
}

//Lấy tọa độ mặc định
function getToaDoMacDinh($inputs)
{
    // if (session('admin')->capdo == 'SSA') {
    //     $inputs['madonvi'] = $m_hoso->madonvi_kt;
    //     $model =   App\Models\DanhMuc\dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
    //         ->where('phanloaidoituong', $inputs['phanloaidoituong'])
    //         ->where('phanloaiphoi', $inputs['phanloaiphoi'])
    //         ->where('madonvi', $inputs['madonvi'])
    //         ->first();
    // } else {
    //     $inputs['madonvi'] = session('admin')->madonvi;
    //     $model =   App\Models\DanhMuc\dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
    //         ->where('phanloaidoituong', $inputs['phanloaidoituong'])
    //         ->where('phanloaiphoi', $inputs['phanloaiphoi'])
    //         ->where('madonvi', $inputs['madonvi'])
    //         ->first();
    // }

    //Làm lấy thông tin tại đơn vị

    $model =   App\Models\DanhMuc\dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
        ->where('phanloaidoituong', $inputs['phanloaidoituong'])
        ->where('phanloaiphoi', $inputs['phanloaiphoi'])
        ->where('madonvi', $inputs['madonvi'])
        ->first();
    if ($model == null) {
        $model =  App\Models\DanhMuc\dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
            ->where('phanloaidoituong', $inputs['phanloaidoituong'])
            ->where('phanloaiphoi', $inputs['phanloaiphoi'])
            ->where('madonvi', session('admin')->madonvi_inphoi)
            ->first();
        // dd($model);
    }
    return $model;
}

//Lấy phôi bằng khen, giấy khen của đon vị
function getPhoiBk($m_donvi)
{
    $m_donvi_inphoi = dsdonvi::where('madonvi', session('admin')->madonvi_inphoi)->first();
    if ($m_donvi->phoi_bangkhen == '') {
        $m_donvi->phoi_bangkhen = $m_donvi_inphoi->phoi_bangkhen;
    }

    if ($m_donvi->phoi_giaykhen == '') {
        $m_donvi->phoi_giaykhen = $m_donvi_inphoi->phoi_giaykhen;
    }
}

//Lấy cấp độ cao nhất
function getCapDoLonNhat($capdo)
{
    if (in_array('T', $capdo)) {
        return 'T';
    } elseif (in_array('H', $capdo)) {
        return 'H';
    } else {
        return 'X';
    }
}

//Lấy cấp độ của địa bàn cấp trên
function getCapDoDiaBanCapTren($capdo)
{
    $kq = 'X';
    switch ($capdo) {
        case 'T': {
                $kq = 'TW';
                break;
            }
        case 'H': {
                $kq = 'T';
                break;
            }
        case 'X': {
                $kq = 'H';
                break;
            }
    }
    return $kq;
}

//Lấy trạng thái tiếp theo của hồ sơ

function getTrangThaiChuyenHS($trangthai)
{
    //Ko tính trường hợp  hồ sơ bị trả lại => nếu hồ sơ bị trả lại thì gán trạng thái theo chức năng rồi mới xác định 
    switch ($trangthai) {
        case 'CC': {
                return 'CD';
            }
        case 'CD': {
                return 'DD';
            }
        case 'DD':
        case 'CXKT': {
                return 'CXKT';
            }
        default:
            return 'CD';
    }
}

function getDonViToaDoMacDinh($a_donvi)
{
    $m_donvi = App\Models\View\viewdiabandonvi::wherein('madonvi', $a_donvi)->get();
    return array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
}

//Xây dựng hàm để chuyển đổi cơ sở dữ liệu cho Danh sách hồ sơ
function convertDanhSachHoSo() {}

function chkTruongCumKhoi($nam, $macumkhoi, $madonvi)
{
    //Thiết lập thông tin trưởng cụm khối (nếu năm nay chưa thiết lập danh sách thì lấy năm trước)
    if ($nam != 'ALL') {
        $dstruongcumkhoi = App\Models\View\view_dstruongcumkhoi::selectraw('madonvi, Year(ngaytu) as nam')
            ->where('macumkhoi', $macumkhoi)
            ->orderby('ngaytu', 'DESC')->get();
        $chk = $dstruongcumkhoi->where('nam', $nam);
        if ($chk->count() == 0) {
            $madonvi_truongck =  $dstruongcumkhoi->first()->madonvi ?? '';
        } else {
            $madonvi_truongck =  $chk->first()->madonvi ?? '';
        }

        //Kiểm tra thông tin
        if ($madonvi == $madonvi_truongck)
            return true;
        else
            return false;
    } else {
        return false;
    }
}

function KiemTraPhongTrao(&$phongtrao, $thoigian)
{
    /*
        Xây dựng lại hàm kiểm tra phong trào
        CC: Nhận hồ sơ tham gia thi đua; Ko tạo hồ sơ đề nghị khen thưởng
        CXKT: Ko nhận hồ sơ tham gia; Tạo hồ sơ đề nghị khen thưởng
        DKT: Ko nhận hồ sơ tham gia thi đua; Ko tạo hồ sơ đề nghị khen thưởng
        */

    //Mặc định đã kết thúc 
    $phongtrao->hoso_thamgia = false;
    $phongtrao->hoso_denghi = false;
    $phongtrao->hoso_pheduyet = false;

    $phongtrao->nhanhoso = 'CHUABATDAU';
    /*         
        if ($phongtrao->trangthai == 'CC') {
            $phongtrao->nhanhoso = 'CHUABATDAU';
            if ($phongtrao->tungay < $thoigian && $phongtrao->denngay > $thoigian) {
                $phongtrao->nhanhoso = 'DANGNHAN';
            }
            if (strtotime($phongtrao->denngay) < strtotime($thoigian)) {
                $phongtrao->nhanhoso = 'KETTHUC';
            }
        } else {
            $phongtrao->nhanhoso = 'KETTHUC';
        }
    */
    if ($phongtrao->dotxetkhenthuong == 'KETTHUC' || $phongtrao->dotxetkhenthuong == '') {
        switch ($phongtrao->trangthai) {
            case 'CC': {
                    if ($phongtrao->denngay < $thoigian) {
                        $phongtrao->nhanhoso = 'KETTHUC';
                    }
                    if ($phongtrao->tungay < $thoigian && $phongtrao->denngay > $thoigian) {
                        $phongtrao->nhanhoso = 'DANGNHAN';
                        $phongtrao->hoso_thamgia = true;
                    }
                    if (strtotime($phongtrao->denngay) < strtotime($thoigian)) {
                        $phongtrao->hoso_denghi = true;
                        $phongtrao->nhanhoso = 'KETTHUC';
                    }
                    break;
                }
            case 'CXKT': {
                    $phongtrao->nhanhoso = 'KETTHUC';
                    $phongtrao->hoso_denghi = true;
                    $phongtrao->hoso_pheduyet = true;
                    break;
                }
            case 'DKT': {
                    $phongtrao->nhanhoso = 'KETTHUC';
                    break;
                }
        }
    } else {

        switch ($phongtrao->trangthai) {
            case 'CC':
            case 'CXKT': {
                    $phongtrao->nhanhoso = 'DANGNHAN';
                    $phongtrao->hoso_thamgia = true;
                    $phongtrao->hoso_denghi = true;
                    $phongtrao->hoso_pheduyet = true;
                    break;
                }
            case 'DKT': {
                    $phongtrao->nhanhoso = 'KETTHUC';
                    break;
                }
        }
    }
}

//Lấy hồ sơ xử lý theo ten đăng nhập
function getHoSoXuLy($a_mahosotdkt, $tendangnhap, $phanloai)
{
    if (session('admin')->capdo == 'SSA') {
        switch ($phanloai) {
            case 'dshosokhencao': {
                    return App\Models\NghiepVu\KhenCao\dshosokhencao_xuly::wherein('mahosotdkt', $a_mahosotdkt)->get();
                }
            case 'dshosotdktcumkhoi': {
                    return App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_xuly::wherein('mahosotdkt', $a_mahosotdkt)->get();
                }
            default: { //Mặc định "dshosothiduakhenthuong"
                    return App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly::wherein('mahosotdkt', $a_mahosotdkt)->get();
                }
        }
    } else {
        switch ($phanloai) {
            case 'dshosokhencao': {
                    return App\Models\NghiepVu\KhenCao\dshosokhencao_xuly::wherein('mahosotdkt', $a_mahosotdkt)->where(function ($qr) use ($tendangnhap) {
                        $qr->where('tendangnhap_xl', $tendangnhap)->orwhere('tendangnhap_tn', $tendangnhap);
                    })->get();
                }
            case 'dshosotdktcumkhoi': {
                    return App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_xuly::wherein('mahosotdkt', $a_mahosotdkt)->where(function ($qr) use ($tendangnhap) {
                        $qr->where('tendangnhap_xl', $tendangnhap)->orwhere('tendangnhap_tn', $tendangnhap);
                    })->get();
                }
            default: { //Mặc định "dshosothiduakhenthuong"
                    return App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_xuly::wherein('mahosotdkt', $a_mahosotdkt)->where(function ($qr) use ($tendangnhap) {
                        $qr->where('tendangnhap_xl', $tendangnhap)->orwhere('tendangnhap_tn', $tendangnhap);
                    })->get();
                }
        }
    }
}

//index các cột trong excel
function ColumnName()
{
    return [
        'A' => 0,
        'B' => 1,
        'C' => 2,
        'D' => 3,
        'E' => 4,
        'F' => 5,
        'G' => 6,
        'H' => 7,
        'I' => 8,
        'J' => 9,
        'K' => 10,
        'L' => 11,
        'M' => 12,
        'N' => 13,
        'O' => 13,
        'P' => 15,
        'Q' => 16,
        'R' => 17,
        'S' => 18,
        'T' => 19,
        'U' => 20,
        'V' => 21,
        'W' => 22
    ];
}

function getPhanNhomTL($phanloai = null)
{
    if (isset($phanloai)) {
        $a_phanloai = [
            'ALL' => 'Tất cả',
            'TW' => 'Tài liệu Trung Ương',
            'T' => 'Tài liệu Tỉnh',
            'S' => 'Tài liệu Sở'
        ];
    } else {
        $a_phanloai = [
            'TW' => 'Tài liệu Trung Ương',
            'T' => 'Tài liệu Tỉnh',
            'S' => 'Tài liệu Sở'
        ];
    }
    return $a_phanloai;
}

function getPhanLoaiTKTiepNhan($madonvi)
{
    $m_taikhoantiepnhan = dsdonvi::where('madonvi', $madonvi)->first();
    if (isset($m_taikhoantiepnhan->taikhoantiepnhan)) {
        $taikhoantiepnhan = $m_taikhoantiepnhan->taikhoantiepnhan;
    } else {
        $taikhoantiepnhan = dstaikhoan::where('madonvi', $madonvi)->first()->tendangnhap ?? '';
    }
    return $taikhoantiepnhan;
}

function getDsCoQuan($madonvi = null)
{
    if ($madonvi == null) {
        $model = dmcoquandonvi::all();
    } else {
        $model = dmcoquandonvi::where('macoquandonvi', $madonvi)->get();
    }

    $a_coquan = array();
    if (count($model) > 0) {
        $a_coquan = array_column($model->toarray(), 'tencoquandonvi', 'macoquandonvi');
    }
    return $a_coquan;
}

function getDVPhanLoaiHS($madonvi)
{
    $donvi = dsdonvi::where('madonvi', $madonvi)->first();
    if (isset($donvi)) {
        $capdo = dsdiaban::where('madiaban', $donvi->madiaban)->first()->capdo;
        if ($capdo == 'T') {
            return 'KHENTHUONG';
        } else {
            return 'KTDONVI';
        }
    }
    // if(in_array(session('admin')->capdo,['SSA'])){
    //     return 'ALL';
    // }
}
function getDVPhanLoaiHsDeNghi($madonvi)
{
    $donvi = dsdonvi::where('madonvi', $madonvi)->first();
    if (isset($donvi)) {
        $capdo = dsdiaban::where('madiaban', $donvi->madiaban)->first()->capdo;
        if ($capdo == 'T') {
            return 'DENGHIKHENTHUONG';
        } else {
            return 'DENGHIKHENTHUONGDV';
        }
    }
}

function getDHTDVaHinhThucKT($phanloai, $doituong = null)
{
    $a_ketqua = [];
    $model = dmhinhthuckhenthuong::all();

    switch ($phanloai) {
        case 'DANHHIEUTD': {
                $m_danhhieu = $model->where('phanloai', $phanloai);
                foreach ($m_danhhieu as $ct) {
                    $a_doituong = explode(';', $ct->doituongapdung);
                    if (in_array($doituong, $a_doituong)) {
                        $a_ketqua[$ct->mahinhthuckt] = $ct->tenhinhthuckt;
                    }
                }
                break;
            }
        case 'KHANGCHIEN': {
                $phanloai = ['HUANCHUONG', 'HUYCHUONG', 'KYNIEMCHUONG'];
                $m_danhhieu = $model->wherein('phanloai', $phanloai);
                foreach ($m_danhhieu as $ct) {
                    // $a_doituong=explode(';', $ct->doituongapdung);
                    // if(in_array($doituong,$a_doituong)){
                    $a_ketqua[$ct->mahinhthuckt] = $ct->tenhinhthuckt;
                    // }
                }
                break;
            }

        default: {
                $m_danhhieu = $model->where('phanloai', '<>', $phanloai);
                foreach ($m_danhhieu as $ct) {
                    $a_doituong = explode(';', $ct->doituongapdung);
                    if (in_array($doituong, $a_doituong)) {
                        $a_ketqua[$ct->mahinhthuckt] = $ct->tenhinhthuckt;
                    }
                }
                break;
            }
    }
    // if($phanloai == 'DANHHIEUTD'){
    //     $m_danhhieu=$model->where('phanloai',$phanloai);
    //     foreach($m_danhhieu as $ct)
    //     {
    //         $a_doituong=explode(';', $ct->doituongapdung);
    //         if(in_array($doituong,$a_doituong)){
    //             $a_ketqua[$ct->mahinhthuckt] = $ct->tenhinhthuckt;
    //         }
    //     }
    // }else{
    //     $m_danhhieu=$model->where('phanloai','<>',$phanloai);
    //     foreach($m_danhhieu as $ct)
    //     {
    //         $a_doituong=explode(';', $ct->doituongapdung);
    //         if(in_array($doituong,$a_doituong)){
    //             $a_ketqua[$ct->mahinhthuckt] = $ct->tenhinhthuckt;
    //         }
    //     }
    // }

    return $a_ketqua;
}

function getTKTiepNhan($capdo)
{
    if (in_array('SSA', $capdo)) {
        $capdo = ['T', 'H'];
    }
    $donvi = dsdonvi::join('dsdiaban', 'dsdiaban.madiaban', '=', 'dsdonvi.madiaban')
        ->select('dsdonvi.taikhoantiepnhan', 'dsdonvi.madonvi')
        ->wherein('dsdiaban.capdo', $capdo)
        ->wherenotnull('dsdonvi.taikhoantiepnhan')
        ->get();
    return $donvi;
}

function chkTkTiepNhan($madonvi, $capdo)
{
    if (in_array($madonvi, array_column(getTKTiepNhan([session('admin')->capdo])->toarray(), 'madonvi'))) {
        return true;
    } else {
        return false;
    }
}

function chkaction()
{

    $model = dstaikhoan::where('tendangnhap', session('admin')->tendangnhap)->first();
    $thoigian = $model->timeaction;
    $chenhlechthoigian = Carbon::now('Asia/Ho_Chi_Minh')->diffInMinutes($thoigian);
    // dd($chenhlechthoigian);
    $time_session = Config::get('session.lifetime');
    if ($model->tendangnhap == 'SSA') {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        dstaikhoan::findOrFail(session('admin')->id)->update(['timeaction' => $time]);
        return true;
        // }elseif(session()->getId() !== $model->sessionID)
    };
    if ($model->islogout == 0 && $model->sessionID == null) {
        return true;
    }
    //Kiểm tra trạng thái đăng nhập của tài khoản
    if ($chenhlechthoigian < $time_session && $model->islogout == 1 && $model->sessionID != null) {
        return true;
    } else {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        dstaikhoan::findOrFail(session('admin')->id)->update(['timeaction' => $time]);
        return false;
    }
}

function getPhamViKT($capkhenthuong)
{
    switch ($capkhenthuong) {
        case 'T': {
                $phamvi = array(
                    'TW' => 'Cấp Nhà nước',
                    'B' => 'Cấp Bộ',
                    'T' => 'Cấp Tỉnh',
                );
                break;
            }
        case 'H': {
                $phamvi = array(
                    'B' => 'Cấp Bộ',
                    'SBN' => 'Cấp Sở, ban, ngành',
                    'H' => 'Cấp Huyện',
                );
                break;
            }
        case 'SBN': {
                $phamvi = array(
                    'B' => 'Cấp Bộ',
                    'SBN' => 'Cấp Sở, ban, ngành',
                    'H' => 'Cấp Huyện',
                );
                break;
            }
        case 'X': {
                $phamvi = array(
                    'X' => 'Cấp Xã',
                );
                break;
            }
    }

    return $phamvi;
}

function storeThongBao($url, $noidung, $chucnang, $mahs_mapt, $phamvi, $madonvi, $madonvi_nhan, $phanloai, $taikhoan_tn, $phanquyen)
{
    $mathongbao = getdate()[0];
    $data = [
        'mathongbao' => $mathongbao,
        'noidung' => $noidung,
        'url' => $url,
        'chucnang' => $chucnang,
        'mahs_mapt' => $mahs_mapt,
        'phamvi' => $phamvi,
        'madonvi_thongbao' => $madonvi,
        'madonvi_nhan' => $madonvi_nhan,
        'trangthai' => 'CHUADOC',
        'phanloai' => $phanloai,
        'taikhoan_tn' => $taikhoan_tn,
        'phanquyen' => $phanquyen
    ];

    thongbao::create($data);
}

function chkThongBao()
{
    switch (session('admin')->capdo) {
        case 'T': {
                $a_phamvi = ['T', 'TW'];
                break;
            }
        case 'TW': {
                $a_phamvi = ['T', 'TW'];
                break;
            }
        case 'H': {
                $a_phamvi = ['T', 'TW', 'H'];
                break;
            }
        case 'X': {
                $a_phamvi = ['T', 'TW', 'H', 'X'];
                break;
            }
        default: {
                $a_phamvi = ['T', 'TW', 'H', 'X'];
                break;
            }
    }
    $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', session('admin')->madonvi)->get();
    $a_macumkhoi = array_column($m_cumkhoi->toarray(), 'macumkhoi');
    $model = thongbao::wherein('phamvi', $a_phamvi)->orwherein('phamvi', $a_macumkhoi)->get();
    foreach ($model as $ct) {
        if ($ct->trangthai == 'CHUADOC') {
            return true;
        } else {
            $trangthai = explode(';', $ct->trangthai);
            if (in_array(session('admin')->tendangnhap, $trangthai)) {
                return false;
            } else {
                return true;
            }
        }
    }
}
function SLThongbao_26092024($capdo, $madonvi, $tendangnhap)
{
    switch ($capdo) {
        case 'T': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW'];
                break;
            }
        case 'TW': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW'];
                break;
            }
        case 'H': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW', 'H'];
                break;
            }
        case 'X': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW', 'H', 'X'];
                break;
            }
        default: {
                $m_cumkhoi = dscumkhoi_chitiet::all();
                $a_phamvi = ['T', 'TW', 'H', 'X'];
                break;
            }
    }

    $a_macumkhoi = array_column($m_cumkhoi->toarray(), 'macumkhoi');
    $model = thongbao::wherein('phamvi', $a_phamvi)->orwherein('phamvi', $a_macumkhoi)->get();
    $sl = 0;
    foreach ($model as $ct) {
        if ($ct->trangthai == 'CHUADOC') {
            $sl += 1;
        } else {
            $trangthai = explode(';', $ct->trangthai);
            if (!in_array($tendangnhap, $trangthai)) {
                $sl += 1;
            }
        }
    }
    return $sl;
}

function SLThongbao($capdo, $madonvi, $tendangnhap)
{
    $a_chucnang = array(
        'phongtraothidua' => [
            'dsphongtraothidua' => 'Phong trào thi đua',
            'khenthuongphongtrao' => 'Khen thưởng theo phong trào thi đua'

        ],
        'quanly' => [
            'congtrang' => 'Khen thưởng công trạng',
            'chuyende' => 'Khen thưởng phong trào thi đua',
            'dotxuat' => 'Khen thưởng đột xuất',
            'conghien' => 'Khen thưởng quá trình cống hiến',
            'nienhan' => 'Khen thưởng theo niên hạn',
            'doingoai' => 'Khen thưởng đối ngoại',
            'khangchien' => 'Khen thưởng kháng chiến'
        ],
        'cumkhoi' => [
            'dsphongtraothiduacumkhoi' => 'Phong trào thi đua cụm khối',
            'khenthuongcumkhoi' => 'Khen thưởng cụm khối'
        ]
    );
    switch ($capdo) {
        case 'T': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW'];
                break;
            }
        case 'TW': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW'];
                break;
            }
        case 'H': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW', 'H'];
                break;
            }
        case 'X': {
                $m_cumkhoi = dscumkhoi_chitiet::where('madonvi', $madonvi)->get();
                $a_phamvi = ['T', 'TW', 'H', 'X'];
                break;
            }
        default: {
                $m_cumkhoi = dscumkhoi_chitiet::all();
                $a_phamvi = ['T', 'TW', 'H', 'X'];
                break;
            }
    }

    $a_macumkhoi = array_column($m_cumkhoi->toarray(), 'macumkhoi');
    // $model = thongbao::wherein('phamvi', $a_phamvi)->orwherein('phamvi', $a_macumkhoi)->orwhere('madonvi_nhan',session('admin')->madonvi)->get();
    //lấy tất cả các thông báo thuộc về đơn vị
    $a_taikhoan_thongbao = array_column(taikhoan_nhanthongbao::where('tendangnhap', $madonvi)->get()->toarray(), 'mathongbao');

    $model = thongbao::where(function ($q) use ($madonvi) {
        $q->where('phanloai', 'quanly')
            ->where('madonvi_nhan', $madonvi);
    })
        ->orwhere(function ($q) use ($a_phamvi, $madonvi) {
            $q->where('phanloai', 'phongtraothidua')
                ->where(function ($query) use ($a_phamvi, $madonvi) {
                    $query->whereIn('phamvi', $a_phamvi)
                        ->where('madonvi_thongbao', '!=', $madonvi);
                })
                ->orWhere('madonvi_nhan', $madonvi);
        })
        ->orwhere(function ($q) use ($a_macumkhoi, $madonvi) {
            $q->where('phanloai', 'cumkhoi')
                ->where(function ($query) use ($a_macumkhoi, $madonvi) {
                    $query->whereIn('phamvi', $a_macumkhoi)
                        ->where('madonvi_thongbao', '!=', $madonvi);
                })
                ->orWhere('madonvi_nhan', $madonvi);
        })
        ->wherenotin('mathongbao', $a_taikhoan_thongbao)
        ->get();
    // dd($model);
    $sl = 0;
    foreach ($model as $key => $ct) {
        switch ($ct->phanloai) {
            case 'quanly': {
                $hosokt = dshosothiduakhenthuong::where('mahosotdkt', $ct->mahs_mapt)->first();
                if(!isset($hosokt)){
                    $model->forget($key);
                    continue 2;
                }
                    $a_dsphanquyen_tn = array(
                        'tnhosodenghikhenthuongcongtrang',
                        'tnhosodenghikhenthuongdoingoai',
                        'tnhosodenghikhenthuongconghien',
                        'tnhosodenghikhenthuongchuyende',
                        'tnhosodenghikhenthuongdotxuat',
                        'tnhosodenghikhenthuongnienhan',
                        'tnhosodenghikhenthuongkhangchien'
                    );
                    $a_phanquyen_xd = array(
                        'xdhosodenghikhenthuongcongtrang',
                        'xdhosodenghikhenthuongdoingoai',
                        'xdhosodenghikhenthuongconghien',
                        'xdhosodenghikhenthuongchuyende',
                        'xdhosodenghikhenthuongdotxuat',
                        'xdhosodenghikhenthuongnienhan',
                        'xdhosodenghikhenthuongkhangchien'
                    );
                    $a_phanquyen_qd = array(
                        'qdhosodenghikhenthuongcongtrang',
                        'qdhosodenghikhenthuongdoingoai',
                        'qdhosodenghikhenthuongconghien',
                        'qdhosodenghikhenthuongchuyende',
                        'qdhosodenghikhenthuongdotxuat',
                        'qdhosodenghikhenthuongnienhan',
                        'qdhosodenghikhenthuongkhangchien',
                    );
                    // foreach ($model as $key => $ct) {
                    // $hosokt = dshosothiduakhenthuong::where('mahosotdkt', $ct->mahs_mapt)->first();
                    // dd($hosokt);
                    //Xem xét hồ sơ đang ở giai đoạn nào
                    $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $ct->mahs_mapt)->orderby('created_at', 'desc')->get();
                    // dd($hoso);
                    if (count($hoso) <= 0 && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                        $model->forget($key);
                        continue 2;
                    }

                    if (count($hoso) > 0) {
                        //Thông báo cho chức năng tiếp nhận
                        foreach ($a_dsphanquyen_tn as $val) {
                            if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                if ($ct->phanquyen == $val) {
                                    $model->forget($key);
                                    continue;
                                }
                            } else {
                                if ($ct->taikhoan_tn != session('admin')->tendangnhap && $ct->phanquyen == $val) {
                                    $model->forget($key);
                                    continue;
                                }
                            }
                        }

                        foreach ($a_phanquyen_xd as $val) {
                            if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                if ($ct->phanquyen == $val) {
                                    $model->forget($key);
                                    continue;
                                }
                            }
                        }

                        foreach ($a_phanquyen_qd as $val) {
                            if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                if ($ct->phanquyen == $val) {
                                    $model->forget($key);
                                    continue;
                                }
                            }
                        }
                    }
                    // }
                    // }
                    break;
                }
            case 'phongtraothidua': {
                    //phong trào cấp tỉnh thì tất cả đơn vị có thể nhìn thấy, phong trào cấp huyện thì chỉ có các đơn vị thuộc huyên mới xem được
                    //kiểm tra đơn vị có thuộc huyện, sở ban ngành để hiển thị thông báo phong trào
                    // foreach ($model as $key => $ct) {
                    $phongtrao = dsphongtraothidua::where('maphongtraotd', $ct->mahs_mapt)->first();
                    if (isset($phongtrao)) {
                        //Kiểm tra quyền
                        if (chkPhanQuyen('dshosothidua', 'phanquyen') == '0') {
                            $model->forget($key);
                            continue 2;
                        }
                        if (in_array($ct->phamvi, ['H', 'SBN'])) {
                            $madiaban = dsdonvi::where('madonvi', $ct->madonvi_thongbao)->first()->madiaban;
                            $diaban = array_column(dsdiaban::where('madiabanQL', $madiaban)->get()->toarray(), 'madiaban');
                            // dd($diaban);
                            // dd(session('admin'));
                            if (!in_array(session('admin')->madiaban, $diaban)) {
                                $model->forget($key);
                                continue 2;
                            }
                        }
                    } else {
                        $hosokt = dshosothiduakhenthuong::where('mahosotdkt', $ct->mahs_mapt)->first();
                        if(!isset($hosokt)){
                            $model->forget($key);
                            continue 2;
                        }
                        $a_dsphanquyen_tn = array(
                            'tnhosodenghikhenthuongthidua',
                        );
                        $a_phanquyen_xd = array(
                            'xdhosodenghikhenthuongthidua',
                        );
                        $a_phanquyen_qd = array(
                            'qdhosodenghikhenthuongthidua',
                        );
                        $hoso = dshosothiduakhenthuong_xuly::where('mahosotdkt', $ct->mahs_mapt)->orderby('created_at', 'desc')->get();
                        if (count($hoso) <= 0 && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                            $model->forget($key);
                            continue 2;
                        }
                        if (count($hoso) > 0) {
                            //Thông báo cho chức năng tiếp nhận
                            foreach ($a_dsphanquyen_tn as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                } else {
                                    if ($ct->taikhoan_tn != session('admin')->tendangnhap && $ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }

                            foreach ($a_phanquyen_xd as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }

                            foreach ($a_phanquyen_qd as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }
                        }
                    }
                    // }
                    break;
                }

            case 'cumkhoi': {
                    // foreach ($model as $key => $ct) {
                    $phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $ct->mahs_mapt)->first();
                    if (isset($phongtrao)) {
                        //Kiểm tra quyền
                        if (chkPhanQuyen('dshosothiduacumkhoi', 'phanquyen') == '0') {
                            $model->forget($key);
                            continue 2;
                        }
                    } else {
                        $hosokt = dshosotdktcumkhoi::where('mahosotdkt', $ct->mahs_mapt)->first();
                        if(!isset($hosokt)){
                            $model->forget($key);
                            continue 2;
                        }
                        $a_dsphanquyen_tn = array(
                            'tnhosodenghikhenthuongthiduacumkhoi',
                        );
                        $a_phanquyen_xd = array(
                            'xdhosodenghikhenthuongthiduacumkhoi',
                        );
                        $a_phanquyen_qd = array(
                            'qdhosodenghikhenthuongthiduacumkhoi',
                        );
                        $hoso = \App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_xuly::where('mahosotdkt', $ct->mahs_mapt)->orderby('created_at', 'desc')->get();
                        if (count($hoso) <= 0 && getPhanLoaiTKTiepNhan(session('admin')->madonvi) != session('admin')->tendangnhap) {
                            $model->forget($key);
                            continue 2;
                        }
                        if (count($hoso) > 0) {
                            //Thông báo cho chức năng tiếp nhận
                            foreach ($a_dsphanquyen_tn as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                } else {
                                    if ($ct->taikhoan_tn != session('admin')->tendangnhap && $ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }
                            foreach ($a_phanquyen_xd as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }
                            foreach ($a_phanquyen_qd as $val) {
                                if (chkPhanQuyen($val, 'phanquyen') == '0') {
                                    if ($ct->phanquyen == $val) {
                                        $model->forget($key);
                                        continue;
                                    }
                                }
                            }
                        }
                    }
                    // }
                    break;
                }
        }

        // if ($ct->trangthai == 'CHUADOC') {
        //     $sl += 1;
        // }
    };
    foreach ($model as $ct) {
        $trangthai = taikhoan_nhanthongbao::where('mathongbao', $ct->mathongbao)->where('tendangnhap', $tendangnhap)->first();
        $ct->trangthai = isset($trangthai) ? 'DADOC' : 'CHUADOC';
        if ($ct->trangthai == 'CHUADOC') {
            $sl += 1;
        }
    }
    // dd($model);
    return $sl;
}

function hasEmail()
{
    if (session('admin')->capdo == 'SSA') {
        return true;
    }
    $model = dstaikhoan::where('tendangnhap', session('admin')->tendangnhap)->first();
    if (isset($model->email)) {
        return true;
    } else {
        return false;
    }
}

function ChucNang()
{
    return [
        'congtrang' => 'Khen thưởng công trạng',
        'chuyende' => 'Khen thưởng theo đợt hoặc chuyên đề',
        'dotxuat' => 'Khen thưởng đột xuất',
        'conghien' => 'Khen thưởng theo quá trình cống hiến',
        'doingoai' => 'Khen thưởng đối ngoại',
        'khangchien' => 'Khen thưởng kháng chiến',
        'dsphongtraothidua' => 'Phong trào thi đua',
        'khenthuongphongtrao' => 'Khen thưởng theo phong trào thi đua',
        'dsphongtraothiduacumkhoi' => 'Phong trào thi đua cụm khối',
        'khenthuongcumkhoi' => 'Khen thưởng cụm khối'
    ];
}

function getDonViThamMuu($phamvi, $kieudulieu)
{
    switch ($phamvi) {
        case 'T': {
                $model = \App\Models\View\viewdiabandonvi::wherein('capdo', ['H', 'T'])->get();
                break;
            }
        case 'TW': {
                $model = \App\Models\View\viewdiabandonvi::wherein('capdo', ['H', 'T'])->get();
                break;
            }
        case 'H': {
                $model = \App\Models\View\viewdiabandonvi::wherein('capdo', ['H'])->get();
                break;
            }
        case 'SBN': {
                $model = \App\Models\View\viewdiabandonvi::wherein('capdo', ['H'])->get();
                break;
            }
        case 'X': {
                $model = \App\Models\View\viewdiabandonvi::wherein('capdo', ['X'])->get();
                break;
            }
    }

    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViXetDuyetDiaBan_PhongTrao($donvi, $kieudulieu = 'ARRAY', $donvithammuu = null)
{
    //Lấy đơn vị quản lý địa bàn và đơn vi
    $m_diaban = \App\Models\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
    //$a_donvi = [$m_diaban->madonviKT, $donvi->madonvi]; 2023.05.25 bỏ chức năng tự gửi hồ sơ đề nghị lên đơn mình do đã tách hồ sơ khen thưởng tại đơn vị
    $a_donvi = [$m_diaban->madonviKT];
    // dd($m_diaban);
    if ($donvithammuu != null) {
        if($donvi->madonvi == $donvithammuu){
            // dd($a_donvi);
            $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();

            if ($m_diabanQL != null)
                $a_donvi = [$m_diabanQL->madonviKT];
        }else{
            array_push($a_donvi, $donvithammuu);
        }

    } else {
        $m_diabanQL = \App\Models\DanhMuc\dsdiaban::where('madiaban', $m_diaban->madiabanQL)->first();

        if ($m_diabanQL != null)
            $a_donvi = array_merge($a_donvi, [$m_diabanQL->madonviKT]);
    }

    //2023.05.25 thêm điều kiện đơn vị không gửi đc cho chính mính (kể cả đơn vị quản lý ở cấp H)
    // if ($donvi->capdo != 'T') {
    //     $a_donvi = array_diff($a_donvi, [$donvi->madonvi]);
    // }

    $model = \App\Models\DanhMuc\dsdonvi::wherein('madonvi', $a_donvi)->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getTenPhongTrao_KhenThuong($mathongbao)
{
    $thongbao=\App\Models\ThongBao\thongbao::where('mathongbao',$mathongbao)->first();
    $mahoso=$thongbao->mahs_mapt;
    switch ($thongbao->phanloai){
        case 'quanly': {
            $hoso=dshosothiduakhenthuong::where('mahosotdkt',$mahoso)->first();
            $noidung=$hoso->noidung??'';
            break;
        }
        case 'phongtraothidua':{
            if($thongbao->chucnang == 'khenthuongphongtrao'){
                $hoso=dshosothiduakhenthuong::where('mahosotdkt',$mahoso)->first();
                $noidung=$hoso->noidung??'';
            }else{
                $hoso=\App\Models\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua::where('maphongtraotd',$mahoso)->first();
                $noidung=$hoso->noidung??'';
            }
            break;
        }
        case 'cumkhoi':{
            if($thongbao->chucnang == 'khenthuongcumkhoi'){
                $hoso= \App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi::where('mahosotdkt',$mahoso)->first();
                $noidung=$hoso->noidung??'';
            }else{
                $hoso=\App\Models\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi::where('mahosotdkt',$mahoso)->first();
                $noidung=$hoso->noidung??'';
            }
            break;
        }
    }
    return $noidung;
}

function getDiaDanh()
{
    $a_HeThongChung = getHeThongChung();
    //Xét theo tỉnh để cho chức năng đơn vị tham mưu chạy
    $diadanh = strtoupper(trim(str_replace(' ', '', chuyenkhongdau($a_HeThongChung['diadanh']))));
    return $diadanh;
}
