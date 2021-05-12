<?php

namespace App\Http\Resources;

use App\Models\Product\Brand;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShowListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->info->id,
            'name' => $this->info->name,
            'price' => $this->info->price,
            'ram' => $this->spec->ram->value,
            'rom' => $this->spec->rom->value,
            'image' => $this->image->link_image,
            'filter' => [
                'Brand' =>new BrandList(Brand::get()),
//                'Brand' =>BrandList::collection(Brand::get()),
                'Cpu' => Filters::collection(Cpu::all()),
                'Ram' => Filters::collection(Ram::all()),
                'Rom' => Filters::collection(Rom::all()),
            ],
        ];
    }
}
