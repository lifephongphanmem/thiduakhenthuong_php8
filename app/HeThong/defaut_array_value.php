<?php

use App\Models\DanhMuc\dscumkhoi;
use App\Models\DanhMuc\dsdonvi;

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 3:05 PM
 */

function getPhanLoaiDiaBan()
{
    return array(
        'DVHC' => 'Đơn vị hành chính, sự nghiệp',
        'DIABAN' => 'Địa bàn hành chính',
        'DOANHNGHIEP' => 'Doanh nghiệp'
    );
}

function getPhanLoaiLocDuLieu()
{
    return array(
        'DONVI' => 'Đơn vị sử dụng',
        'DIABAN' => 'Địa bàn hành chính',
        'CUMKHOI' => 'Cụm, khối thi đua'
    );
}

function getPhanLoaiDoiTuong()
{
    return array(
        'Ông' => 'Ông',
        'Bà' => 'Bà',
    );
}

function getChucVuKhenThuong($capdo = 'T')
{
    return array(
        'Chủ tịch UBND Xã' => 'Chủ tịch UBND Xã',
        'Chủ tịch UBND Huyện' => 'Chủ tịch UBND Huyện',
        'Chủ tịch UBND Tỉnh' => 'Chủ tịch UBND Tỉnh',
        'Thủ tướng chính phủ' => 'Thủ tướng chính phủ',
        'Chủ tịch nước' => 'Chủ tịch nước',
        'Tổng giám đốc' => 'Tổng giám đốc',
        'Giám đốc' => 'Giám đốc',
        'Chủ tịch' => 'Chủ tịch',
    );
}

function getFontFamilyList()
{
    return array(
        'Arial' => 'Arial',
        'Times New Roman' => 'Times New Roman',
        'Shelley Allegro' => 'Shelley Allegro',
        'VnTimes' => 'VnTimes',
    );
}

function getDSToaDo_Truong()
{
    return  [
        'toado_tendoituongin' => 'tendoituongin',
        'toado_ngayqd' => 'ngayqd',
        'toado_chucvunguoikyqd' => 'chucvunguoikyqd',
        'toado_hotennguoikyqd' => 'hotennguoikyqd',
        'toado_chucvudoituong' => 'chucvudoituong',
        'toado_quyetdinh' => 'quyetdinh',
        'toado_pldoituong' => 'pldoituong',
        'toado_noidungkhenthuong' =>  'noidungkhenthuong',
    ];
}

function getTenTruongTheToaDo($tentoado)
{
    $a_kq = getDSToaDo_Truong();
    return $a_kq[$tentoado] ?? 'noidungkhenthuong';
}

function getLinhVucHoatDong()
{
    return array(
        '0001' => 'An ninh - Quốc phòng',
        '0009' => 'Báo chí - Thông tin - Truyền thông',
        '0021' => 'Bảo hiểm xã hội',
        '0022' => 'Các cơ quan, tổ chức Đảng',
        '0020' => 'Các tổ chức Hội và Đoàn thể',
        '0002' => 'Công nghiệp - Thương mại',
        '0023' => 'Cơ quan lập pháp',
        '0003' => 'Giáo dục - Đào tạo',
        '0004' => 'Giao thông vận tải',
        '0024' => 'Kế hoạch - Đầu tư',
        '0014' => 'Kinh tế - Xã hội',
        '0006' => 'Khoa học - Công nghệ',
        '0019' => 'Lao động, Thương Binh và Xã hội',
        '0005' => 'N/A',
        '0007' => 'Nông nghiệp - Nông thôn',
        '0015' => 'Ngoại giao',
        '0013' => 'Quản lý Nhà nước',
        '0008' => 'Tài chính - Ngân hàng',
        '0018' => 'Tài nguyên - Môi trường',
        '0016' => 'Tôn giáo - Tín ngưỡng',
        '0017' => 'Tư pháp - Thanh tra - Tòa án - Kiểm sát',
        '0010' => 'Văn hóa - Thể Thao - Du lịch',
        '0011' => 'Xây dựng',
        '0012' => 'Y tế',
    );
}

function getPhanLoaiDMDuThao()
{
    return array(
        'QUYETDINH' => 'Dự thảo quyết định khen thưởng',
        'TOTRINHHOSO' => 'Dự thảo tờ trình hồ sơ đề nghị khen thưởng',
        'TOTRINHPHEDUYET' => 'Dự thảo tờ trình phê duyệt khen thưởng',
        'KHAC' => 'Dự thảo khác',
    );
}

function getTrangThaiTheoDoi()
{
    return array(
        '0' => 'Không theo dõi',
        '1' => 'Có theo dõi',
    );
}

//chưa dùng
function getPhanLoaiHoSoKT()
{
    return array(
        'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
    );
}

function getPhanLoaiHoSo($phanloai = 'ALL')
{
    $a_kq = '';
    switch ($phanloai) {
        case 'ALL': {
                $a_kq = array(
                    'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
                    'KHENTHUONG' => 'Hồ sơ đề nghị cấp trên khen thưởng',
                    'KHENCAOTHUTUONG' => 'Hồ sơ đề nghị Thủ tướng chính phủ khen thưởng',
                    'KHENCAOCHUTICHNUOC' => 'Hồ sơ đề nghị Chủ tịch nước khen thưởng',
                    //'KTNGANH' => 'Hồ sơ khen thưởng theo ngành', //chuyển lên loại hồ sơ khen thưởng tại đơn vị
                );
                break;
            }
        case 'KTDONVI': {
                $a_kq = array(
                    'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
                );
                break;
            }
        case 'KHENTHUONG': {
                $a_kq = array(
                    'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
                    // 'KHENTHUONG' => 'Hồ sơ đề nghị cấp trên khen thưởng',
                    'KHENCAOTHUTUONG' => 'Hồ sơ khen thưởng của Thủ tướng chính phủ',
                    'KHENCAOCHUTICHNUOC' => 'Hồ sơ khen thưởng của Chủ tịch nước ',
                );
                break;
            }
            case 'DENGHIKHENTHUONG': {
                $a_kq = array(
                    'KHENCAOTHUTUONG' => 'Hồ sơ đề nghị Thủ tướng chính phủ khen thưởng',
                    'KHENCAOCHUTICHNUOC' => 'Hồ sơ đề nghị Chủ tịch nước khen thưởng',
                );
                break;
            }
            case 'DENGHIKHENTHUONGDV': {
                $a_kq = array(
                    'KHENTHUONG' => 'Hồ sơ đề nghị cấp trên khen thưởng',
                    'KHENCAOTHUTUONG' => 'Hồ sơ đề nghị Thủ tướng chính phủ khen thưởng',
                    'KHENCAOCHUTICHNUOC' => 'Hồ sơ đề nghị Chủ tịch nước khen thưởng',
                );
                break;
            }
        case 'KHANGCHIEN': {
                $a_kq = array(
                    'KTCHONGPHAP' => 'Hồ sơ khen thưởng kháng chiến chống Pháp',
                    'KTCHONGMY' => 'Hồ sơ khen thưởng kháng chiến chống Mỹ',

                );
                break;
            }
        case 'KHENCAO': {
                $a_kq = array(
                    'KHENCAOTHUTUONG' => 'Hồ sơ khen thưởng của Thủ tướng chính phủ',
                    'KHENCAOCHUTICHNUOC' => 'Hồ sơ khen thưởng của Chủ tịch nước',
                );
                break;
            }
        case 'BAOCAOKHENTINH': {
                $a_kq = array(
                    'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
                    'KHENTHUONG' => 'Hồ sơ đề nghị cấp trên khen thưởng',
                );
                break;
            }
    }

    return $a_kq;
}

