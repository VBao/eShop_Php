<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersAdmin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray($request): array
    {
        $products = [];
        foreach (OrderDetail::query()->where('order_id', '=', $this->id)->get() as $item) {
            $products[] = (object)[
                "id" => $item->product_id,
                "name" => $item->product_name,
                "image" => $item->thumbnail,
                "price" => $item->price,
                "qty" => $item->quantity
            ];
        }
        $user = User::query()->where('id', '=', $this->user_id)->first();
        return [
            'billId' => $this->id,
            'userId' => $this->user_id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'address' => $user->address,
            'status' => OrderStatus::query()->where('id', '=', $this->status_id)->first()->status,
            'bill' => [
                'billId' => $this->id,
                'totalPrice' => $this->total,
                'timeBuy' => $this->created_at,
                'products' => $products
            ]
        ];
    }
}
