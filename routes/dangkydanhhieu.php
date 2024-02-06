<?php

use App\Http\Controllers\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController;
use App\Http\Controllers\NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController;
use App\Http\Controllers\NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'DangKyDanhHieu'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodangkyphongtraothiduaController::class, 'ThongTin']);
        Route::post('Them', [dshosodangkyphongtraothiduaController::class, '@Them']);
        Route::get('Sua', [dshosodangkyphongtraothiduaController::class, '@ThayDoi']);
        Route::post('Sua', [dshosodangkyphongtraothiduaController::class, '@LuuHoSo']);
        Route::get('Xem', [dshosodangkyphongtraothiduaController::class, '@XemHoSo']);
        Route::post('CaNhan', [dshosodangkyphongtraothiduaController::class, '@ThemCaNhan']);
        Route::post('TapThe', [dshosodangkyphongtraothiduaController::class, '@ThemTapThe']);

        Route::post('ChuyenHoSo', [dshosodangkyphongtraothiduaController::class, '@ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodangkyphongtraothiduaController::class, '@LayLyDo']);
        Route::post('Xoa', [dshosodangkyphongtraothiduaController::class, '@XoaHoSo']);

        Route::get('LayCaNhan', [dshosodangkyphongtraothiduaController::class, '@LayCaNhan']);
        Route::get('LayTapThe', [dshosodangkyphongtraothiduaController::class, '@LayTapThe']);
        Route::post('XoaDoiTuong', [dshosodangkyphongtraothiduaController::class, '@XoaDoiTuong']);
        Route::post('NhanExcelTapThe', [dshosodangkyphongtraothiduaController::class, '@NhanExcelTapThe']);
        Route::post('NhanExcelCaNhan', [dshosodangkyphongtraothiduaController::class, '@NhanExcelCaNhan']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodangkyphongtraothiduaController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodangkyphongtraothiduaController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodangkyphongtraothiduaController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodangkyphongtraothiduaController::class, 'ChuyenHoSo']);
    });
    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodangkythiduaController::class, 'ThongTin']);
        Route::post('KhenThuong', [qdhosodangkythiduaController::class, 'KhenThuong']);
        Route::get('DanhSach', [qdhosodangkythiduaController::class, 'DanhSach']);
        Route::post('DanhSach', [qdhosodangkythiduaController::class, 'LuuHoSo']);
        Route::post('PheDuyet', [qdhosodangkythiduaController::class, 'PheDuyet']);
        Route::post('HoSo', [qdhosodangkythiduaController::class, 'HoSo']);
        Route::post('KetQua', [qdhosodangkythiduaController::class, 'KetQua']);
        Route::get('LayDoiTuong', [qdhosodangkythiduaController::class, 'LayDoiTuong']);
        Route::get('LayTieuChuan', [qdhosodangkythiduaController::class, 'LayTieuChuan']);
        Route::get('InKetQua', [qdhosodangkythiduaController::class, 'InKetQua']);
        Route::get('MacDinhQuyetDinh', [qdhosodangkythiduaController::class, 'MacDinhQuyetDinh']);
        Route::get('QuyetDinh', [qdhosodangkythiduaController::class, 'QuyetDinh']);
        Route::post('QuyetDinh', [qdhosodangkythiduaController::class, 'LuuQuyetDinh']);
        Route::get('XemQuyetDinh', [qdhosodangkythiduaController::class, 'XemQuyetDinh']);
        Route::get('Xem', [qdhosodangkythiduaController::class, 'XemHoSo']);
    });
});
