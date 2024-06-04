<?php

use App\Http\Controllers\HeThong\hethongchungController;
use App\Http\Controllers\NhatKy\nhatkytruycapController;
use Illuminate\Support\Facades\Route;

Route::prefix('NhatKyHeThong')->group(function(){
    Route::get('ThongTin',[nhatkytruycapController::class,'ThongTin']);
    Route::post('Xoa',[nhatkytruycapController::class,'Xoa']);
});
