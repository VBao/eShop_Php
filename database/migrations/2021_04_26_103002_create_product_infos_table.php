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
            $table->foreignId('brand_id')->references('id')->on('brands');
            $table->foreignId('type_id')->references('id')->on('types');
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
