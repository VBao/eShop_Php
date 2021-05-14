<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriveSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drive_specs', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->foreignId('dimension_id')->references('id')->on('drive_dimensions');
            $table->foreignId('capacity_id')->references('id')->on('drive_capacities');
            $table->foreignId('connect_id')->references('id')->on('drive_connects');
            $table->foreignId('type_id')->references('id')->on('drive_types');
            $table->foreignId('read_id')->references('id')->on('drive_reads');
            $table->foreignId('write_id')->references('id')->on('drive_writes');
            $table->foreignId('rotation_id')->references('id')->on('drive_rotations');
            $table->foreignId('cache_id')->references('id')->on('drive_caches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drive_specs');
    }
}
