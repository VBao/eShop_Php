<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrdersAdmin;
use App\Mail\OrderReceive;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mail;

class PurchaseController extends Controller
{

    public function purchase(Request $request): JsonResponse
    {
        $user = Auth::user();
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
        $mail = [];
        $products = [];
        $total = 0;
        foreach (Cart::query()->where('order_id', '=', $order->id)->get() as $item) {
            $product = productInfo::find($item->product_id);
            $total += $item->quantity * $product->price;
            $products[] = (object)[
                "name" => $product->name,
                "price" => $product->price,
                "img"=>Image::query()->where('info_id','=',$product->id)->first()->link_image,
                "qty" => $item->quantity
            ];
        }
        $mail['product'] = $products;
        $mail['total'] = $total;
        $mail['orderId']=$order->id;
        $mail['createAt']=$order->created_at;
        $mail['userInfo'] = (object)[
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address
        ];
        Mail::to($user->email)->send(new OrderReceive($mail));

        return response()->json(['notify' => 'order succeed'], 201);
    }

//    public function detail($id)
//    {
//        $res = [];
//        foreach (Cart::where('order_id', $id)->get() as $item) {
//            $res[] = $this->info($item->product_id, $item->quantity);
//        }
//        return $res;
//    }

    public function orders(): JsonResponse
    {
        $user = Auth::user();
        $res = OrdersAdmin::collection(Order::query()->where('user_id', $user->id)->get());
        return response()->json($res);
    }

    public function ordersAdmin(): JsonResponse
    {
        return response()->json(OrdersAdmin::collection(Order::all()));
    }

    public function changeStats(int $orderId, string $stat): JsonResponse
    {
        $order = Order::query()->where('id', '=', $orderId)->first();
        $stats = OrderStatus::all();
        if ($order->status_id == $stats->where('status', '=', $stat)->first()->id) return response()->json(['result' => 'Already changed']);
        $order->status_id = $stats->where('status', '=', $stat)->first()->id;
        $order->save();
        return response()->json(['result' => 'Changed'], 202);
    }
}
