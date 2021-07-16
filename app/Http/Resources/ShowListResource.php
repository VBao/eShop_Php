<?php

namespace App\Http\Resources;

use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Image;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'image' => Image::query()->where('info_id', '=', $this->id)->first()->link_image,
        ];
        if ($this->type_id == 1) {
            $laptop = laptopSpec::find($this->id);
            $result['spec1'] = Ram::find($laptop->ram_id)->value;
            $result['spec2'] = Rom::find($laptop->rom_id)->value;
            $result['type'] = 'laptop';
        } elseif ($this->type_id == 2) {
            $drive = DriveSpecs::find($this->id);
            $result['spec1'] = explode(', ', DriveType::find($drive->type_id)->value, 2)[0];
            $result['spec2'] = explode(', ', DriveCapacity::find($drive->capacity_id)->value, 2)[0];
            $result['type'] = 'drive';
        }
        return $result;
    }

//            'filter' => [
//                'Brand' =>BrandList::collection(Brand::get()),
//                'Cpu' => Filters::collection(Cpu::all()),
//                'Ram' => Filters::collection(Ram::all()),
//                'Rom' => Filters::collection(Rom::all()),
//            ],
}
