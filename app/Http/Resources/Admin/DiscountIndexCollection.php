<?php

namespace App\Http\Resources\Admin;

use App\Models\Product\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountIndexCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'percent' => $this->percent,
            'discount_price' => $this->discount_price,
            'base_price' => $this->product->price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'thumbnail' => Image::where('info_id', '=', $this->product->id)->first()->link_image
        ];
//        return parent::toArray($request);
    }
}
