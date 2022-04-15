<?php

namespace Database\Seeders;

use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Models\User;
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
        for ($i = 1; $i < 10000; $i++) {
            $user = User::where('id', '=', random_int(3, 10))->first();
            \DB::table('orders')->insert([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'note' => 'Ship in the afternoon',
                'status_id' => random_int(1, 4),
                'total' => rand(100000, 50000000),
                'created_at' => \Date::now(),
            ]);
        }

        for ($i = 1; $i < 10000; $i++) {
            $sum = 0;
            for ($j = 0; $j < random_int(1, 5); $j++) {
                $product_id = random_int(1, 100);
                $quantity = random_int(1, 5);
                $prop = productInfo::where('id', '=', $product_id)->first();
                \DB::table('carts')->insert([
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'order_id' => $i,
                ]);
                \DB::table('order_details')->insert([
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'order_id' => $i,
                    'price' => $prop->price,
                    'product_name' => $prop->name,
                    'thumbnail' => Image::where('info_id', '=', $product_id)->first()->link_image,
                ]);
                $sum += $prop->price * $quantity;
            }
            \DB::table('orders')->where('id', '=', $i)->update(['total' => $sum]);
        }


    }
}
