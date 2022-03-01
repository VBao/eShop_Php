<?php

namespace App\Http\Resources\Product;

use App\Models\Product\Brand;
use App\Models\Product\Image;
use App\Models\Product\Laptop\Battery;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\Os;
use App\Models\Product\Laptop\Port;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\Laptop\Screen;
use App\Models\Product\Laptop\Size;
use App\Models\Product\Laptop\Weight;
use Illuminate\Http\Resources\Json\JsonResource;

class adminIndex extends JsonResource
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
        $spec = laptopSpec::find($this->id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->created_at,
            'description' => $this->description,
            'price' => $this->price,
            'image' => Image::query()->where('info_id', '=', $this->id)->first()->link_image,
            'Brand' => Brand::find($this->brand_id)->brand,
            'cpu' => Cpu::find($spec->cpu_id)->value,
            'ram' => Ram::find($spec->ram_id)->value,
            'rom' => Rom::find($spec->rom_id)->value,
            'os' => Os::find($spec->os_id)->value,
            'battery' => Battery::find($spec->battery_id)->value,
            'screen' => Screen::find($spec->screen_id)->value,
            'weight' => Weight::find($spec->weight_id)->value,
            'size' => Size::find($spec->size_id)->value,
            'port' => Port::find($spec->port_id)->value
        ];
    }
}
