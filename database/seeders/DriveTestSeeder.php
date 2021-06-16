<?php

namespace Database\Seeders;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\postLaptopDto;
use App\Service\IDriveService;
use App\Service\IProductService;
use Illuminate\Database\Seeder;

class DriveTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected IDriveService $driveService;
    protected IProductService $productService;

    /**
     * DriveTestSeeder constructor.
     * @param IDriveService $driveService
     * @param IProductService $productService
     */
    public function __construct(IDriveService $driveService, IProductService $productService)
    {
        $this->driveService = $driveService;
        $this->productService = $productService;
    }

    public function run()
    {
        $this->genJson();
    }

    private function genJson()
    {
        $json = file_get_contents('drive.json',FILE_USE_INCLUDE_PATH);
        $json_data = json_decode($json, true);
        foreach($json_data as $drive)
        {
            $info = new postInfoDto;
            foreach ($drive['info'] as $key => $val) {
                $info->$key = $val;
            }
            $response = [];
            $response['info'] = $this->productService->create($info);
            $this->driveService->create($drive['spec'], $response['info']->id);
            $this->productService->createImages($drive['image'], $response['info']->id);
        }
    }

    private function genRandom()
    {
        for ($i = 36; $i < 100; $i++) {
            \DB::table('product_infos')->insert(['name' => \Str::random(20), 'description' => 'Example description', 'guarantee' => random_int(12, 24), 'price' => random_int(2000000, 10000000), 'brand_id' => random_int(8, 16), 'type_id' => 2, 'created_at' => date('Y/m/d H:i:s')]);
            \DB::table('drive_specs')->insert([
                'id' => $i,
                'dimension_id' => random_int(1, 5),
                'capacity_id' => random_int(1, 8),
                'connect_id' => random_int(1, 9),
                'type_id' => random_int(1, 4),
                'read_id' => random_int(1, 9),
                'write_id' => random_int(1, 6),
                'rotation_id' => random_int(1, 3),
                'cache_id' => random_int(1, 2),
            ]);
        }
    }
}
