<?php

use App\Http\Controllers\API\APIhethongsohoaController;
use App\Http\Controllers\API\APInghiepvuController;
use App\Http\Controllers\API\APIquanlycanboController;
use App\Http\Controllers\API\APIquanlyvanbanController;
use App\Http\Controllers\API\APItdktbonoivuController;
use App\Http\Controllers\API\APIthongtinchungController;
use App\Http\Controllers\API\APIxuatdulieuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('XuatCaNhan', [APIxuatdulieuController::class, 'XuatCaNhan']);
Route::get('XuatTapThe', [APIxuatdulieuController::class, 'XuatTapThe']);

Route::post('token', [APIthongtinchungController::class, 'token']);

//Danh mục chung
Route::group(['prefix' => 'DanhMucChung'], function () {
    Route::post('LoaiHinhKhenThuong', [APIthongtinchungController::class, 'LoaiHinhKhenThuong']);
    Route::post('HinhThucKhenThuong', [APIthongtinchungController::class, 'HinhThucKhenThuong']);
    Route::post('PhanLoaiDoiTuong', [APIthongtinchungController::class, 'PhanLoaiDoiTuong']);
    Route::post('DiaBanHanhChinh',  [APIthongtinchungController::class, 'DiaBanHanhChinh']);
    Route::post('DonViSuDung',  [APIthongtinchungController::class, 'DonViSuDung']);    
    Route::post('LinhVucHoatDong',  [APIthongtinchungController::class, 'LinhVucHoatDong']);

    Route::post('getDanhSachHoSo', [APInghiepvuController::class, 'getDanhSachHoSo']);
    Route::post('getHoSoKhenThuong', [APInghiepvuController::class, 'getHoSoKhenThuong']);
    Route::post('postHoSoKhenThuong', [APInghiepvuController::class, 'postHoSoKhenThuong']);
    Route::post('getKhenThuongCaNhan',  [APInghiepvuController::class, 'getKhenThuongCaNhan']);
    Route::post('postKhenThuongCaNhan', [APInghiepvuController::class, 'postKhenThuongCaNhan']);
});

//Nghiệp vụ chung
Route::group(['prefix' => 'NghiepVu'], function () {
    Route::post('getDanhSachHoSo', [APInghiepvuController::class, 'getDanhSachHoSo']);
    Route::post('getHoSoKhenThuong', [APInghiepvuController::class, 'getHoSoKhenThuong']);
    Route::post('postHoSoKhenThuong', [APInghiepvuController::class, 'postHoSoKhenThuong']);
    Route::post('getKhenThuongCaNhan',  [APInghiepvuController::class, 'getKhenThuongCaNhan']);
    Route::post('postKhenThuongCaNhan', [APInghiepvuController::class, 'postKhenThuongCaNhan']);
});

//Quản lý cán bộ
Route::group(['prefix' => 'QuanLyVanBan'], function () {
    //Xem phần getHoso(lấy hồ sơ từ LGSP) chỉ để 01 route dùng chung cho các trạng thái

    Route::get('getDanhSachHoSo',[APIquanlyvanbanController::class, 'getDanhSachHoSo']);//Lấy từ LGSP
    Route::get('postHoSo',[APIquanlyvanbanController::class, 'postHoSo']);//Gửi hồ sơ lên LGSP
    Route::get('getHoSoDeNghi', [APIquanlyvanbanController::class, 'getHoSoDeNghi']);//Lấy hồ sơ đề nghị
    Route::get('postHoSoDeNghi',[APIquanlyvanbanController::class, 'postHoSoDeNghi']);//Gửi hồ sơ đề nghị
    Route::get('getHoSoXetDuyet', [APIquanlyvanbanController::class, 'getHoSoXetDuyet']);
    Route::get('postHoSoXetDuyet', [APIquanlyvanbanController::class, 'postHoSoXetDuyet']);
    Route::get('getHoSoPheDuyet',[APIquanlyvanbanController::class, 'getHoSoPheDuyet']);
    Route::get('postHoSoPheDuyet', [APIquanlyvanbanController::class, 'postHoSoPheDuyet']);
   //hồ sơ đã có kết quả khen thưởng
    Route::get('getHoSoKhenThuong', [APIquanlyvanbanController::class, 'getHoSoKhenThuong']);//Lấy hồ sơ đã có kết quả khen thưởng
    Route::get('postHoSoKhenThuong', [APIquanlyvanbanController::class, 'postHoSoKhenThuong']);//Gửi hồ sơ khen thưởng lên LGSP
});
//Quản lý cán bộ
Route::group(['prefix' => 'QuanLyCanBo'], function () {
    Route::get('getKhenThuongCaNhan',  [APIquanlycanboController::class, 'getKhenThuongCaNhan']);//Lấy hồ sơ đã có kết quả khen thưởng
    Route::get('postKhenThuongCaNhan', [APIquanlycanboController::class, 'postKhenThuongCaNhan']);//Gửi hồ sơ khen thưởng lên LGSP
});

Route::group(['prefix' => 'HeThongSoHoa'], function () {
    Route::get('getHoSoKhenThuong', [APIhethongsohoaController::class, 'getHoSoKhenThuong']);//Lấy hồ sơ đã có kết quả khen thưởng
    Route::get('postHoSoKhenThuong', [APIhethongsohoaController::class, 'postHoSoKhenThuong']);//Gửi hồ sơ khen thưởng lên LGSP
});

Route::group(['prefix' => 'TDKTBoNV'], function () {
    Route::get('getHoSoKhenThuong', [APItdktbonoivuController::class, 'getHoSoKhenThuong']);//Lấy hồ sơ đã có kết quả khen thưởng
    Route::get('postHoSoKhenThuong', [APItdktbonoivuController::class, 'postHoSoKhenThuong']);//Gửi hồ sơ khen thưởng lên LGSP
});