<?php

namespace App\Http\Resources;

use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveRead;
use App\Models\Product\Drive\DriveRotation;
use App\Models\Product\Drive\DriveWrite;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Models\ProductDiscount;
use Illuminate\Http\Resources\Json\JsonResource;

class DriveDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $info = productInfo::find($this->id);
        $discount = ProductDiscount::query()->where('product_id', '=', $this->id)->first();
        if ($discount == null || strtotime($discount->start_time) > now()) $discount = null;
        return [
            'id' => $this->id,
            'info' => ['name' => $info->name,
                'guarantee' => $info->guarantee,
                'price' => $info->price,
                'brand' => Brand::where('id', $info->brand_id)->get(['id', 'brand'])->first()->brand,
                'read' => DriveRead::find($this->read_id)->value,
                'write' => DriveWrite::find($this->write_id)->value,
                'cache' => DriveRead::find($this->cache_id)->value,
                'rotation' => DriveRotation::find($this->rotation_id)->value,
                'type' => DriveRead::find($this->type_id)->value,
                'connect' => DriveRead::find($this->connect_id)->value,
                'capacity' => DriveRead::find($this->capacity_id)->value,
                'dimension' => DriveRead::find($this->dimension_id)->value,],
            'description' => $info->description,
            'images' => ImageResource::collection(Image::where('info_id', $this->id)->get()),
            'discount' => [
                "discount_percent" => $discount == null ? 0 : $discount->percent,
                "discount_price" => $discount == null ? 0 : $discount->discount_price,
                "discount_Start" => $discount == null ? 0 : $discount->start_date,
                "discount_end" => $discount == null ? 0 : $discount->end_date,
            ]
        ];
    }
}
