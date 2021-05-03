<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class Images extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 1;
        $id = 1;
        for ($i = 1; $i < 298; $i++) {
            if ($count == 4) {
                $count = 1;
                $id++;
            }
            DB::table('images')->insert([
                'link_image' => 'LINK ' . $count,
                'info_id' => $id
            ]);
            $count++;
        }
    }
}
