<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuytrinhxulytheotaikhoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->string('opt_quytrinhkhenthuong')->nullable();//DIABAN;TAIKHOAN            
        });
        Schema::table('dstaikhoan', function (Blueprint $table) {
            $table->string('phanloai')->nullable();//TRUONGPHONG;NHANVIEN
            
        });
        Schema::table('dshosothiduakhenthuong', function (Blueprint $table) {
            $table->string('tendangnhap_xd')->nullable();//Thông tin tài khoản xét duyệt xử lý hồ sơ
            $table->string('tendangnhap_kt')->nullable();//Thông tin tài khoản phê duyệt xử lý hồ sơ
            $table->string('noidungxuly_xd')->nullable();//Nôi dung xử lý trong xét duyệt
            $table->string('noidungxuly_kt')->nullable();//Nôi dung xử lý trong phê duyệt            
        });
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {
            $table->string('tendangnhap_xd')->nullable();//Thông tin tài khoản xét duyệt xử lý hồ sơ
            $table->string('tendangnhap_kt')->nullable();//Thông tin tài khoản phê duyệt xử lý hồ sơ
            $table->string('noidungxuly_xd')->nullable();//Nôi dung xử lý trong xét duyệt
            $table->string('noidungxuly_kt')->nullable();//Nôi dung xử lý trong phê duyệt            
        });
        Schema::table('dshosokhencao', function (Blueprint $table) {
            $table->string('tendangnhap_xd')->nullable();//Thông tin tài khoản xét duyệt xử lý hồ sơ
            $table->string('tendangnhap_kt')->nullable();//Thông tin tài khoản phê duyệt xử lý hồ sơ
            $table->string('noidungxuly_xd')->nullable();//Nôi dung xử lý trong xét duyệt
            $table->string('noidungxuly_kt')->nullable();//Nôi dung xử lý trong phê duyệt            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hethongchung', function (Blueprint $table) {            
            $table->dropColumn('opt_quytrinhkhenthuong');
        });
        Schema::table('dstaikhoan', function (Blueprint $table) {            
            $table->dropColumn('phanloai');
        });
        Schema::table('dshosothiduakhenthuong', function (Blueprint $table) {            
            $table->dropColumn('tendangnhap_xd');
            $table->dropColumn('tendangnhap_kt');
            $table->dropColumn('noidungxuly_xd');
            $table->dropColumn('noidungxuly_kt');
        });
        Schema::table('dshosotdktcumkhoi', function (Blueprint $table) {            
            $table->dropColumn('tendangnhap_xd');
            $table->dropColumn('tendangnhap_kt');
            $table->dropColumn('noidungxuly_xd');
            $table->dropColumn('noidungxuly_kt');
        });
        Schema::table('dshosokhencao', function (Blueprint $table) {            
            $table->dropColumn('tendangnhap_xd');
            $table->dropColumn('tendangnhap_kt');
            $table->dropColumn('noidungxuly_xd');
            $table->dropColumn('noidungxuly_kt');
        });
    }
}
