<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('topic_config', function (Blueprint $table) {
            $table->increments('topic_config_id');
            $table->string('environment',200);
            $table->unsignedInteger('config_id');
            $table->unsignedInteger('topic_id');
            $table->enum('status',['-1','0','1']);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->foreign('config_id')->references('config_id')->on('contest_config');
            $table->foreign('topic_id')->references('topic_id')->on('contest_topic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_vne')->dropIfExists('topic_config');
    }
}
