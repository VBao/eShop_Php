<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phone')->nullable(false);
            $table->string('address')->nullable(false);
            $table->text('note')->nullable(true);
            $table->integer('total')->nullable(false);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('status_id')->references('id')->on('order_statuses');
//            $table->foreignId('method_id')->references('id')->on('payment_methods');
//            $table->foreignId('payment_id')->references('id')->on('payment_histories');
//            $table->boolean('is_paid')->default(false);
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
