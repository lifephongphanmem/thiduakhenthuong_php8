<?php

use App\Http\Controllers\HeThong\dschucnangController;
use App\Http\Controllers\HeThong\dsdiabanController;
use App\Http\Controllers\HeThong\dsdonviController;
use App\Http\Controllers\HeThong\dstaikhoanController;
use App\Http\Controllers\HeThong\dsvanphonghotroController;
use App\Http\Controllers\HeThong\hethongchungController;
use App\Http\Controllers\HeThong\tailieuhuongdanController;
use Illuminate\Support\Facades\Route;

//Đăng nhập
Route::get('DangNhap', [hethongchungController::class, 'DangNhap']);
Route::post('DangNhap', [hethongchungController::class, 'XacNhanDangNhap']);
Route::post('QuenMatKhau', [hethongchungController::class, 'QuenMatKhau']);
Route::get('DangXuat', [hethongchungController::class, 'DangXuat']);
Route::get('ThongTinDonVi', [dsdonviController::class, 'ThongTinDonVi']);
Route::post('ThongTinDonVi', [dsdonviController::class, 'LuuThongTinDonVi']);

Route::group(['prefix' => 'HeThongChung'], function () {
    Route::get('ThongTin', [hethongchungController::class, 'ThongTin']);
    Route::get('ThayDoi', [hethongchungController::class, 'ThayDoi']);
    Route::post('ThayDoi', [hethongchungController::class, 'LuuThayDoi']);
});
Route::group(['prefix' => 'DiaBan'], function () {
    Route::get('ThongTin', [dsdiabanController::class, 'index']);
    Route::post('Sua', [dsdiabanController::class, 'modify']);
    Route::post('Xoa', [dsdiabanController::class, 'delete']);
    Route::get('LayDonVi', [dsdiabanController::class, 'LayDonVi']);
    Route::post('NhanExcel', [dsdiabanController::class, 'NhanExcel']);
});

Route::group(['prefix' => 'DonVi'], function () {
    Route::get('ThongTin', [dsdonviController::class, 'ThongTin']);
    Route::get('DanhSach', [dsdonviController::class, 'DanhSach']);
    Route::get('Them', [dsdonviController::class, 'create']);
    Route::post('Them', [dsdonviController::class, 'store']);
    Route::get('Sua', [dsdonviController::class, 'edit']);
    Route::post('Sua', [dsdonviController::class, 'store']);
    Route::post('Xoa', [dsdonviController::class, 'destroy']);
    //Route::get('QuanLy', 'HeThong\dsdonviController@QuanLy');
    Route::post('QuanLy', [dsdonviController::class, 'LuuQuanLy']);

    Route::post('NhanExcel',[dsdonviController::class, 'NhanExcel']);
});

Route::group(['prefix' => 'TaiKhoan'], function () {
    Route::get('ThongTin', [dstaikhoanController::class, 'ThongTin']);
    Route::get('DanhSach',[dstaikhoanController::class, 'DanhSach']);
    Route::get('PhanQuyen',[dstaikhoanController::class, 'PhanQuyen']);
    Route::post('PhanQuyen',[dstaikhoanController::class, 'LuuPhanQuyen']);
    Route::get('Them', [dstaikhoanController::class, 'create']);
    Route::post('Them', [dstaikhoanController::class, 'store']);
    Route::get('Sua', [dstaikhoanController::class, 'edit']);
    Route::post('Sua', [dstaikhoanController::class, 'store']);
    Route::post('NhomChucNang', [dstaikhoanController::class, 'NhomChucNang']);
    Route::post('Xoa', [dstaikhoanController::class, 'XoaTaiKhoan']);
    Route::get('PhamViDuLieu', [dstaikhoanController::class, 'PhamViDuLieu']);
    Route::post('PhamViDuLieu', [dstaikhoanController::class, 'LuuPhamViDuLieu']);
    Route::post('XoaPhamViDuLieu', [dstaikhoanController::class, 'XoaPhamViDuLieu']);
});
Route::group(['prefix' => 'HeThongAPI'], function () {
    //Route::get('CaNhan', 'HeThong\HeThongAPIController@CaNhan');
    //Route::get('TapThe', 'HeThong\HeThongAPIController@TapThe');
    //Route::get('PhongTrao', 'HeThong\HeThongAPIController@PhongTrao');
});

Route::group(['prefix' => 'ChucNang'], function () {
    Route::get('ThongTin', [dschucnangController::class, 'ThongTin']);
    Route::post('ThongTin', [dschucnangController::class, 'LuuChucNang']);
    Route::get('LayChucNang', [dschucnangController::class, 'LayChucNang']);
    Route::post('Xoa', [dschucnangController::class, 'XoaChucNang']);
});

Route::group(['prefix' => 'VanPhongHoTro'], function () {
    Route::get('ThongTin', [dsvanphonghotroController::class, 'ThongTin']);
    Route::post('Them', [dsvanphonghotroController::class, 'Them']);
    Route::get('LayChucNang', [dsvanphonghotroController::class, 'LayChucNang']);
    Route::post('Xoa', [dsvanphonghotroController::class, 'XoaChucNang']);
});

Route::prefix('TaiLieuHuongDan')->group(function(){
    Route::get('ThongTin',[tailieuhuongdanController::class,'index']);
    Route::post('Them',[tailieuhuongdanController::class,'store']);
    Route::post('Xoa',[tailieuhuongdanController::class,'delete']);
    Route::post('update/{id}',[tailieuhuongdanController::class,'update']);
    Route::post('uploadvideo/{id}',[tailieuhuongdanController::class,'upload']);
    Route::post('XoaVideo/{id}',[tailieuhuongdanController::class,'XoaVideo']);

});
