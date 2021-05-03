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
        $this->call(InfoSpecs::class);
        $this->call(TestValues::class);
        $this->call(Images::class);
        // \App\Models\User::factory(10)->create();
    }
}
