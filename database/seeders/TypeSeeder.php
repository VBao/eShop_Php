<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = [
            'Laptop',
            'Drive',
            'Monitor',
            'Mouse',
            'Keyboard',
        ];
        foreach ($types as $type) DB::table('types')->insert(['type' => $type]);
    }
}
