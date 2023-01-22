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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik_name');
            $table->string('email')->unique();
            $table->timestampTz('age');
            $table->text('img');
            $table->unsignedBigInteger('country_id');
            $table->string('gender');
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->boolean('block')->default(false);
            $table->timestamps();

            $table->index('country_id', 'user_country_idx');
            $table->foreign('country_id')->on('countries')
                ->references('id');

            $table->index('role_id', 'user_role_idx');
            $table->foreign('role_id')->on('roles')
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
        Schema::dropIfExists('users');
    }
};
