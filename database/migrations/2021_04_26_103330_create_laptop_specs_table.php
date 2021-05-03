<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaptopSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laptop_specs', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->unsigned();
            $table->foreignId('cpu_id')->references('id')->on('laptop_cpus');
            $table->foreignId('gpu_id')->references('id')->on('laptop_gpus');
            $table->foreignId('max_ram_id')->references('id')->on('laptop_max_rams');
            $table->foreignId('ram_id')->references('id')->on('laptop_rams');
            $table->foreignId('rom_id')->references('id')->on('laptop_roms');
            $table->foreignId('os_id')->references('id')->on('laptop_os');
            $table->foreignId('battery_id')->references('id')->on('laptop_batteries');
            $table->foreignId('screen_id')->references('id')->on('laptop_screens');
            $table->foreignId('weight_id')->references('id')->on('laptop_weights');
            $table->foreignId('size_id')->references('id')->on('laptop_sizes');
            $table->foreignId('port_id')->references('id')->on('laptop_ports');
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
        Schema::dropIfExists('laptop_specs');
    }
}
