<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = [
            ['id' => 1, 'status' => 'ON_STOCK'],
            ['id' => 2, 'status' => 'OUT_OF_STOCK'],
        ];

        foreach ($statuses as $status) \DB::table('product_status')->insert(['id' => $status['id'], 'status' => $status['status']]);
    }
}
