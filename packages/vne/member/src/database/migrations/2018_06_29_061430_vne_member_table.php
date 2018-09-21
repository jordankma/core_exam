<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_member', function (Blueprint $table) {
            $table->increments('member_id');
            $table->string('token')->nullable();
            $table->string('name');
            $table->string('u_name')->nullable();
            $table->string('password')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique()->nullable();


            $table->integer('city_id',false,true)->nullable();
            $table->integer('district_id',false,true)->nullable();
            $table->integer('school_id',false,true)->nullable();
            $table->integer('class_id',false,true)->nullable();
            $table->integer('table_id',false,true)->nullable();
            
            
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            // $table->foreign('city_id')->references('city_id')->on('vne_city');
            // $table->foreign('school_id')->references('school_id')->on('vne_school');
            // $table->foreign('class_id')->references('class_id')->on('vne_classes');
            // $table->foreign('table_id')->references('table_id')->on('vne_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_vne')->dropIfExists('vne_member');
    }
}
