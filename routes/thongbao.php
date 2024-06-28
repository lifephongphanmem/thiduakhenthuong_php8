<?php

use App\Http\Controllers\ThongBao\thongbaoController;
use Illuminate\Support\Facades\Route;

Route::prefix('ThongBao')->group(function(){
    Route::get('ThongTin',[thongbaoController::class,'ThongTin']);
    Route::post('LuuThongTin',[thongbaoController::class,'LuuThongTin']);
    Route::get('DocTin',[thongbaoController::class,'DocTin']);
});