<?php

namespace App\Http\Resources;

use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class DriveListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $spec=DriveSpecs::find($this->id);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'price'=>$this->price,
            'spec1'=>explode(', ', DriveType::find($spec->type_id)->value, 2)[0],
            'spec2'=>explode(', ', DriveCapacity::find($spec->capacity_id)->value, 2)[0],
            'images'=>Image::where('info_id',$this->id)->get()->first()->link_image,
            'type'=>'drive'
        ];
    }
}
