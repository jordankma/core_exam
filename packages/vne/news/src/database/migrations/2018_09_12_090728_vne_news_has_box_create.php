<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneNewsHasBoxCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vne_news_has_box', function (Blueprint $table) {
            $table->increments('news_has_box_id');
            $table->integer('news_id', false, true)->index();
            $table->integer('news_box_id', false, true)->index();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('news_id')->references('news_id')->on('vne_news');
            $table->foreign('news_box_id')->references('news_box_id')->on('vne_news_box');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vne_news_has_box');
    }
}