function getPhanLoaiHoSo_BaoCao()
{
    return getPhanLoaiHoSo('ALL');
    // return array(
    //     'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
    //     'KHENTHUONG' => 'Hồ sơ đề nghị cấp trên khen thưởng',
    // );
}

function getPhamViKhenCao($phamvi = 'T')
{
    // dd($phamvi);
    switch ($phamvi) {
        case 'X': {
                return array(
                    'H' => 'Hồ sơ khen cấp Huyện',
                );
                break;
            }
        case 'H': {
                return array(
                    'T' => 'Hồ sơ khen cấp Tỉnh',
                );
                break;
            }
        case 'T': {
                return array(
                    'TW' => 'Hồ sơ khen cấp Nhà nước',
                );
                break;
            }
        default: {
                return array(
                    'TW' => 'Hồ sơ khen cấp Nhà nước',
                );
                break;
            }
    }
}

function getPhanLoaiHoSoKhenCao($phanloai = 'ALL')
{
    $a_kq = array(
        'KHENCAOTHUTUONG' => 'Hồ sơ khen của Thủ tướng chính phủ',
        'KHENCAOCHUTICHNUOC' => 'Hồ sơ khen của Chủ tịch nước',
        'KHANGCHIEN' => 'Hồ sơ khen kháng chiến',
    );
    if ($phanloai == 'ALL') {
        return $a_kq;
    } else {
        return [$phanloai => $a_kq[$phanloai]];
    }
}

function getTaoDuThaoToTrinhHoSoCumKhoi(&$model, $maduthao = null)
{
    //$maduthao = 'ALL' =>khỏi tạo lại dự thảo
    if ($maduthao  == 'ALL') {
        $thongtintotrinhhoso = App\Models\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->first()->codehtml ?? '';
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $tendonvi = $donvi->tendonvi ?? '';

        //Gán thông tin
        $thongtintotrinhhoso = str_replace('[noidung]', $model->noidung, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhhoso);
        //Thông tin đơn vị
        $thongtintotrinhhoso = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[chucvunguoiky]',  $model->chucvunguoiky, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[nguoikytotrinh]',  $donvi->nguoikytotrinh, $thongtintotrinhhoso);

        $m_canhan = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_canhan->count() > 0) {
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtintotrinhhoso = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhhoso);
        }

        //Tập thể
        $m_tapthe = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhhoso);
        }
        $model->thongtintotrinhhoso = $thongtintotrinhhoso;
    } else {
        //Load dự thảo theo mẫu
        if ($model->thongtintotrinhhoso == '') {
            if ($maduthao == null)
                $thongtintotrinhhoso = App\Models\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->first()->codehtml ?? '';
            else
                $thongtintotrinhhoso = App\Models\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

            $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
            $tendonvi = $donvi->tendonvi ?? '';

            //Gán thông tin
            $thongtintotrinhhoso = str_replace('[noidung]', $model->noidung, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhhoso);
            //Thông tin đơn vị
            $thongtintotrinhhoso = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[chucvunguoiky]',  $model->chucvunguoiky, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[nguoikytotrinh]',  $donvi->nguoikytotrinh, $thongtintotrinhhoso);

            $m_canhan = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
                ->where('ketqua', '1')->orderby('stt')->get();
            if ($m_canhan->count() > 0) {
                $s_canhan = '';
                $i = 1;
                foreach ($m_canhan as $canhan) {
                    $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $canhan->tendoituong .
                        ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                        ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
                        '</p>';
                    //dd($s_canhan);
                }
                //dd($s_canhan);
                // $thongtintotrinhhoso = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhhoso);
                $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhhoso);
            }

            //Tập thể
            $m_tapthe = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
                ->where('ketqua', '1')->orderby('stt')->get();
            if ($m_tapthe->count() > 0) {
                $s_tapthe = '';
                $i = 1;
                foreach ($m_tapthe as $chitiet) {
                    $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhhoso);
            }
            $model->thongtintotrinhhoso = $thongtintotrinhhoso;
        }
    }
}

function getTaoDuThaoToTrinhPheDuyetCumKhoi(&$model, $maduthao = null)
{

    //Load dự thảo theo mẫu
    if ($model->thongtintotrinhdenghi == '') {
        $thongtintotrinhdenghi = App\Models\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

        // Lấy danh sách khen thưởng theo cá nhân và tập thể
        $i_theodoi = 1;
        $m_canhan = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_tapthe = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_hogiadinh = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        $a_coquan=getDsCoQuan();
        //Xử lý các trường hợp
        //Cá nhân
        if ($m_canhan->count() > 0) {
            $s_canhan = IntToRoman($i_theodoi++) . '. Cá nhân';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $a_coquan[$canhan->tencoquan]??$canhan->tencoquan)) .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân,', $thongtintotrinhdenghi);
        } else {
            $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongcanhan]', '', $thongtintotrinhdenghi);
        }

        //Tập thể
        if ($m_tapthe->count() > 0) {
            $s_tapthe = IntToRoman($i_theodoi++) . '. Tập thể';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể,', $thongtintotrinhdenghi);
        } else {
            $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongtapthe]', '', $thongtintotrinhdenghi);
        }

        //Hộ gia đình
        if ($m_hogiadinh->count() > 0) {
            $s_hogiadinh = IntToRoman($i_theodoi++) . '. Hộ gia đình';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hogiadinh .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuonghogiadinh]',  $s_hogiadinh, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluonghogiadinh]', $m_hogiadinh->count() . ' hộ gia đình,', $thongtintotrinhdenghi);
        } else {
            $thongtintotrinhdenghi = str_replace('[khenthuonghogiadinh]',  '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluonghogiadinh]', '', $thongtintotrinhdenghi);
        }

        $model->thongtintotrinhdenghi = $thongtintotrinhdenghi;
        //Gán thông tin
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        // $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
        // $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();
        //Lấy đơn vị xét duyệt và đơn vị khen thưởng theo dscumkhoi
        $dscumkhoi = dscumkhoi::where('macumkhoi', $model->macumkhoi)->first();
        $donvi_xd = isset($dscumkhoi) ? dsdonvi::where('madonvi', $dscumkhoi->madonvixd)->first() : '';
        $donvi_kt = isset($dscumkhoi) ? dsdonvi::where('madonvi', $dscumkhoi->madonvikt)->first() : '';

        $model->thongtintotrinhdenghi = str_replace('[noidung]', $model->noidung, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[nguoikytotrinh]', $model->nguoikytotrinh, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[soqd]',  $model->soqd, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[diadanh]',  $donvi_xd->diadanh ?? '.......', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[donvidenghi]',  $donvi->tendvhienthi, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[donvikhenthuong]', $donvi_kt->tendvhienthi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[donvixetduyet]',  $donvi_xd->tendvhienthi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[sototrinhdenghi]',  $model->sototrinhdenghi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[chucvutotrinhdenghi]',  $model->chucvutotrinhdenghi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[nguoikytotrinhdenghi]',  $model->nguoikytotrinhdenghi ?? '', $model->thongtintotrinhdenghi);
    }
}

