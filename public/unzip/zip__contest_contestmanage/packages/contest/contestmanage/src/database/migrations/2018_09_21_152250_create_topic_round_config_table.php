<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicRoundConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('topic_round_config', function (Blueprint $table) {
            $table->increments('topic_round_config_id');
            $table->string('environment',200);
            $table->unsignedInteger('config_id');
            $table->unsignedInteger('topic_round_id');
            $table->enum('status',['-1','0','1']);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->foreign('config_id')->references('config_id')->on('contest_config');
            $table->foreign('topic_round_id')->references('topic_round_id')->on('topic_round');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_cuocthi')->dropIfExists('topic_round_config');
    }
}
