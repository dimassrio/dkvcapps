<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('video_id');
            $table->integer('user_id');
            $table->text('comments');
            $table->integer('level')->default(1);
            $table->integer('parent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('videos_comments');
    }
}
