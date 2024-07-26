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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->bigInteger('user_id');
            $table->string('product_name');
            $table->string('cas_no');
            $table->string('quantity_required')->nullable();
            $table->string('purity_required')->nullable();
            $table->string('structure')->nullable();
            $table->text('description')->nullable();
            $table->string('docs')->nullable();
            $table->boolean('enquiry_show');
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->date('expiry_date')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->boolean('approved')->default(false);
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('enquiries');
    }
};
