<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneNewsTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_news_tag', function (Blueprint $table) {
            $table->increments('news_tag_id');
            $table->string('name');
            $table->string('alias');
            $table->tinyInteger('status')->default(1); 
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_vne')->dropIfExists('vne_news_tag');
    }
}
