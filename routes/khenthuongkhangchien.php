<?php

use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongMyCaNhan\dshosochongmy_canhanController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongMyGiaDinh\dshosochongmy_giadinhController;
use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController;
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
});
