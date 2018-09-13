<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_news', function (Blueprint $table) {
            $table->increments('news_id');
            $table->string('create_by')->comment('email cua nguoi dang tin');
            $table->string('news_cat')->comment('json chua cac chuyen muc')->nullable();
            $table->string('news_tag')->comment('json chua cac tag')->nullable();
            $table->string('news_box')->comment('json chua cac box')->nullable();
            $table->string('title')->comment('tieu de');
            $table->string('title_alias')->comment('alias cua tieu de');
            $table->longText('desc')->comment('doan mo ta ngan tin')->nullable();
            $table->longText('content')->comment('noi dung tin')->nullable();
            $table->longText('image')->comment('anh dai dien tin tuc')->nullable();
            $table->tinyInteger('is_hot')->comment('1: tin hot 2: tin thuong')->default(2);

            $table->tinyInteger('type')->default('1')->nullable()->comment('1: tin text 2: tin anh');
            $table->string('type_page')->comment('news: tin tuc page: trang tinh');

            $table->longText('gallery')->comment('bo suu tap tin anh')->nullable();
            
            $table->integer('priority')->comment('thu tu uu tien cua tin de hien thi')->nullable();
            $table->string('key_word_seo')->comment('json cac tu khoa seo')->nullable();
            $table->string('desc_seo')->comment('mo ta cua seo')->nullable();
            $table->tinyInteger('visible', false, true)->comemt('an hien tin 1:hien 0:an')->default(1);
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_vne')->dropIfExists('vne_news');
    }
}
