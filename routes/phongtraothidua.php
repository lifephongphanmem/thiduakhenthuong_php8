<?php
//Phong trào thi đua
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dshosothiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dshosokhenthuongthiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\tnhosodenghikhenthuongthiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\xdhosodenghikhenthuongthiduaController;

Route::group(['prefix' => 'PhongTraoThiDua'], function () {
    Route::get('ThongTin', [dsphongtraothiduaController::class, 'ThongTin']);
    Route::get('Xem', [dsphongtraothiduaController::class, 'XemThongTin']);
    Route::get('Them', [dsphongtraothiduaController::class, 'ThayDoi']);
    Route::post('Them', [dsphongtraothiduaController::class, 'LuuPhongTrao']);
    Route::get('Sua', [dsphongtraothiduaController::class, 'ThayDoi']);
    Route::post('Sua', [dsphongtraothiduaController::class, 'LuuPhongTrao']);
    Route::post('KetThuc', [dsphongtraothiduaController::class, 'KetThuc']);
    Route::post('HuyKetThuc', [dsphongtraothiduaController::class, 'HuyKetThuc']);
    Route::post('Xoa', [dsphongtraothiduaController::class, 'Xoa']);

    Route::get('ThemKhenThuong', [dsphongtraothiduaController::class, 'ThemKhenThuong']);
    Route::post('ThemTieuChuan', [dsphongtraothiduaController::class, 'ThemTieuChuan']);
    Route::get('LayTieuChuan', [dsphongtraothiduaController::class, 'LayTieuChuan']);
    Route::post('XoaTieuChuan', [dsphongtraothiduaController::class, 'XoaTieuChuan']);
    Route::get('TaiLieuDinhKem', [dsphongtraothiduaController::class, 'TaiLieuDinhKem']);
    Route::get('DinhKemTieuChuan', [dsphongtraothiduaController::class, 'DinhKemTieuChuan']);

    Route::get('HoSoKT',[dsphongtraothiduaController::class,'HoSoKT']);

    //Route::get('Sua','system\DSTaiKhoanController@edit']);
});

