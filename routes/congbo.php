<?php

use App\Http\Controllers\HeThong\congboController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'CongBo'], function(){    
    Route::get('VanBan', [congboController::class, 'VanBan']);    
    Route::get('QuyetDinh',[congboController::class, 'QuyetDinh']);

    Route::get('TaiLieuVanBan',[congboController::class, 'TaiLieuDinhKem']);
    Route::get('TaiLieuQuyetDinh',[congboController::class, 'TaiLieuQuyetDinh']);
});


