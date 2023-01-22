<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');

            $table->index('user_id', 'like_user_idx');
            $table->foreign('user_id', 'like_user_fk')->on('users')
                  ->references('id');

            $table->index('post_id', 'like_post_idx');
            $table->foreign('post_id', 'like_post_fk')->on('posts')
                  ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
