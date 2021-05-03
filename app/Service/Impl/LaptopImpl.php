<?php
namespace App\Service\Impl;
use App\Dto\Laptop\createLaptopDto;
use App\Dto\Laptop\postLaptopDto;
use App\Models\Product\Laptop\Battery;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\Gpu;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\maxRam;
use App\Models\Product\Laptop\Os;
use App\Models\Product\Laptop\Port;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\Laptop\Screen;
use App\Models\Product\Laptop\Size;
use App\Models\Product\Laptop\Weight;
use App\Service\ILaptopService;
use Database\Seeders\LaptopSpecs;


class LaptopImpl implements ILaptopService{

    protected Ram $ram;
    protected Rom $rom;
    protected Cpu $cpu;
    protected Gpu $gpu;
    protected Size $size;
    protected maxRam $maxRam;
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
     * @param maxRam $maxRam
     * @param Os $os
     * @param Screen $screen
     * @param Weight $weight
     * @param Battery $battery
     * @param Port $port
     * @param laptopSpec $laptop
     */
    public function __construct(Ram $ram, Rom $rom, Cpu $cpu, Gpu $gpu, Size $size, maxRam $maxRam, Os $os, Screen $screen, Weight $weight, Battery $battery, Port $port, laptopSpec $laptop)
    {
        $this->ram = $ram;
        $this->rom = $rom;
        $this->cpu = $cpu;
        $this->gpu = $gpu;
        $this->size = $size;
        $this->maxRam = $maxRam;
        $this->os = $os;
        $this->screen = $screen;
        $this->weight = $weight;
        $this->battery = $battery;
        $this->port = $port;
        $this->laptop = $laptop;
    }


    public function getSpecsIndex(int $id): array
    {
        $res=[];
        $lap=$this->laptop->newQuery()->where('id',$id)->first();
        $res['ram']=$this->ram->where('id',$lap->ram_id)->first()->value;
        $res['rom']=$this->rom->newQuery()->where('id',$lap->rom_id)->first()->value;
        return $res;
    }

    public function getList()
    {

    }

    public function getSpecs(int $lapId)
    {
        // TODO: Implement getSpecs() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function getForm(): createLaptopDto
    {
        $form=new createLaptopDto();
        $form->cpus=$this->cpu->allArr();
        $form->gpus=$this->gpu->allArr();
        $form->max_ram=$this->maxRam->allArr();
        $form->rams=$this->ram->allArr();
        $form->roms=$this->rom->allArr();
        $form->ports=$this->port->allArr();
        $form->screens=$this->screen->allArr();
        $form->sizes=$this->size->allArr();
        $form->weights=$this->weight->allArr();
        $form->batteries=$this->battery->allArr();
        $form->os=$this->os->allArr();
        return $form;
    }

    public function create(postLaptopDto $lap)
    {
        $createLap=new laptopSpec;
        $createLap->id =$lap->id ;
        $createLap->os_id =$lap->os ;
        $createLap->battery_id =$lap->battery ;
        $createLap->weight_id =$lap->weight ;
        $createLap->cpu_id =$lap->cpu ;
        $createLap->screen_id =$lap->screen ;
        $createLap->size_id =$lap->size ;
        $createLap->gpu_id =$lap->gpu ;
        $createLap->ram_id =$lap->ram ;
        $createLap->rom_id =$lap->rom ;
        $createLap->max_ram_id =$lap->maxRam;
        $createLap->port_id =$lap->port;
        $createLap->created_at=date('Y-m-d H:i:s');
        $createLap->save();
        return $createLap;
    }
}
