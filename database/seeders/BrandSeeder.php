<?php

namespace Database\Seeders;

use App\Models\Product\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands_lap=[
            'Dell',
            'Hp',
            'Lenovo',
            'Acer',
            'Msi',
            'Macbook',
            'Asus',
        ];

        $brands_drive=[
            "WD",
            "SAMSUNG",
            "KINGSTON",
            "KINGMAX",
            "SANDISK",
            "LACIE",
            "TRANSCEND",
            "CRUCIAL",
            "SEAGATE"
        ];

        foreach ($brands_lap as $brand)DB::table('brands')->insert(['brand'=>$brand,'type_id'=>1]);
        foreach ($brands_drive as $brand)DB::table('brands')->insert(['brand'=>$brand,'type_id'=>2]);
    }
}
