<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneBannerPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_banner_position', function (Blueprint $table) {
            $table->increments('banner_position_id');
            $table->string("create_by")->nullable();
            $table->string("name");
            $table->string("alias");
            $table->string("width");
            $table->string("height");
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
        Schema::connection('mysql_vne')->dropIfExists('vne_banner_position');
    }
}
