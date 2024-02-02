<?php

use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dscumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongthiduacumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dshosothiduacumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dstruongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dsvanbancumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\GiaoUoc\dshosogiaouocthiduaController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\GiaoUoc\xdhosogiaouocthiduaController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\qdhosodenghikhenthuongthiduacumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\qdhosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\tnhosodenghikhenthuongthiduacumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\tnhosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\xdhosodenghikhenthuongthiduacumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\xetduyethosothamgiathiduacumkhoiController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'CumKhoiThiDua'], function () {
    Route::group(['prefix' => 'VanBan'], function () {
        Route::get('ThongTin', [dsvanbancumkhoiController::class, 'ThongTin']);
        Route::get('Them', [dsvanbancumkhoiController::class, 'Them']);
        Route::get('Sua', [dsvanbancumkhoiController::class, 'ThayDoi']);
        Route::post('Sua', [dsvanbancumkhoiController::class, 'LuuHoSo']);
        Route::post('Xoa', [dsvanbancumkhoiController::class, 'XoaHoSo']);
        Route::get('TaiLieuDinhKem', [dsvanbancumkhoiController::class, 'TaiLieuDinhKem']);
    });
    Route::group(['prefix' => 'CumKhoi'], function () {
        Route::get('ThongTin', [dscumkhoiController::class, 'ThongTin']);
        Route::get('Them', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@ThayDoi');
        Route::post('Them', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@LuuCumKhoi');
        Route::get('Sua', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@ThayDoi');
        Route::post('Sua', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@LuuCumKhoi');
        Route::post('Xoa', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@Xoa');

        Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@DanhSach');
        Route::post('ThemDonVi', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@ThemDonVi');
        Route::post('XoaDonVi', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@XoaDonVi');

        Route::get('TaiLieuDinhKem', [dscumkhoiController::class, 'TaiLieuDinhKem']);
    });
    Route::group(['prefix' => 'TruongCumKhoi'], function () {
        Route::get('ThongTin', [dstruongcumkhoiController::class, 'ThongTin']);
        Route::get('Them', [dstruongcumkhoiController::class, 'ThayDoi']);
        Route::post('Them', [dstruongcumkhoiController::class, 'LuuDanhSach']);

        Route::get('DanhSach', [dstruongcumkhoiController::class, 'DanhSach']);
        Route::get('LayDSDonVi', [dstruongcumkhoiController::class, 'LayDSDonVi']);
        Route::post('Xoa', [dstruongcumkhoiController::class, 'XoaDS']);
        Route::post('LuuTruongCum', [dstruongcumkhoiController::class, 'LuuTruongCum']);
    });

    Route::group(['prefix' => 'PhongTraoThiDua'], function () {
        Route::get('ThongTin', [dsphongtraothiduacumkhoiController::class, 'ThongTin']);
        Route::get('Xem', [dsphongtraothiduacumkhoiController::class, 'XemThongTin']);
        Route::get('Them', [dsphongtraothiduacumkhoiController::class, 'ThayDoi']);
        Route::post('Them', [dsphongtraothiduacumkhoiController::class, 'LuuPhongTrao']);
        Route::get('Sua', [dsphongtraothiduacumkhoiController::class, 'ThayDoi']);
        Route::post('Sua', [dsphongtraothiduacumkhoiController::class, 'LuuPhongTrao']);
        Route::post('GanTrangThai', [dsphongtraothiduacumkhoiController::class, 'GanTrangThai']);

        Route::get('ThemKhenThuong', [dsphongtraothiduacumkhoiController::class, 'ThemKhenThuong']);
        Route::get('ThemTieuChuan', [dsphongtraothiduacumkhoiController::class, 'ThemTieuChuan']);
        Route::get('LayTieuChuan', [dsphongtraothiduacumkhoiController::class, 'LayTieuChuan']);
        Route::get('XoaTieuChuan', [dsphongtraothiduacumkhoiController::class, 'XoaTieuChuan']);
        Route::get('TaiLieuDinhKem', [dsphongtraothiduacumkhoiController::class, 'TaiLieuDinhKem']);

        //Route::get('Sua','system\DSTaiKhoanController@edit');
    });

    Route::group(['prefix' => 'KTCumKhoi'], function () {
        Route::group(['prefix' => 'HoSoKT'], function () {
            Route::get('ThongTin', [dshosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::post('Them', [dshosokhenthuongcumkhoiController::class, 'Them']);
            Route::get('Sua', [dshosokhenthuongcumkhoiController::class, 'ThayDoi']);
            Route::post('Sua', [dshosokhenthuongcumkhoiController::class, 'LuuHoSo']);

            Route::get('InHoSo', [dshosokhenthuongcumkhoiController::class, 'InHoSo']);
            Route::get('InHoSoPD', [qdhosokhenthuongcumkhoiController::class, 'InHoSoPD']);
            Route::post('Xoa', [dshosokhenthuongcumkhoiController::class, 'XoaHoSo']);

            Route::post('ThemTapThe', [dshosokhenthuongcumkhoiController::class, 'ThemTapThe']);
            Route::get('XoaTapThe', [dshosokhenthuongcumkhoiController::class, 'XoaTapThe']);
            Route::get('LayTapThe', [dshosokhenthuongcumkhoiController::class, 'LayTapThe']);
            Route::post('NhanExcelTapThe', [dshosokhenthuongcumkhoiController::class, 'NhanExcelTapThe']);

            Route::post('ThemCaNhan', [dshosokhenthuongcumkhoiController::class, 'ThemCaNhan']);
            Route::get('XoaCaNhan', [dshosokhenthuongcumkhoiController::class, 'XoaCaNhan']);
            Route::get('LayCaNhan', [dshosokhenthuongcumkhoiController::class, 'LayCaNhan']);
            Route::post('NhanExcelCaNhan', [dshosokhenthuongcumkhoiController::class, 'NhanExcelCaNhan']);

            Route::post('ThemDeTai', [dshosokhenthuongcumkhoiController::class, 'ThemDeTai']);
            Route::get('XoaDeTai', [dshosokhenthuongcumkhoiController::class, 'XoaDeTai']);
            Route::get('LayDeTai', [dshosokhenthuongcumkhoiController::class, 'LayDeTai']);
            Route::post('NhanExcelDeTai', [dshosokhenthuongcumkhoiController::class, 'NhanExcelDeTai']);

            Route::post('NhanExcel', [dshosokhenthuongcumkhoiController::class, 'NhanExcel']);

            Route::get('TaiLieuDinhKem', [dshosokhenthuongcumkhoiController::class, 'TaiLieuDinhKem']);
            Route::post('GanKhenThuong', [dshosokhenthuongcumkhoiController::class, 'GanKhenThuong']);
            //29.10.2022
            Route::get('QuyetDinh', [dshosokhenthuongcumkhoiController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [dshosokhenthuongcumkhoiController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [dshosokhenthuongcumkhoiController::class, 'LuuQuyetDinh']);
            Route::get('PheDuyet', [dshosokhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::post('PheDuyet', [dshosokhenthuongcumkhoiController::class, 'LuuPheDuyet']);
            Route::post('HuyPheDuyet', [dshosokhenthuongcumkhoiController::class, 'HuyPheDuyet']);
            Route::get('InQuyetDinh', [dshosokhenthuongcumkhoiController::class, 'InQuyetDinh']);
            Route::get('InPhoi', [dshosokhenthuongcumkhoiController::class, 'InPhoi']);

            Route::post('NoiDungKhenThuong', [dshosokhenthuongcumkhoiController::class, 'NoiDungKhenThuong']);
            Route::get('InBangKhenCaNhan', [dshosokhenthuongcumkhoiController::class, 'InBangKhenCaNhan']);
            Route::get('InBangKhenTapThe', [dshosokhenthuongcumkhoiController::class, 'InBangKhenTapThe']);
            Route::get('InGiayKhenCaNhan', [dshosokhenthuongcumkhoiController::class, 'InGiayKhenCaNhan']);
            Route::get('InGiayKhenTapThe', [dshosokhenthuongcumkhoiController::class, 'InGiayKhenTapThe']);

            //09.11.22
            Route::get('ToTrinhHoSo', [dshosokhenthuongcumkhoiController::class, 'ToTrinhHoSo']);
            Route::post('ToTrinhHoSo', [dshosokhenthuongcumkhoiController::class, 'LuuToTrinhHoSo']);
            Route::get('InToTrinhHoSo', [dshosokhenthuongcumkhoiController::class, 'InToTrinhHoSo']);

            Route::get('ToTrinhPheDuyet', [dshosokhenthuongcumkhoiController::class, 'ToTrinhPheDuyet']);
            Route::post('ToTrinhPheDuyet', [dshosokhenthuongcumkhoiController::class, 'LuuToTrinhPheDuyet']);
            Route::get('InToTrinhPheDuyet', [dshosokhenthuongcumkhoiController::class, 'InToTrinhPheDuyet']);
        });

        Route::group(['prefix' => 'HoSo'], function () {
            Route::get('ThongTin', [dshosodenghikhenthuongcumkhoiController::class, 'ThongTin']);
            Route::get('DanhSach', [dshosodenghikhenthuongcumkhoiController::class, 'DanhSach']);
            Route::post('Them', [dshosodenghikhenthuongcumkhoiController::class, 'Them']);
            Route::get('Sua', [dshosodenghikhenthuongcumkhoiController::class, 'ThayDoi']);
            Route::post('Sua', [dshosodenghikhenthuongcumkhoiController::class, 'LuuHoSo']);
            Route::get('InHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'XemHoSo']);
            Route::get('InHoSoPD', [qdhosokhenthuongcumkhoiController::class, 'InHoSo']);
            Route::post('Xoa', [dshosodenghikhenthuongcumkhoiController::class, 'XoaHoSo']);

            Route::post('ThemTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'ThemTapThe']);
            Route::get('XoaTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'XoaTapThe']);
            Route::get('LayTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'LayTapThe']);
            Route::post('NhanExcelTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'NhanExcelTapThe']);

            Route::post('ThemCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'ThemCaNhan']);
            Route::get('XoaCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'XoaCaNhan']);
            Route::get('LayCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'LayCaNhan']);
            Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'NhanExcelCaNhan']);

            Route::post('ThemDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'ThemDeTai']);
            Route::get('XoaDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'XoaDeTai']);
            Route::get('LayDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'LayDeTai']);
            Route::post('NhanExcelDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'NhanExcelDeTai']);

            Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongcumkhoiController::class, 'TaiLieuDinhKem']);
            Route::post('ChuyenHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'ChuyenHoSo']);
            Route::get('LayLyDo', [dshosodenghikhenthuongcumkhoiController::class, 'LayLyDo']);
            Route::get('LayTieuChuan', [dshosodenghikhenthuongcumkhoiController::class, 'LayTieuChuan']);
            Route::get('LayDoiTuong', [dshosodenghikhenthuongcumkhoiController::class, 'LayDoiTuong']);
            
            Route::post('ChuyenHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'ChuyenHoSo']);

            //29.10.2022
            Route::get('QuyetDinh', [dshosodenghikhenthuongcumkhoiController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [dshosodenghikhenthuongcumkhoiController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [dshosodenghikhenthuongcumkhoiController::class, 'LuuQuyetDinh']);
            Route::get('PheDuyet', [dshosodenghikhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::post('PheDuyet', [dshosodenghikhenthuongcumkhoiController::class, 'LuuPheDuyet']);
            Route::post('HuyPheDuyet', [dshosodenghikhenthuongcumkhoiController::class, 'HuyPheDuyet']);

            Route::get('InQuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'InQuyetDinh']);
            Route::get('InPhoi', [qdhosokhenthuongcumkhoiController::class, 'InPhoi']);

            Route::post('NoiDungKhenThuong', [qdhosokhenthuongcumkhoiController::class, 'NoiDungKhenThuong']);
            Route::get('InBangKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenCaNhan']);
            Route::get('InBangKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenTapThe']);
            Route::get('InGiayKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenCaNhan']);
            Route::get('InGiayKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenTapThe']);
            //09.11.2022
            Route::get('ToTrinhHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'ToTrinhHoSo']);
            Route::post('ToTrinhHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'LuuToTrinhHoSo']);
            Route::get('InToTrinhHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'InToTrinhHoSo']);

            Route::post('NhanExcel', [dshosodenghikhenthuongcumkhoiController::class, 'NhanExcel']);
        });

        Route::group(['prefix' => 'XetDuyet'], function () {
            Route::get('ThongTin', [xetduyethosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::get('DanhSach', [xetduyethosokhenthuongcumkhoiController::class, 'DanhSach']);
            Route::post('TraLai', [xetduyethosokhenthuongcumkhoiController::class, 'TraLai']);
            Route::post('NhanHoSo', [xetduyethosokhenthuongcumkhoiController::class, 'NhanHoSo']);
            Route::post('ChuyenHoSo', [xetduyethosokhenthuongcumkhoiController::class, 'ChuyenHoSo']);

            Route::get('XetKT', [xetduyethosokhenthuongcumkhoiController::class, 'XetKT']);
            Route::post('ThemTapThe', [xetduyethosokhenthuongcumkhoiController::class, 'ThemTapThe']);
            Route::post('ThemCaNhan', [xetduyethosokhenthuongcumkhoiController::class, 'ThemCaNhan']);
            Route::post('GanKhenThuong', [xetduyethosokhenthuongcumkhoiController::class, 'GanKhenThuong']);
            Route::get('QuyetDinh', [xetduyethosokhenthuongcumkhoiController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [xetduyethosokhenthuongcumkhoiController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [xetduyethosokhenthuongcumkhoiController::class, 'LuuQuyetDinh']);
            Route::post('PheDuyet', [xetduyethosokhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::get('LayLyDo', [xetduyethosokhenthuongcumkhoiController::class, 'LayLyDo']);

            Route::get('ToTrinhPheDuyet', [xetduyethosokhenthuongcumkhoiController::class, 'ToTrinhPheDuyet']);
            Route::post('ToTrinhPheDuyet', [xetduyethosokhenthuongcumkhoiController::class, 'LuuToTrinhPheDuyet']);

            Route::get('TrinhKetQua', [xetduyethosokhenthuongcumkhoiController::class, 'TrinhKetQua']);
            Route::post('TrinhKetQua', [xetduyethosokhenthuongcumkhoiController::class, 'LuuTrinhKetQua']);
        });

        Route::group(['prefix' => 'TiepNhan'], function () {
            Route::get('ThongTin', [tnhosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::get('DanhSach', [tnhosokhenthuongcumkhoiController::class, 'DanhSach']);
            Route::post('TraLai', [tnhosokhenthuongcumkhoiController::class, 'TraLai']);
            Route::post('NhanHoSo', [tnhosokhenthuongcumkhoiController::class, 'NhanHoSo']);
            Route::post('ChuyenHoSo', [tnhosokhenthuongcumkhoiController::class, 'ChuyenHoSo']);
        });

        Route::group(['prefix' => 'KhenThuong'], function () {
            Route::get('DanhSach', [qdhosokhenthuongcumkhoiController::class, 'DanhSach']);
            Route::get('ThongTin', [qdhosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::post('Them', [qdhosokhenthuongcumkhoiController::class, 'Them']);
            // Route::get('Sua', [qdhosokhenthuongcumkhoiController::class, 'Sua']);
            // Route::post('Sua', [qdhosokhenthuongcumkhoiController::class, 'LuuHoSo']);
            // Route::post('Xoa', [qdhosokhenthuongcumkhoiController::class, 'XoaHoSo']);

            Route::post('ThemTapThe', [qdhosokhenthuongcumkhoiController::class, 'ThemTapThe']);
            Route::get('XoaTapThe', [qdhosokhenthuongcumkhoiController::class, 'XoaTapThe']);
            Route::post('NhanExcelTapThe', [qdhosokhenthuongcumkhoiController::class, 'NhanExcelTapThe']);
            Route::post('ThemCaNhan', [qdhosokhenthuongcumkhoiController::class, 'ThemCaNhan']);
            Route::get('XoaCaNhan', [qdhosokhenthuongcumkhoiController::class, 'XoaCaNhan']);
            Route::post('NhanExcelCaNhan', [qdhosokhenthuongcumkhoiController::class, 'NhanExcelCaNhan']);
            Route::post('NhanExcelDeTai', [qdhosokhenthuongcumkhoiController::class, 'NhanExcelDeTai']);

            // Route::get('XetKT', [qdhosokhenthuongcumkhoiController::class, 'XetKT']);
            Route::get('QuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [qdhosokhenthuongcumkhoiController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'LuuQuyetDinh']);
            //Route::post('PheDuyet', [qdhosokhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::get('PheDuyet', [qdhosokhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::post('PheDuyet', [qdhosokhenthuongcumkhoiController::class, 'LuuPheDuyet']);
            Route::post('GanKhenThuong', [qdhosokhenthuongcumkhoiController::class, 'GanKhenThuong']);
            Route::post('HuyPheDuyet', [qdhosokhenthuongcumkhoiController::class, 'HuyPheDuyet']);
            Route::post('TraLai', [qdhosokhenthuongcumkhoiController::class, 'TraLai']);

            //In dữ liệu
            Route::post('LayDoiTuong', [qdhosokhenthuongcumkhoiController::class, 'LayDoiTuong']);
            Route::get('InQuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'InQuyetDinh']);
            Route::post('InBangKhen', [qdhosokhenthuongcumkhoiController::class, 'InBangKhen']);
            Route::post('InGiayKhen', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhen']);
            Route::get('InHoSoPD', [qdhosokhenthuongcumkhoiController::class, 'InHoSo']);

            Route::get('InPhoi', [qdhosokhenthuongcumkhoiController::class, 'InPhoi']);
            Route::post('NoiDungKhenThuong', [qdhosokhenthuongcumkhoiController::class, 'NoiDungKhenThuong']);
            Route::get('InBangKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenCaNhan']);
            Route::get('InBangKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenTapThe']);
            Route::get('InGiayKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenCaNhan']);
            Route::get('InGiayKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenTapThe']);

            //09.11.2022

            Route::get('InToTrinhPheDuyet', [qdhosokhenthuongcumkhoiController::class, 'InToTrinhPheDuyet']);
        });
    });

    Route::group(['prefix' => 'HoSoKhenThuong'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongcumkhoiController::class, 'ThongTin']);
        Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@DanhSach');

        Route::get('Them', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ThayDoi');
        Route::post('Them', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LuuHoSo');
        Route::get('Sua', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@Sua');
        Route::post('Sua', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LuuHoSo');
        Route::get('Xem', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@XemHoSo');

        Route::get('ThemDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ThemDoiTuong');
        Route::get('ThemDoiTuongTapThe', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ThemDoiTuongTapThe');
        Route::get('LayTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LayTieuChuan');
        Route::get('LuuTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LuuTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LayDoiTuong');

        Route::get('LayLyDo', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LayLyDo');
        Route::get('XoaDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@XoaDoiTuong');

        Route::post('Xoa', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@XoaHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ChuyenHoSo');
    });

    Route::group(['prefix' => 'XetDuyetHoSoKhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController@ThongTin');
        Route::post('NhanHoSo', 'NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController@NhanHoSo');
        Route::post('TraLai', 'NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController@TraLai');
        //
        // Route::get('DanhSach','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@DanhSach');
        // Route::post('TraLai','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@TraLai'); 
        // Route::post('ChuyenHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ChuyenHoSo');
        // Route::post('KetThuc','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    });

    Route::group(['prefix' => 'ThamGiaThiDua'], function () {
        Route::get('ThongTin', [dshosothiduacumkhoiController::class, 'ThongTin']);
        Route::get('DanhSach', [dshosothiduacumkhoiController::class, 'DanhSach']);
        Route::get('Them', [dshosothiduacumkhoiController::class, 'ThemHoSo']);
        Route::get('Sua', [dshosothiduacumkhoiController::class, 'ThayDoi']);
        Route::post('Sua', [dshosothiduacumkhoiController::class, 'LuuHoSo']);

        Route::get('Xem', [dshosothiduacumkhoiController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosothiduacumkhoiController::class, 'XoaHoSo']);

        Route::post('ChuyenHoSo', [dshosothiduacumkhoiController::class, 'ChuyenHoSo']);
        // Route::get('LayTieuChuan', [dshosothiduaController::class, 'LayTieuChuan']);
        // Route::get('LuuTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuTieuChuan');
        // Route::post('delete', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@delete');
        // Route::get('LayLyDo', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayLyDo');
        // Route::get('XoaDoiTuong', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XoaDoiTuong');

        Route::post('ThemTapThe', [dshosothiduacumkhoiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosothiduacumkhoiController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosothiduacumkhoiController::class, 'LayTapThe']);

        Route::post('ThemCaNhan', [dshosothiduacumkhoiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosothiduacumkhoiController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosothiduacumkhoiController::class, 'LayCaNhan']);

        // Route::get('ToTrinhHoSo', [dshosothiduacumkhoiController::class, 'ToTrinhHoSo']);
        // Route::post('ToTrinhHoSo', [dshosothiduacumkhoiController::class, 'LuuToTrinhHoSo']);
        // Route::get('InToTrinhHoSo', [dshosothiduacumkhoiController::class, 'InToTrinhHoSo']);

    });

    Route::group(['prefix' => 'XetDuyetThamGiaThiDua'], function () {
        Route::get('ThongTin', [xetduyethosothamgiathiduacumkhoiController::class, 'ThongTin']);
        Route::post('TraLai', [xetduyethosothamgiathiduacumkhoiController::class, 'TraLai']);
        Route::post('NhanHoSo', [xetduyethosothamgiathiduacumkhoiController::class, 'NhanHoSo']);
    });

    Route::group(['prefix' => 'DeNghiThiDua'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongthiduacumkhoiController::class, 'ThongTin']);
        Route::get('DanhSach', [dshosodenghikhenthuongthiduacumkhoiController::class, 'DanhSach']);
        Route::get('DanhSachChiTiet', [dshosodenghikhenthuongthiduacumkhoiController::class, 'DanhSachChiTiet']);
        Route::get('InHoSo', [dshosodenghikhenthuongthiduacumkhoiController::class, 'InHoSo']);
        
        Route::post('TraLai', [dshosodenghikhenthuongthiduacumkhoiController::class, 'TraLai']);
        Route::get('Xem', [dshosodenghikhenthuongthiduacumkhoiController::class, 'XemDanhSach']);
        Route::post('ChuyenHoSo',[dshosodenghikhenthuongthiduacumkhoiController::class, 'ChuyenHoSo'] );
        Route::post('NhanHoSo', [dshosodenghikhenthuongthiduacumkhoiController::class, 'NhanHoSo']);

        Route::post('ThemKT', [dshosodenghikhenthuongthiduacumkhoiController::class, 'ThemKT']);
        Route::get('XetKT', [dshosodenghikhenthuongthiduacumkhoiController::class, 'XetKT']);
        Route::post('XetKT', [dshosodenghikhenthuongthiduacumkhoiController::class, 'LuuKT']);
        Route::post('XoaHoSoKT', [dshosodenghikhenthuongthiduacumkhoiController::class, 'XoaHoSoKT']);
        Route::get('Xem', [dshosodenghikhenthuongthiduacumkhoiController::class, 'XemHoSoKT']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongthiduacumkhoiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongthiduacumkhoiController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongthiduacumkhoiController::class, 'LayTapThe']);       

        Route::post('ThemCaNhan', [dshosodenghikhenthuongthiduacumkhoiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongthiduacumkhoiController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongthiduacumkhoiController::class, 'LayCaNhan']);
    });

    Route::group(['prefix' => 'TiepNhanThiDua'], function () {
        Route::get('ThongTin', [tnhosodenghikhenthuongthiduacumkhoiController::class, 'ThongTin']);
        // Route::get('DanhSach', [tnhosodenghikhenthuongthiduacumkhoiController::class, 'DanhSach']);
        Route::post('TraLai', [tnhosodenghikhenthuongthiduacumkhoiController::class, 'TraLai']);
        Route::post('NhanHoSo', [tnhosodenghikhenthuongthiduacumkhoiController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [tnhosodenghikhenthuongthiduacumkhoiController::class, 'ChuyenHoSo']);
    });

    Route::group(['prefix' => 'XetDuyetThiDua'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'ThongTin']);
        Route::get('DanhSach', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'DanhSach']);
        Route::post('TraLai', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'ChuyenHoSo']);
        Route::post('Xem', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'XemHoSo']);

        Route::get('XetKT', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'GanKhenThuong']);
        ///Route::get('QuyetDinh', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'DuThaoQuyetDinh']);
        //Route::post('QuyetDinh', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'LuuQuyetDinh']);
        //Route::post('PheDuyet', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'LayLyDo']);

        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'LuuToTrinhPheDuyet']);

        Route::get('TrinhKetQua', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongthiduacumkhoiController::class, 'LuuTrinhKetQua']);
    });   

    Route::group(['prefix' => 'PheDuyetThiDua'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'ThongTin']);

        Route::get('PheDuyet', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'LuuPheDuyet']); 
        Route::get('LayTapThe', [dshosodenghikhenthuongthiduacumkhoiController::class, 'LayTapThe']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongthiduacumkhoiController::class, 'LayCaNhan']);       
        Route::post('ThemTapThe', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'ThemCaNhan']);
        // Route::get('QuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'QuyetDinh']);
        // Route::get('TaoDuThao', [qdhosodenghikhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        // Route::post('QuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        // Route::post('GanKhenThuong', [qdhosodenghikhenthuongchuyendeController::class, 'GanKhenThuong']);
        Route::get('InHoSo', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'XemHoSo']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongthiduacumkhoiController::class, 'TraLai']);

    });

    // Route::group(['prefix' => 'KhenThuongHoSoKhenThuong'], function () {
    //     Route::get('ThongTin', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@ThongTin');
    //     Route::post('KhenThuong', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@KhenThuong');
    //     Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@DanhSach');
    //     Route::post('DanhSach', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@LuuKhenThuong');
    //     Route::post('HoSo', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@HoSo');
    //     Route::post('KetQua', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@KetQua');
    //     Route::post('PheDuyet', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@PheDuyet');
    //     Route::get('Xem', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@XemHoSo');
    //     Route::get('LayTieuChuan', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@LayTieuChuan');

    //     Route::get('InKetQua', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@InKetQua');
    //     Route::get('MacDinhQuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@MacDinhQuyetDinh');
    //     Route::get('QuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@QuyetDinh');
    //     Route::post('QuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@LuuQuyetDinh');
    //     Route::get('XemQuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@XemQuyetDinh');

    //     Route::get('Sua', [khenthuonghosokhenthuongcumkhoiController::class, 'Sua']);
    // });
});
Route::group(['prefix' => 'GiaoUocThiDua'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosogiaouocthiduaController::class, 'ThongTin']);
        Route::post('Them', [dshosogiaouocthiduaController::class, 'Them']);
        Route::get('Sua', [dshosogiaouocthiduaController::class, 'ThayDoi']);
        Route::post('Sua', [dshosogiaouocthiduaController::class, 'LuuHoSo']);
        Route::post('Xoa', [dshosogiaouocthiduaController::class, 'XoaHoSo']);
        Route::get('Xem', [dshosogiaouocthiduaController::class, 'XemHoSo']);

        Route::post('TapThe', [dshosogiaouocthiduaController::class, 'ThemTapThe']);
        Route::post('CaNhan', [dshosogiaouocthiduaController::class, 'ThemCaNhan']);
        Route::post('DeTai', [dshosogiaouocthiduaController::class, 'ThemDeTai']);

        Route::get('TapThe', [dshosogiaouocthiduaController::class, 'LayTapThe']);
        Route::get('CaNhan', [dshosogiaouocthiduaController::class, 'LayCaNhan']);
        Route::get('DeTai', [dshosogiaouocthiduaController::class, 'LayDeTai']);

        Route::post('ChuyenHoSo', [dshosogiaouocthiduaController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosogiaouocthiduaController::class, 'LayLyDo']);
        Route::post('XoaDoiTuong', [dshosogiaouocthiduaController::class, 'XoaHoSo']);

        Route::post('NhanExcelTapThe', [dshosogiaouocthiduaController::class, 'NhanExcelTapThe']);
        Route::post('NhanExcelCaNhan', [dshosogiaouocthiduaController::class, 'NhanExcelCaNhan']);
    });
    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosogiaouocthiduaController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosogiaouocthiduaController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosogiaouocthiduaController::class, 'NhanHoSo']);
    });
});
