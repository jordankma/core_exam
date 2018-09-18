<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdtechCoreJsonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_core')->create('adtech_core_json', function (Blueprint $table) {
            $table->increments('json_id');
            $table->string('name');
            $table->string('path');
            $table->integer('domain_id', false, true)->index();
            $table->timestamps();
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
        Schema::connection('mysql_core')->dropIfExists('adtech_core_json');
    }
}
