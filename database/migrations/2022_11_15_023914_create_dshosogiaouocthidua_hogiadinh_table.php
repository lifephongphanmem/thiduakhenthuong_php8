<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosogiaouocthiduaHogiadinhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosogiaouocthidua_hogiadinh', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahosodk')->nullable();
            $table->string('linhvuchoatdong')->nullable();
            $table->string('maphanloaitapthe')->nullable(); //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
            //Thông tin tập thể            
            $table->string('tentapthe')->nullable();
            $table->string('ghichu')->nullable(); //
            //Kết quả đánh giá
            $table->boolean('ketqua')->default(0); //
            $table->string('madanhhieutd')->nullable();//bỏ
            $table->string('mahinhthuckt')->nullable();//bỏ
            $table->string('madanhhieukhenthuong')->nullable();//gộp danh hiệu & khen thưởng
            $table->string('lydo')->nullable();
            $table->string('noidungkhenthuong')->nullable(); //in trên phôi bằng khen
            $table->string('madonvi')->nullable(); //phục vụ lấy dữ liệu
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
        Schema::dropIfExists('dshosogiaouocthidua_hogiadinh');
    }
}
