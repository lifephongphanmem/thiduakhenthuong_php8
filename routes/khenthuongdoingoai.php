<?php

use Illuminate\Support\Facades\Route;

//Khen thưởng theo đối ngoại
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\dshosodenghikhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\dshosokhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\qdhosodenghikhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\tnhosodenghikhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\xdhosodenghikhenthuongdoingoaiController;

Route::group(['prefix' => 'KhenThuongDoiNgoai'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongdoingoaiController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [dshosokhenthuongdoingoaiController::class, 'InHoSoPD']);
        Route::post('Xoa', [dshosokhenthuongdoingoaiController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongdoingoaiController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongdoingoaiController::class, 'LayTapThe']);


        Route::post('ThemHoGiaDinh', [dshosokhenthuongdoingoaiController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosokhenthuongdoingoaiController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosokhenthuongdoingoaiController::class, 'LayHoGiaDinh']);

        Route::post('ThemCaNhan', [dshosokhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongdoingoaiController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongdoingoaiController::class, 'LayCaNhan']);


        Route::post('ThemDeTai', [dshosokhenthuongdoingoaiController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongdoingoaiController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongdoingoaiController::class, 'LayDeTai']);
        Route::post('NhanExcel', [dshosokhenthuongdoingoaiController::class, 'NhanExcel']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongdoingoaiController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongdoingoaiController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongdoingoaiController::class, 'LayLyDo']);
        
        Route::get('QuyetDinh', [dshosokhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongdoingoaiController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongdoingoaiController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongdoingoaiController::class, 'InQuyetDinh']);
        
        /*2023.09.21 Lọc dần các chức năng thừa
        Route::get('InPhoi', [dshosokhenthuongdoingoaiController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [dshosokhenthuongdoingoaiController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [dshosokhenthuongdoingoaiController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [dshosokhenthuongdoingoaiController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [dshosokhenthuongdoingoaiController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [dshosokhenthuongdoingoaiController::class, 'InGiayKhenTapThe']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongdoingoaiController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongdoingoaiController::class, 'NhanExcelTapThe']);
        */        
       
        Route::get('ToTrinhHoSo', [dshosokhenthuongdoingoaiController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongdoingoaiController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongdoingoaiController::class, 'InToTrinhHoSo']);
        Route::get('ToTrinhPheDuyet', [dshosokhenthuongdoingoaiController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongdoingoaiController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongdoingoaiController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongdoingoaiController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongdoingoaiController::class, 'XoaHoSo']);
        Route::post('NhanExcel', [dshosodenghikhenthuongdoingoaiController::class, 'NhanExcel']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'LayTapThe']);        

        Route::post('ThemHoGiaDinh', [dshosodenghikhenthuongdoingoaiController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosodenghikhenthuongdoingoaiController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosodenghikhenthuongdoingoaiController::class, 'LayHoGiaDinh']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'LayCaNhan']);        

        Route::post('ThemDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'LayDeTai']);
        
        Route::post('ChuyenHoSo', [dshosodenghikhenthuongdoingoaiController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongdoingoaiController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosodenghikhenthuongdoingoaiController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosodenghikhenthuongdoingoaiController::class, 'LayDoiTuong']);

        /*2023.09.21 Lọc dần các chức năng thừa
        Route::post('NhanExcelDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'NhanExcelDeTai']);
        Route::post('NhanExcelTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'NhanExcelTapThe']);
        Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'NhanExcelCaNhan']);
        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongdoingoaiController::class, 'TaiLieuDinhKem']);
        Route::get('QuyetDinh', [dshosodenghikhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosodenghikhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosodenghikhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosodenghikhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosodenghikhenthuongdoingoaiController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosodenghikhenthuongdoingoaiController::class, 'HuyPheDuyet']);
        Route::get('InPhoi', [qdhosodenghikhenthuongdoingoaiController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongdoingoaiController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenTapThe']);
        */

        Route::get('ToTrinhHoSo', [dshosodenghikhenthuongdoingoaiController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosodenghikhenthuongdoingoaiController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosodenghikhenthuongdoingoaiController::class, 'InToTrinhHoSo']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'InQuyetDinh']);
    });

    Route::group(['prefix' => 'TiepNhan'], function () {
        Route::get('ThongTin', [tnhosodenghikhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('TraLai', [tnhosodenghikhenthuongdoingoaiController::class, 'TraLai']);
        Route::post('NhanHoSo', [tnhosodenghikhenthuongdoingoaiController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [tnhosodenghikhenthuongdoingoaiController::class, 'ChuyenHoSo']);
        
        Route::post('ChuyenChuyenVien', [tnhosodenghikhenthuongdoingoaiController::class, 'ChuyenChuyenVien']);
        Route::post('XuLyHoSo', [tnhosodenghikhenthuongdoingoaiController::class, 'XuLyHoSo']);
        Route::post('LayXuLyHoSo', [tnhosodenghikhenthuongdoingoaiController::class, 'LayXuLyHoSo']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongdoingoaiController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongdoingoaiController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongdoingoaiController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongdoingoaiController::class, 'LayLyDo']);
        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongdoingoaiController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongdoingoaiController::class, 'LuuToTrinhPheDuyet']);
        Route::get('TrinhKetQua', [xdhosodenghikhenthuongdoingoaiController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongdoingoaiController::class, 'LuuTrinhKetQua']);
        /*2023.09.21 Lọc dần các chức năng thừa
        Route::get('XetKT', [xdhosodenghikhenthuongdoingoaiController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongdoingoaiController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongdoingoaiController::class, 'PheDuyet']);
        */        
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongdoingoaiController::class, 'ThongTin']);
        Route::get('QuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongdoingoaiController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongdoingoaiController::class, 'TraLai']);
        Route::get('PheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'LuuPheDuyet']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'InQuyetDinh']);
        Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'InToTrinhPheDuyet']);
        Route::post('ThemTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemHoGiaDinh']);
        /*2023.09.21 Lọc dần các chức năng thừa
        Route::post('Them', [qdhosodenghikhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongdoingoaiController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosodenghikhenthuongdoingoaiController::class, 'XoaHoSo']);
        Route::post('ThemTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemHoGiaDinh']);
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongdoingoaiController::class, 'LayDoiTuong']);
        // Route::get('InQuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'InQuyetDinh']);
        // Route::post('InBangKhen', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhen']);
        // Route::post('InGiayKhen', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhen']);
        Route::get('XetKT', [qdhosodenghikhenthuongdoingoaiController::class, 'XetKT']);
        Route::get('InPhoi', [qdhosodenghikhenthuongdoingoaiController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongdoingoaiController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenTapThe']);
        */        
    });
});
