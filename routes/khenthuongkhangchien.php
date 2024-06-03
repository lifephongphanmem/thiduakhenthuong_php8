<?php

use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongMyCaNhan\dshosochongmy_canhanController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongMyGiaDinh\dshosochongmy_giadinhController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\dshosodenghikhenthuongkhangchienController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\dshosokhenthuongkhangchienController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\qdhosodenghikhenthuongkhangchienController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\tnhosodenghikhenthuongkhangchienController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\xdhosodenghikhenthuongkhangchienController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'KhenThuongKhangChien'], function () {
    Route::group(['prefix' => 'ChongPhapCaNhan'], function () {
        Route::get('ThongTin', [dshosochongphap_canhanController::class, 'ThongTin']);
        Route::get('Them', [dshosochongphap_canhanController::class, 'ThemHoSo']);
        Route::post('Them', [dshosochongphap_canhanController::class, 'LuuHoSo']);
        Route::get('Sua', [dshosochongphap_canhanController::class, 'SuaHoSo']);
        Route::post('NhanHoSo', [dshosochongphap_canhanController::class, 'NhanHoSo']);
        Route::get('Xem', [dshosochongphap_canhanController::class, 'XemHoSo']);
        Route::get('TaiLieuDinhKem', [dshosochongphap_canhanController::class, 'TaiLieuDinhKem']);
        Route::post('PheDuyet', [dshosochongphap_canhanController::class, 'PheDuyet']);
        Route::post('HuyPheDuyet', [dshosochongphap_canhanController::class, 'HuyPheDuyet']);
    });

    Route::group(['prefix' => 'ChongMyCaNhan'], function () {
        Route::get('ThongTin', [dshosochongmy_canhanController::class, 'ThongTin']);
        Route::get('Them', [dshosochongmy_canhanController::class, 'ThemHoSo']);
        Route::post('Them', [dshosochongmy_canhanController::class, 'LuuHoSo']);
        Route::get('Sua', [dshosochongmy_canhanController::class, 'SuaHoSo']);
        Route::post('NhanHoSo', [dshosochongmy_canhanController::class, 'NhanHoSo']);
        Route::get('Xem', [dshosochongmy_canhanController::class, 'XemHoSo']);
        Route::get('TaiLieuDinhKem', [dshosochongmy_canhanController::class, 'TaiLieuDinhKem']);
        Route::post('PheDuyet', [dshosochongmy_canhanController::class, 'PheDuyet']);
        Route::post('HuyPheDuyet', [dshosochongmy_canhanController::class, 'HuyPheDuyet']);
    });

    Route::group(['prefix' => 'ChongMyGiaDinh'], function () {
        Route::get('ThongTin', [dshosochongmy_giadinhController::class, 'ThongTin']);
        Route::get('Them', [dshosochongmy_giadinhController::class, 'ThemHoSo']);
        Route::post('Them', [dshosochongmy_giadinhController::class, 'LuuHoSo']);
        Route::get('Sua', [dshosochongmy_giadinhController::class, 'SuaHoSo']);
        Route::post('NhanHoSo', [dshosochongmy_giadinhController::class, 'NhanHoSo']);
        Route::get('Xem', [dshosochongmy_giadinhController::class, 'XemHoSo']);
        Route::get('TaiLieuDinhKem', [dshosochongmy_giadinhController::class, 'TaiLieuDinhKem']);
        Route::post('PheDuyet', [dshosochongmy_giadinhController::class, 'PheDuyet']);
        Route::post('HuyPheDuyet', [dshosochongmy_giadinhController::class, 'HuyPheDuyet']);
    });

    //Theo quy trình hồ sơ thầu khánh hòa 03062024
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongkhangchienController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongkhangchienController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongkhangchienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongkhangchienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongkhangchienController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhenthuongkhangchienController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhenthuongkhangchienController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongkhangchienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongkhangchienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongkhangchienController::class, 'LayTapThe']);
        
        Route::post('ThemCaNhan', [dshosokhenthuongkhangchienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongkhangchienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongkhangchienController::class, 'LayCaNhan']);
        
        Route::post('ThemHoGiaDinh', [dshosokhenthuongkhangchienController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosokhenthuongkhangchienController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosokhenthuongkhangchienController::class, 'LayHoGiaDinh']);

        Route::post('ThemDeTai', [dshosokhenthuongkhangchienController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongkhangchienController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongkhangchienController::class, 'LayDeTai']);

        Route::post('NhanExcel', [dshosokhenthuongkhangchienController::class, 'NhanExcel']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongkhangchienController::class, 'NhanExcelDeTai']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongkhangchienController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongkhangchienController::class, 'NhanExcelTapThe']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongkhangchienController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongkhangchienController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongkhangchienController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosokhenthuongkhangchienController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosokhenthuongkhangchienController::class, 'LayDoiTuong']);
        //29.10.2022
        Route::get('QuyetDinh', [dshosokhenthuongkhangchienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongkhangchienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongkhangchienController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongkhangchienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongkhangchienController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongkhangchienController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongkhangchienController::class, 'InQuyetDinh']);

        Route::get('ToTrinhHoSo', [dshosokhenthuongkhangchienController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongkhangchienController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongkhangchienController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongkhangchienController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongkhangchienController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongkhangchienController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongkhangchienController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongkhangchienController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongkhangchienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongkhangchienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongkhangchienController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongkhangchienController::class, 'XoaHoSo']);
        Route::post('ThemTongHop', [dshosodenghikhenthuongkhangchienController::class, 'ThemTongHop']);
        Route::post('ThemHoGiaDinh', [dshosodenghikhenthuongkhangchienController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosodenghikhenthuongkhangchienController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosodenghikhenthuongkhangchienController::class, 'LayHoGiaDinh']);
        Route::post('NhanExcel', [dshosodenghikhenthuongkhangchienController::class, 'NhanExcel']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongkhangchienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongkhangchienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongkhangchienController::class, 'LayTapThe']);
        // Route::post('NhanExcelTapThe', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongkhangchienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongkhangchienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongkhangchienController::class, 'LayCaNhan']);
        // Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosodenghikhenthuongkhangchienController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongkhangchienController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongkhangchienController::class, 'LayDeTai']);
        // Route::post('NhanExcelDeTai', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongkhangchienController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosodenghikhenthuongkhangchienController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongkhangchienController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosodenghikhenthuongkhangchienController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosodenghikhenthuongkhangchienController::class, 'LayDoiTuong']);

        Route::get('ToTrinhHoSo', [dshosodenghikhenthuongkhangchienController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosodenghikhenthuongkhangchienController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosodenghikhenthuongkhangchienController::class, 'InToTrinhHoSo']);
        Route::get('InToTrinhPheDuyet', [dshosodenghikhenthuongkhangchienController::class, 'InToTrinhPheDuyet']);
        Route::get('InHoSoPD', [dshosodenghikhenthuongkhangchienController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [dshosodenghikhenthuongkhangchienController::class, 'InQuyetDinh']);

        Route::post('ThemTongHop', [dshosodenghikhenthuongkhangchienController::class, 'ThemTongHop']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongkhangchienController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongkhangchienController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongkhangchienController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongkhangchienController::class, 'ChuyenHoSo']);
        Route::post('TraLaiQuyTrinhTaiKhoan', [xdhosodenghikhenthuongkhangchienController::class, 'TraLaiQuyTrinhTaiKhoan']);
        
        //09.11.2022
        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongkhangchienController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongkhangchienController::class, 'LuuToTrinhPheDuyet']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongkhangchienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongkhangchienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongkhangchienController::class, 'LuuQuyetDinh']);

        Route::get('TrinhKetQua', [xdhosodenghikhenthuongkhangchienController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongkhangchienController::class, 'LuuTrinhKetQua']);
    });

    Route::group(['prefix' => 'TiepNhan'], function () {
        Route::get('ThongTin', [tnhosodenghikhenthuongkhangchienController::class, 'ThongTin']);
        Route::post('TraLai', [tnhosodenghikhenthuongkhangchienController::class, 'TraLai']);
        Route::post('NhanHoSo', [tnhosodenghikhenthuongkhangchienController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [tnhosodenghikhenthuongkhangchienController::class, 'ChuyenHoSo']);
        
        Route::post('ChuyenChuyenVien', [tnhosodenghikhenthuongkhangchienController::class, 'ChuyenChuyenVien']);
        Route::post('XuLyHoSo', [tnhosodenghikhenthuongkhangchienController::class, 'XuLyHoSo']);
        Route::post('LayXuLyHoSo', [tnhosodenghikhenthuongkhangchienController::class, 'LayXuLyHoSo']);
        Route::get('QuaTrinhXuLyHoSo', [tnhosodenghikhenthuongkhangchienController::class, 'QuaTrinhXuLyHoSo']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongkhangchienController::class, 'ThongTin']);
        Route::post('ThemTapThe', [qdhosodenghikhenthuongkhangchienController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongkhangchienController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongkhangchienController::class, 'ThemHoGiaDinh']);

        Route::get('PheDuyet', [qdhosodenghikhenthuongkhangchienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongkhangchienController::class, 'LuuPheDuyet']);

        Route::get('XetKT', [qdhosodenghikhenthuongkhangchienController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosodenghikhenthuongkhangchienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongkhangchienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongkhangchienController::class, 'LuuQuyetDinh']);       
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongkhangchienController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongkhangchienController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongkhangchienController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongkhangchienController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongkhangchienController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosodenghikhenthuongkhangchienController::class, 'InBangKhen']);
        Route::post('InGiayKhen', [qdhosodenghikhenthuongkhangchienController::class, 'InGiayKhen']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongkhangchienController::class, 'XemHoSo']);        
        Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongkhangchienController::class, 'InToTrinhPheDuyet']);
    });
});
