<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneNewsHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_news_has_tag', function (Blueprint $table) {
            $table->increments('news_has_tag_id')->comment('id');
            $table->integer('news_id',false,true);
            $table->integer('news_tag_id',false,true);
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->softDeletes();
            
            $table->foreign('news_id')->references('news_id')->on('vne_news');
            $table->foreign('news_tag_id')->references('news_tag_id')->on('vne_news_tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_vne')->dropIfExists('vne_news_has_tag');
    }
}
