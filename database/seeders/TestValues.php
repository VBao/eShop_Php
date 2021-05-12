<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestValues extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $infos = ['name' => \Str::random(40), 'description' => 'Example description', 'guarantee' => random_int(12,24), 'price' => 25000000, 'brand_id' => random_int(1, 7), 'type_id' => 1, 'created_at' => date('Y/m/d H:i:s'), 'updated_at' => date('Y/m/d H:i:s')];
//
//        $laps = ['cpu_id' => random_int(1, 28), 'gpu_id' => random_int(1, 14), 'max_ram_id' => random_int(1, 5), 'ram_id' => random_int(1, 24), 'rom_id' => random_int(1, 18), 'os_id' => random_int(1, 5), 'screen_id' => random_int(1, 19), 'battery_id' => random_int(1, 3), 'weight_id' => random_int(1, 27), 'size_id' => random_int(1, 10), 'port_id' => random_int(1, 32)];
        for ($i=1;$i<100;$i++){
            DB::table('product_infos')->insert(['name' => \Str::random(20), 'description' => 'Example description', 'guarantee' => random_int(12,24), 'price' => 25000000, 'brand_id' => random_int(1, 7), 'type_id' => 1, 'created_at' => date('Y/m/d H:i:s'), 'updated_at' => date('Y/m/d H:i:s')]);
            DB::table('laptop_specs')->insert(['id'=>$i,'cpu_id' => random_int(1, 28), 'gpu_id' => random_int(1, 14),'ram_id' => random_int(1, 22), 'rom_id' => random_int(1, 14), 'os_id' => random_int(1, 5), 'screen_id' => random_int(1, 19), 'battery_id' => random_int(1, 3), 'weight_id' => random_int(1, 27), 'size_id' => random_int(1, 10), 'port_id' => random_int(1, 32)]);
        }
    }
}
