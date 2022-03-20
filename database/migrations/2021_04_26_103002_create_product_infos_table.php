<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_infos', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name', 100);
            $table->longText('description');
            $table->unsignedSmallInteger('guarantee');
            $table->unsignedBigInteger('price');
            $table->boolean('discount')->default(false);
            $table->foreignId('brand_id')->references('id')->on('brands');
            $table->foreignId('type_id')->references('id')->on('types');
            $table->tinyInteger('status_id')->nullable(false)->unsigned();
            $table->foreign('status_id')->references('id')->on('product_status');
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
        Schema::dropIfExists('product_infos');
    }
}
