<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicRoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('topic_round', function (Blueprint $table) {
            $table->increments('topic_round_id');
            $table->string('display_name',200);
            $table->string('topic_round_name',200);
            $table->text('description');
            $table->text('rule_text');
            $table->unsignedInteger('order');
            $table->unsignedInteger('total_question');
            $table->unsignedInteger('total_point');
            $table->unsignedInteger('total_time_limit');
            $table->unsignedInteger('topic_id');
            $table->boolean('point_minus_no_answer');
            $table->boolean('show_true_answer');
            $table->text('lucky_star');
            $table->enum('status',['-1','0','1']);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
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
        Schema::connection('mysql_cuocthi')->dropIfExists('topic_round');
    }
}
