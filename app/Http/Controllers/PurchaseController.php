<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrdersAdmin;
use App\Mail\OrderReceive;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Image;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\productInfo;
use App\Models\User;
use Database\Seeders\LaptopSpecs;
use http\Env\Response;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    private function info($id, int $quantity = 1)
    {
        $product = productInfo::find($id);
        if ($product->type_id == 1) {
            $spec = laptopSpec::find($id);
            $res = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price * $quantity,
                'spec1' => Ram::find($spec->ram_id)->value,
                'spec2' => Rom::find($spec->rom_id)->value,
                'images' => Image::where('info_id', $product->id)->first()->link_image,
                'qty' => $quantity,
            ];
        } elseif ($product->type_id == 2) {
            $spec = DriveSpecs::find($id);
            $res = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price * $quantity,
                'spec1' => DriveType::find($spec->type_id)->value,
                'spec2' => DriveCapacity::find($spec->capacity_id)->value,
                'image' => Image::where('info_id', $product->id)->first()->link_image,
                'qty' => $quantity,
            ];
        }
        return $res;
    }

    public function cart_info(Request $request)
    {
        $res = [];
        foreach ($request->id as $item) {
            $res[] = $this->info($item);
        }
        return response()->json($res);
    }

    public function purchase(Request $request)
    {
        $user = \Auth::user();
        $order = new Order();
        $order->user_id = $user->id;
        $order->status_id = 1;
        $order->created_at = now();
        $order->save();
        foreach ($request->order as $item) {
            $cart = new Cart();
            $cart->product_id = $item['id'];
            $cart->quantity = $item['qty'];
            $cart->order_id = $order->id;
            $cart->save();
        }
        $mail=[];
        $products = [];
        $total = 0;
        foreach (Cart::query()->where('order_id', '=', $order->id)->get() as $item) {
            $product = productInfo::find($item->product_id);
            $total += $item->quantity * $product->price;
            $products[] = (object)[
                "name" => $product->name,
                "price" => $product->price,
                "qty" => $item->quantity
            ];
        }
        $mail['product']=$products;
        $mail['total']=$total;
        $mail['userInfo']=(object)[
            'name'=>$user->name,
            'email'=>$user->email,
            'phone'=>$user->phone,
            'address'=>$user->address
        ];
        \Mail::to($user->email)->send(new OrderReceive($mail));

        return response()->json(['notify' => 'order succeed'], 201);
    }

    public function detail($id)
    {
        $res = [];
        foreach (Cart::where('order_id', $id)->get() as $item) {
            $res[] = $this->info($item->product_id, $item->quantity);
        }
        return $res;
    }

    public function orders()
    {
        $res = [];
        $user = \Auth::user();
        foreach (Order::where('user_id', $user->id)->get() as $order) {
            $res[] = [
                'id' => $order->id,
                'status' => OrderStatus::find($order->status_id)->status
            ];
        }
        return response()->json($res);
    }

    public function ordersAdmin()
    {
        return response()->json(OrdersAdmin::collection(Order::all()));
    }

    public function changeStats(int $orderId, string $stat)
    {
        $order=Order::query()->where('id','=',$orderId)->first();
        $stats=OrderStatus::all();
        if ($order->status_id == $stats->where('status','=',$stat)->first()->id) return response()->json(['result' => 'Already changed']);
        $order->status_id=$stats->where('status','=',$stat)->first()->id;
        $order->save();
        return response()->json(['result'=>'Changed'],202);
    }
}
