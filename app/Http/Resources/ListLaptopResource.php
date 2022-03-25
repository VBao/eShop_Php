<?php

namespace App\Http\Resources;

use App\Models\Product\Image;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\ProductDiscount;
use Illuminate\Http\Resources\Json\JsonResource;

class ListLaptopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $spec = laptopSpec::find($this->id);
        if ($this->discount) {
            $discount = ProductDiscount::query()
                ->where('start_date', '<', date('Y-m-d H:i:s'))
                ->where('end_date', '>', date('Y-m-d H:i:s'))
                ->where('product_id', '=', $this->id)
                ->first();
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'test' => date('Y-m-d H:i:s'),
            'spec1' => explode(', ', Ram::find($spec->ram_id)->value, 2)[0],
            'spec2' => explode(', ', Rom::find($spec->rom_id)->value, 2)[0],
            'image' => Image::where('info_id', $this->id)->get()->first()->link_image,
            'type' => 'laptop',
            "discount_percent" => $this->discount ? $discount->discount_price : 0,
            "discount_price" => $this->discount ? $discount->discount_price : 0
        ];
    }
}
