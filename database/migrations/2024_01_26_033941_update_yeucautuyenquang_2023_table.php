<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateYeucautuyenquang2023Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Thêm tài khoản tiếp nhận hồ sơ và một trường báo cáo thông tư 03
        Schema::table('dstaikhoan', function (Blueprint $table) {
            $table->string('taikhoantiepnhan')->nullable();//Danh sách tài khoản: tk1;tk2;tk3;...
            $table->date('ngaysinh')->nullable();
            $table->string('trinhdodaotao')->nullable();
            $table->date('ngaycongtac')->nullable();//Thời gian làm công tác để tính thâm niên
            $table->boolean('gioitinh')->default(0);//0: Nam; 1: Nữ            
        });

        //Thêm 02 phân quyền trong xử lý hồ sơ
        Schema::table('dstaikhoan_phanquyen', function (Blueprint $table) {
            $table->boolean('tiepnhan')->default(0);
            $table->boolean('xuly')->default(0);
        });
        //Thêm trạng thái xử lý để lấy thông tin
        Schema::table('dshosothiduakhenthuong', function (Blueprint $table) {
            $table->string('trangthai_xl')->nullable();//Trạng thái xử lý hồ sơ
            $table->string('tendangnhap_xl')->nullable();//Tài khoản đang xử lý hồ sơ
        });
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {
            $table->string('trangthai_xl')->nullable();//Trạng thái xử lý hồ sơ
            $table->string('tendangnhap_xl')->nullable();//Tài khoản đang xử lý hồ sơ
        });
        Schema::table('dshosokhencao', function (Blueprint $table) {
            $table->string('trangthai_xl')->nullable();//Trạng thái xử lý hồ sơ
            $table->string('tendangnhap_xl')->nullable();//Tài khoản đang xử lý hồ sơ
        });
        //Thêm bảng chi tiết xử lý
        //Khen cao
        Schema::create('dshosokhencao_xuly', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosotdkt')->nullable();
            $table->string('trangthai_xl')->nullable();
            $table->string('tendangnhap_xl')->nullable();//Thông tin tài khoản xử lý hồ sơ
            $table->string('tendangnhap_tn')->nullable();//Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
            $table->string('noidung_xl')->nullable();
            $table->date('ngaythang_xl')->nullable();
            $table->string('ghichu')->nullable();
            $table->timestamps();
        });
        //Cụm khối
        Schema::create('dshosotdktcumkhoi_xuly', function (Blueprint $table) {
            $table->string('mahosotdkt')->nullable();
            $table->string('trangthai_xl')->nullable();
            $table->string('tendangnhap_xl')->nullable();//Thông tin tài khoản xử lý hồ sơ
            $table->string('tendangnhap_tn')->nullable();//Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
            $table->string('noidung_xl')->nullable();
            $table->date('ngaythang_xl')->nullable();
            $table->string('ghichu')->nullable();
            $table->timestamps();
        });
         //Thi đua khen thưởng
         Schema::create('dshosothiduakhenthuong_xuly', function (Blueprint $table) {
            $table->string('mahosotdkt')->nullable();
            $table->string('trangthai_xl')->nullable();
            $table->string('tendangnhap_xl')->nullable();//Thông tin tài khoản xử lý hồ sơ
            $table->string('tendangnhap_tn')->nullable();//Thông tin tài khoản tiếp nhận kết quả xử lý hồ sơ
            $table->string('noidung_xl')->nullable();
            $table->date('ngaythang_xl')->nullable();
            $table->string('ghichu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dstaikhoan', function (Blueprint $table) {            
            $table->dropColumn('taikhoantiepnhan');
            $table->dropColumn('ngaysinh');
            $table->dropColumn('trinhdodaotao');
            $table->dropColumn('ngaycongtac');
            $table->dropColumn('gioitinh');
        });

        Schema::table('dstaikhoan_phanquyen', function (Blueprint $table) {            
            $table->dropColumn('tiepnhan');
            $table->dropColumn('xuly');
        });

        Schema::table('dshosothiduakhenthuong', function (Blueprint $table) {            
            $table->dropColumn('trangthai_xl');
            $table->dropColumn('tendangnhap_xl');
        });

        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {            
            $table->dropColumn('trangthai_xl');
            $table->dropColumn('tendangnhap_xl');
        });

        Schema::table('dshosokhencao', function (Blueprint $table) {            
            $table->dropColumn('trangthai_xl');
            $table->dropColumn('tendangnhap_xl');
        });

        Schema::dropIfExists('dshosokhencao_xuly');
        Schema::dropIfExists('dshosotdktcumkhoi_xuly');
        Schema::dropIfExists('dshosothiduakhenthuong_xuly');        
    }
}
