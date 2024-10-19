<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NghiepVu\KhenThuongNienHan\dshosodenghikhenthuongnienhanController;
use App\Http\Controllers\NghiepVu\KhenThuongNienHan\qdhosodenghikhenthuongnienhanController;
use App\Http\Controllers\NghiepVu\KhenThuongNienHan\tnhosodenghikhenthuongnienhanController;
use App\Http\Controllers\NghiepVu\KhenThuongNienHan\xdhosodenghikhenthuongnienhanController;
use App\Http\Controllers\NghiepVu\KhenThuongNienHan\dshosokhenthuongnnienhanController;

//Khen thưởng theo công trạng
Route::group(['prefix' => 'KhenThuongNienHan'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongnnienhanController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongnnienhanController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongnnienhanController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongnnienhanController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongnnienhanController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhenthuongnnienhanController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhenthuongnnienhanController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongnnienhanController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongnnienhanController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongnnienhanController::class, 'LayTapThe']);
        
        Route::post('ThemCaNhan', [dshosokhenthuongnnienhanController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongnnienhanController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongnnienhanController::class, 'LayCaNhan']);
        
        Route::post('ThemHoGiaDinh', [dshosokhenthuongnnienhanController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosokhenthuongnnienhanController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosokhenthuongnnienhanController::class, 'LayHoGiaDinh']);

        Route::post('ThemDeTai', [dshosokhenthuongnnienhanController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongnnienhanController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongnnienhanController::class, 'LayDeTai']);

        Route::post('NhanExcel', [dshosokhenthuongnnienhanController::class, 'NhanExcel']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongnnienhanController::class, 'NhanExcelDeTai']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongnnienhanController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongnnienhanController::class, 'NhanExcelTapThe']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongnnienhanController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongnnienhanController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongnnienhanController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosokhenthuongnnienhanController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosokhenthuongnnienhanController::class, 'LayDoiTuong']);
        //29.10.2022
        Route::get('QuyetDinh', [dshosokhenthuongnnienhanController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongnnienhanController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongnnienhanController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongnnienhanController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongnnienhanController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongnnienhanController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongnnienhanController::class, 'InQuyetDinh']);
        // Route::get('InPhoi', [dungchung_nghiepvuController::class, 'InPhoi']);
        // Route::post('NoiDungKhenThuong', [dshosokhenthuongnnienhanController::class, 'NoiDungKhenThuong']);
        // Route::get('InBangKhenCaNhan', [dshosokhenthuongnnienhanController::class, 'InBangKhenCaNhan']);
        // Route::get('InBangKhenTapThe', [dshosokhenthuongnnienhanController::class, 'InBangKhenTapThe']);
        // Route::get('InGiayKhenCaNhan', [dshosokhenthuongnnienhanController::class, 'InGiayKhenCaNhan']);
        // Route::get('InGiayKhenTapThe', [dshosokhenthuongnnienhanController::class, 'InGiayKhenTapThe']);
        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongnnienhanController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongnnienhanController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongnnienhanController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongnnienhanController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongnnienhanController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongnnienhanController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongnienhanController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongnienhanController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongnienhanController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongnienhanController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongnienhanController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongnienhanController::class, 'XoaHoSo']);
        Route::post('ThemTongHop', [dshosodenghikhenthuongnienhanController::class, 'ThemTongHop']);
        Route::post('ThemHoGiaDinh', [dshosodenghikhenthuongnienhanController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosodenghikhenthuongnienhanController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosodenghikhenthuongnienhanController::class, 'LayHoGiaDinh']);
        Route::post('NhanExcel', [dshosodenghikhenthuongnienhanController::class, 'NhanExcel']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongnienhanController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongnienhanController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongnienhanController::class, 'LayTapThe']);
        // Route::post('NhanExcelTapThe', [dshosodenghikhenthuongnienhanController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongnienhanController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongnienhanController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongnienhanController::class, 'LayCaNhan']);
        // Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongnienhanController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosodenghikhenthuongnienhanController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongnienhanController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongnienhanController::class, 'LayDeTai']);
        // Route::post('NhanExcelDeTai', [dshosodenghikhenthuongnienhanController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongnienhanController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosodenghikhenthuongnienhanController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongnienhanController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosodenghikhenthuongnienhanController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosodenghikhenthuongnienhanController::class, 'LayDoiTuong']);
        //29.10.2022
        // 
        // Route::get('QuyetDinh', [dshosodenghikhenthuongnienhanController::class, 'QuyetDinh']);
        // Route::get('TaoDuThao', [dshosodenghikhenthuongnienhanController::class, 'DuThaoQuyetDinh']);
        // Route::post('QuyetDinh', [dshosodenghikhenthuongnienhanController::class, 'LuuQuyetDinh']);
        // Route::get('PheDuyet', [dshosodenghikhenthuongnienhanController::class, 'PheDuyet']);
        // Route::post('PheDuyet', [dshosodenghikhenthuongnienhanController::class, 'LuuPheDuyet']);
        // Route::post('HuyPheDuyet', [dshosodenghikhenthuongnienhanController::class, 'HuyPheDuyet']);       
        // Route::get('InPhoi', [qdhosodenghikhenthuongnienhanController::class, 'InPhoi']);
        // Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongnienhanController::class, 'NoiDungKhenThuong']);
        // Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'InBangKhenCaNhan']);
        // Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongnienhanController::class, 'InBangKhenTapThe']);
        // Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'InGiayKhenCaNhan']);
        // Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongnienhanController::class, 'InGiayKhenTapThe']);
       
        //2023.10.21 xem bỏ đi để chuyển sang dùng chung
        Route::get('ToTrinhHoSo', [dshosodenghikhenthuongnienhanController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosodenghikhenthuongnienhanController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosodenghikhenthuongnienhanController::class, 'InToTrinhHoSo']);
        Route::get('InToTrinhPheDuyet', [xdhosodenghikhenthuongnienhanController::class, 'InToTrinhPheDuyet']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongnienhanController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongnienhanController::class, 'InQuyetDinh']);

        Route::post('ThemTongHop', [dshosodenghikhenthuongnienhanController::class, 'ThemTongHop']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongnienhanController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongnienhanController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongnienhanController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongnienhanController::class, 'ChuyenHoSo']);
        Route::post('TraLaiQuyTrinhTaiKhoan', [xdhosodenghikhenthuongnienhanController::class, 'TraLaiQuyTrinhTaiKhoan']);
        
        /*2023.09.21 Lọc dần các chức năng thừa
        Route::get('XetKT', [xdhosodenghikhenthuongnienhanController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongnienhanController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongnienhanController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongnienhanController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongnienhanController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongnienhanController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongnienhanController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongnienhanController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongnienhanController::class, 'LayLyDo']);
        */

        //09.11.2022
        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongnienhanController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongnienhanController::class, 'LuuToTrinhPheDuyet']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongnienhanController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongnienhanController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongnienhanController::class, 'LuuQuyetDinh']);

        Route::get('TrinhKetQua', [xdhosodenghikhenthuongnienhanController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongnienhanController::class, 'LuuTrinhKetQua']);
    });

    Route::group(['prefix' => 'TiepNhan'], function () {
        Route::get('ThongTin', [tnhosodenghikhenthuongnienhanController::class, 'ThongTin']);
        Route::post('TraLai', [tnhosodenghikhenthuongnienhanController::class, 'TraLai']);
        Route::post('NhanHoSo', [tnhosodenghikhenthuongnienhanController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [tnhosodenghikhenthuongnienhanController::class, 'ChuyenHoSo']);
        
        Route::post('ChuyenChuyenVien', [tnhosodenghikhenthuongnienhanController::class, 'ChuyenChuyenVien']);
        Route::post('XuLyHoSo', [tnhosodenghikhenthuongnienhanController::class, 'XuLyHoSo']);
        Route::post('LayXuLyHoSo', [tnhosodenghikhenthuongnienhanController::class, 'LayXuLyHoSo']);
        Route::get('QuaTrinhXuLyHoSo', [tnhosodenghikhenthuongnienhanController::class, 'QuaTrinhXuLyHoSo']);
        Route::get('DsHoSoThamDinh',[tnhosodenghikhenthuongnienhanController::class,'HoSoThamDinh']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongnienhanController::class, 'ThongTin']);
        Route::post('ThemTapThe', [qdhosodenghikhenthuongnienhanController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongnienhanController::class, 'ThemHoGiaDinh']);

        /*2023.09.21 Lọc dần các chức năng thừa
        Route::post('Them', [qdhosodenghikhenthuongnienhanController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongnienhanController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongnienhanController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosodenghikhenthuongnienhanController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongnienhanController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongnienhanController::class, 'ThemHoGiaDinh']);

        Route::get('XoaTapThe', [qdhosodenghikhenthuongnienhanController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongnienhanController::class, 'NhanExcelTapThe']);
        Route::get('XoaCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosodenghikhenthuongnienhanController::class, 'NhanExcelDeTai']);

        Route::get('InPhoi', [qdhosodenghikhenthuongnienhanController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongnienhanController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongnienhanController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongnienhanController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongnienhanController::class, 'InGiayKhenTapThe']);
        */
        Route::get('PheDuyet', [qdhosodenghikhenthuongnienhanController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongnienhanController::class, 'LuuPheDuyet']);

        Route::get('XetKT', [qdhosodenghikhenthuongnienhanController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosodenghikhenthuongnienhanController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongnienhanController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongnienhanController::class, 'LuuQuyetDinh']);       
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongnienhanController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongnienhanController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongnienhanController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongnienhanController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongnienhanController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosodenghikhenthuongnienhanController::class, 'InBangKhen']);
        Route::post('InGiayKhen', [qdhosodenghikhenthuongnienhanController::class, 'InGiayKhen']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongnienhanController::class, 'XemHoSo']);        
        Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongnienhanController::class, 'InToTrinhPheDuyet']);
    });
});
