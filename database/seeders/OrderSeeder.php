<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 21; $i++) {
            \DB::table('orders')->insert([
                'user_id' => random_int(3, 10),
                'status_id' => random_int(1, 4),
                'created_at' => \Date::now(),
            ]);
        }
        for ($i = 1; $i < 21; $i++) {
            for ($j = 0; $j < random_int(1, 5); $j++)
                \DB::table('carts')->insert([
                    'product_id' => random_int(1, 30),
                    'quantity' => random_int(1, 5),
                    'order_id' => $i,
                ]);
        }

    }
}
