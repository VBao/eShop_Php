<?php

namespace App\Http\Resources;

use App\Models\Product\productInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->type_id == 1) {
            $type = 'laptop';
            $rs = ListLaptopResource::collection(productInfo::where('brand_id', $this->id)->orderBy('id', 'desc')->limit(4)->get());
        } elseif ($this->type_id == 2) {
            $type = 'drive';
            $rs = DriveListResource::collection(productInfo::where('brand_id', $this->id)->orderBy('id', 'desc')->limit(4)->get());
        }
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'type' => $type,
            'result' => $rs,
        ];
    }
}
