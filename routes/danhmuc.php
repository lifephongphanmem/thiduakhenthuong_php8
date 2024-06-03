<?php

use App\Http\Controllers\DanhMuc\dmcoquandonviController;
use App\Http\Controllers\DanhMuc\dmdanhhieuthiduaController;
use App\Http\Controllers\DanhMuc\dmdetaisangkienController;
use App\Http\Controllers\DanhMuc\dmhinhthuckhenthuongController;
use App\Http\Controllers\DanhMuc\dmhinhthucthiduaController;
use App\Http\Controllers\DanhMuc\dmloaihinhkhenthuongController;
use App\Http\Controllers\DanhMuc\dmphanloaiController;
use App\Http\Controllers\DanhMuc\dmphongtraothiduaController;
use App\Http\Controllers\DanhMuc\duthaoquyetdinhController;
use App\Http\Controllers\HeThong\dsnhomtaikhoanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'DanhHieuThiDua'], function () {
    Route::get('ThongTin', [dmdanhhieuthiduaController::class, 'ThongTin']);
    Route::post('Them', [dmdanhhieuthiduaController::class, 'store']);
    Route::post('Xoa', [dmdanhhieuthiduaController::class, 'delete']);
    Route::get('TieuChuan', [dmdanhhieuthiduaController::class, 'TieuChuan']);
    Route::post('TieuChuan', [dmdanhhieuthiduaController::class, 'ThemTieuChuan']);
    Route::post('XoaTieuChuan', [dmdanhhieuthiduaController::class, 'delete_TieuChuan']);
    //Route::get('Sua','system\DSTaiKhoanController@edit']);
});

Route::group(['prefix' => 'LoaiHinhKhenThuong'], function () {
    Route::get('ThongTin', [dmloaihinhkhenthuongController::class, 'ThongTin']);
    Route::post('Them', [dmloaihinhkhenthuongController::class, 'store']);
    Route::post('Xoa', [dmloaihinhkhenthuongController::class, 'delete']);
});

Route::group(['prefix' => 'HinhThucKhenThuong'], function () {
    Route::get('ThongTin', [dmhinhthuckhenthuongController::class, 'ThongTin']);
    Route::post('Them', [dmhinhthuckhenthuongController::class, 'store']);
    Route::post('Xoa', [dmhinhthuckhenthuongController::class, 'delete']);
    Route::get('LayChiTiet', [dmhinhthuckhenthuongController::class, 'LayChiTiet']);
});


Route::group(['prefix' => 'DuThaoQD'], function () {
    Route::get('ThongTin', [duthaoquyetdinhController::class, 'ThongTin']);
    Route::post('Them', [duthaoquyetdinhController::class, 'Them']);
    Route::post('Xoa', [duthaoquyetdinhController::class, 'Xoa']);
    Route::get('Xem', [duthaoquyetdinhController::class, 'XemDuThao']);
    Route::post('Luu', [duthaoquyetdinhController::class, 'LuuDuThao']);
});

Route::group(['prefix' => 'DMPhanLoai'], function () {
    Route::get('ThongTin', [dmphanloaiController::class, 'ThongTin']);
    Route::post('Them', [dmphanloaiController::class, 'Them']);
    Route::post('ThemNhom', [dmphanloaiController::class, 'ThemNhom']);
    Route::post('Xoa', [dmphanloaiController::class, 'Xoa']);
});


Route::group(['prefix' => 'NhomChucNang'], function () {
    Route::get('ThongTin', [dsnhomtaikhoanController::class, 'ThongTin']);
    Route::post('Sua', [dsnhomtaikhoanController::class, 'store']);
    Route::post('Xoa', [dsnhomtaikhoanController::class, 'destroy']);
    Route::get('PhanQuyen', [dsnhomtaikhoanController::class, 'PhanQuyen']);
    Route::post('PhanQuyen', [dsnhomtaikhoanController::class, 'LuuPhanQuyen']);
    Route::get('DanhSach', [dsnhomtaikhoanController::class, 'DanhSach']);
    Route::post('ThietLapLai', [dsnhomtaikhoanController::class, 'ThietLapLai']);
});

Route::group(['prefix' => 'HinhThucThiDua'], function () {
    Route::get('ThongTin', [dmhinhthucthiduaController::class, 'ThongTin']);
    Route::post('Them', [dmhinhthucthiduaController::class, 'store']);
    Route::post('Xoa', [dmhinhthucthiduaController::class, 'delete']);
    Route::get('LayChiTiet', [dmhinhthucthiduaController::class, 'LayChiTiet']);
});

Route::group(['prefix' => 'CoQuanDonVi'], function () {
    Route::get('ThongTin', [dmcoquandonviController::class, 'ThongTin']);
    Route::post('Them', [dmcoquandonviController::class, 'store']);
    Route::post('Xoa', [dmcoquandonviController::class, 'delete']);
    Route::get('LayChiTiet', [dmcoquandonviController::class, 'LayChiTiet']);
    Route::post('LayDonVi',[dmcoquandonviController::class,'LayDonVi']);
});

Route::group(['prefix' => 'DeTaiSangKien'], function () {
    Route::get('ThongTin', [dmdetaisangkienController::class, 'ThongTin']);
    Route::post('Them', [dmdetaisangkienController::class, 'store']);
    Route::post('Xoa', [dmdetaisangkienController::class, 'delete']);
    Route::get('LayChiTiet', [dmdetaisangkienController::class, 'LayChiTiet']);
});

Route::group(['prefix' => 'PLPhongTraoThiDua'], function () {
    Route::get('ThongTin', [dmphongtraothiduaController::class, 'ThongTin']);
    Route::post('Them', [dmphongtraothiduaController::class, 'store']);
    Route::post('Xoa', [dmphongtraothiduaController::class, 'delete']);
    Route::get('LayChiTiet', [dmphongtraothiduaController::class, 'LayChiTiet']);
});
