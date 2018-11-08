<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVneEssayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vne_essay', function (Blueprint $table) {
            $table->increments('essay_id');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('path')->nullable();
            $table->string('filename')->nullable();
            $table->string('alias')->nullable();
            $table->string('extension')->nullable();
            $table->string('timestamp')->nullable();
            $table->string('size')->nullable();
            $table->string('dirname')->nullable();
            $table->string('basename')->nullable();
            $table->string('image')->nullable();
            $table->logText('note')->nullable();
            
            $table->integer('point')->nullable();
            $table->integer('is_point')->default(0);

            $table->integer('essay_topic_id',false,true)->nullable();
            $table->integer('member_id',false,true)->nullable();

            $table->foreign('essay_topic_id')->references('essay_topic_id')->on('vne_essay_topic');
            $table->foreign('member_id')->references('member_id')->on('vne_member');
            
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
        Schema::dropIfExists('vne_essay');
    }
}
