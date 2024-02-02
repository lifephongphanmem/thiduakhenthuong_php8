<?php

use App\Http\Controllers\VanBan\dsquyetdinhkhenthuongController;
use App\Http\Controllers\VanBan\dsvanbanphaplyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'QuanLyVanBan'], function () {
    Route::group(['prefix' => 'VanBanPhapLy'], function () {
        Route::get('ThongTin', [dsvanbanphaplyController::class, 'ThongTin']);
        Route::get('Them', [dsvanbanphaplyController::class, 'Them']);
        Route::get('Sua', [dsvanbanphaplyController::class, 'ThayDoi']);
        Route::post('Sua', 'VanBan\dsvanbanphaplyController@LuuHoSo');
        Route::post('Xoa', 'VanBan\dsvanbanphaplyController@XoaHoSo');
        Route::get('TaiLieuDinhKem', [dsvanbanphaplyController::class, 'TaiLieuDinhKem']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [dsquyetdinhkhenthuongController::class, 'ThongTin']);
        Route::get('Them', 'VanBan\dsquyetdinhkhenthuongController@Them');
        Route::get('Sua', 'VanBan\dsquyetdinhkhenthuongController@ThayDoi');
        Route::post('Sua', 'VanBan\dsquyetdinhkhenthuongController@LuuHoSo');
        Route::post('Xoa', 'VanBan\dsquyetdinhkhenthuongController@XoaHoSo');
        Route::get('TaiLieuDinhKem', 'VanBan\dsquyetdinhkhenthuongController@TaiLieuDinhKem');
    });
});
