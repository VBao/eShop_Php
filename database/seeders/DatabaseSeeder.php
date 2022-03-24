<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaptopSpecs::class);
        $this->call(DriveSpecsSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductStatusSeeder::class);
        $this->call(TestValues::class);
        $this->call(UserSeeder::class);
        $this->call(DriveTestSeeder::class);
//        $this->call(Images::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
