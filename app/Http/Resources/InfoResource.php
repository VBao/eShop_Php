<?php

namespace App\Http\Resources;

use App\Models\Product\Brand;
use App\Models\Product\Type;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

//class InfoResource extends ResourceCollection
class InfoResource extends JsonResource
{
    /**
     * @var mixed
     */

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
//            /**
//             * "id": 91,
//             * "name": "y2CD5g4L2gBhHW5kfpab",
//             * "price": 25000000,
//             * "ram": "4 GB",
//             * "rom": "512GB SSD M.2 SATA",
//             * "image": "LINK 1"
//             */
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            "guarantee" => 19,
            "brand" => Brand::where('id',$this->brand_id)->first(['id','brand']),
            "type" => Type::where('id',$this->type_id)->first(),
            "description" => $this->description,
        ];
    }
}
