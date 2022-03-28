<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert(['status' => 'AWAIT_FOR_CONFIRMATION']);
        DB::table('order_statuses')->insert(['status' => 'ON_GOING']);
        DB::table('order_statuses')->insert(['status' => 'DELIVERED']);
        DB::table('order_statuses')->insert(['status' => 'CANCELLED']);

        DB::table('payment_methods')->insert(['method' => 'COD']);
        DB::table('payment_methods')->insert(['method' => 'PAYPAL']);
    }
}
