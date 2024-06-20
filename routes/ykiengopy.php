<?php

use App\Http\Controllers\YKienGopY\ykiengopyController;
use Illuminate\Support\Facades\Route;

Route::prefix('YKienGopY')->group(function(){
    Route::get('ThongTin',[ykiengopyController::class,'ThongTin']);
    Route::post('LuuThongTin',[ykiengopyController::class,'LuuThongTin']);
    Route::post('/Xoa',[ykiengopyController::class,'Xoa']);

    Route::get('Them',[ykiengopyController::class,'Them']);
    Route::get('Sua',[ykiengopyController::class,'ThayDoi']);
    Route::post('Sua',[ykiengopyController::class,'LuuThayDoi']);

    Route::post('NhanYKien',[ykiengopyController::class,'NhanYKien']);
    Route::get('PhanHoi',[ykiengopyController::class,'PhanHoi']);
    Route::post('PhanHoi',[ykiengopyController::class,'LuuPhanHoi']);

    Route::get('LayThongTin',[ykiengopyController::class,'LayThongTin']);

    Route::get('DinhKemGopY',[ykiengopyController::class,'DinhKemGopY']);
});