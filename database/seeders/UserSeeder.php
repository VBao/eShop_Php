<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Type\Integer;
use randomNameGenerator;

include 'randomNameGenerator.php';


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private randomNameGenerator $rand;

    /**
     * UserSeeder constructor.
     * @param randomNameGenerator $rand
     */
    public function __construct(randomNameGenerator $rand)
    {
        $this->rand = $rand;
    }

    public function run()
    {
        $gen = $this->rand->generateNames(1000);
        \DB::table('users')->insert(['name' => 'My name is Admin', 'email' => 'admin@etech.com', 'phone' => $this->phone(), 'gender' => rand(0, 1), 'address' => \Str::random(30), 'password' => bcrypt('admin123456'), 'is_admin' => true, 'created_at' => date("Y-m-d H:i:s",random_int(1568546464,1650021664)), 'updated_at' => date("Y-m-d H:i:s",random_int(1568546464,1650021664))]);
        \DB::table('users')->insert(['name' => 'My name is user', 'email' => 'user@gmail.com', 'phone' => $this->phone(), 'gender' => rand(0, 1), 'address' => \Str::random(30), 'password' => bcrypt('user123456'), 'is_admin' => false, 'created_at' => date("Y-m-d H:i:s",random_int(1568546464,1650021664)), 'updated_at' => date("Y-m-d H:i:s",random_int(1568546464,1650021664))]);
//        for ($i = 0; $i < 20; $i++) {
//            $temp = \Str::random(20);
//            \DB::table('users')->insert(['name' => $temp, 'email' => \Str::random(10) . '@gmail.com', 'phone' => $this->phone(), 'address' => \Str::random(30), 'password' => bcrypt($temp)]);
//        }
        foreach ($gen as $name) {
            \DB::table('users')->insert(['name' => $name, 'email' => \Str::random(10) . '@gmail.com', 'phone' => $this->phone(), 'gender' => rand(0, 1), 'address' => \Str::random(30), 'password' => bcrypt($name), 'created_at' => date("Y-m-d H:i:s",random_int(1568546464,1650021664)), 'updated_at' => date("Y-m-d H:i:s",random_int(1568546464,1650021664))]);
        }
    }

    public function phone(): string
    {
        $phone = '09';
        for ($i = 1; $i < 9; $i++) $phone = $phone . rand(0, 9);
        return $phone;
    }
}
