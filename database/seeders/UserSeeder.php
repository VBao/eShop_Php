<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(['name' => 'My name is Admin', 'email' => 'admin@etech.com', 'phone' => $this->phone(), 'address' => \Str::random(30), 'password' => bcrypt('admin123456'), 'is_admin' => true]);
        \DB::table('users')->insert(['name' => 'My name is user', 'email' => 'user@gmail.com', 'phone' => $this->phone(), 'address' => \Str::random(30), 'password' => bcrypt('user123456'), 'is_admin' => false]);
        for ($i = 0; $i < 20; $i++) {
            $temp = \Str::random(20);
            \DB::table('users')->insert(['name' => $temp, 'email' => \Str::random(10) . '@gmail.com', 'phone' => $this->phone(), 'address' => \Str::random(30), 'password' => bcrypt($temp)]);
        }
    }

    public function phone(): string
    {
        $phone = '09';
        for ($i = 1; $i < 9; $i++) $phone = $phone . rand(0, 9);
        return $phone;
    }
}
