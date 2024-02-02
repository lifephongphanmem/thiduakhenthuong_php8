<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Models\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;

class APIdungchungController extends Controller
{
    public function convertHoSo($hoso, $danhsachdonvi)
    {

        $a_kq = [
            'MaHoSo' => $hoso->mahosotdkt,
            'LoaiHinhKhenThuong' => $hoso->mahinhthuckt,
            'NoiDungKhenThuong' => $hoso->noidung,
            'SoQuyetDinh' => $hoso->soqd,
            'NgayQuyetDinh' => $hoso->ngayqd,
            'TrangThaiHoSo' => $hoso->trangthai,
        ];
        //Gán thông tin đơn vị
        $donvi_denghi = $danhsachdonvi->where('madonvi', $hoso->madonvi)->first();
        $a_kq['MaDonViDeNghi'] = $donvi_denghi->madonvi;
        $a_kq['TenDonViDeNghi'] = $donvi_denghi->tendonvi;
        $a_kq['MaQuanHeNganSachDonViDeNghi'] = $donvi_denghi->maqhns;

        $donvi_xd = $danhsachdonvi->where('madonvi', $hoso->madonvi_xd)->first();
        $a_kq['MaDonViXetDuyet'] = $donvi_xd->madonvi ?? '';
        $a_kq['TenDonViXetDuyet'] = $donvi_xd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViXetDuyet'] = $donvi_xd->maqhns ?? '';

        $donvi_pd = $danhsachdonvi->where('madonvi', $hoso->madonvi_kt)->first();
        $a_kq['MaDonViPheDuyet'] = $donvi_pd->madonvi ?? '';
        $a_kq['TenDonViPheDuyet'] = $donvi_pd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViPheDuyet'] = $donvi_pd->maqhns ?? '';
        //Gán tài liệu đính kèm
        $tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $hoso->mahosotdkt)->get();
        $a_tailieu = [];
        $i = 1;
        foreach ($tailieu as $dinhkem) {
            $a_tailieu[] = [
                'STT' => $i++,
                'TenTaiLieu' => $dinhkem->tentailieu,
                'PhanLoaiTaiLieu' => $dinhkem->phanloai,
                'MoTaTaiLieu' => $dinhkem->noidung,
                'Base_64' => $dinhkem->base64,
                'MaDonViDinhKem' => $dinhkem->madonvi,
            ];
        }
        $a_kq['DanhSachTaiLieu'] = $a_tailieu;
        //Gán khen thưởng cá nhân
        $canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->get();
        $a_canhan = [];
        $i = 1;
        foreach ($canhan as $ct) {
            $a_canhan[] = [
                'STT' => $i++,
                'MaCongChucVienChuc' => $ct->maccvc,
                'TenCanBo' => $ct->tendoituong,
                'NgaySinh' => $ct->ngaysinh,
                'GioiTinh' => $ct->gioitinh,
                'ChucVu' => $ct->chucvu,
                'DiaChi' => $ct->diachi,
                'TenPhongBan' => $ct->tenphongban,
                'TenDonViCongTac' => $ct->tencoquan,
                'MaPhanLoaiDoiTuong' => $ct->maphanloaicanbo,
                'MaHinhThucKhenThuong' => $ct->madanhhieukhenthuong,
                'KetQuaKhenThuong' => $ct->ketqua,
                'GhiChu' => $ct->lydo,
            ];
        }
        $a_kq['DanhSachKhenThuongCaNhan'] = $a_canhan;

        //Gán khen thưởng tập thể
        $tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->get();
        $a_tapthe = [];
        $i = 1;
        foreach ($tapthe as $ct) {
            $a_tapthe[] = [
                'STT' => $i++,
                'TenTapThe' => $ct->tentapthe,
                'LinhVucHoatDong' => $ct->linhvuchoatdong,
                'MaHinhThucKhenThuong' => $ct->madanhhieukhenthuong,
                'KetQuaKhenThuong' => $ct->ketqua,
                'GhiChu' => $ct->lydo,
            ];
        }
        $a_kq['DanhSachKhenThuongTapThe'] = $a_tapthe;

