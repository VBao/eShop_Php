<?php

namespace Database\Seeders;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\postLaptopDto;
use App\Models\Product\productInfo;
use App\Service\ILaptopService;
use App\Service\IProductService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestValues extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected ILaptopService $laptopService;
    protected IProductService $productService;

    public function __construct(IProductService $productService, ILaptopService $laptopService)
    {
        $this->productService = $productService;
        $this->laptopService = $laptopService;
    }

    public function run()
    {
        $json = file_get_contents('laptop.json', FILE_USE_INCLUDE_PATH);
        $json_data = json_decode($json, true);
        foreach ($json_data as $laptop) {
            $postInfo = new postInfoDto;
            $postLaptop = new postLaptopDto;
            foreach ($laptop['info'] as $key => $val) {
                $postInfo->$key = $val;
            }
            $res['info'] = $this->productService->create($postInfo);
            foreach ($laptop['spec'] as $key => $val) $postLaptop->$key = $val;
            $postLaptop->id = $res['info']->id;
            $this->laptopService->create($postLaptop);
            $this->productService->createImages($laptop['image'], $postLaptop->id);
        }
    }

    private function genRandom()
    {
        for ($i = 1; $i < 50; $i++) {
            DB::table('product_infos')->insert(['name' => \Str::random(20), 'description' => 'Example description', 'guarantee' => random_int(12, 24), 'price' => random_int(20000000, 40000000), 'brand_id' => random_int(1, 7), 'type_id' => 1, 'created_at' => date('Y/m/d H:i:s'), 'updated_at' => date('Y/m/d H:i:s')]);
            DB::table('laptop_specs')->insert(['id' => $i, 'cpu_id' => random_int(1, 28), 'gpu_id' => random_int(1, 14), 'ram_id' => random_int(1, 22), 'rom_id' => random_int(1, 14), 'os_id' => random_int(1, 5), 'screen_id' => random_int(1, 19), 'battery_id' => random_int(1, 3), 'weight_id' => random_int(1, 27), 'size_id' => random_int(1, 10), 'port_id' => random_int(1, 32)]);
        }
    }
}
