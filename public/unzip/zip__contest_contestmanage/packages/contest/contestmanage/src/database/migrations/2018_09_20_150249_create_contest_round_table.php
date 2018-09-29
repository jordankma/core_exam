<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestRoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cuocthi')->create('contest_round', function (Blueprint $table) {
            $table->increments('round_id');
            $table->string('display_name',200);
            $table->string('round_name',200);
            $table->enum('type',['online','offline']);
            $table->text('description');
            $table->text('rule')->nullable();
            $table->unsignedInteger('order');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->text('end_notify');
            $table->enum('status',['-1','0','1']);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_cuocthi')->dropIfExists('contest_round');
    }
}