function getTaoDuThaoToTrinhHoSo(&$model, $maduthao = null)
{
    //Load dự thảo theo mẫu
    if ($model->thongtintotrinhhoso == '') {
        $thongtintotrinhhoso = App\Models\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

        // Lấy danh sách khen thưởng theo cá nhân và tập thể
        $i_theodoi = 1;
        $m_canhan = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_tapthe = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_hogiadinh = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();


        //Xử lý các trường hợp
        //Cá nhân
        if ($m_canhan->count() > 0) {
            $s_canhan = IntToRoman($i_theodoi++) . '. Cá nhân';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                    '</p>';
            }
            $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân,', $thongtintotrinhhoso);
        } else {
            $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  '', $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[soluongcanhan]', '', $thongtintotrinhhoso);
        }

        //Tập thể
        if ($m_tapthe->count() > 0) {
            $s_tapthe = IntToRoman($i_theodoi++) . '. Tập thể';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể,', $thongtintotrinhhoso);
        } else {
            $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  '', $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[soluongtapthe]', '', $thongtintotrinhhoso);
        }

        //Hộ gia đình
        if ($m_hogiadinh->count() > 0) {
            $s_hogiadinh = IntToRoman($i_theodoi++) . '. Hộ gia đình';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hogiadinh .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhhoso = str_replace('[khenthuonghogiadinh]',  $s_hogiadinh, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[soluonghogiadinh]', $m_hogiadinh->count() . ' hộ gia đình,', $thongtintotrinhhoso);
        } else {
            $thongtintotrinhhoso = str_replace('[khenthuonghogiadinh]',  '', $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[soluonghogiadinh]', '', $thongtintotrinhhoso);
        }

        $model->thongtintotrinhhoso = $thongtintotrinhhoso;
        //Gán thông tin
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
        $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();
        $model->thongtintotrinhhoso = str_replace('[noidung]', $model->noidung, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[nguoikytotrinh]', $model->nguoikytotrinh, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[soqd]',  $model->soqd, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[diadanh]',  $donvi->diadanh, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[donvidenghi]',  $donvi->tendvhienthi, $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[donvikhenthuong]', $donvi_kt->tendvhienthi ?? '', $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[donvixetduyet]',  $donvi_xd->tendvhienthi ?? '', $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[sototrinhdenghi]',  $model->sototrinhdenghi ?? '', $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[chucvutotrinhdenghi]',  $model->chucvutotrinhdenghi ?? '', $model->thongtintotrinhhoso);
        $model->thongtintotrinhhoso = str_replace('[nguoikytotrinhdenghi]',  $model->nguoikytotrinhdenghi ?? '', $model->thongtintotrinhhoso);
    }
}

function getTaoDuThaoToTrinhPheDuyet(&$model, $maduthao = null)
{
    //Load dự thảo theo mẫu
    if ($model->thongtintotrinhdenghi == '') {
        $thongtintotrinhdenghi = App\Models\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

        // Lấy danh sách khen thưởng theo cá nhân và tập thể
        $i_theodoi = 1;
        $m_canhan = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_tapthe = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_hogiadinh = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();


        //Xử lý các trường hợp
        //Cá nhân
        if ($m_canhan->count() > 0) {
            $s_canhan = IntToRoman($i_theodoi++) . '. Cá nhân';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân,', $thongtintotrinhdenghi);
        } else {
            $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongcanhan]', '', $thongtintotrinhdenghi);
        }

        //Tập thể
        if ($m_tapthe->count() > 0) {
            $s_tapthe = IntToRoman($i_theodoi++) . '. Tập thể';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể,', $thongtintotrinhdenghi);
        } else {
            $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongtapthe]', '', $thongtintotrinhdenghi);
        }

        //Hộ gia đình
        if ($m_hogiadinh->count() > 0) {
            $s_hogiadinh = IntToRoman($i_theodoi++) . '. Hộ gia đình';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hogiadinh .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuonghogiadinh]',  $s_hogiadinh, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluonghogiadinh]', $m_hogiadinh->count() . ' hộ gia đình,', $thongtintotrinhdenghi);
        } else {
            $thongtintotrinhdenghi = str_replace('[khenthuonghogiadinh]',  '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluonghogiadinh]', '', $thongtintotrinhdenghi);
        }

        $model->thongtintotrinhdenghi = $thongtintotrinhdenghi;
        //Gán thông tin
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
        $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();
        $model->thongtintotrinhdenghi = str_replace('[noidung]', $model->noidung, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[nguoikytotrinh]', $model->nguoikytotrinh, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[soqd]',  $model->soqd, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[diadanh]',  $donvi_xd->diadanh ?? '......', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[donvidenghi]',  $donvi->tendvhienthi, $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[donvikhenthuong]', $donvi_kt->tendvhienthi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[donvixetduyet]',  $donvi_xd->tendvhienthi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[sototrinhdenghi]',  $model->sototrinhdenghi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[chucvutotrinhdenghi]',  $model->chucvutotrinhdenghi ?? '', $model->thongtintotrinhdenghi);
        $model->thongtintotrinhdenghi = str_replace('[nguoikytotrinhdenghi]',  $model->nguoikytotrinhdenghi ?? '', $model->thongtintotrinhdenghi);
    }
}

function getTaoQuyetDinhKT(&$model, $maduthao = null)
{
    if ($model->thongtinquyetdinh == '') {
        getTaoDuThaoKT($model, $maduthao);
    }
    // dd($model);
    $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
    $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
    $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();

    $model->thongtinquyetdinh = str_replace('[nguoikytotrinh]', $model->nguoikytotrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[soqd]',  $model->soqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[diadanh]',  $donvi_kt->diadanh ?? '......', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvidenghi]',  $donvi->tendvhienthi, $model->thongtinquyetdinh);
    // $model->thongtinquyetdinh = str_replace('[donvikhenthuong]', $donvi_kt->tendvhienthi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvikhenthuong]', $donvi_kt->tendvhienthi ? mb_strtoupper($donvi_kt->tendvhienthi, 'UTF-8') : '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvixetduyet]',  $donvi_xd->tendvhienthi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinhdenghi]',  $model->sototrinhdenghi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvutotrinhdenghi]',  $model->chucvutotrinhdenghi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[nguoikytotrinhdenghi]',  $model->nguoikytotrinhdenghi ?? '', $model->thongtinquyetdinh);
}

