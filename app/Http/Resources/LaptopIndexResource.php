<?php

namespace App\Http\Resources;

use App\Models\Product\productInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class LaptopIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'result' => ListLaptopResource::collection(productInfo::where('brand_id', $this->id)->orderBy('id', 'desc')->limit(4)->get())
        ];
    }
}
