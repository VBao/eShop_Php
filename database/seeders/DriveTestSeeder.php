<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DriveTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 50; $i < 101; $i++) {
            \DB::table('product_infos')->insert(['name' => \Str::random(20), 'description' => 'Example description', 'guarantee' => random_int(12,24), 'price' => 2500000, 'brand_id' => random_int(8, 16), 'type_id' => 2, 'created_at' => date('Y/m/d H:i:s')]);
            \DB::table('drive_specs')->insert([
                'id'=>$i,
                'dimension_id'=>random_int(1,5),
                'capacity_id'=>random_int(1,8),
                'connect_id'=>random_int(1,9),
                'type_id'=>random_int(1,4),
                'read_id'=>random_int(1,9),
                'write_id'=>random_int(1,6),
                'rotation_id'=>random_int(1,3),
                'cache_id'=>random_int(1,2),
            ]);
        }
    }
}
