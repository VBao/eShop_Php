<?php

namespace App\Service\Impl;

use App\Dto\Laptop\listSpecsLaptopDto;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


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

    public function getList(): AnonymousResourceCollection
    {
        return ListLaptopResource::collection(productInfo::where('type_id', 1)->get());
    }

    public function getSpecs(int $lapId, $update = false): showSpecsDto
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

    public function getForm(): array
    {
        $info = [];
        $info["info"]["brands"] = Brand::where('type_id', 1)->get(['id', 'brand'])->toArray();
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
        $info["spec"] = $form;
        return $info;
    }

    public function create(postLaptopDto $lap): laptopSpec
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
        $lap = laptopSpec::where('id', $id)->get(['cpu_id', 'ram_id', 'rom_id'])->first();
        $res['cpu'] = Cpu::where('id', $lap->cpu_id)->first()->value;
        $res['ram'] = $this->ram->newQuery()->where('id', $lap->ram_id)->first()->value;
        $res['rom'] = $this->rom->newQuery()->where('id', $lap->rom_id)->first()->value;
        return $res;
    }

    public function filter(array $filter): AnonymousResourceCollection
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

    public function index(): AnonymousResourceCollection
    {
        return LaptopIndexResource::collection(Brand::where('type_id', 1)->get());
    }


    public function postFilter(array $brand_id_list, array $ram_id_list, array $screen_id_list, array $cpu_id_list, array $price, string $search = null): array
    {
        if (count($brand_id_list) != 0) {
            if (count($price) != 0) {
                $temp_laptop = count($price) == 1 ?
                    productInfo::where('type_id', '=', 1)->whereIn('brand_id', $brand_id_list)->whereBetween('price', [0, $price[0]]) :
                    productInfo::where('type_id', '=', 1)->whereIn('brand_id', $brand_id_list)->whereBetween('price', [$price[0], $price[1]]);
            } else {
                $temp_laptop = productInfo::where('type_id', '=', 1)->whereIn('brand_id', $brand_id_list);
            }
        } else {
            if (count($price) != 0) {
                $temp_laptop = count($price) == 1 ?
                    productInfo::where('type_id', '=', 1)->whereBetween('price', [0, $price[0]]) :
                    productInfo::where('type_id', '=', 1)->whereBetween('price', [$price[0], $price[0]]);
            } else {
                $temp_laptop = productInfo::where('type_id', '=', 1);
            }
        }

        if ($search != null) {
            $temp_laptop = $temp_laptop->where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $temp_laptop = $temp_laptop->get();
        }
//        $temp_laptop = $temp_laptop->limit(12)->offset(($page - 1) * 12)->get();

        if (count($ram_id_list) != 0 || count($screen_id_list) != 0 || count($cpu_id_list) != 0) {
            if (count($ram_id_list) != 0)
                foreach ($temp_laptop as $i => $value) {
                    $spec = laptopSpec::where('id', '=', $temp_laptop[$i]->id)->first();
                    if (!in_array($spec->ram_id, $ram_id_list)) unset($temp_laptop[$i]);
                }
            if (count($screen_id_list) != 0)
                foreach ($temp_laptop as $i => $value) {
                    $spec = laptopSpec::where('id', '=', $temp_laptop[$i]->id)->first();
                    if (!in_array($spec->screen_id, $screen_id_list)) unset($temp_laptop[$i]);
                }
            if (count($cpu_id_list) != 0)
                foreach ($temp_laptop as $i => $value) {
                    $spec = laptopSpec::where('id', '=', $temp_laptop[$i]->id)->first();
                    if (!in_array($spec->cpu_id, $cpu_id_list)) unset($temp_laptop[$i]);
                }
        }
        $result = [];
        foreach ($temp_laptop as $laptop) {
            $result[] = new ListLaptopResource($laptop);
        }
        return $result;
    }

    public function filterCheck(array $brand_id_list = null, array $ram_id_list = null, array $screen_id_list = null, array $cpu_id_list = null): array
    {
        $brand_list = [];
        $brand = Brand::query()->where('type_id', '=', 1)->get(['id', 'brand']);
        foreach ($brand as $id => $value)
            $brand_list[] = [
                'id' => $value->id,
                'value' => $value->brand,
                'active' => (($brand_id_list != null && count($brand_id_list) != 0) && in_array($value->id, $brand_id_list))
            ];

        $ram = Screen::all();
        foreach ($ram as $id => $value)
            $ram[$id]['active'] = (($ram_id_list != null && count($ram_id_list) != 0) && in_array($value->id, $ram_id_list));

        $screen = Screen::all();
        foreach ($screen as $id => $value)
            $screen[$id]['active'] = (($screen_id_list != null && count($screen_id_list) != 0) && in_array($value->id, $screen_id_list));

        $cpu = Cpu::all();
        foreach ($cpu as $id => $value)
            $cpu[$id]['active'] = (($cpu_id_list != null && count($cpu_id_list) != 0) && in_array($value->id, $cpu_id_list));

        return [
            'brand' => $brand_list,
            'ram' => $ram,
            'screen' => $screen,
            'cpu' => $cpu,
        ];
    }
}
