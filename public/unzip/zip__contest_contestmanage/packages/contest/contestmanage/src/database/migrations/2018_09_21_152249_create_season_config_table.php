<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('season_config', function (Blueprint $table) {
            $table->increments('season_config_id');
            $table->string('environment',200);
            $table->unsignedInteger('config_id');
            $table->unsignedInteger('season_id');
            $table->enum('status',['-1','0','1']);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->foreign('config_id')->references('config_id')->on('contest_config');
            $table->foreign('season_id')->references('season_id')->on('contest_season');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_cuocthi')->dropIfExists('season_config');
    }
}
