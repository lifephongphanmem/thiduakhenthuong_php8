<?php

use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\qdhosodenghikhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController;


//Khen thưởng theo công trạng
Route::group(['prefix' => 'KhenThuongCongTrang'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('Them', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LuuHoSo');
        Route::get('InHoSo', [dshosokhenthuongcongtrangController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhenthuongcongtrangController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhenthuongcongtrangController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongcongtrangController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongcongtrangController::class, 'LayTapThe']);
        
        Route::post('ThemCaNhan', [dshosokhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongcongtrangController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongcongtrangController::class, 'LayCaNhan']);
        
        Route::post('ThemHoGiaDinh', [dshosokhenthuongcongtrangController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosokhenthuongcongtrangController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosokhenthuongcongtrangController::class, 'LayHoGiaDinh']);

        Route::post('ThemDeTai', [dshosokhenthuongcongtrangController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongcongtrangController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongcongtrangController::class, 'LayDeTai']);

        Route::post('NhanExcel', [dshosokhenthuongcongtrangController::class, 'NhanExcel']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongcongtrangController::class, 'NhanExcelDeTai']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongcongtrangController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongcongtrangController::class, 'NhanExcelTapThe']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongcongtrangController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ChuyenHoSo');
        Route::get('LayLyDo', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayLyDo');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayDoiTuong');
        //29.10.2022
        Route::get('QuyetDinh', [dshosokhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongcongtrangController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongcongtrangController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongcongtrangController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongcongtrangController::class, 'InQuyetDinh']);
        // Route::get('InPhoi', [dungchung_nghiepvuController::class, 'InPhoi']);
        // Route::post('NoiDungKhenThuong', [dshosokhenthuongcongtrangController::class, 'NoiDungKhenThuong']);
        // Route::get('InBangKhenCaNhan', [dshosokhenthuongcongtrangController::class, 'InBangKhenCaNhan']);
        // Route::get('InBangKhenTapThe', [dshosokhenthuongcongtrangController::class, 'InBangKhenTapThe']);
        // Route::get('InGiayKhenCaNhan', [dshosokhenthuongcongtrangController::class, 'InGiayKhenCaNhan']);
        // Route::get('InGiayKhenTapThe', [dshosokhenthuongcongtrangController::class, 'InGiayKhenTapThe']);
        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongcongtrangController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongcongtrangController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongcongtrangController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongcongtrangController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongcongtrangController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongcongtrangController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@ThongTin');
        Route::post('Them', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LuuHoSo');
        Route::get('InHoSo', [dshosodenghikhenthuongcongtrangController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongcongtrangController::class, 'XoaHoSo']);

        Route::post('ThemTongHop', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@ThemTongHop');

        Route::post('ThemHoGiaDinh', [dshosodenghikhenthuongcongtrangController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosodenghikhenthuongcongtrangController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosodenghikhenthuongcongtrangController::class, 'LayHoGiaDinh']);
        Route::post('NhanExcel', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcel']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongcongtrangController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongcongtrangController::class, 'LayTapThe']);
        // Route::post('NhanExcelTapThe', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'LayCaNhan']);
        // Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosodenghikhenthuongcongtrangController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongcongtrangController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongcongtrangController::class, 'LayDeTai']);
        // Route::post('NhanExcelDeTai', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongcongtrangController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@ChuyenHoSo');
        Route::get('LayLyDo', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LayLyDo');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LayTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LayDoiTuong');
        //29.10.2022
        // 
        // Route::get('QuyetDinh', [dshosodenghikhenthuongcongtrangController::class, 'QuyetDinh']);
        // Route::get('TaoDuThao', [dshosodenghikhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        // Route::post('QuyetDinh', [dshosodenghikhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        // Route::get('PheDuyet', [dshosodenghikhenthuongcongtrangController::class, 'PheDuyet']);
        // Route::post('PheDuyet', [dshosodenghikhenthuongcongtrangController::class, 'LuuPheDuyet']);
        // Route::post('HuyPheDuyet', [dshosodenghikhenthuongcongtrangController::class, 'HuyPheDuyet']);       
        // Route::get('InPhoi', [qdhosodenghikhenthuongcongtrangController::class, 'InPhoi']);
        // Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongcongtrangController::class, 'NoiDungKhenThuong']);
        // Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenCaNhan']);
        // Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenTapThe']);
        // Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenCaNhan']);
        // Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenTapThe']);
       
        //2023.10.21 xem bỏ đi để chuyển sang dùng chung
        Route::get('ToTrinhHoSo', [dshosodenghikhenthuongcongtrangController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosodenghikhenthuongcongtrangController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosodenghikhenthuongcongtrangController::class, 'InToTrinhHoSo']);
        Route::get('InToTrinhPheDuyet', [xdhosodenghikhenthuongcongtrangController::class, 'InToTrinhPheDuyet']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongcongtrangController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'InQuyetDinh']);

        Route::post('ThemTongHop', [dshosodenghikhenthuongcongtrangController::class, 'ThemTongHop']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('TraLai', 'NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController@ChuyenHoSo');

        Route::post('TraLaiQuyTrinhTaiKhoan', 'NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController@TraLaiQuyTrinhTaiKhoan');
        
        /*2023.09.21 Lọc dần các chức năng thừa
        Route::get('XetKT', [xdhosodenghikhenthuongcongtrangController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongcongtrangController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongcongtrangController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongcongtrangController::class, 'LayLyDo']);
        */

        //09.11.2022
        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongcongtrangController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongcongtrangController::class, 'LuuToTrinhPheDuyet']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongcongtrangController::class, 'LuuQuyetDinh']);

        Route::get('TrinhKetQua', [xdhosodenghikhenthuongcongtrangController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongcongtrangController::class, 'LuuTrinhKetQua']);
    });

    Route::group(['prefix' => 'TiepNhan'], function () {
        Route::get('ThongTin', [tnhosodenghikhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('TraLai', 'NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController@ChuyenHoSo');
        
        Route::post('ChuyenChuyenVien', 'NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController@ChuyenChuyenVien');
        Route::post('XuLyHoSo', 'NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController@XuLyHoSo');
        Route::post('LayXuLyHoSo', 'NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController@LayXuLyHoSo');
        Route::get('QuaTrinhXuLyHoSo', 'NghiepVu\KhenThuongCongTrang\tnhosodenghikhenthuongcongtrangController@QuaTrinhXuLyHoSo');
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('ThemTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongcongtrangController::class, 'ThemHoGiaDinh']);

        /*2023.09.21 Lọc dần các chức năng thừa
        Route::post('Them', [qdhosodenghikhenthuongcongtrangController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongcongtrangController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongcongtrangController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosodenghikhenthuongcongtrangController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongcongtrangController::class, 'ThemHoGiaDinh']);

        Route::get('XoaTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'NhanExcelTapThe']);
        Route::get('XoaCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosodenghikhenthuongcongtrangController::class, 'NhanExcelDeTai']);

        Route::get('InPhoi', [qdhosodenghikhenthuongcongtrangController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongcongtrangController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenTapThe']);
        */
        Route::get('PheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'LuuPheDuyet']);

        Route::get('XetKT', [qdhosodenghikhenthuongcongtrangController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'LuuQuyetDinh']);       
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongcongtrangController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongcongtrangController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongcongtrangController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhen']);
        Route::post('InGiayKhen', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhen']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongcongtrangController::class, 'XemHoSo']);        
        Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'InToTrinhPheDuyet']);
    });
});