Route::group(['prefix' => 'HoSoThiDua'], function () {
    Route::get('ThongTin', [dshosothiduaController::class, 'ThongTin']);
    Route::get('DanhSach', [dshosothiduaController::class, 'DanhSach']);
    Route::get('Them', [dshosothiduaController::class, 'ThemHoSo']);
    Route::post('Them', [dshosothiduaController::class, 'LuuHoSo']);
    Route::get('Sua', [dshosothiduaController::class, 'ThayDoi']);
    Route::post('Sua', [dshosothiduaController::class, 'LuuHoSo']);
    Route::get('Xem', [dshosothiduaController::class, 'XemHoSo']);
    Route::post('Xoa', [dshosothiduaController::class, 'XoaHoSo']);

    Route::get('LayTieuChuan', [dshosothiduaController::class, 'LayTieuChuan']);
    Route::get('LuuTieuChuan', [dshosothiduaController::class, 'LuuTieuChuan']);
    Route::post('ChuyenHoSo', [dshosothiduaController::class, 'ChuyenHoSo']);
    Route::post('TraLai', [dshosothiduaController::class, 'TraLai']);
    Route::post('NhanHoSo', [dshosothiduaController::class, 'NhanHoSo']);
    Route::post('delete', [dshosothiduaController::class, 'delete']);
    Route::get('LayLyDo', [dshosothiduaController::class, 'LayLyDo']);
    Route::get('XoaDoiTuong', [dshosothiduaController::class, 'XoaDoiTuong']);

    Route::post('ThemTapThe', [dshosothiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [dshosothiduaController::class, 'XoaTapThe']);
    Route::get('LayTapThe', [dshosothiduaController::class, 'LayTapThe']);
    
    Route::post('ThemCaNhan', [dshosothiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [dshosothiduaController::class, 'XoaCaNhan']);
    Route::get('LayCaNhan', [dshosothiduaController::class, 'LayCaNhan']);    

    Route::post('ThemHoGiaDinh', [dshosothiduaController::class, 'ThemHoGiaDinh']);
    Route::get('XoaHoGiaDinh', [dshosothiduaController::class, 'XoaHoGiaDinh']);
    Route::get('LayHoGiaDinh', [dshosothiduaController::class, 'LayHoGiaDinh']);

    Route::post('NhanExcel', [dshosothiduaController::class, 'NhanExcel']);
    Route::post('NhanExcelTapThe', [dshosothiduaController::class, 'NhanExcelTapThe']);
    Route::post('NhanExcelCaNhan', [dshosothiduaController::class, 'NhanExcelCaNhan']);

    Route::get('TaiLieuDinhKem', [dshosothiduaController::class, 'TaiLieuDinhKem']);

    //09.11.2022
    Route::get('ToTrinhHoSo', [dshosodenghikhenthuongthiduaController::class, 'ToTrinhHoSo']);
    Route::post('ToTrinhHoSo', [dshosodenghikhenthuongthiduaController::class, 'LuuToTrinhHoSo']);
    Route::get('InToTrinhHoSo', [dshosodenghikhenthuongthiduaController::class, 'InToTrinhHoSo']);

    // Route::get('ToTrinhPheDuyet', [dshosodenghikhenthuongthiduaController::class, 'ToTrinhPheDuyet']);
    // Route::post('ToTrinhPheDuyet', [dshosodenghikhenthuongthiduaController::class, 'LuuToTrinhPheDuyet']);
    // Route::get('InToTrinhPheDuyet', [dshosodenghikhenthuongthiduaController::class, 'InToTrinhPheDuyet']);
});

Route::group(['prefix' => 'HoSoDeNghiKhenThuongThiDua'], function () {
    Route::get('ThongTin', [dshosodenghikhenthuongthiduaController::class, 'ThongTin']);
    Route::get('DanhSach', [dshosodenghikhenthuongthiduaController::class, 'DanhSach']);
    Route::get('DSHoSoThamGia', [dshosodenghikhenthuongthiduaController::class, 'DanhSachHoSo']);
    //Route::post('TraLai', [dshosodenghikhenthuongthiduaController::class, 'TraLai']);
    Route::get('Xem', [dshosodenghikhenthuongthiduaController::class, 'XemDanhSach']);
    Route::post('ChuyenHoSo', [dshosodenghikhenthuongthiduaController::class, 'ChuyenHoSo']);
    Route::get('LayLyDo', [dshosodenghikhenthuongthiduaController::class, 'LayLyDo']);
    Route::post('Xoa', [dshosodenghikhenthuongthiduaController::class, 'XoaHoSo']);
    //Route::post('NhanHoSo', [dshosodenghikhenthuongthiduaController::class, 'NhanHoSo']);

    Route::post('ThemKT', [dshosodenghikhenthuongthiduaController::class, 'ThemKT']);
    Route::get('Sua', [dshosodenghikhenthuongthiduaController::class, 'Sua']);
    Route::post('Sua', [dshosodenghikhenthuongthiduaController::class, 'LuuKT']);
    Route::post('XoaHoSoKT', [dshosodenghikhenthuongthiduaController::class, 'XoaHoSoKT']);
    Route::get('InHoSo', [dshosodenghikhenthuongthiduaController::class, 'XemHoSoKT']);
    Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongthiduaController::class, 'TaiLieuDinhKem']);

    Route::get('LayTapThe', [dshosodenghikhenthuongthiduaController::class, 'LayTapThe']);
    Route::post('ThemTapThe', [dshosodenghikhenthuongthiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [dshosodenghikhenthuongthiduaController::class, 'XoaTapThe']);
    
    Route::get('LayCaNhan', [dshosodenghikhenthuongthiduaController::class, 'LayCaNhan']);
    Route::post('ThemCaNhan', [dshosodenghikhenthuongthiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [dshosodenghikhenthuongthiduaController::class, 'XoaCaNhan']);

    Route::post('NhanExcel', [dshosodenghikhenthuongthiduaController::class, 'NhanExcel']);
    //Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongthiduaController::class, 'NhanExcelCaNhan']);
    //Route::post('NhanExcelTapThe', [dshosodenghikhenthuongthiduaController::class, 'NhanExcelTapThe']);

    //Route::get('QuyetDinh', [dshosodenghikhenthuongthiduaController::class, 'QuyetDinh']);
    //Route::get('TaoDuThao', [dshosodenghikhenthuongthiduaController::class, 'DuThaoQuyetDinh']);
    //Route::post('QuyetDinh', [dshosodenghikhenthuongthiduaController::class, 'LuuQuyetDinh']);
    //Route::post('PheDuyet', [dshosodenghikhenthuongthiduaController::class, 'PheDuyet']);
    

    //Route::post('GanKhenThuong', [dshosodenghikhenthuongthiduaController::class, 'GanKhenThuong']);
    //09.11.2022
    //Route::get('ToTrinhHoSo', [dshosodenghikhenthuongthiduaController::class, 'ToTrinhHoSo']);
    //Route::post('ToTrinhHoSo', [dshosodenghikhenthuongthiduaController::class, 'LuuToTrinhHoSo']);
    //Route::get('InToTrinhHoSo', [dshosodenghikhenthuongthiduaController::class, 'InToTrinhHoSo']);

    Route::post('NhanHoSo',[dshosodenghikhenthuongthiduaController::class,'NhanHoSo']);
    Route::get('DSHoSo_DvThamMuu',[dshosodenghikhenthuongthiduaController::class,'DSHoSo_DvThamMuu']);
});

Route::group(['prefix' => 'TiepNhanHoSoThiDua'], function () {
    Route::get('ThongTin', [tnhosodenghikhenthuongthiduaController::class, 'ThongTin']);
    Route::get('DanhSach', [tnhosodenghikhenthuongthiduaController::class, 'DanhSach']);
    Route::post('TraLai', [tnhosodenghikhenthuongthiduaController::class, 'TraLai']);
    Route::post('NhanHoSo', [tnhosodenghikhenthuongthiduaController::class, 'NhanHoSo']);
    Route::post('ChuyenHoSo', [tnhosodenghikhenthuongthiduaController::class, 'ChuyenHoSo']);
    
    Route::post('ChuyenChuyenVien', [tnhosodenghikhenthuongthiduaController::class, 'ChuyenChuyenVien']);
    Route::post('XuLyHoSo', [tnhosodenghikhenthuongthiduaController::class, 'XuLyHoSo']);
    Route::post('LayXuLyHoSo', [tnhosodenghikhenthuongthiduaController::class, 'LayXuLyHoSo']);
    Route::get('QuaTrinhXuLyHoSo', [tnhosodenghikhenthuongthiduaController::class, 'QuaTrinhXuLyHoSo']);
});

Route::group(['prefix' => 'XetDuyetHoSoThiDua'], function () {
    Route::get('ThongTin', [xdhosodenghikhenthuongthiduaController::class, 'ThongTin']);
    Route::get('DanhSach', [xdhosodenghikhenthuongthiduaController::class, 'DanhSach']);
    Route::post('TraLai', [xdhosodenghikhenthuongthiduaController::class, 'TraLai']);
    Route::get('Xem', [xdhosodenghikhenthuongthiduaController::class, 'XemDanhSach']);
    Route::post('ChuyenHoSo', [xdhosodenghikhenthuongthiduaController::class, 'ChuyenHoSo']);
    Route::post('NhanHoSo', [xdhosodenghikhenthuongthiduaController::class, 'NhanHoSo']);
    Route::get('TrinhKetQua', [xdhosodenghikhenthuongthiduaController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongthiduaController::class, 'LuuTrinhKetQua']);

    Route::post('ThemKT', [xdhosodenghikhenthuongthiduaController::class, 'ThemKT']);
    Route::get('XetKT', [xdhosodenghikhenthuongthiduaController::class, 'XetKT']);
    Route::post('XetKT', [xdhosodenghikhenthuongthiduaController::class, 'LuuKT']);
    Route::post('XoaHoSoKT', [xdhosodenghikhenthuongthiduaController::class, 'XoaHoSoKT']);
    Route::get('Xem', [xdhosodenghikhenthuongthiduaController::class, 'XemHoSoKT']);
    Route::get('TaiLieuDinhKem', [xdhosodenghikhenthuongthiduaController::class, 'TaiLieuDinhKem']);

    Route::get('LayTapThe', [xdhosodenghikhenthuongthiduaController::class, 'LayTapThe']);
    Route::post('ThemTapThe', [xdhosodenghikhenthuongthiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [xdhosodenghikhenthuongthiduaController::class, 'XoaTapThe']);
    
    Route::get('LayCaNhan', [xdhosodenghikhenthuongthiduaController::class, 'LayCaNhan']);
    Route::post('ThemCaNhan', [xdhosodenghikhenthuongthiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [xdhosodenghikhenthuongthiduaController::class, 'XoaCaNhan']);

    Route::post('NhanExcel', [xdhosodenghikhenthuongthiduaController::class, 'NhanExcel']);    
    Route::get('QuyetDinh', [xdhosodenghikhenthuongthiduaController::class, 'QuyetDinh']);
    Route::get('TaoDuThao', [xdhosodenghikhenthuongthiduaController::class, 'DuThaoQuyetDinh']);
    Route::post('QuyetDinh', [xdhosodenghikhenthuongthiduaController::class, 'LuuQuyetDinh']);
    Route::post('PheDuyet', [xdhosodenghikhenthuongthiduaController::class, 'PheDuyet']);
    Route::get('LayLyDo', [xdhosodenghikhenthuongthiduaController::class, 'LayLyDo']);
    Route::post('GanKhenThuong', [xdhosodenghikhenthuongthiduaController::class, 'GanKhenThuong']);
    //09.11.2022
    Route::get('ToTrinhHoSo', [xdhosodenghikhenthuongthiduaController::class, 'ToTrinhHoSo']);
    Route::post('ToTrinhHoSo', [xdhosodenghikhenthuongthiduaController::class, 'LuuToTrinhHoSo']);
    Route::get('InToTrinhHoSo', [xdhosodenghikhenthuongthiduaController::class, 'InToTrinhHoSo']);
});

Route::group(['prefix' => 'KhenThuongHoSoThiDua'], function () {
    Route::get('ThongTin', [qdhosodenghikhenthuongthiduaController::class, 'ThongTin']);
    Route::get('DanhSach', [qdhosodenghikhenthuongthiduaController::class, 'DanhSach']);
    Route::post('KhenThuong', [qdhosodenghikhenthuongthiduaController::class, 'KhenThuong']);
    Route::get('DanhSach', [qdhosodenghikhenthuongthiduaController::class, 'DanhSach']);
    Route::post('Sua', [qdhosodenghikhenthuongthiduaController::class, 'LuuHoSo']);
    Route::get('InHoSoPD', [qdhosodenghikhenthuongthiduaController::class, 'XemHoSo']);
    Route::post('TraLai', [qdhosodenghikhenthuongthiduaController::class, 'TraLai']);

    Route::post('HoSo', [qdhosodenghikhenthuongthiduaController::class, 'HoSo']);
    Route::post('KetQua', [qdhosodenghikhenthuongthiduaController::class, 'KetQua']);


    Route::get('InKetQua', [qdhosodenghikhenthuongthiduaController::class, 'InKetQua']);
    Route::get('MacDinhQuyetDinh', [qdhosodenghikhenthuongthiduaController::class, 'MacDinhQuyetDinh']);
    Route::get('QuyetDinh', [qdhosodenghikhenthuongthiduaController::class, 'QuyetDinh']);
    Route::post('QuyetDinh', [qdhosodenghikhenthuongthiduaController::class, 'LuuQuyetDinh']);
    Route::get('XemQuyetDinh', [qdhosodenghikhenthuongthiduaController::class, 'XemQuyetDinh']);
    Route::get('LayTieuChuan', [qdhosodenghikhenthuongthiduaController::class, 'LayTieuChuan']);
    Route::post('KetThuc', [qdhosodenghikhenthuongthiduaController::class, 'KetThuc']);

    Route::get('LayTapThe', [qdhosodenghikhenthuongthiduaController::class, 'LayTapThe']);
    Route::post('ThemTapThe', [qdhosodenghikhenthuongthiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [qdhosodenghikhenthuongthiduaController::class, 'XoaTapThe']);
    //Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongthiduaController::class, 'NhanExcelTapThe']);
    Route::get('LayCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'LayCaNhan']);
    Route::post('ThemCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'XoaCaNhan']);
    //Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'NhanExcelCaNhan']);
    Route::get('LayHoGiaDinh', [qdhosodenghikhenthuongthiduaController::class, 'LayHoGiaDinh']);
    Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongthiduaController::class, 'ThemHoGiaDinh']);

    //In dữ liệu
    Route::post('LayDoiTuong', [qdhosodenghikhenthuongthiduaController::class, 'LayDoiTuong']);
    Route::post('InBangKhen', [qdhosodenghikhenthuongthiduaController::class, 'InBangKhen']);
    Route::post('InGiayKhen', [qdhosodenghikhenthuongthiduaController::class, 'InGiayKhen']);

    Route::get('InPhoi', [qdhosodenghikhenthuongthiduaController::class, 'InPhoi']);
    Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongthiduaController::class, 'NoiDungKhenThuong']);
    Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'InBangKhenCaNhan']);
    Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongthiduaController::class, 'InBangKhenTapThe']);
    Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'InGiayKhenCaNhan']);
    Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongthiduaController::class, 'InGiayKhenTapThe']);
    //
    Route::get('PheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'PheDuyet']);
    Route::post('PheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'LuuPheDuyet']);

    //Route::post('PheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'PheDuyet']);
    Route::post('HuyPheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'HuyPheDuyet']);

    //09.11.2022
    Route::get('ToTrinhPheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'ToTrinhPheDuyet']);
    Route::post('ToTrinhPheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'LuuToTrinhPheDuyet']);
    Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'InToTrinhPheDuyet']);

    Route::post('GanKhenThuong', [qdhosodenghikhenthuongthiduaController::class, 'GanKhenThuong']);
});

Route::group(['prefix' => 'HoSoThiDuaKT'], function () {
    Route::get('ThongTin', [dshosokhenthuongthiduaController::class, 'ThongTin']);
    Route::post('ThemKT', [dshosokhenthuongthiduaController::class, 'Them']);
    Route::get('Sua', [dshosokhenthuongthiduaController::class, 'ThayDoi']);
    Route::post('Sua', [dshosokhenthuongthiduaController::class, 'LuuHoSo']);
    Route::get('InHoSo', [dshosokhenthuongthiduaController::class, 'XemHoSo']);
    Route::get('InHoSoPD', [dshosokhenthuongthiduaController::class, 'XemHoSo']);
    Route::post('Xoa', [dshosokhenthuongthiduaController::class, 'XoaHoSo']);

    Route::post('ThemTapThe', [dshosokhenthuongthiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [dshosokhenthuongthiduaController::class, 'XoaTapThe']);
    Route::get('LayTapThe', [dshosokhenthuongthiduaController::class, 'LayTapThe']);
    
    Route::post('ThemCaNhan', [dshosokhenthuongthiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [dshosokhenthuongthiduaController::class, 'XoaCaNhan']);
    Route::get('LayCaNhan', [dshosokhenthuongthiduaController::class, 'LayCaNhan']);

    Route::post('ThemHoGiaDinh', [dshosokhenthuongthiduaController::class, 'ThemHoGiaDinh']);
    Route::get('XoaHoGiaDinh', [dshosokhenthuongthiduaController::class, 'XoaHoGiaDinh']);
    Route::get('LayHoGiaDinh', [dshosokhenthuongthiduaController::class, 'LayHoGiaDinh']);

    Route::post('NhanExcel', [dshosokhenthuongthiduaController::class, 'NhanExcel']);
    Route::post('NhanExcelDeTai', [dshosokhenthuongthiduaController::class, 'NhanExcelDeTai']);
    Route::post('NhanExcelCaNhan', [dshosokhenthuongthiduaController::class, 'NhanExcelCaNhan']);

    Route::post('ThemDeTai', [dshosokhenthuongthiduaController::class, 'ThemDeTai']);
    Route::get('XoaDeTai', [dshosokhenthuongthiduaController::class, 'XoaDeTai']);
    Route::get('LayDeTai', [dshosokhenthuongthiduaController::class, 'LayDeTai']);

    Route::get('TaiLieuDinhKem', [dshosokhenthuongthiduaController::class, 'TaiLieuDinhKem']);

    //29.10.2022
    Route::get('QuyetDinh', [dshosokhenthuongthiduaController::class, 'QuyetDinh']);
    Route::get('TaoDuThao', [dshosokhenthuongthiduaController::class, 'DuThaoQuyetDinh']);
    Route::post('QuyetDinh', [dshosokhenthuongthiduaController::class, 'LuuQuyetDinh']);
    Route::get('PheDuyet', [dshosokhenthuongthiduaController::class, 'PheDuyet']);
    Route::post('PheDuyet', [dshosokhenthuongthiduaController::class, 'LuuPheDuyet']);
    Route::post('HuyPheDuyet', [dshosokhenthuongthiduaController::class, 'HuyPheDuyet']);
    Route::get('InQuyetDinh', [dshosokhenthuongthiduaController::class, 'InQuyetDinh']);
    Route::get('InPhoi', [dshosokhenthuongthiduaController::class, 'InPhoi']);

    Route::post('NoiDungKhenThuong', [dshosokhenthuongthiduaController::class, 'NoiDungKhenThuong']);
    Route::get('InBangKhenCaNhan', [dshosokhenthuongthiduaController::class, 'InBangKhenCaNhan']);
    Route::get('InBangKhenTapThe', [dshosokhenthuongthiduaController::class, 'InBangKhenTapThe']);
    Route::get('InGiayKhenCaNhan', [dshosokhenthuongthiduaController::class, 'InGiayKhenCaNhan']);
    Route::get('InGiayKhenTapThe', [dshosokhenthuongthiduaController::class, 'InGiayKhenTapThe']);

    //09.11.2022
    Route::get('ToTrinhHoSo', [dshosokhenthuongthiduaController::class, 'ToTrinhHoSo']);
    Route::post('ToTrinhHoSo', [dshosokhenthuongthiduaController::class, 'LuuToTrinhHoSo']);
    Route::get('InToTrinhHoSo', [dshosokhenthuongthiduaController::class, 'InToTrinhHoSo']);

    Route::get('ToTrinhPheDuyet', [dshosokhenthuongthiduaController::class, 'ToTrinhPheDuyet']);
    Route::post('ToTrinhPheDuyet', [dshosokhenthuongthiduaController::class, 'LuuToTrinhPheDuyet']);
    Route::get('InToTrinhPheDuyet', [dshosokhenthuongthiduaController::class, 'InToTrinhPheDuyet']);
});