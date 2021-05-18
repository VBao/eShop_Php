<?php


namespace App\Service;


use App\Http\Resources\Product\BrandResource;
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

class SpecList
{
    public function laptop()
    {
        $arBrand = [];
        foreach (Brand::query()->where('type_id', 1)->get(['id', 'brand']) as $val) {
            $arBrand[] = (object)[
                'id' => $val->id,
                'value' => $val->brand
            ];
        }
        return [
            'brands' => $arBrand,
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

    public function drive()
    {$arBrand = [];
        foreach (Brand::query()->where('type_id', 2)->get(['id', 'brand']) as $val) {
            $arBrand[] = (object)[
                'id' => $val->id,
                'value' => $val->brand
            ];
        }
        return [
            'capacities' => DriveCapacity::all(),
            'caches' => DriveCache::all(),
            'connections' => DriveConnect::all(),
            'writes' => DriveWrite::all(),
            'reads' => DriveRead::all(),
            'dimensions' => DriveDimension::all(),
            'rotations' => DriveRotation::all(),
            'types' => DriveType::all(),
            'brands' => $arBrand,
        ];
    }
}
