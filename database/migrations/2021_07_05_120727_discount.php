<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Discount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discounts',function (Blueprint $table){
            $table->bigInteger('id',true);
            $table->bigInteger('product_id');
            $table->unsignedInteger('percent');
            $table->unsignedBigInteger('discount_price');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreign('product_id')->on('product_infos')->references('id');
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
        Schema::dropIfExists('product_discounts');
    }
}