        //Gán khen thưởng tập thể
        $hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $hoso->mahosotdkt)->get();
        $a_hogiadinh = [];
        $i = 1;
        foreach ($hogiadinh as $ct) {
            $a_hogiadinh[] = [
                'STT' => $i++,
                'TenTapThe' => $ct->tentapthe,
                'LinhVucHoatDong' => $ct->linhvuchoatdong,
                'MaHinhThucKhenThuong' => $ct->madanhhieukhenthuong,
                'KetQuaKhenThuong' => $ct->ketqua,
                'GhiChu' => $ct->lydo,
            ];
        }
        $a_kq['DanhSachKhenThuongHoGiaDinh'] = $a_hogiadinh;

        //Trả kết quả
        return  $a_kq;
    }

    public function convertDanhSachHoSo($hoso, $danhsachdonvi)
    {

        $a_kq = [
            'MaHoSoTDKT' => $hoso->mahosotdkt,
            'MaLoaiHinhKhenThuong' => $hoso->maloaihinhkt,
            'NoiDungKhenThuong' => $hoso->noidung,
        ];
        //Gán thông tin đơn vị
        $donvi_denghi = $danhsachdonvi->where('madonvi', $hoso->madonvi)->first();
        $a_kq['MaDonViDeNghi'] = $donvi_denghi->madonvi;
        $a_kq['TenDonViDeNghi'] = $donvi_denghi->tendonvi;
        $a_kq['MaQuanHeNganSachDonViDeNghi'] = $donvi_denghi->maqhns;
        $a_kq['NgayDeNghi'] = $hoso->ngayhoso;
        $a_kq['TrangThaiDeNghi'] = $hoso->trangthai;

        $donvi_xd = $danhsachdonvi->where('madonvi', $hoso->madonvi_xd)->first();
        $a_kq['MaDonViXetDuyet'] = $donvi_xd->madonvi ?? '';
        $a_kq['TenDonViXetDuyet'] = $donvi_xd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViXetDuyet'] = $donvi_xd->maqhns ?? '';
        $a_kq['NgayXetDuyet'] = $hoso->thoigian_xd;
        $a_kq['TrangThaiXetDuyet'] = $hoso->trangthai_xd;

        $donvi_pd = $danhsachdonvi->where('madonvi', $hoso->madonvi_kt)->first();
        $a_kq['MaDonViPheDuyet'] = $donvi_pd->madonvi ?? '';
        $a_kq['TenDonViPheDuyet'] = $donvi_pd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViPheDuyet'] = $donvi_pd->maqhns ?? '';
        $a_kq['NgayPheDuyet'] = $hoso->thoigian_kt;
        $a_kq['TrangThaiPheDuyet'] = $hoso->trangthai_kt;
        //Trả kết quả
        return  $a_kq;
    }

    public function convertLoaiHinhKhenThuong($hoso)
    {
        $a_kq = [
            'MaLoaiHinhKhenThuong' => $hoso->maloaihinhkt,
            'TenLoaiHinhKhenThuong' => $hoso->tenloaihinhkt,
            'PhamViApDung' => $hoso->phamviapdung,
            'TrangThaiTheoDoi' => $hoso->theodoi,
        ];
        //Trả kết quả
        return  $a_kq;
    }

    public function convertHinhThucKhenThuong($hoso)
    {
        $a_kq = [
            'MaHinhThucKhenThuong' => $hoso->mahinhthuckt,
            'TenHinhThucKhenThuong' => $hoso->tenhinhthuckt,
            'DoiTuongApDung' => $hoso->doituongapdung,
            'PhanLoaiKhenThuong' => $hoso->phanloai,
            'TrangThaiTheoDoi' => 1,
        ];
        //Trả kết quả
        return  $a_kq;
    }

    public function convertPhanLoaiDoiTuong($hoso)
    {
        $a_kq = [
            'NhomDoiTuong' => $hoso->manhomphanloai,
            'MaPhanLoaiDoiTuong' => $hoso->maphanloai,
            'TenPhanLoaiDoiTuong' => $hoso->tenphanloai,
            'TrangThaiTheoDoi' => 1,
        ];
        //Trả kết quả
        return  $a_kq;
    }

    public function convertDiaBanHanhChinh($hoso)
    {
        $a_kq = [
            'NhomDiaBan' => $hoso->capdo,
            'MaDiaBan' => $hoso->madiaban,
            'TenDiaBan' => $hoso->tendiaban,
            'CapDoHanhChinh' => $hoso->capdohanhchinh,
            'MaDiaBanQuanLy' => $hoso->madiabanQL,
            'TrangThaiTheoDoi' => 1,
        ];
        //Trả kết quả
        return  $a_kq;
    }

    public function convertDonViSuDung($hoso)
    {
        $a_kq = [
            'MaDiaBan' => $hoso->madiaban,
            'MaDonVi' => $hoso->madonvi,
            'TenDonVi' => $hoso->tendonvi,
            'MaDonViQuanHeNganSach' => $hoso->maqhns,
            'TrangThaiTheoDoi' => 1,
        ];
        //Trả kết quả
        return  $a_kq;
    }


    public function convertHoSoCaNhan($hoso, $danhsachdonvi, $maccvc)
    {

        $a_kq = [
            'MaHoSo' => $hoso->mahosotdkt,
            'LoaiHinhKhenThuong' => $hoso->mahinhthuckt,
            'NoiDungKhenThuong' => $hoso->noidung,
            'SoQuyetDinh' => $hoso->soqd,
            'NgayQuyetDinh' => $hoso->ngayqd,
            'TrangThaiHoSo' => $hoso->trangthai,
        ];
        //Gán thông tin đơn vị
        $donvi_denghi = $danhsachdonvi->where('madonvi', $hoso->madonvi)->first();
        $a_kq['MaDonViDeNghi'] = $donvi_denghi->madonvi;
        $a_kq['TenDonViDeNghi'] = $donvi_denghi->tendonvi;
        $a_kq['MaQuanHeNganSachDonViDeNghi'] = $donvi_denghi->maqhns;

        $donvi_xd = $danhsachdonvi->where('madonvi', $hoso->madonvi_xd)->first();
        $a_kq['MaDonViXetDuyet'] = $donvi_xd->madonvi ?? '';
        $a_kq['TenDonViXetDuyet'] = $donvi_xd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViXetDuyet'] = $donvi_xd->maqhns ?? '';

        $donvi_pd = $danhsachdonvi->where('madonvi', $hoso->madonvi_kt)->first();
        $a_kq['MaDonViPheDuyet'] = $donvi_pd->madonvi ?? '';
        $a_kq['TenDonViPheDuyet'] = $donvi_pd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViPheDuyet'] = $donvi_pd->maqhns ?? '';
        //Gán tài liệu đính kèm
        $tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $hoso->mahosotdkt)->get();
        $a_tailieu = [];
        $i = 1;
        foreach ($tailieu as $dinhkem) {
            $a_tailieu[] = [
                'STT' => $i++,
                'TenTaiLieu' => $dinhkem->tentailieu,
                'PhanLoaiTaiLieu' => $dinhkem->phanloai,
                'MoTaTaiLieu' => $dinhkem->noidung,
                'Base_64' => $dinhkem->base64,
                'MaDonViDinhKem' => $dinhkem->madonvi,
            ];
        }
        $a_kq['DanhSachTaiLieu'] = $a_tailieu;
        //Gán khen thưởng cá nhân
        $canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->where('maccvc', $maccvc)->get();
        $a_canhan = [];
        $i = 1;
        foreach ($canhan as $ct) {
            $a_canhan[] = [
                'STT' => $i++,
                'MaCongChucVienChuc' => $ct->maccvc,
                'TenCanBo' => $ct->tendoituong,
                'NgaySinh' => $ct->ngaysinh,
                'GioiTinh' => $ct->gioitinh,
                'ChucVu' => $ct->chucvu,
                'DiaChi' => $ct->diachi,
                'TenPhongBan' => $ct->tenphongban,
                'TenDonViCongTac' => $ct->tencoquan,
                'MaPhanLoaiDoiTuong' => $ct->maphanloaicanbo,
                'MaHinhThucKhenThuong' => $ct->madanhhieukhenthuong,
                'KetQuaKhenThuong' => $ct->ketqua,
                'GhiChu' => $ct->lydo,
            ];
        }
        $a_kq['DanhSachKhenThuongCaNhan'] = $a_canhan;
        
        //Trả kết quả
        return  $a_kq;
    }

    public function convertHoSoKhenThuong2DB($body){

        return false;
    }
}
