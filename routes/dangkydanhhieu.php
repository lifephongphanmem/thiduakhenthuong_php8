<?php

Route::group(['prefix'=>'DangKyDanhHieu'], function(){
    Route::group(['prefix'=>'HoSo'], function(){
        Route::get('ThongTin','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThongTin');
        Route::post('Them','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@Them');
        Route::get('Sua','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThayDoi');
        Route::post('Sua','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@LuuHoSo');        
        Route::get('Xem','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@XemHoSo');
        Route::post('CaNhan','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThemCaNhan');
        Route::post('TapThe','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ThemTapThe');
        
        Route::post('ChuyenHoSo','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@ChuyenHoSo');
        Route::get('LayLyDo','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@LayLyDo');
        Route::post('Xoa', 'NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@XoaHoSo');

        Route::get('LayCaNhan','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@LayCaNhan');
        Route::get('LayTapThe','NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@LayTapThe');
        Route::post('XoaDoiTuong', 'NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@XoaDoiTuong');
        Route::post('NhanExcelTapThe', 'NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@NhanExcelTapThe');
        Route::post('NhanExcelCaNhan', 'NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothiduaController@NhanExcelCaNhan');
    });

    Route::group(['prefix'=>'XetDuyet'], function(){
        Route::get('ThongTin','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@ThongTin');
        Route::post('TraLai','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@TraLai');
        Route::post('NhanHoSo','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@NhanHoSo');
        Route::post('ChuyenHoSo','NghiepVu\DangKyDanhHieu\xdhosodangkyphongtraothiduaController@ChuyenHoSo');
    });
    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@ThongTin');
        Route::post('KhenThuong', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@KhenThuong');
        Route::get('DanhSach', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@DanhSach');
        Route::post('DanhSach', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@LuuHoSo');
        Route::post('PheDuyet', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@PheDuyet');
        Route::post('HoSo', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@HoSo');
        Route::post('KetQua', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@KetQua');
        Route::get('LayDoiTuong', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@LayDoiTuong');
        Route::get('LayTieuChuan', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@LayTieuChuan');

        Route::get('InKetQua', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@InKetQua');
        Route::get('MacDinhQuyetDinh', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@MacDinhQuyetDinh');
        Route::get('QuyetDinh', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@QuyetDinh');
        Route::post('QuyetDinh', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@LuuQuyetDinh');
        Route::get('XemQuyetDinh', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@XemQuyetDinh');

        Route::get('Xem', 'NghiepVu\DangKyDanhHieu\qdhosodangkythiduaController@XemHoSo');
    });
});


