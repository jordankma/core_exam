<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_group', function (Blueprint $table) {
            $table->increments('group_id');
            $table->string('name');
            $table->string('alias');        
            $table->string('desc');        
            $table->string('image')->nullable();        
            $table->longText('members')->nullable();        
            $table->tinyInteger('type', false, true)->comment('1 doan binh thuong 2 doan bau cu')->default(2);
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            $table->string('sync_es')->nullable()->default('pending');
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
        Schema::connection('mysql_vne')->dropIfExists('vne_group');
    }
}
