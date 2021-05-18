<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\BrandResource;
use App\Models\Product\Brand;
use App\Models\Product\Laptop\Battery;
use Illuminate\Http\Resources\Json\JsonResource;

class AllSpecsResource extends JsonResource
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
                'brand' => BrandResource::collection(Brand::where('type_id', 1)->get()),
                'id' => $request,
                'cpus' => Cpu::all(),
                'gpus' => Gpu::all(),
                'rams' => Ram::all(),
                'roms' => Rom::all(),
                'ports' => Port::all(),
                'screens' => Screen::all(),
                'sizes' => Size::all(),
                'weights' => Weight::all(),
                'batteries' => Battery::all(),
                'os' => Os::all(),
            ];

    }
}
