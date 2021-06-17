<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaptopResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'ram' => $this->ram,
            'rom' => $this->rom
        ];
    }
}
