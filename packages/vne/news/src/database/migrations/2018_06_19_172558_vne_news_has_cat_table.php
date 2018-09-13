<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneNewsHasCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_news_has_cat', function (Blueprint $table) {
            $table->increments('news_has_cat_id');
            $table->integer('news_id', false, true)->index();
            $table->integer('news_cat_id', false, true)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->foreign('news_id')->references('news_id')->on('vne_news');
            $table->foreign('news_cat_id')->references('news_cat_id')->on('vne_news_cat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_vne')->dropIfExists('vne_news_has_cat');
    }
}
