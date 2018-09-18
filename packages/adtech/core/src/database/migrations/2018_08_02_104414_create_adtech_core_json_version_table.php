<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdtechCoreJsonVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_core')->create('adtech_core_json_version', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('json_id', false, true)->index();
            $table->string('version');
            $table->timestamps();

            $table->foreign('json_id')->references('json_id')->on('adtech_core_json');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_core')->dropIfExists('adtech_core_json_version');
    }
}
