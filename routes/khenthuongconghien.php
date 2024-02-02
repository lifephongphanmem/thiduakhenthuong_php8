<?php

use Illuminate\Support\Facades\Route;

//Khen thưởng công hiến
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\dshosodenghikhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\dshosokhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\qdhosodenghikhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\tnhosodenghikhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\xdhosodenghikhenthuongconghienController;

Route::group(['prefix' => 'KhenThuongCongHien'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongconghienController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongconghienController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongconghienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongconghienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongconghienController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [dshosokhenthuongconghienController::class, 'InHoSoPD']);
        Route::post('Xoa', [dshosokhenthuongconghienController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongconghienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongconghienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongconghienController::class, 'LayTapThe']);
        //Route::post('NhanExcelTapThe', [dshosokhenthuongconghienController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongconghienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongconghienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongconghienController::class, 'LayCaNhan']);
        Route::post('NhanExcel', [dshosokhenthuongconghienController::class, 'NhanExcel']);

        Route::post('ThemDeTai', [dshosokhenthuongconghienController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongconghienController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongconghienController::class, 'LayDeTai']);

        Route::post('ThemHoGiaDinh', [dshosokhenthuongconghienController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosokhenthuongconghienController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosokhenthuongconghienController::class, 'LayHoGiaDinh']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongconghienController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongconghienController::class, 'LayLyDo']);

        //29.10.2022
        Route::get('QuyetDinh', [dshosokhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongconghienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongconghienController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongconghienController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongconghienController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [dshosokhenthuongconghienController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [dshosokhenthuongconghienController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [dshosokhenthuongconghienController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [dshosokhenthuongconghienController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [dshosokhenthuongconghienController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [dshosokhenthuongconghienController::class, 'InGiayKhenTapThe']);

        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongconghienController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongconghienController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongconghienController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongconghienController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongconghienController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongconghienController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongconghienController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongconghienController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongconghienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongconghienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongconghienController::class, 'InHoSo']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongconghienController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongconghienController::class, 'XoaHoSo']);

        Route::post('ChuyenHoSo', [dshosodenghikhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongconghienController::class, 'LayLyDo']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongconghienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongconghienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongconghienController::class, 'LayTapThe']);
        //Route::post('NhanExcelTapThe', [dshosodenghikhenthuongconghienController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongconghienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongconghienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongconghienController::class, 'LayCaNhan']);
        //Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongconghienController::class, 'NhanExcelCaNhan']);

        Route::post('ThemHoGiaDinh', [dshosodenghikhenthuongconghienController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosodenghikhenthuongconghienController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosodenghikhenthuongconghienController::class, 'LayHoGiaDinh']);

        Route::post('NhanExcel', [dshosodenghikhenthuongconghienController::class, 'NhanExcel']);
        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongconghienController::class, 'TaiLieuDinhKem']);
                
        //29.10.2022
        // Route::get('QuyetDinh', [dshosodenghikhenthuongconghienController::class, 'QuyetDinh']);
        // Route::get('TaoDuThao', [dshosodenghikhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        // Route::post('QuyetDinh', [dshosodenghikhenthuongconghienController::class, 'LuuQuyetDinh']);
        // Route::get('PheDuyet', [dshosodenghikhenthuongconghienController::class, 'PheDuyet']);
        // Route::post('PheDuyet', [dshosodenghikhenthuongconghienController::class, 'LuuPheDuyet']);
        // Route::post('HuyPheDuyet', [dshosodenghikhenthuongconghienController::class, 'HuyPheDuyet']);

        // Route::get('InQuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'InQuyetDinh']);
        // Route::get('InPhoi', [qdhosodenghikhenthuongconghienController::class, 'InPhoi']);

        // Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongconghienController::class, 'NoiDungKhenThuong']);
        // Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenCaNhan']);
        // Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenTapThe']);
        // Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenCaNhan']);
        // Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenTapThe']);

        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosodenghikhenthuongconghienController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosodenghikhenthuongconghienController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosodenghikhenthuongconghienController::class, 'InToTrinhHoSo']);

    });

    Route::group(['prefix' => 'TiepNhan'], function () {
        Route::get('ThongTin', [tnhosodenghikhenthuongconghienController::class, 'ThongTin']);
        Route::post('TraLai', [tnhosodenghikhenthuongconghienController::class, 'TraLai']);
        Route::post('NhanHoSo', [tnhosodenghikhenthuongconghienController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [tnhosodenghikhenthuongconghienController::class, 'ChuyenHoSo']);
        
        Route::post('ChuyenChuyenVien', [tnhosodenghikhenthuongconghienController::class, 'ChuyenChuyenVien']);
        Route::post('XuLyHoSo', [tnhosodenghikhenthuongconghienController::class, 'XuLyHoSo']);
        Route::post('LayXuLyHoSo', [tnhosodenghikhenthuongconghienController::class, 'LayXuLyHoSo']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongconghienController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongconghienController::class, 'TraLai']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongconghienController::class, 'NhanHoSo']);

        Route::get('XetKT', [xdhosodenghikhenthuongconghienController::class, 'XetKT']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongconghienController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongconghienController::class, 'ThemCaNhan']);

        Route::post('GanKhenThuong', [xdhosodenghikhenthuongconghienController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongconghienController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongconghienController::class, 'LayLyDo']);

        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongconghienController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongconghienController::class, 'LuuToTrinhPheDuyet']);

        Route::get('TrinhKetQua', [xdhosodenghikhenthuongconghienController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongconghienController::class, 'LuuTrinhKetQua']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongconghienController::class, 'ThongTin']);
        // Route::post('Them', [qdhosodenghikhenthuongconghienController::class, 'Them']);
        // Route::get('Sua', [qdhosodenghikhenthuongconghienController::class, 'Sua']);
        // Route::post('Sua', [qdhosodenghikhenthuongconghienController::class, 'LuuHoSo']);       
        Route::post('ThemTapThe', [qdhosodenghikhenthuongconghienController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongconghienController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongconghienController::class, 'ThemHoGiaDinh']);
        
        Route::post('NhanExcel', [qdhosodenghikhenthuongconghienController::class, 'NhanExcel']);       
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongconghienController::class, 'GanKhenThuong']);
        Route::get('XetKT', [qdhosodenghikhenthuongconghienController::class, 'XetKT']);

        Route::get('QuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [qdhosodenghikhenthuongconghienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongconghienController::class, 'LuuPheDuyet']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongconghienController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongconghienController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongconghienController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongconghienController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosodenghikhenthuongconghienController::class, 'InBangKhen']);

        Route::get('InHoSoPD', [qdhosodenghikhenthuongconghienController::class, 'XemHoSo']);
        // Route::get('InPhoi', [qdhosodenghikhenthuongconghienController::class, 'InPhoi']);
        // Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongconghienController::class, 'NoiDungKhenThuong']);
        // Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenCaNhan']);
        // Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenTapThe']);
        // Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenCaNhan']);
        // Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenTapThe']);
        //09.11.2022
       
        // Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongconghienController::class, 'InToTrinhPheDuyet']);
    });
});
