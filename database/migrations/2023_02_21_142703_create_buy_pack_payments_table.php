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
        Schema::create('buy_pack_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('payment_method');
            $table->string('order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('cost_per_product');
            $table->integer('products');
            $table->integer('amount');
            $table->string('coupon');
            $table->integer('discount');
            $table->integer('final_amount');
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
        Schema::dropIfExists('buy_pack_payments');
    }
};
