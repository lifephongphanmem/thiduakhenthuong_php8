<?php

use App\Http\Controllers\BaoCao\baocaocumkhoiController;
use App\Http\Controllers\BaoCao\baocaodonviController;
use App\Http\Controllers\BaoCao\baocaothongtu022023Controller;
use App\Http\Controllers\BaoCao\baocaotonghopController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'BaoCao'], function () {
    Route::group(['prefix' => 'DonVi'], function () {
        Route::get('ThongTin', [baocaodonviController::class, 'ThongTin']);
        Route::post('CaNhan', [baocaodonviController::class, 'CaNhan']);
        Route::post('PhongTrao', [baocaodonviController::class, 'PhongTrao']);
        Route::post('TapThe', [baocaodonviController::class, 'TapThe']);
    });
    Route::group(['prefix' => 'TongHop'], function () {
        Route::get('ThongTin', [baocaotonghopController::class, 'ThongTin']);
        Route::post('PhongTrao', [baocaotonghopController::class, 'PhongTrao']);
        Route::post('HoSo', [baocaotonghopController::class, 'HoSo']);
        Route::post('DanhHieu', [baocaotonghopController::class, 'DanhHieu']);
        Route::post('KhenThuong_m1', [baocaotonghopController::class, 'KhenThuong_m1']);
        Route::post('KhenThuong_m2', [baocaotonghopController::class, 'KhenThuong_m2']);
        Route::post('KhenThuong_m3', [baocaotonghopController::class, 'KhenThuong_m3']);
        Route::post('KhenCao_m1', [baocaotonghopController::class, 'KhenCao_m1']);
        Route::post('KhenCao_m2', [baocaotonghopController::class, 'KhenCao_m2']);
        Route::post('Mau0701', [baocaotonghopController::class, 'Mau0701']);
        Route::post('Mau0702', 'BaoCao\baocaotonghopController@Mau0702');
        Route::post('Mau0703', 'BaoCao\baocaotonghopController@Mau0703');

        Route::post('Mau0601', [baocaothongtu022023Controller::class, 'Mau0601']);
        Route::post('Mau0602', [baocaothongtu022023Controller::class, 'Mau0602']);
        Route::post('Mau0603', [baocaothongtu022023Controller::class, 'Mau0603']);
        Route::post('Mau0604', [baocaothongtu022023Controller::class, 'Mau0604']);
        Route::post('Mau0605', [baocaothongtu022023Controller::class, 'Mau0605']);
        Route::post('QuyKhenThuong', [baocaotonghopController::class, 'QuyKhenThuong']);
    });
    Route::group(['prefix' => 'CumKhoi'], function () {
        Route::get('ThongTin', [baocaocumkhoiController::class, 'ThongTin']);
        Route::post('PhongTraoThiDua', [baocaocumkhoiController::class, 'PhongTraoThiDua']);
        Route::post('HoSoKhenThuong', [baocaocumkhoiController::class, 'HoSoKhenThuong']);
        Route::post('HinhThucKhenThuong', [baocaocumkhoiController::class, 'HinhThucKhenThuong']);
    });
});
