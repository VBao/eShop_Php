<?php

namespace App\Http\Resources\Discount;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            "product_id"=>$this->product->id,
            "product_name"=>$this->product->name,
            "product_price"=>$this->product->price,
            "percent" => $this->percent,
            "discount_price" => $this->discount_price,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
