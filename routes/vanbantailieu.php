<?php

use App\Http\Controllers\VanBan\dsquyetdinhkhenthuongController;
use App\Http\Controllers\VanBan\dsvanbanphaplyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'QuanLyVanBan'], function () {
    Route::group(['prefix' => 'VanBanPhapLy'], function () {
        Route::get('ThongTin', [dsvanbanphaplyController::class, 'ThongTin']);
        Route::get('Them', [dsvanbanphaplyController::class, 'Them']);
        Route::get('Sua', [dsvanbanphaplyController::class, 'ThayDoi']);
        Route::post('Sua', [dsvanbanphaplyController::class, 'LuuHoSo']);
        Route::post('Xoa', [dsvanbanphaplyController::class, 'XoaHoSo']);
        Route::get('TaiLieuDinhKem', [dsvanbanphaplyController::class, 'TaiLieuDinhKem']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [dsquyetdinhkhenthuongController::class, 'ThongTin']);
        Route::get('Them', [dsquyetdinhkhenthuongController::class, 'Them']);
        Route::get('Sua', [dsquyetdinhkhenthuongController::class, 'ThayDoi']);
        Route::post('Sua', [dsquyetdinhkhenthuongController::class, 'LuuHoSo']);
        Route::post('Xoa', [dsquyetdinhkhenthuongController::class, 'XoaHoSo']);
        Route::get('TaiLieuDinhKem', [dsquyetdinhkhenthuongController::class, 'TaiLieuDinhKem']);
    });
});
