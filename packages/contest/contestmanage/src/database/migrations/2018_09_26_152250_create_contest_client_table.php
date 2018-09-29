<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('contest_client', function (Blueprint $table) {
            $table->increments('client_id');
            $table->string('name',200);
            $table->string('environment',200);
            $table->string('resource_path',200);
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->text('config');
            $table->text('description');
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
        Schema::connection('mysql_vne')->dropIfExists('contest_client');
    }
}
