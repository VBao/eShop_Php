<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriveIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return ['id' => $this->id,
            'brand' => $this->brand,
            'result' => DriveListResource::collection(productInfo::where('brand_id', $this->id)->orderBy('id', 'desc')->limit(4)->get()),
        ];
    }
}
