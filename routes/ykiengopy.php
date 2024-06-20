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

});