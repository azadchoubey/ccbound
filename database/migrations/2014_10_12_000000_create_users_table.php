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
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('referrer')->nullable();
            $table->bigInteger('admin')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('hide_email')->default(false);
            $table->string('number');
            $table->boolean('hide_number')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('number_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->bigInteger('company_id');
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullabe();
            $table->string('city')->nullable();
            $table->string('role')->default('admin');
            $table->boolean('active')->default(true);
            $table->bigInteger('active_chatroom_id')->nullable();
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
        Schema::dropIfExists('users');
    }
};
