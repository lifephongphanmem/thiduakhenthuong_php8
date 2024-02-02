<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'CongBo'], function(){    
    Route::get('VanBan','HeThong\congboController@VanBan');    
    Route::get('QuyetDinh','HeThong\congboController@QuyetDinh');

    Route::get('TaiLieuVanBan','HeThong\congboController@TaiLieuVanBan');
    Route::get('TaiLieuQuyetDinh','HeThong\congboController@TaiLieuQuyetDinh');
});


