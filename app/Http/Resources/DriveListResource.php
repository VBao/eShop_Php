<?php

namespace App\Http\Resources;

use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Image;
use App\Models\ProductDiscount;
use Carbon\Carbon;
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
        $discounts = ProductDiscount::query()
            ->where('product_id', '=', $this->id)
            ->get();
        $discount = null;
        foreach ($discounts as $discount_temp) {
            if (Carbon::parse($discount_temp->start_date) > Carbon::now() || Carbon::parse($discount_temp->end_date) < Carbon::now()) {
                $discount = $discount_temp;
                break;
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'spec1' => explode(', ', DriveType::find($spec->type_id)->value, 2)[0],
            'spec2' => explode(', ', DriveCapacity::find($spec->capacity_id)->value, 2)[0],
            'image' => Image::where('info_id', $this->id)->get()->first()->link_image,
            'type' => 'drive',
            "discount_percent" => $discount != null ? $discount->percent : 0,
            "discount_price" => $discount != null ? $discount->discount_price : 0
        ];
    }
}