function getTaoDuThaoKT(&$model, $maduthao = null)
{
    if ($model->thongtinquyetdinh == '') {
        if ($maduthao == null)
            $thongtinquyetdinh = App\Models\DanhMuc\duthaoquyetdinh::all()->first()->codehtml ?? '';
        else
            $thongtinquyetdinh = App\Models\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';
        $tendonvi = dsdonvi::where('madonvi', $model->madonvi)->first()->tendonvi ?? '';

        //Gán thông tin
        $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();

        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $thongtinquyetdinh);

        // Lấy danh sách khen thưởng theo cá nhân và tập thể
        $i_theodoi = 1;
        $m_canhan = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_tapthe = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_hogiadinh = App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();


        //Xử lý các trường hợp
        //Cá nhân
        if ($m_canhan->count() > 0) {
            $s_canhan = IntToRoman($i_theodoi++) . '. Cá nhân';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                    '</p>';
            }
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân,', $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongcanhan]', '', $thongtinquyetdinh);
        }

        //Tập thể
        if ($m_tapthe->count() > 0) {
            $s_tapthe = IntToRoman($i_theodoi++) . '. Tập thể';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể,', $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongtapthe]', '', $thongtinquyetdinh);
        }

        //Hộ gia đình
        if ($m_hogiadinh->count() > 0) {
            $s_hogiadinh = IntToRoman($i_theodoi++) . '. Hộ gia đình';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hogiadinh .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  $s_hogiadinh, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluonghogiadinh]', $m_hogiadinh->count() . ' hộ gia đình,', $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluonghogiadinh]', '', $thongtinquyetdinh);
        }
        //gán thong tin quyet dinh
        $model->thongtinquyetdinh = $thongtinquyetdinh;
    }
}

function getTaoQuyetDinhKTCumKhoi(&$model, $maduthao)
{
    if ($model->thongtinquyetdinh == '') {
        getTaoDuThaoKTCumKhoi($model, $maduthao);
    }
    $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
    $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
    $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();

    $model->thongtinquyetdinh = str_replace('[nguoikytotrinh]', $model->nguoikytotrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[soqd]',  $model->soqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[diadanh]',  $donvi_kt->diadanh ?? '......', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvidenghi]',  $donvi->tendvhienthi, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvikhenthuong]', $donvi_kt->tendvhienthi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvixetduyet]',  $donvi_xd->tendvhienthi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinhdenghi]',  $model->sototrinhdenghi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvutotrinhdenghi]',  $model->chucvutotrinhdenghi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[nguoikytotrinhdenghi]',  $model->nguoikytotrinhdenghi ?? '', $model->thongtinquyetdinh);
}

function getTaoDuThaoKTCumKhoi(&$model, $maduthao = null)
{
    if ($model->thongtinquyetdinh == '') {
        if ($maduthao == null)
            $thongtinquyetdinh = App\Models\DanhMuc\duthaoquyetdinh::all()->first()->codehtml ?? '';
        else
            $thongtinquyetdinh = App\Models\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';
        $tendonvi = dsdonvi::where('madonvi', $model->madonvi)->first()->tendonvi ?? '';

        //Gán thông tin
        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtinquyetdinh);

        $m_canhan = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        //dd($m_canhan);
        if ($m_canhan->count() > 0) {
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongcanhan]', '', $thongtinquyetdinh);
        }

        //Tập thể
        $m_tapthe = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongtapthe]', '', $thongtinquyetdinh);
        }

        //Hộ gia đình        
        $m_hogiadinh = App\Models\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_hogiadinh->count() > 0) {
            $s_hgd = '';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hgd .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  $s_hgd, $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluonghogiadinh]', '', $thongtinquyetdinh);
        }

        $model->thongtinquyetdinh = $thongtinquyetdinh;
    }
}

function getTaoQuyetDinhKTKhenCao(&$model, $maduthao)
{
    if ($model->thongtinquyetdinh == '') {
        $thongtinquyetdinh = App\Models\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';
        $tendonvi = dsdonvi::where('madonvi', $model->madonvi)->first()->tendonvi ?? '';

        //Gán thông tin
        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtinquyetdinh);

        $m_canhan = App\Models\NghiepVu\KhenCao\dshosokhencao_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        //dd($m_canhan);
        if ($m_canhan->count() > 0) {
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongcanhan]', '', $thongtinquyetdinh);
        }

        //Tập thể
        $m_tapthe = App\Models\NghiepVu\KhenCao\dshosodenghikhencao_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongtapthe]', '', $thongtinquyetdinh);
        }

        //Hộ gia đình        
        $m_hogiadinh = App\Models\NghiepVu\KhenCao\dshosokhencao_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_hogiadinh->count() > 0) {
            $s_hgd = '';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hgd .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  $s_hgd, $thongtinquyetdinh);
        } else {
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  '', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluonghogiadinh]', '', $thongtinquyetdinh);
        }

        $model->thongtinquyetdinh = $thongtinquyetdinh;
    }
    //Gán thông tin
    $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
    $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
    $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();

    $model->thongtinquyetdinh = str_replace('[nguoikytotrinh]', $model->nguoikytotrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[soqd]',  $model->soqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[diadanh]',  $donvi_kt->diadanh ?? '......', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvidenghi]',  $donvi->tendvhienthi, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvikhenthuong]', $donvi_kt->tendvhienthi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvixetduyet]',  $donvi_xd->tendvhienthi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinhdenghi]',  $model->sototrinhdenghi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[chucvutotrinhdenghi]',  $model->chucvutotrinhdenghi ?? '', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[nguoikytotrinhdenghi]',  $model->nguoikytotrinhdenghi ?? '', $model->thongtinquyetdinh);
}

