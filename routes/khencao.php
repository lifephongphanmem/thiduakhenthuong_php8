<?php

use App\Http\Controllers\NghiepVu\KhenCao\dshosodenghikhencaoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NghiepVu\KhenCao\dshosokhencaochinhphuController;
use App\Http\Controllers\NghiepVu\KhenCao\dshosokhencaokhangchienController;
use App\Http\Controllers\NghiepVu\KhenCao\dshosokhencaonhanuocController;
use App\Http\Controllers\NghiepVu\KhenCao\qdhosodenghikhencaoController;
use App\Http\Controllers\NghiepVu\KhenCao\tnhosodenghikhencaoController;
use App\Http\Controllers\NghiepVu\KhenCao\xdhosodenghikhencaoController;

Route::group(['prefix' => 'KhenCao'], function () {
    Route::group(['prefix' => 'HoSoDeNghi'], function () {
        Route::get('ThongTin', [dshosodenghikhencaoController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhencaoController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhencaoController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhencaoController::class, 'LuuHoSo']);
        Route::post('ThemTapThe', [dshosodenghikhencaoController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhencaoController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhencaoController::class, 'LayTapThe']);
        Route::post('ThemCaNhan', [dshosodenghikhencaoController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhencaoController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhencaoController::class, 'LayCaNhan']);

        Route::post('ChuyenHoSo', [dshosodenghikhencaoController::class, 'ChuyenHoSo']);
        Route::get('InHoSo', [dshosodenghikhencaoController::class, 'XemHoSo']);
        // Route::get('InHoSoKT', [dshosokhencaochinhphuController::class, 'InHoSoKT']);
        // Route::post('Xoa', [dshosokhencaochinhphuController::class, 'XoaHoSo']);
        // Route::get('PheDuyet', [dshosokhencaochinhphuController::class, 'PheDuyet']);
        // Route::post('PheDuyet', [dshosokhencaochinhphuController::class, 'LuuPheDuyet']);
        // Route::post('HuyPheDuyet', [dshosokhencaochinhphuController::class, 'HuyPheDuyet']);
        // Route::get('TaiLieuDinhKem', [dshosokhencaochinhphuController::class, 'TaiLieuDinhKem']);
        // Route::get('InQuyetDinh', [dshosokhencaochinhphuController::class, 'InQuyetDinh']);
        // Route::post('GanKhenThuong', [dshosokhencaochinhphuController::class, 'GanKhenThuong']);

        // 
        // Route::post('NhanExcelTapThe', [dshosokhencaochinhphuController::class, 'NhanExcelTapThe']);


        // Route::post('NhanExcelCaNhan', [dshosokhencaochinhphuController::class, 'NhanExcelCaNhan']);
    });

    Route::group(['prefix' => 'TiepNhanDeNghi'], function () {
        Route::get('ThongTin', [tnhosodenghikhencaoController::class, 'ThongTin']);
        Route::post('TraLai', [tnhosodenghikhencaoController::class, 'TraLai']);
        Route::post('NhanHoSo', [tnhosodenghikhencaoController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [tnhosodenghikhencaoController::class, 'ChuyenHoSo']);
    });

    Route::group(['prefix' => 'XetDuyetHoSoDN'], function () {
        Route::get('ThongTin', [xdhosodenghikhencaoController::class, 'ThongTin']);        
        Route::post('TraLai', [xdhosodenghikhencaoController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhencaoController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhencaoController::class, 'ChuyenHoSo']);      
    });

    Route::group(['prefix' => 'PheDuyetDeNghi'], function () {
        Route::get('ThongTin', [qdhosodenghikhencaoController::class, 'ThongTin']);
        Route::post('ThemTapThe', [qdhosodenghikhencaoController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhencaoController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhencaoController::class, 'ThemHoGiaDinh']);
        
        Route::get('PheDuyet', [qdhosodenghikhencaoController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhencaoController::class, 'LuuPheDuyet']);

        Route::get('XetKT', [qdhosodenghikhencaoController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosodenghikhencaoController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhencaoController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhencaoController::class, 'LuuQuyetDinh']);       
        Route::post('GanKhenThuong', [qdhosodenghikhencaoController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhencaoController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhencaoController::class, 'TraLai']);
        
        Route::get('InHoSoPD', [qdhosodenghikhencaoController::class, 'XemHoSo']);        
        Route::get('InToTrinhPheDuyet', [qdhosodenghikhencaoController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'ChinhPhu'], function () {
        Route::get('ThongTin', [dshosokhencaochinhphuController::class, 'ThongTin']);
        Route::post('Them', [dshosokhencaochinhphuController::class, 'Them']);
        Route::get('Sua', [dshosokhencaochinhphuController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhencaochinhphuController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhencaochinhphuController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhencaochinhphuController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhencaochinhphuController::class, 'XoaHoSo']);
        Route::get('PheDuyet', [dshosokhencaochinhphuController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhencaochinhphuController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhencaochinhphuController::class, 'HuyPheDuyet']);
        Route::get('TaiLieuDinhKem', [dshosokhencaochinhphuController::class, 'TaiLieuDinhKem']);
        Route::get('InQuyetDinh', [dshosokhencaochinhphuController::class, 'InQuyetDinh']);
        Route::post('GanKhenThuong', [dshosokhencaochinhphuController::class, 'GanKhenThuong']);

        Route::post('ThemTapThe', [dshosokhencaochinhphuController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhencaochinhphuController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhencaochinhphuController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhencaochinhphuController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhencaochinhphuController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhencaochinhphuController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhencaochinhphuController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhencaochinhphuController::class, 'NhanExcelCaNhan']);
    });
    Route::group(['prefix' => 'NhaNuoc'], function () {
        Route::get('ThongTin', [dshosokhencaonhanuocController::class, 'ThongTin']);
        Route::post('Them', [dshosokhencaonhanuocController::class, 'Them']);
        Route::get('Sua', [dshosokhencaonhanuocController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhencaonhanuocController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhencaonhanuocController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhencaonhanuocController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhencaonhanuocController::class, 'XoaHoSo']);
        Route::get('PheDuyet', [dshosokhencaonhanuocController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhencaonhanuocController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhencaonhanuocController::class, 'HuyPheDuyet']);
        Route::get('TaiLieuDinhKem', [dshosokhencaonhanuocController::class, 'TaiLieuDinhKem']);
        Route::get('InQuyetDinh', [dshosokhencaonhanuocController::class, 'InQuyetDinh']);
        Route::post('GanKhenThuong', [dshosokhencaonhanuocController::class, 'GanKhenThuong']);

        Route::post('ThemTapThe', [dshosokhencaonhanuocController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhencaonhanuocController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhencaonhanuocController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhencaonhanuocController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhencaonhanuocController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhencaonhanuocController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhencaonhanuocController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhencaonhanuocController::class, 'NhanExcelCaNhan']);
    });

    Route::group(['prefix' => 'KhangChien'], function () {
        Route::get('ThongTin', [dshosokhencaokhangchienController::class, 'ThongTin']);
        Route::post('Them', [dshosokhencaokhangchienController::class, 'Them']);
        Route::get('Sua', [dshosokhencaokhangchienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhencaokhangchienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhencaokhangchienController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhencaokhangchienController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhencaokhangchienController::class, 'XoaHoSo']);
        Route::get('PheDuyet', [dshosokhencaokhangchienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhencaokhangchienController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhencaokhangchienController::class, 'HuyPheDuyet']);
        Route::get('TaiLieuDinhKem', [dshosokhencaokhangchienController::class, 'TaiLieuDinhKem']);
        Route::get('InQuyetDinh', [dshosokhencaokhangchienController::class, 'InQuyetDinh']);
        Route::post('GanKhenThuong', [dshosokhencaokhangchienController::class, 'GanKhenThuong']);

        Route::post('ThemTapThe', [dshosokhencaokhangchienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhencaokhangchienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhencaokhangchienController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhencaokhangchienController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhencaokhangchienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhencaokhangchienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhencaokhangchienController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhencaokhangchienController::class, 'NhanExcelCaNhan']);
    });
});
