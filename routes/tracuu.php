<?php

use App\Http\Controllers\TraCuu\tracuucanhanController;
use App\Http\Controllers\TraCuu\tracuuphongtraoController;
use App\Http\Controllers\TraCuu\tracuutaptheController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'TraCuu'], function () {
    Route::group(['prefix' => 'DungChung'], function () {
        Route::get('LayDonVi', [tracuucanhanController::class, 'ThongTin']);
       
    });

    Route::group(['prefix' => 'CaNhan'], function () {
        Route::get('ThongTin', [tracuucanhanController::class, 'ThongTin']);
        Route::post('ThongTin', [tracuucanhanController::class, 'KetQua']);
        Route::post('InKetQua', [tracuucanhanController::class, 'InKetQua']);
        Route::get('/ThongTinHoSo',[tracuucanhanController::class,'ThongTinHoSo']);
    });
    Route::group(['prefix' => 'TapThe'], function () {
        Route::get('ThongTin', [tracuutaptheController::class, 'ThongTin']);
        Route::post('ThongTin', [tracuutaptheController::class, 'KetQua']);
        Route::post('InKetQua', [tracuutaptheController::class, 'InKetQua']);
        Route::get('/ThongTinHoSo',[tracuutaptheController::class,'ThongTinHoSo']);
    });
    Route::group(['prefix' => 'PhongTrao'], function () {
        Route::get('ThongTin', [tracuuphongtraoController::class, 'ThongTin']);
        Route::post('ThongTin', [tracuuphongtraoController::class, 'KetQua']);
        Route::post('InKetQua', [tracuuphongtraoController::class, 'InKetQua']);
    });
});