function getNganhLinhVuc()
{
    /*
    Điều 3 Nghị định 99/NQ-CP ngày 24/6/2020 quy định
    a) Ngành, lĩnh vực nội vụ, gồm: Tổ chức bộ máy hành chính nhà nước; đơn vị sự nghiệp công lập; tiền lương của cán bộ, công chức, viên chức, vị trí việc làm;

    b) Ngành, lĩnh vực tài nguyên và môi trường, gồm: Biển và hải đảo;

    c) Ngành, lĩnh vực thông tin và truyền thông, gồm: Phát thanh và truyền hình;

    d) Ngành, lĩnh vực văn hóa, gồm: Điện ảnh;

    đ) Ngành, lĩnh vực y tế, gồm: Khám bệnh, chữa bệnh;

    e) Ngành, lĩnh vực xây dựng, gồm: Hoạt động đầu tư xây dựng; kiến trúc; quy hoạch; phát triển đô thị;

    g) Ngành, lĩnh vực khoa học và công nghệ, gồm: Hoạt động khoa học và công nghệ;

    h) Ngành, lĩnh vực lao động, thương binh và xã hội, gồm: Quản lý người lao động Việt Nam đi làm việc ở nước ngoài theo hợp đồng; an toàn, vệ sinh lao động;

    i) Ngành, lĩnh vực tài chính, gồm: Thu ngân sách nhà nước; chi ngân sách nhà nước; quản lý nợ công; phí và lệ phí; tài sản công;

    k) Ngành, lĩnh vực kế hoạch và đầu tư, gồm: Quản lý đầu tư; đầu tư công; đầu tư nước ngoài.
    */
    $a_nganh = array(
        'NLVNOIVU' => 'Ngành, lĩnh vực nội vụ',
        'NLVTAINGHUYEN' => 'Ngành, lĩnh vực tài nguyên và môi trường',
        'NLVTHONGTIN' => 'Ngành, lĩnh vực thông tin và truyền thông',
        'NLVVANHOA' => 'Ngành, lĩnh vực văn hóa',
        'NLVYTE' => 'Ngành, lĩnh vực y tế',
        'NLVXAYDUNG' => 'Ngành, lĩnh vực xây dựng',
        'NLVKHOAHOC' => 'Ngành, lĩnh vực khoa học và công nghệ',
        'NLVLAODONG' => 'Ngành, lĩnh vực lao động, thương binh và xã hội',
        'NLVTAICHINH' => 'Ngành, lĩnh vực tài chính',
        'NLVKEHOACH' => 'Ngành, lĩnh vực kế hoạch và đầu tư',
        'NLVGDDT' => 'Ngành, lĩnh vực giáo dục và đào tạo',
        'NLVTDTT' => 'Ngành, lĩnh vực thể dục và thể thao',
        'NLVQLNN' => 'Ngành, lĩnh vực quản lý nhà nước',
    );
    return $a_nganh;
}

function getTenTrangThaiPT($trangthai)
{
    $a_trangthai = array(
        'DKT' => 'Đã khen thưởng',
        'DXKT' => 'Đang xét khen thưởng',
        'CC' => 'Đang phát động',
    );
    return $a_trangthai[$trangthai] ?? $trangthai;
}

function getLoaiVbQlNn()
{
    $vbqlnn = array(
        'luat' => 'Luật',
        'nghidinh' => 'Nghị định',
        'nghiquyet' => 'Nghị quyết',
        'thongtu' => 'Thông tư',
        'quyetdinh' => 'Quyết định',
        'vbhd' => 'Văn bản hướng dẫn',
        'baocao' => 'Báo cáo tình hình giá trị trường',
        'tailieu' => 'Báo cáo, tài liệu học tập kinh nghiệm',
        'khoahoc' => 'Kết quả, đề tài nghiên cứu khoa học',
        'vbkhac' => 'Báo cáo, văn bản có liên quan khác',
    );
    return $vbqlnn;
}

function getTrangThaiVanBan()
{
    $vbqlnn = array(
        'CONHL' => 'Còn hiệu lực',
        'HETMP' => 'Hết hiệu lực một phần',
        'HETHL' => 'Hết hiệu lực',
    );
    return $vbqlnn;
}

function getPhanLoaiPhongTraoThiDua($all = false)
{
    $a_kq = array(
        'CHUYENDE' => 'Phong trào thi đua thường xuyên',
        'DOT' => 'Phong trào thi đua theo đợt',
        'HANGNAM' => 'Phong trào thi đua hàng năm',
        'NAMNAM' => 'Phong trào thi đua 05 năm',
        'KHAC' => 'Phong trào thi đua khác',
    );
    if ($all == true) {
        return array_merge(['ALL' => 'Tất cả'], $a_kq);
    }
    return $a_kq;
}

function getPhanLoaiDonVi_DiaBan()
{
    return array(
        //'ADMIN'=>'Đơn vị tổng hợp toàn Tỉnh',
        'T' => 'Đơn vị hành chính cấp Tỉnh',
        'H' => 'Đơn vị hành chính cấp Huyện',
        'X' => 'Đơn vị hành chính cấp Xã',
    );
}

function getPhanLoaiDonViCumKhoi()
{
    return array(
        'TRUONGKHOI' => 'Trưởng cụm, khối',
        'PHOKHOI' => 'Phó trưởng cụm, khối',
        'THANHVIEN' => 'Thành viên',
    );
}

function getPhamViApDung()
{
    return array(
        //'ADMIN'=>'Đơn vị tổng hợp toàn Tỉnh',
        'TW' => 'Cấp Nhà nước',
        'T' => 'Cấp Tỉnh',
        'H' => 'Cấp Huyện',
        'X' => 'Cấp Xã',
    );
}

function getNhomChiQuy()
{
    return array(
        'KHENTHUONG' => 'Chi khen thưởng',
        'KHAC' => 'Chi khác',
    );
}

function getPhanLoaiQuy()
{
    return array(
        'THU' => 'Thu',
        'CHI' => 'Chi',
    );
}

function getDoiTuongApDung()
{
    return array(
        'CANHAN' => 'Cá nhân',
        'TAPTHE' => 'Tập thể',
        'HOGIADINH' => 'Hộ gia đình',
    );
}

function getPhamViKhenThuong()
{
    return array(
        'TW' => 'Cấp Nhà nước',
        'T' => 'Cấp Tỉnh',
        'SBN' => 'Cấp Sở, ban, ngành',
        'H' => 'Cấp Huyện',
        'X' => 'Cấp Xã',
    );
}

function getPhanLoaiDonVi()
{
    return array(
        'TONGHOP' => 'Đơn vị tổng hợp dữ liệu',
        'NHAPLIEU' => 'Đơn vị nhập liệu',
        'QUANTRI' => 'Đơn vị quản trị hệ thống',
    );
}

function getPhanLoaiTDKT()
{
    return array(
        'CANHAN' => 'Áp dụng đối với cá nhân',
        'TAPTHE' => 'Áp dụng đối với tập thể',
        'HOGIADINH' => 'Áp dụng đối với hộ gia đình',
    );
}

function getPhanLoaiHinhThucKT()
{
    return array(
        'DANHHIEUTD' => 'Danh hiệu thi đua',
        'HUANCHUONG' => 'Huân chương',
        'HUYCHUONG' => 'Huy chương',
        'DANHHIEUNN' => 'Danh hiệu vinh dự Nhà nước',
        'GIAITHUONG' => 'Giải thưởng Hồ Chí Minh, Giải thưởng Nhà nước',
        'KYNIEMCHUONG' => 'Kỷ niệm chương, Huy hiệu',
        'BANGKHEN' => 'Bằng khen',
        'GIAYKHEN' => 'Giấy khen',
    );
}

