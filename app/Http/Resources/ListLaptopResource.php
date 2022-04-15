<?php

namespace App\Http\Resources;

use App\Models\Product\Image;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\ProductDiscount;
use Carbon\Carbon;
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
        $discounts = ProductDiscount::query()
            ->where('product_id', '=', $this->id)
            ->get();
        $discount = null;
        foreach ($discounts as $discount_temp) {
            if (Carbon::parse($discount_temp->start_date) > now() || Carbon::parse($discount_temp->end_date) < now()) {
                $discount = $discount_temp;
                break;
            }
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
            "discount_percent" => $discount ? $discount->percent : 0,
            "discount_price" => $discount ? $discount->discount_price : 0
        ];
    }
}
