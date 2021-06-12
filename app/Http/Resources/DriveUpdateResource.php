<?php

namespace App\Http\Resources;

use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
use Illuminate\Http\Resources\Json\JsonResource;

class DriveUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
//        return [
//            'info'=>new InfoResource(productInfo::where('id',$request->id)->first()),
////            'spec'=>new SpecUpdateResource(DriveSpecs::where('id',$request)->first()),
////            'images'=>ImageResource::collection(Image::where('info_id',$request)->get()),
//        ];
        return [
            'info'=>new InfoResource(productInfo::where('id',$request->id)->first()),
            'spec'=>new SpecUpdateResource(DriveSpecs::where('id',$request->id)->first()),
            'image'=>ImageResource::collection(Image::where('info_id',$request->id)->get()),
//            'spec_list'=>new SpecsListResource(Type::where('id',2)->first()),
        ];
    }
}