function getPhamViPhongTrao($capdo = 'T')
{
    // return array(
    //     'CUNGCAP' => 'Các đơn vị trong cùng cấp quản lý (cùng địa bàn quản lý)',
    //     'CAPDUOI' => 'Các đơn vị cấp dưới quản lý trực tiếp',
    //     'TOANTINH' => 'Toàn bộ các đơn vị trong Tỉnh',
    //     'TRUNGUONG' => 'Phong trào thi đua cấp TW',
    // );
    $a_kq['T'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
        'H' => 'Phong trào thi đua cấp Huyện',
        'T' => 'Phong trào thi đua cấp Tỉnh',
        'SBN' => 'Phong trào cho Sở, ban, ngành',
        'TW' => 'Phong trào thi đua cấp Nhà nước',
    );
    $a_kq['H'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
        'H' => 'Phong trào thi đua cấp Huyện',
    );
    $a_kq['X'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
    );
    return $a_kq[$capdo];
}

function getPhamViPhatDongPhongTrao($capdo = 'T')
{
    // return array(
    //     'CUNGCAP' => 'Các đơn vị trong cùng cấp quản lý (cùng địa bàn quản lý)',
    //     'CAPDUOI' => 'Các đơn vị cấp dưới quản lý trực tiếp',
    //     'TOANTINH' => 'Toàn bộ các đơn vị trong Tỉnh',
    //     'TRUNGUONG' => 'Phong trào thi đua cấp TW',
    // );
    $a_kq['T'] =  array(
        //'X' => 'Phong trào thi đua cấp Xã',
        //'H' => 'Phong trào thi đua cấp Huyện',
        'T' => 'Phong trào thi đua cấp Tỉnh',
        'TW' => 'Phong trào thi đua cấp Trung Ương',
    );
    $a_kq['H'] =  array(
        //'X' => 'Phong trào thi đua cấp Xã',
        'SBN' => 'Phong trào cho Sở, ban, ngành',
        'H' => 'Phong trào thi đua cấp Huyện',
    );
    $a_kq['X'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
    );
    return $a_kq[$capdo];
}

function getPhamViApDungPhongTrao($capdo = 'T')
{
    $a_kq['T'] =  array('T', 'TW',);
    $a_kq['H'] =  array('H', 'SBN', 'T', 'TW',);
    $a_kq['X'] =  array('X', 'H', 'T', 'TW',);
    return $a_kq[$capdo];
}

function getPhamViThongKe($capdo = 'T')
{
    $a_kq['T'] =  array('T' => 'Cấp Tỉnh', 'H' => 'Cấp Huyện', 'X' => 'Cấp Xã');
    $a_kq['H'] =  array('H' => 'Cấp Huyện', 'X' => 'Cấp Xã');
    $a_kq['X'] =  array('X' => 'Cấp Xã');
    return $a_kq[$capdo];
}

function getTrangThaiTDKT()
{
    return array(
        'CHUABATDAU' => 'Chưa bắt đầu nhận hồ sơ',
        'DANGNHAN' => 'Đang nhận hồ sơ',
        'DXKT' => 'Đang xét khen thưởng',
        'KETTHUC' => 'Đã kết thúc nhận hồ sơ',
    );
}

function getGioiTinh()
{
    return array(
        'NAM' => 'Nam',
        'NU' => 'Nữ',
        'KHAC' => 'Khác',
    );
}

function getLoaiVanBan()
{
    $vbqlnn = array(
        'luat' => 'Luật',
        'nghidinh' => 'Nghị định',
        'nghiquyet' => 'Nghị quyết',
        'thongtu' => 'Thông tư',
        'quyetdinh' => 'Quyết định',
        // 'vbhdcd' => 'Văn bản hướng dẫn, chỉ đạo',
        'vbpl' => 'Văn bản pháp lý',
        'vbdh' => 'Văn bản điều hành',
        'vbkhac' => 'Văn bản khác',
    );
    return $vbqlnn;
}

function getThoiDiem()
{
    return [
        '06THANGDAUNAM' => 'Báo cáo 06 tháng đầu năm',
        '06THANGCUOINAM' => 'Báo cáo 06 tháng cuối năm',
        'CANAM' => 'Báo cáo cả năm',
        '05NAM' => 'Báo cáo 05 năm',
        'quy1' => 'Quý I',
        'quy2' => 'Quý II',
        'quy3' => 'Quý III',
        'quy4' => 'Quý IV',
        'thang01' => 'Tháng 01',
        'thang02' => 'Tháng 02',
        'thang03' => 'Tháng 03',
        'thang04' => 'Tháng 04',
        'thang05' => 'Tháng 05',
        'thang06' => 'Tháng 06',
        'thang07' => 'Tháng 07',
        'thang08' => 'Tháng 08',
        'thang09' => 'Tháng 09',
        'thang10' => 'Tháng 10',
        'thang11' => 'Tháng 11',
        'thang12' => 'Tháng 12',
    ];
}

function getTDChiTiet()
{
    // return [
    //     '06THANGDAUNAM' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-06-30'],
    //     '06THANGCUOINAM' => ['tungay' => $nam . '-07-01', 'denngay' => $nam . '-12-31'],
    //     'CANAM' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-12-31'],
    //     '05NAM' => ['tungay' => '2020-01-01', 'denngay' => $nam . '2025-12-31'],
    //     'quy1' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-03-31'],
    //     'quy2' => ['tungay' => $nam . '-04-01', 'denngay' => $nam . '-06-30'],
    //     'quy3' => ['tungay' => $nam . '-07-01', 'denngay' => $nam . '-09-30'],
    //     'quy4' => ['tungay' => $nam . '-10-01', 'denngay' => $nam . '-12-31'],
    //     'thang01' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-12-31'],
    //     'thang02' => ['tungay' => $nam . '-02-01', 'denngay' => $nam . '-12-31'],
    //     'thang03' => ['tungay' => $nam . '-03-01', 'denngay' => $nam . '-12-31'],
    //     'thang04' => ['tungay' => $nam . '-04-01', 'denngay' => $nam . '-12-31'],
    //     'thang05' => ['tungay' => $nam . '-05-01', 'denngay' => $nam . '-12-31'],
    //     'thang06' => ['tungay' => $nam . '-06-01', 'denngay' => $nam . '-12-31'],
    //     'thang07' => ['tungay' => $nam . '-07-01', 'denngay' => $nam . '-12-31'],
    //     'thang08' => ['tungay' => $nam . '-08-01', 'denngay' => $nam . '-12-31'],
    //     'thang09' => ['tungay' => $nam . '-09-01', 'denngay' => $nam . '-12-31'],
    //     'thang10' => ['tungay' => $nam . '-10-01', 'denngay' => $nam . '-12-31'],
    //     'thang11' => ['tungay' => $nam . '-11-01', 'denngay' => $nam . '-12-31'],
    //     'thang12' => ['tungay' => $nam . '-12-01', 'denngay' => $nam . '-12-31'],
    // ];
}

