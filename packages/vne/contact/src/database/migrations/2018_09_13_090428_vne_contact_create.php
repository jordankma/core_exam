<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneContactCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_contact', function (Blueprint $table) {
            $table->increments('contact_id');
            $table->string("name");
            $table->string("email");
            $table->string("content");

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
        Schema::connection('mysql_vne')->dropIfExists('vne_contact');
    }
}
