<?php

namespace App\Http\Resources;

use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Image;
use App\Models\ProductDiscount;
use Illuminate\Http\Resources\Json\JsonResource;

class DriveListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $spec = DriveSpecs::find($this->id);
        $discount = ProductDiscount::query()
            ->where('start_date', '>', date('Y-m-d H:i:s'))
            ->where('end_date', '<', date('Y-m-d H:i:s'))
            ->where('product_id', '=', $this->id)
            ->first();
        if ($discount == null || strtotime($discount->start_time) > now()) $discount = null;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'spec1' => explode(', ', DriveType::find($spec->type_id)->value, 2)[0],
            'spec2' => explode(', ', DriveCapacity::find($spec->capacity_id)->value, 2)[0],
            'images' => Image::where('info_id', $this->id)->get()->first()->link_image,
            'type' => 'drive',
            "discount_percent" => $discount == null ? 0 : $discount->percent,
            "discount_price" => $discount == null ? 0 : $discount->discount_price
        ];
    }
}