function getThang($all = false)
{
    $a_tl = array(
        '01' => '01', '02' => '02', '03' => '03',
        '04' => '04', '05' => '05', '06' => '06',
        '07' => '07', '08' => '08', '09' => '09',
        '10' => '10', '11' => '11', '12' => '12'
    );
    if ($all)
        return array_merge(array('ALL' => '--Tất cả--'), $a_tl);
    else
        return $a_tl;
}

function getNam($all = false)
{
    $a_tl = $all == true ? array('ALL' => 'Tất cả') : array();
    for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++) {
        $a_tl[$i] = $i;
    }
    return $a_tl;
}

function getTrangThaiHoSo()
{
    return [
        'CC' => 'Chờ chuyển',
        'CD' => 'Chờ duyệt',
        'BTL' => 'Bị trả lại',
        'BTLXD' => 'Trả lại xét duyệt',
        'CXKT' => 'Chờ xét khen thưởng',
        'DKT' => 'Đã khen thưởng',
        'DXKT' => 'Đang xét khen thưởng',
        'DD' => 'Chờ chuyển khen thưởng',
        'DDK' => 'Đủ điều kiện',
        'KDK' => 'Không điều kiện',
        'DCCVXD' => 'Đã chuyển chuyên viên xét duyệt',
        'DCCVKT' => 'Đã chuyển chuyên viên khen thưởng',
        'DTH' => 'Đã tổng hợp',
    ];
}

function getTrangThaiXuLyHoSo()
{
    return [
        'DDK' => 'Đủ điều kiện',
        'KDK' => 'Không điều kiện',
    ];
}

//Gán cho mặc định chức năg
function getTrangThaiChucNangHoSo($trangthai = 'ALL')
{
    $a_kq = [
        'CC' => 'Chờ chuyển', //=>Nộp hồ sơ bình thưởng
        'CD' => 'Chờ duyệt', //
        'DTN' => 'Đã tiếp nhận', //
        'DD' => 'Chờ chuyển khen thưởng', //
        'CXKT' => 'Chờ xét khen thưởng', //Đã gán madonvi_xd,madonvi_kt,
        'DKT' => 'Đã khen thưởng', //Đã gán madonvi_xd,madonvi_kt,
        'BTL' => 'Bị trả lại',
        'BTLXD' => 'Trả lại xét duyệt',
        'DXL' => 'Đã xử lý',
        'DTH' => 'Đã tổng hợp',
        // 'DDK' => 'Đủ điều kiện',
        // 'KDK' => 'Không điều kiện',
    ];
    return $trangthai == 'ALL' ? $a_kq : [$trangthai => $a_kq[$trangthai]];
}

function getTEST()
{
    return [
        'Hồ sơ' => ['CC' => 'Chờ chuyển',],
        'Xét duyệt' => ['CD' => 'Chờ duyệt', 'DD' => 'Đã duyệt',],
        'Phê duyệt' => ['CXKT' => 'Chờ xét khen thưởng', 'DKT' => 'Đã khen thưởng',],
    ];
}

function getTrangThai_TD_HoSo($trangthai)
{
    $a_trangthai = [
        'CC' => [
            'trangthai' => 'Chờ chuyển',
            'class' => 'badge badge-warning'
        ],

        'CD' => [
            'trangthai' => 'Chờ duyệt',
            'class' => 'badge badge-info'
        ],

        'DTN' => [
            'trangthai' => 'Đã tiếp<br>nhận',
            'class' => 'badge badge-info'
        ],
        'CXD' => [
            'trangthai' => 'Không có<br>hồ sơ',
            'class' => 'badge badge-info'
        ],
        'BTL' => [
            'trangthai' => 'Bị trả<br>lại',
            'class' => 'badge badge-danger'
        ],

        'BTLXD' => [
            'trangthai' => 'Trả lại<br>xét duyệt',
            'class' => 'badge badge-danger'
        ],
        'BTLTN' => [
            'trangthai' => 'Trả lại<br>tiếp nhận',
            'class' => 'badge badge-danger'
        ],

        'CNXKT' => [
            'trangthai' => 'Chờ nhận<br>để xét<br>khen thưởng',
            'class' => 'badge badge-info'
        ],
        'CXKT' => [
            'trangthai' => 'Chờ xét<br>khen thưởng',
            'class' => 'badge badge-warning'
        ],

        'DKT' => [
            'trangthai' => 'Đã khen<br>thưởng',
            'class' => 'badge badge-success'
        ],
        'DD' => [
            'trangthai' => 'Chờ chuyển<br>khen thưởng',
            'class' => 'badge badge-success'
        ],

        'DXKT' => [
            'trangthai' => 'Đang xét<br>khen thưởng',
            'class' => 'badge badge-warning'
        ],

        'DDK' => [
            'trangthai' => 'Đủ điều<br>kiện',
            'class' => 'badge badge-success'
        ],
        'KDK' => [
            'trangthai' => 'Không đủ điều<br>kiện',
            // 'class' => 'badge badge-warning'
            'class' => 'badge badge-danger'
        ],
        'DCCVXD' => [
            'trangthai' => 'Đã chuyển</br>chuyên viên</br>xét duyệt',
            'class' => 'badge badge-warning'
        ],
        'DCCVKT' => [
            'trangthai' => 'Đã chuyển</br>chuyên viên</br>khen thưởng',
            'class' => 'badge badge-warning'
        ],
        'DTH' => [
            'trangthai' => 'Đã chuyển</br>tổng hợp',
            'class' => 'badge badge-success'
        ],
        'DCXL' => [
            'trangthai' => 'Đã chuyển</br>xử lý',
            'class' => 'badge badge-warning'
        ]

    ];

    return $a_trangthai[$trangthai] ?? ['trangthai' => $trangthai, 'class' => 'badge badge-info'];
}

function getPhanLoaiTaiLieuDK($phanloaihoso = 'ALL')
{
    //Đề nghị khen thưởng
    if ($phanloaihoso == 'DENGHI') {
        return  [
            'TOTRINH' => 'Tờ trình đề nghị khen thưởng',
            'BAOCAO' => 'Báo cáo thành tích',
            'BIENBAN' => 'Biên bản cuộc họp',
            'DTKH' => 'Đề tài khoa học',
            'SANGKIEN' => 'Sáng kiến sáng tạo',
            'KHAC' => 'Tài liệu khác',
        ];
    }
    //Tờ trình kết quả khen thưởng
    if ($phanloaihoso == 'TOTRINHKQ') {
        return [
            'TOTRINHKQ' => 'Tờ trình kết quả khen thưởng',
        ];
    }
    //Tờ trình kết quả khen thưởng & ý kiến đóng góp
    if ($phanloaihoso == 'TOTRINHKQ&YKIEN') {
        return [
            'TOTRINHKQ' => 'Tờ trình kết quả khen thưởng',
            'YKIEN' => 'Ý kiến đóng góp'
        ];
    }
    //Quyết định khen thưởng
    if ($phanloaihoso == 'QDKT') {
        return [
            'QDKT' => 'Quyết định khen thưởng',
        ];
    }
    // //Đăng ký phong trào thi đua
    // if($phanloaihoso == "PHONGTRAO")
    // {
    //     return [
    //         'BIENBAN'=>'Biên bản cuộc họp',
    //         'KHAC'=>'Tài liệu khác'
    //     ];
    // }
    //dd($phanloaihoso);
    //Hồ sơ khen thưởng
    $a_kq = [
        'TOTRINH' => 'Tờ trình đề nghị khen thưởng',
        'BAOCAO' => 'Báo cáo thành tích',
        'BIENBAN' => 'Biên bản cuộc họp',
        'DTKH' => 'Đề tài khoa học',
        'SANGKIEN' => 'Sáng kiến sáng tạo',
        'TOTRINHKQ' => 'Tờ trình kết quả khen thưởng',
        'QDKT' => 'Quyết định khen thưởng',
        'YKIEN' => 'Ý kiến đóng góp',
        'KHAC' => 'Tài liệu khác',
    ];
    return $a_kq;
}

