<?php

use App\Http\Controllers\VanPhongHoTro\vanphonghotroController;
use Illuminate\Support\Facades\Route;

Route::prefix('VanPhongHoTro')->group(function(){
    Route::get('/ThongTin',[vanphonghotroController::class,'ThongTin']);
    Route::post('/Store',[vanphonghotroController::class,'store']);
    Route::get('/CapNhat',[vanphonghotroController::class,'edit']);
    Route::post('/Xoa',[vanphonghotroController::class,'destroy']);
});