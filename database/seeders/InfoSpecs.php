<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoSpecs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands=[
            'Dell',
            'Hp',
            'Lenovo',
            'Acer',
            'Msi',
            'Macbook',
            'Asus',
        ];
        $types=[
            'Laptop',
            'Drive',
            'Monitor',
            'Mouse',
            'Keyboard',
        ];

        foreach ($brands as $brand)DB::table('brands')->insert(['brand'=>$brand]);
        foreach ($types as $type)DB::table('types')->insert(['type'=>$type]);
    }
}
