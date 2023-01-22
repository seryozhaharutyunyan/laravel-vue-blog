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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->text('content');
            $table->integer('reviews_count')->default(0);

            $table->timestamps();

            $table->index('user_id', 'post_user_idx');
            $table->foreign('user_id')->on('users')
                  ->references('id');

            $table->index('category_id', 'post_category_idx');
            $table->foreign('category_id')->on('categories')
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
        Schema::dropIfExists('posts');
    }
};
