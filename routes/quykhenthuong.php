<?php

use App\Http\Controllers\QuyKhenThuong\dsquanlyquykhenthuongController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'QuyKhenThuong'], function(){    
    Route::get('ThongTin',[dsquanlyquykhenthuongController::class,'ThongTin']);
    Route::post('Them',[dsquanlyquykhenthuongController::class,'Them']);
    Route::get('Sua',[dsquanlyquykhenthuongController::class,'ThayDoi']);

    Route::post('ThemThu', [dsquanlyquykhenthuongController::class, 'ThemThu']);
    Route::post('ThemChi', [dsquanlyquykhenthuongController::class, 'ThemChi']);
    Route::get('LayChiTiet', [dsquanlyquykhenthuongController::class, 'LayChiTiet']);
    Route::get('XoaChiTiet', [dsquanlyquykhenthuongController::class, 'XoaChiTiet']);
    
});


