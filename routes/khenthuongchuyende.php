<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\dshosodenghikhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\dshosokhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\qdhosodenghikhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\tnhosodenghikhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\xdhosodenghikhenthuongchuyendeController;

//Khen thưởng chuyên đề
Route::group(['prefix' => 'KhenThuongChuyenDe'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongchuyendeController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongchuyendeController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhenthuongchuyendeController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhenthuongchuyendeController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongchuyendeController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongchuyendeController::class, 'LayTapThe']);
        Route::post('NhanExcel', [dshosokhenthuongchuyendeController::class, 'NhanExcel']);

        Route::post('ThemCaNhan', [dshosokhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongchuyendeController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongchuyendeController::class, 'LayCaNhan']);
        //Route::post('NhanExcelCaNhan', [dshosokhenthuongchuyendeController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosokhenthuongchuyendeController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongchuyendeController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongchuyendeController::class, 'LayDeTai']);
        //Route::post('NhanExcelDeTai', [dshosokhenthuongchuyendeController::class, 'NhanExcelDeTai']);

        Route::post('ThemHoGiaDinh', [dshosokhenthuongchuyendeController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosokhenthuongchuyendeController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosokhenthuongchuyendeController::class, 'LayHoGiaDinh']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongchuyendeController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongchuyendeController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongchuyendeController::class, 'LayLyDo']);

        //29.10.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongchuyendeController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongchuyendeController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongchuyendeController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongchuyendeController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongchuyendeController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongchuyendeController::class, 'InToTrinhPheDuyet']);
        Route::get('QuyetDinh', [dshosokhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongchuyendeController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongchuyendeController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongchuyendeController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongchuyendeController::class, 'InQuyetDinh']);

        /*2023.09.21 Lọc dần các chức năng thừa
        Route::get('InPhoi', [dshosokhenthuongchuyendeController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [dshosokhenthuongchuyendeController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [dshosokhenthuongchuyendeController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [dshosokhenthuongchuyendeController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [dshosokhenthuongchuyendeController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [dshosokhenthuongchuyendeController::class, 'InGiayKhenTapThe']);
        */
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongchuyendeController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongchuyendeController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongchuyendeController::class, 'XoaHoSo']);
        Route::post('NhanExcel', [dshosodenghikhenthuongchuyendeController::class, 'NhanExcel']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongchuyendeController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongchuyendeController::class, 'LayTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'LayCaNhan']);

        Route::post('ThemDeTai', [dshosodenghikhenthuongchuyendeController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongchuyendeController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongchuyendeController::class, 'LayDeTai']);

        Route::post('ThemHoGiaDinh', [dshosodenghikhenthuongchuyendeController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosodenghikhenthuongchuyendeController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosodenghikhenthuongchuyendeController::class, 'LayHoGiaDinh']);

        Route::post('ChuyenHoSo', [dshosodenghikhenthuongchuyendeController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongchuyendeController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosodenghikhenthuongchuyendeController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosodenghikhenthuongchuyendeController::class, 'LayDoiTuong']);

        /*2023.09.21 Lọc dần các chức năng thừa
        Route::post('NhanExcelTapThe', [dshosodenghikhenthuongchuyendeController::class, 'NhanExcelTapThe']);
        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongchuyendeController::class, 'TaiLieuDinhKem']);
        Route::post('NhanExcelDeTai', [dshosodenghikhenthuongchuyendeController::class, 'NhanExcelDeTai']);
        Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'NhanExcelCaNhan']);
        Route::get('InPhoi', [qdhosodenghikhenthuongchuyendeController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongchuyendeController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenTapThe']);
        Route::get('QuyetDinh', [dshosodenghikhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosodenghikhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosodenghikhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosodenghikhenthuongchuyendeController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosodenghikhenthuongchuyendeController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosodenghikhenthuongchuyendeController::class, 'HuyPheDuyet']);
        */

        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosodenghikhenthuongchuyendeController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosodenghikhenthuongchuyendeController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosodenghikhenthuongchuyendeController::class, 'InToTrinhHoSo']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'InQuyetDinh']);

        Route::get('InHoSoPD', [qdhosodenghikhenthuongchuyendeController::class, 'XemHoSo']);
    });

    Route::group(['prefix' => 'TiepNhan'], function () {
        Route::get('ThongTin', [tnhosodenghikhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('TraLai', [tnhosodenghikhenthuongchuyendeController::class, 'TraLai']);
        Route::post('NhanHoSo', [tnhosodenghikhenthuongchuyendeController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [tnhosodenghikhenthuongchuyendeController::class, 'ChuyenHoSo']);
        
        Route::post('ChuyenChuyenVien', [tnhosodenghikhenthuongchuyendeController::class, 'ChuyenChuyenVien']);
        Route::post('XuLyHoSo', [tnhosodenghikhenthuongchuyendeController::class, 'XuLyHoSo']);
        Route::post('LayXuLyHoSo', [tnhosodenghikhenthuongchuyendeController::class, 'LayXuLyHoSo']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongchuyendeController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongchuyendeController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongchuyendeController::class, 'ChuyenHoSo']);
        
        /*2023.09.21 Lọc dần các chức năng thừa
        Route::get('XetKT', [xdhosodenghikhenthuongchuyendeController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongchuyendeController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongchuyendeController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongchuyendeController::class, 'LayLyDo']);
        */
        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongchuyendeController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongchuyendeController::class, 'LuuToTrinhPheDuyet']);

        Route::get('TrinhKetQua', [xdhosodenghikhenthuongchuyendeController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongchuyendeController::class, 'LuuTrinhKetQua']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('ThemTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongchuyendeController::class, 'ThemHoGiaDinh']);
        /*2023.09.21 Lọc dần các chức năng thừa
        Route::post('Them', [qdhosodenghikhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongchuyendeController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosodenghikhenthuongchuyendeController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongchuyendeController::class, 'ThemHoGiaDinh']);
        Route::get('InPhoi', [qdhosodenghikhenthuongchuyendeController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongchuyendeController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenTapThe']);
        Route::get('XetKT', [qdhosodenghikhenthuongchuyendeController::class, 'XetKT']);        
        */

        Route::get('PheDuyet', [qdhosodenghikhenthuongchuyendeController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongchuyendeController::class, 'LuuPheDuyet']);        
        Route::get('QuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongchuyendeController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongchuyendeController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongchuyendeController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongchuyendeController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'InQuyetDinh']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongchuyendeController::class, 'XemHoSo']);        
        Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongchuyendeController::class, 'InToTrinhPheDuyet']);
    });
});
