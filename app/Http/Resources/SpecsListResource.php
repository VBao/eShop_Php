<?php

namespace App\Http\Resources;

use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveCache;
use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveConnect;
use App\Models\Product\Drive\DriveDimension;
use App\Models\Product\Drive\DriveRead;
use App\Models\Product\Drive\DriveRotation;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Drive\DriveWrite;
use App\Models\Product\Laptop\Battery;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\Gpu;
use App\Models\Product\Laptop\Os;
use App\Models\Product\Laptop\Port;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\Laptop\Screen;
use App\Models\Product\Laptop\Size;
use App\Models\Product\Laptop\Weight;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecsListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        switch ($this->type) {
            case 'Laptop':
                return [
                    'id'=>$request,
                    'cpus'=>Cpu::all(),
                    'gpus'=>Gpu::all(),
                    'rams'=>Ram::all(),
                    'roms'=>Rom::all(),
                    'ports'=>Port::all(),
                    'screens'=>Screen::all(),
                    'sizes'=>Size::all(),
                    'weights'=>Weight::all(),
                    'batteries'=>Battery::all(),
                    'os'=>Os::all(),
                    'brand'=>Brand::where('type_id',1)->get(['id','brand']),
                ];
            case 'Drive':
                return [
                    'capacities' => DriveCapacity::all(),
                    'caches' => DriveCache::all(),
                    'connections' => DriveConnect::all(),
                    'writes' => DriveWrite::all(),
                    'reads' => DriveRead::all(),
                    'dimensions' => DriveDimension::all(),
                    'rotations' => DriveRotation::all(),
                    'types' => DriveType::all(),
                    'brands' => Brand::query()->where('type_id', 2)->get(['id', 'brand']),
                ];

        }
        return logger('Can\'t get the type!');
    }
}
