<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosodenghikhencaoTaptheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosodenghikhencao_tapthe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahoso')->nullable();
            $table->string('maphanloaitapthe')->nullable(); //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
            //Thông tin tập thể            
            $table->string('tentapthe')->nullable();
            $table->string('ghichu')->nullable(); //
            //Kết quả đánh giá
            $table->boolean('ketqua')->default(0); //         
            $table->string('madanhhieukhenthuong')->nullable();//gộp danh hiệu & khen thưởng
            $table->string('lydo')->nullable();
            $table->string('noidungkhenthuong')->nullable(); //in trên phôi bằng khen
            $table->string('madonvi')->nullable(); //phục vụ lấy dữ liệu  
            $table->string('toado_tendoituongin')->nullable();
            $table->string('toado_noidungkhenthuong')->nullable();
            $table->string('toado_quyetdinh')->nullable();
            $table->string('toado_ngayqd')->nullable();
            $table->string('toado_chucvunguoikyqd')->nullable();
            $table->string('toado_hotennguoikyqd')->nullable();
            $table->string('toado_donvikhenthuong')->nullable();
            $table->string('toado_sokhenthuong')->nullable();
            $table->string('tendoituongin')->nullable();
            $table->string('quyetdinh')->nullable();
            $table->string('ngayqd')->nullable();
            $table->string('chucvunguoikyqd')->nullable();
            $table->string('hotennguoikyqd')->nullable();
            $table->string('donvikhenthuong')->nullable();
            $table->string('sokhenthuong')->nullable();	
            $table->string('tencoquan')->nullable();
            $table->string('toado_chucvudoituong')->nullable();
            $table->string('chucvudoituong')->nullable();
            $table->string('toado_pldoituong')->nullable();
            $table->string('pldoituong')->nullable();
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
        Schema::dropIfExists('dshosodenghikhencao_tapthe');
    }
}