function getTenTruongDuLieuDuThao()
{
    /* Sau làm bảng để phần mềm chạy tự động
    '[noidung]', $model->noidung, $thongtintotrinhhoso);
    '[chucvunguoiky]',  $model->chucvunguoiky, $thongtintotrinhhoso);
    '[nguoikytotrinh]',  $donvi->nguoikytotrinh, $thongtintotrinhhoso);
            
            [khenthuongcanhan]
            [khenthuongtapthe]
            [khenthuonghogiadinh]
            [khenthuongtapthevahogiadinh]
             '[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtinquyetdinh);
        '[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtinquyetdinh);
        '[soqd]',  $model->soqd, $model->thongtinquyetdinh);
        '[sototrinh]',  $model->sototrinh, $model->thongtinquyetdinh);
        '[diadanh]',  '......', $model->thongtinquyetdinh);
        '[ngayqd]',  Date2Str($model->ngayqd), $model->thongtinquyetdinh);
        '[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtinquyetdinh);
        '[donvidenghi]',  $tendonvi, $model->thongtinquyetdinh);
        '[donvikhenthuong]',  $model->donvikhenthuong, $model->thongtinquyetdinh);
        '[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $model->thongtinquyetdinh);
        */
    return [
        //Thông tin tờ trình đề nghị khen thưởng
        '[ngayhoso]' => 'Ngày tháng tạo hồ sơ (ngày trình đề nghị)',
        '[sototrinh]' => 'Số tờ trình đề nghị khen thưởng',
        '[chucvunguoiky]' => 'Chức vụ người ký tờ trình',
        '[nguoikytotrinh]' => 'Họ tên người ký tờ trình',
        '[donvidenghi]' => 'Tên đơn vị đề nghị khen thưởng (theo thông tin đơn vị)',
        //Thông tin tờ trình kết quả khen thưởng
        '[sototrinhdenghi]' => 'Số tờ trình kết quả khen thưởng',
        '[ngaythangtotrinhdenghi]' => 'Ngày trình kết quả khen thưởng',
        '[chucvutotrinhdenghi]' => 'Chức vụ người ký tờ trình kết quả khen thưởng',
        '[nguoikytotrinhdenghi]' => 'Họ tên người ký tờ trình kết quả khen thưởng',
        '[donvixetduyet]' => 'Tên đơn vị xét duyệt hồ sơ (theo thông tin đơn vị)',
        //Thông tin quyết định khen thưởng
        '[chucvunguoikyqd]' => 'Chức vụ người ký quyết định khen thưởng',
        '[hotennguoikyqd]' => 'Họ tên người ký quyết định khen thưởng',
        '[soqd]' => 'Số quyết định khen thưởng',
        '[ngayqd]' => 'Ngày tháng quyết định',
        '[donvikhenthuong]' => 'Tên đơn vị phê duyệt khen thưởng (theo thông tin đơn vị)',
        //Thông tin chung
        '[noidung]' => 'Nội dung hồ sơ',
        '[diadanh]' => 'Địa danh (theo thông tin đơn vị)',
        '[hinhthuckhenthuong]' => 'Tên hình thức khen thưởng', //Đang lấy mặc định 
        //Thông tin danh sách khen thưởng
        '[soluongtapthe]' => 'Tổng số lượng khen thưởng cho tập thể',
        '[soluongcanhan]' => 'Tổng số lượng khen thưởng cho cá nhân',
        '[soluonghogiadinh]' => 'Tổng số lượng khen thưởng cho hộ gia đình',
        '[soluongtapthevahogiadinh]' => 'Tổng số lượng khen thưởng cho tập thể và hộ gia đình',
        '[khenthuongcanhan]' => 'Danh sách khen thưởng của cá nhân',
        '[khenthuongtapthe]' => 'Danh sách khen thưởng của tập thể',
        '[khenthuonghogiadinh]' => 'Danh sách khen thưởng của hộ gia đình',
        '[khenthuongtapthevahogiadinh]' => 'Danh sách khen thưởng của tạp thể và hộ gia đình',


    ];
}

function getPhanLoaiChuKySo($phanloaihoso = 'ALL')
{

    $a_kq = [
        'MACDINH' => 'Không dùng chữ ký số',
        'BANCOYEU' => 'Chữ ký số của Ban cơ yếu chính phủ',
    ];
    return $a_kq;
}

function getQuyTrinhXuLyKhenThuong()
{
    $a_kq = [
        'DIABAN' => 'Theo địa bàn quản lý',
        'TAIKHOAN' => 'Theo chuyên viên',
    ];
    return $a_kq;
}

function getPhanLoaiTaiKhoan()
{
    $a_kq = [
        'LANHDAO' => 'Tài khoản lãnh đạo',
        'QUANLY' => 'Tài khoản trưởng ban (trưởng phòng)',
        'PHOPHONG' => 'Tài khoản phó trưởng ban (phó trưởng phòng)',
        'CHUYENVIEN' => 'Tài khoản chuyên viên',
        'VANTHU' => 'Tài khoản văn thư',
    ];
    return $a_kq;
}

function getPhanLoaiDotXetKhenThuong()
{
    $a_kq = [
        'KETTHUC' => 'Khen thưởng khi kết thúc phong trào',
        'NHIEUDOT' => 'Khen thưởng theo từng giai đoạn',
    ];
    return $a_kq;
}

function getThoiHanThiDua()
{
    $a_kq = [
        'DUOIMOTNAM' => 'Dưới 01 năm',
        'MOTNAM' => '01 năm',
        'MOTNAMDENBANAM' => 'Từ 01 năm đến dưới 03 năm',
        'BANAMDENNAMNAM' => 'Từ 03 năm đến dưới 05 năm',
        'TRENNAMNAM' => 'Từ 05 năm trở lên',
    ];
    return $a_kq;
}

function getPhuongThucToChucPhongTrao()
{
    $a_kq = [
        'CHUYENDE' => 'Thi đua theo chuyên đề',
        'HANGNAM' => 'Thi đua thường xuyên hàng năm',
    ];
    return $a_kq;
}
