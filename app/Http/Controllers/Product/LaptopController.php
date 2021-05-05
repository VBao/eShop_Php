<?php

namespace App\Http\Controllers\Product;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\detailLaptopDto;
use App\Dto\Laptop\postLaptopDto;
use App\Dto\Laptop\showSpecsDto;
use App\Dto\Laptop\updateLaptopDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShowProductResource;
use App\Models\Product\Image;
use App\Service\ILaptopService;
use App\Service\IProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    protected ILaptopService $laptopService;
    protected IProductService $productService;

    /**
     * LaptopController constructor.
     * @param ILaptopService $laptopService
     * @param IProductService $productService
     */
    public function __construct(ILaptopService $laptopService, IProductService $productService)
    {
        $this->laptopService = $laptopService;
        $this->productService = $productService;
    }

    public function index()
    {
        return $this->productService->getIndex();
    }

    public function show($id)
    {
        $response = new detailLaptopDto();
        $response->info = $this->productService->getById($id);
        $response->specs = $this->laptopService->getSpecs($id);
        $response->image = $this->productService->getImages($id);
        $a = [
            'id' => $response->info->id,
            'info' => [
                'name' => $response->info->name,
                'guarantee' => $response->info->guarantee,
                'price' => $response->info->price,
                'brand' => $response->info->brand,
                'cpu' => $response->specs->cpu,
                'gpu' => $response->specs->gpu,
                'ram' => $response->specs->ram,
                'size' => $response->specs->size,
                'rom' => $response->specs->rom,
                'screen' => $response->specs->screen,
                'port' => $response->specs->port,
                'os' => $response->specs->os,
                'battery' => $response->specs->battery,
                'weight' => $response->specs->weight,
            ],
            'description' => $response->info->description,
            'images' => $response->image
        ];
        return response()->json($a);
    }

    public function getUpdate($id)
    {
        $response = new updateLaptopDto();
        $response->info = $this->productService->getById($id);
        $response->spec = $this->laptopService->getSpecs($id, true);
        $response->specList = $this->laptopService->getForm();
        $response->image = $this->productService->getImages($id);
        $a = [
            'id' => $response->info->id,
            'info' => [
                'name' => $response->info->name,
                'guarantee' => $response->info->guarantee,
                'price' => $response->info->price,
                'brand' => $response->info->brand,
                'cpu' => $response->spec->cpu_id,
                'gpu' => $response->spec->gpu_id,
                'ram' => $response->spec->ram_id,
                'size' => $response->spec->size_id,
                'rom' => $response->spec->rom_id,
                'screen' => $response->spec->screen_id,
                'port' => $response->spec->port_id,
                'os' => $response->spec->os_id,
                'battery' => $response->spec->battery_id,
                'weight' => $response->spec->weight_id,
            ],
            'description' => $response->info->description,
            'images' => $response->image
        ];
        return response()->json($a);
    }

    public function postUpdate(Request $request)
    {
        $res = [];
        $info = new postInfoDto;
        $specs = new postLaptopDto();
        foreach ($request->info as $key => $val) $info->$key = $val;
        $specs->id = $info->id;
        foreach ($request->specs as $key => $val) $specs->$key = $val;
        $res['info'] = $this->info->putInfo($info);
        $res['specs'] = $this->laptop->putLaptop($specs);
        $res['images'] = $this->info->putImage($request->images, $info->id);
        return response()->json(['result' => 'updated']);

    }



    public function getCreate(): JsonResponse
    {
        return response()->json($this->laptopService->getForm());
    }

    public function postCreate(Request $request): JsonResponse
    {
        $res = [];
        $postInfo = new postInfoDto;
        $postLaptop = new postLaptopDto;
        foreach ($request->info as $key => $val) {
            $postInfo->$key = $val;
        }
        $res['info'] = $this->productService->create($postInfo);
        foreach ($request->laptop as $key => $val) $postLaptop->$key = $val;
        $postLaptop->id = $res['info']->id;
        $res['spec'] = $this->laptopService->create($postLaptop);
        $this->productService->createImages($request->image, $postLaptop->id);
        error_log('=================Insert new laptop completed!=================');
        return response()->json(['result' => 'created']);
    }

    public function adminProducts(){
        $res=[];
        foreach($this->productService->getByType(1) as $key => $val) {
            $tempProduct=$this->productService->getById($val->id);
            $tempInfo=[];
            $tempInfo['id']=$tempProduct->id;
            $tempInfo['name']=$tempProduct->id;
            $tempInfo['description']=$tempProduct->id;
            $tempInfo['brand']=$tempProduct->brand;
            foreach($this->laptopService->getSpecsAdmin($val->id) as $key => $value) $tempInfo[$key]=$value;
            $res[]=$tempInfo;
        }
        return $res;

    }
}
