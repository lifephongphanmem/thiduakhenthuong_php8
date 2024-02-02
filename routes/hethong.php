<?php

use App\Http\Controllers\HeThong\dschucnangController;
use App\Http\Controllers\HeThong\dsdiabanController;
use App\Http\Controllers\HeThong\dsdonviController;
use App\Http\Controllers\HeThong\dstaikhoanController;
use App\Http\Controllers\HeThong\dsvanphonghotroController;
use App\Http\Controllers\HeThong\hethongchungController;
use Illuminate\Support\Facades\Route;

//Đăng nhập
Route::get('DangNhap', [hethongchungController::class, 'DangNhap']);
Route::post('DangNhap', [hethongchungController::class, 'XacNhanDangNhap']);
Route::post('QuenMatKhau', [hethongchungController::class, 'QuenMatKhau']);
Route::get('DangXuat', [hethongchungController::class, 'DangXuat']);
Route::get('ThongTinDonVi', [hethongchungController::class, 'ThongTinDonVi']);
Route::post('ThongTinDonVi', [hethongchungController::class, 'LuuThongTinDonVi']);

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
});

Route::group(['prefix' => 'DonVi'], function () {
    Route::get('ThongTin', [dsdonviController::class, 'ThongTin']);
    Route::get('DanhSach', 'HeThong\dsdonviController@DanhSach');
    Route::get('Them', 'HeThong\dsdonviController@create');
    Route::post('Them', 'HeThong\dsdonviController@store');
    Route::get('Sua', 'HeThong\dsdonviController@edit');
    Route::post('Sua', 'HeThong\dsdonviController@store');
    Route::post('Xoa', 'HeThong\dsdonviController@destroy');
    //Route::get('QuanLy', 'HeThong\dsdonviController@QuanLy');
    Route::post('QuanLy', 'HeThong\dsdonviController@LuuQuanLy');

    Route::post('NhanExcel', 'HeThong\dsdonviController@NhanExcel');
});

Route::group(['prefix' => 'TaiKhoan'], function () {
    Route::get('ThongTin', 'HeThong\dstaikhoanController@ThongTin');
    Route::get('DanhSach', 'HeThong\dstaikhoanController@DanhSach');

    Route::get('PhanQuyen', 'HeThong\dstaikhoanController@PhanQuyen');
    Route::post('PhanQuyen', 'HeThong\dstaikhoanController@LuuPhanQuyen');

    Route::get('Them', 'HeThong\dstaikhoanController@create');
    Route::post('Them', 'HeThong\dstaikhoanController@store');
    Route::get('Sua', 'HeThong\dstaikhoanController@edit');
    Route::post('Sua', 'HeThong\dstaikhoanController@store');
    Route::post('NhomChucNang', 'HeThong\dstaikhoanController@NhomChucNang');

    Route::post('Xoa', 'HeThong\dstaikhoanController@XoaTaiKhoan');

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
    Route::post('ThongTin', 'HeThong\dschucnangController@LuuChucNang');
    Route::get('LayChucNang', 'HeThong\dschucnangController@LayChucNang');
    Route::post('Xoa', 'HeThong\dschucnangController@XoaChucNang');
});

Route::group(['prefix' => 'VanPhongHoTro'], function () {
    Route::get('ThongTin', [dsvanphonghotroController::class, 'ThongTin']);
    Route::post('Them', [dsvanphonghotroController::class, 'Them']);
    Route::get('LayChucNang', 'HeThong\dschucnangController@LayChucNang');
    Route::post('Xoa', 'HeThong\dschucnangController@XoaChucNang');
});
