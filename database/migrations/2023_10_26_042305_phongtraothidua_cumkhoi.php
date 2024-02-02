<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhongtraothiduaCumkhoi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Hố sơ
        Schema::create('dshosothamgiathiduacumkhoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahoso')->unique();
            $table->string('macumkhoi')->nullable();
            $table->date('ngayhoso')->nullable();
            $table->string('noidung')->nullable();
            $table->string('phanloai')->nullable(); //hồ sơ thi đua; hồ sơ khen thưởng (để sau thống kê)
            $table->string('maloaihinhkt')->nullable(); //lấy từ phong trào nếu là hồ sơ thi đua
            $table->string('maphongtraotd')->nullable(); //tùy theo phân loại
            $table->string('ghichu')->nullable();
            $table->string('sototrinh')->nullable();
            $table->string('chucvunguoiky')->nullable();
            $table->string('nguoikytotrinh')->nullable();
            //Trạng thái đơn vị
            $table->string('madonvi')->nullable(50);
            $table->string('madonvi_nhan')->nullable(50);
            $table->string('lydo')->nullable();
            $table->string('thongtin')->nullable(); //chưa dùng
            $table->string('trangthai')->nullable(20);
            $table->dateTime('thoigian')->nullable();
            //Trạng thái xét duyệt
            $table->string('madonvi_xd')->nullable(50);
            $table->string('madonvi_nhan_xd')->nullable(50);
            $table->string('lydo_xd')->nullable();
            $table->string('thongtin_xd')->nullable(); //chưa dùng
            $table->string('trangthai_xd')->nullable(20);
            $table->dateTime('thoigian_xd')->nullable();
            //Trạng thái khen thưởng
            $table->string('madonvi_kt')->nullable(50);
            $table->string('madonvi_nhan_kt')->nullable(50);
            $table->string('lydo_kt')->nullable();
            $table->string('thongtin_kt')->nullable(); //chưa dùng
            $table->string('trangthai_kt')->nullable(20);
            $table->dateTime('thoigian_kt')->nullable();
            $table->timestamps();
        });

        //Cá nhân
        Schema::create('dshosothamgiathiduacumkhoi_canhan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahoso')->nullable();
            //Thông tin cá nhân
            $table->string('maccvc')->nullable();
            $table->string('socancuoc')->nullable();
            $table->string('tendoituong')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('gioitinh')->nullable();
            $table->string('chucvu')->nullable();
            $table->string('diachi')->nullable();
            $table->string('tencoquan')->nullable();
            $table->string('tenphongban')->nullable();
            $table->string('maphanloaicanbo')->nullable(); //phân loại cán bộ
            //Kết quả đánh giá
            $table->string('madanhhieukhenthuong')->nullable(); //gộp danh hiệu & khen thưởng
            $table->string('madonvi')->nullable(); //phục vụ lấy dữ liệu            
            $table->timestamps();
        });
        //Tập thể
        Schema::create('dshosothamgiathiduacumkhoi_tapthe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahoso')->nullable();
            $table->string('maphanloaitapthe')->nullable(); //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
            //Thông tin tập thể            
            $table->string('tentapthe')->nullable();
            $table->string('ghichu')->nullable(); //
            //Kết quả đánh giá
            $table->boolean('ketqua')->default(0);
            $table->string('madanhhieukhenthuong')->nullable(); //gộp danh hiệu & khen thưởng
            $table->string('lydo')->nullable();
            $table->string('noidungkhenthuong')->nullable(); //in trên phôi bằng khen
            $table->string('madonvi')->nullable(); //phục vụ lấy dữ liệu             
            $table->timestamps();
        });
        //Tài liệu
        Schema::create('dshosothamgiathiduacumkhoi_tailieu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahoso')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('madonvi')->nullable(); //Lưu đơn vị đính kèm (sử lý trường hợp tổng hợp hồ sơ)
            $table->string('tentailieu')->nullable();
            $table->string('noidung')->nullable();
            $table->text('base64')->nullable();
            $table->date('ngaythang')->nullable();
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
        Schema::dropIfExists('dshosothamgiathiduacumkhoi');
        Schema::dropIfExists('dshosothamgiathiduacumkhoi_canhan');
        Schema::dropIfExists('dshosothamgiathiduacumkhoi_tapthe');
        Schema::dropIfExists('dshosothamgiathiduacumkhoi_tailieu');
    }
}
