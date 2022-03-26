<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersAdmin;
use App\Mail\OrderReceive;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Models\ProductDiscount;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mail;

class PurchaseController extends Controller
{

    public function purchase(Request $request): JsonResponse
    {
        $user = Auth::user();
        $info = $request->get('info');
        $order = new Order();
        $order->user_id = $user->id;
        $order->status_id = 1;
        $order->created_at = now();
        $order->name = $info['name'];
        $order->email = $info['email'];
        $order->phone = $info['phone'];
        $order->address = $info['address'];

        $total = 0;
        $products = [];
        $order_request = $request->get('order');
        foreach ($order_request as $order_product) {
            $prop = productInfo::find($order_product['id'])->first();
            $discount = ProductDiscount::query()
                ->where('start_date', '<', date('Y-m-d H:i:s'))
                ->where('end_date', '>', date('Y-m-d H:i:s'))
                ->where('product_id', '=', $prop->id)
                ->first();
            $add_order = new OrderDetail();
            $add_order->product_id = $prop->id;
            $add_order->product_name = $prop->name;
            $add_order->thumbnail = Image::where('info_id', '=', $prop->id)->first()->link_image;
            $add_order->quantity = $order_product['qty'];
            $add_order->price = $discount == null ? $prop->price : $discount->discount_price;
            $total += $add_order->price * $add_order->quantity;
            $products[] = $add_order;
        }
        $order->total = $total;
        $order->save();

        foreach ($products as $product) {
            $product->order_id = $order->id;
            $product->save();
        }

        $mail = [];
        $mail['product'] = $products;
        $mail['total'] = $order->total;
        $mail['orderId'] = $order->id;
        $mail['createAt'] = $order->created_at;
        $mail['userInfo'] = (object)[
            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'address' => $order->address
        ];
        Mail::to($user->email)->send(new OrderReceive($mail));
        return response()->json(['message' => 'order succeed',
//      TODO fix not get data
//                'data' => OrdersAdmin::collection(Order::query()->where('id', $order->id)->first())
            ]
            , 201);
    }

    public function orders(): JsonResponse
    {
        $user = Auth::user();
        $res = OrdersAdmin::collection(Order::query()->where('user_id', $user->id)->get());
        return response()->json(['data' => $res]);
    }

    public function ordersAdmin(): JsonResponse
    {
        return response()->json(['data' => OrdersAdmin::collection(Order::all())]);
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
