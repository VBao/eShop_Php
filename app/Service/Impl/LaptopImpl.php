<?php

namespace App\Service\Impl;

use App\Dto\Laptop\listSpecsLaptopDto;
use App\Dto\Laptop\detailLaptopDto;
use App\Dto\Laptop\postLaptopDto;
use App\Dto\Laptop\showSpecsDto;
use App\Http\Resources\LaptopIndexResource;
use App\Http\Resources\ListLaptopResource;
use App\Models\Product\Brand;
use App\Models\Product\Laptop\Battery;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\Gpu;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\Os;
use App\Models\Product\Laptop\Port;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\Laptop\Screen;
use App\Models\Product\Laptop\Size;
use App\Models\Product\Laptop\Weight;
use App\Models\Product\productInfo;
use App\Service\ILaptopService;
use Database\Seeders\LaptopSpecs;
use Illuminate\Database\Eloquent\Collection;


class LaptopImpl implements ILaptopService
{

    protected Ram $ram;
    protected Rom $rom;
    protected Cpu $cpu;
    protected Gpu $gpu;
    protected Size $size;
    protected Os $os;
    protected Screen $screen;
    protected Weight $weight;
    protected Battery $battery;
    protected Port $port;
    protected laptopSpec $laptop;

    /**
     * LaptopImpl constructor.
     * @param Ram $ram
     * @param Rom $rom
     * @param Cpu $cpu
     * @param Gpu $gpu
     * @param Size $size
     * @param Os $os
     * @param Screen $screen
     * @param Weight $weight
     * @param Battery $battery
     * @param Port $port
     * @param laptopSpec $laptop
     */
    public function __construct(Ram $ram, Rom $rom, Cpu $cpu, Gpu $gpu, Size $size, Os $os, Screen $screen, Weight $weight, Battery $battery, Port $port, laptopSpec $laptop)
    {
        $this->ram = $ram;
        $this->rom = $rom;
        $this->cpu = $cpu;
        $this->gpu = $gpu;
        $this->size = $size;
        $this->os = $os;
        $this->screen = $screen;
        $this->weight = $weight;
        $this->battery = $battery;
        $this->port = $port;
        $this->laptop = $laptop;
    }


    public function getSpecsIndex(int $id): array
    {
        $res = [];
        $lap = $this->laptop->newQuery()->where('id', $id)->first();
        $res['ram'] = $this->ram->newQuery()->where('id', $lap->ram_id)->first()->value;
        $res['rom'] = $this->rom->newQuery()->where('id', $lap->rom_id)->first()->value;
        return $res;
    }

    public function getList()
    {
        return ListLaptopResource::collection(productInfo::where('type_id', 1)->get());
//        return ListLaptopResource::collection(productInfo::where('type_id', 1)->get());
    }

    public function getSpecs(int $lapId, $update = false)
    {
        $response = new showSpecsDto;
        $lapSpec = $this->laptop->newQuery()->where('id', $lapId)->first();
        if ($update) {
            $response->port_id = $lapSpec->port->id;
            $response->ram_id = $lapSpec->ram->id;
            $response->rom_id = $lapSpec->rom->id;
            $response->screen_id = $lapSpec->screen->id;
            $response->cpu_id = $lapSpec->cpu->id;
            $response->gpu_id = $lapSpec->gpu->id;
            $response->size_id = $lapSpec->size->id;
            $response->weight_id = $lapSpec->weight->id;
            $response->os_id = $lapSpec->os->id;
            $response->battery_id = $lapSpec->battery->id;
        } else {
            $response->port = $lapSpec->port->value;
            $response->ram = $lapSpec->ram->value;
            $response->rom = $lapSpec->rom->value;
            $response->screen = $lapSpec->screen->value;
            $response->cpu = $lapSpec->cpu->value;
            $response->gpu = $lapSpec->gpu->value;
            $response->size = $lapSpec->size->value;
            $response->weight = $lapSpec->weight->value;
            $response->os = $lapSpec->os->value;
            $response->battery = $lapSpec->battery->value;
        }
        return $response;
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function getForm(): listSpecsLaptopDto
    {
        $form = new listSpecsLaptopDto();
        $form->cpus = $this->cpu->allArr();
        $form->gpus = $this->gpu->allArr();
        $form->rams = $this->ram->allArr();
        $form->roms = $this->rom->allArr();
        $form->ports = $this->port->allArr();
        $form->screens = $this->screen->allArr();
        $form->sizes = $this->size->allArr();
        $form->weights = $this->weight->allArr();
        $form->batteries = $this->battery->allArr();
        $form->os = $this->os->allArr();
        $form->brand = Brand::where('type_id', 1)->get(['id', 'brand'])->toArray();
        return $form;
    }

    public function create(postLaptopDto $lap)
    {
        $createLap = new laptopSpec;
        foreach ($lap as $key => $value) {
            $createLap->$key = $value;
        }
        $createLap->created_at = date('Y-m-d H:i:s');
        $createLap->save();
        return $createLap;
    }

    public function putLaptop(postLaptopDto $lap)
    {
        $oldLap = laptopSpec::find($lap->id);
        foreach ($lap as $key => $value) {
            $oldLap->$key = $value;
        }
        $oldLap->save();
        return $oldLap;
    }

    public function getSpecsAdmin(int $id): array
    {
        $res = [];
        $lap = laptopSpec::where('id', 21)->get(['cpu_id', 'ram_id', 'rom_id'])->first();;
        $res['cpu'] = Cpu::where('id', $lap->cpu_id)->first()->value;
        $res['ram'] = $this->ram->newQuery()->where('id', $lap->ram_id)->first()->value;
        $res['rom'] = $this->rom->newQuery()->where('id', $lap->rom_id)->first()->value;
        return $res;
    }

    public function filter(array $filter)
    {
        $list_laptop = new Collection();
        foreach ($filter['brand'] as $brand) {
            foreach
            (productInfo::where('brand_id', $brand)->whereBetween('price', [$filter['min_price'], $filter['max_price']])->get()
             as $info) {
                $laptop_spec = LaptopSpec::find($info->id);
                if (in_array($laptop_spec->ram_id, $filter['ram']) || in_array($laptop_spec->rom_id, $filter))
                    $list_laptop->add($info);
            }
        }
        return ListLaptopResource::collection($list_laptop);
    }

    public function index()
    {
        return LaptopIndexResource::collection(Brand::where('type_id', 1)->get());
    }
}
