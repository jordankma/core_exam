<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VneGroupHasMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_vne')->create('vne_group_has_member', function (Blueprint $table) {
            $table->increments('group_has_member_id');
            $table->integer('group_id',false,true);
            $table->integer('member_id',false,true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('group_id')->references('group_id')->on('vne_group');
            $table->foreign('member_id')->references('member_id')->on('vne_member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_vne')->dropIfExists('vne_group_has_member');
    }
}
