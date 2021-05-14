<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoUpdateResource extends JsonResource
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
            'id' => $request->id,
            "name" => $request->name,
            "guarantee" => $request->guarantee,
            "price" => $request->price,
            "brand_id" => $this->brand_id,
            "type_id" => $request->type_id,
            "description" => $request->description
        ];
    }
}
