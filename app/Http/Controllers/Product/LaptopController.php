<?php

namespace App\Http\Controllers\Product;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\detailLaptopDto;
use App\Dto\Laptop\postLaptopDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\LaptopIndexResource;
use App\Http\Resources\ListLaptopResource;
use App\Http\Resources\Product\adminIndex;
use App\Models\Product\Brand;
use App\Models\Product\Image;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\laptopSpec;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\Laptop\Screen;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
use App\Models\ProductDiscount;
use App\Service\ILaptopService;
use App\Service\Impl\ProductImpl;
use App\Service\IProductService;
use App\Service\IValidate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    protected ILaptopService $laptopService;
    protected IProductService $productService;
    protected IValidate $validate;
    protected Brand $brand;
    protected Ram $ram;
    protected Rom $rom;
    protected Cpu $cpu;

    /**
     * LaptopController constructor.
     * @param ILaptopService $laptopService
     * @param IProductService $productService
     * @param Brand $brand
     * @param Ram $ram
     * @param Rom $rom
     * @param Cpu $cpu
     * @param IValidate $validate
     */
    public function __construct(ILaptopService $laptopService, IProductService $productService, Brand $brand, Ram $ram, Rom $rom, Cpu $cpu, IValidate $validate)
    {
        $this->laptopService = $laptopService;
        $this->productService = $productService;
        $this->validate = $validate;
        $this->brand = $brand;
        $this->ram = $ram;
        $this->rom = $rom;
        $this->cpu = $cpu;
    }


    public function index()
    {
        return $this->productService->getIndex();
    }

    public function getFilter(): JsonResponse
    {
        $res = [];
        $filter['id'] = Type::query()->where('type', '=', 'Laptop')->first()->id;
        $filter['value'] = (object)[
            'brands' => Brand::query()->where('type_id', 1)->get(['id', 'brand']),
            'rams' => Ram::all(),
            'screens' => Screen::all(),
            'cpus' => Cpu::all(),
        ];
        $res['filter'] = $filter;
        $res['data'] = LaptopIndexResource::collection(Brand::query()->where('type_id', '=', 1)->get());
        return response()->json($res);
    }

    public function postFilter(Request $request): JsonResponse
    {
        $laptop_brands = [];
        foreach (Brand::where('type_id', '=', 1)->get(['id', 'brand']) as $brand)
            $laptop_brands[] = (object)[
                "id" => $brand->id,
                "value" => $brand->brand,
                "active" => in_array($brand->id, $request->laptop_brands)
            ];
        $filter = (object)[
            'brands' => $laptop_brands,
            'rams' => $this->ramOption($request->laptop_rams),
            'screens' => $this->screenOption($request->laptop_screens),
            'cpus' => $this->cpuOption($request->laptop_cpus)
        ];

        $rawInfo = [];
        if ($request->laptop_brands != null) {
            if ($request->price != null) {
                foreach ($request->laptop_brands as $brand)
                    $rawInfo = array_merge($rawInfo, productInfo::where('brand_id', '=', $brand)
                        ->whereBetween('price', [$request->price[0], $request->price[1]])->get('id')->toArray());
            } else {
                foreach ($request->laptop_brands as $brand) {
                    $rawInfo = array_merge($rawInfo, productInfo::where('brand_id', '=', $brand)->get('id')->toArray());
                }
            }
        } else {
            $rawInfo = ($request->price != null) ?
                productInfo::where('type_id', '=', 1)->whereBetween('price', [$request->price[0], $request->price[1]])->get('id')->toArray() :
                productInfo::where('type_id', '=', 1)->get('id')->toArray();
        }
        $data = [];
        $activeScreen = [];
        foreach ($request->laptop_screens as $item) {
            foreach (Screen::where('value', 'LIKE', "%" . $item . "%")->get('id')->toArray() as $value)
                $activeScreen[] = $value['id'];
        }
        $activeCpu = [];
        foreach ($request->laptop_cpus as $item) {
            foreach (Cpu::where('value', 'LIKE', "%" . $item . "%")->get(['id'])->toArray() as $value)
                $activeCpu[] = $value['id'];
        }
        $activeRam = [];
        foreach ($request->laptop_rams as $item) {
            foreach (Ram::where('value', 'LIKE', "%" . $item . "%")->get(['id'])->toArray() as $value)
                $activeRam[] = $value['id'];
        }
        if ($activeRam != null || $activeCpu != null || $activeScreen != null) {
            if ($activeCpu == null) {
                if ($activeRam == null) {
                    foreach ($rawInfo as $info) {
                        $checkLaptop = laptopSpec::find($info['id']);
                        $a[] = $checkLaptop->ram_id;
                        if (in_array($checkLaptop->screen_id, $activeScreen))
                            $data[] = new ListLaptopResource(productInfo::find($info['id']));
                    }
                } else {
                    if ($activeScreen == null) {
                        foreach ($rawInfo as $info) {
                            $checkLaptop = laptopSpec::find($info['id']);
                            $a[] = $checkLaptop->ram_id;
                            if (in_array($checkLaptop->ram_id, $activeRam))
                                $data[] = new ListLaptopResource(productInfo::find($info['id']));
                        }
                    } else {
                        foreach ($rawInfo as $info) {
                            $checkLaptop = laptopSpec::find($info['id']);
                            $a[] = $checkLaptop->ram_id;
                            if (in_array($checkLaptop->ram_id, $activeRam) && in_array($checkLaptop->screen_id, $activeScreen))
                                $data[] = new ListLaptopResource(productInfo::find($info['id']));
                        }
                    }
                }
            } else {
                if ($activeRam == null) {
                    if ($activeScreen == null) {
                        foreach ($rawInfo as $info) {
                            $checkLaptop = laptopSpec::find($info['id']);
                            $a[] = $checkLaptop->ram_id;
                            if (in_array($checkLaptop->cpu_id, $activeCpu))
                                $data[] = new ListLaptopResource(productInfo::find($info['id']));
                        }
                    } else {
                        foreach ($rawInfo as $info) {
                            $checkLaptop = laptopSpec::find($info['id']);
                            $a[] = $checkLaptop->ram_id;
                            if (in_array($checkLaptop->cpu_id, $activeCpu) && in_array($checkLaptop->screen_id, $activeScreen))
                                $data[] = new ListLaptopResource(productInfo::find($info['id']));
                        }
                    }
                } else {
                    if ($activeScreen == null) {
                        foreach ($rawInfo as $info) {
                            $checkLaptop = laptopSpec::find($info['id']);
                            $a[] = $checkLaptop->ram_id;
                            if (in_array($checkLaptop->ram_id, $activeRam) && in_array($checkLaptop->cpu_id, $activeCpu))
                                $data[] = new ListLaptopResource(productInfo::find($info['id']));
                        }
                    } else {
                        foreach ($rawInfo as $info) {
                            $checkLaptop = laptopSpec::find($info['id']);
                            $a[] = $checkLaptop->ram_id;
                            if (in_array($checkLaptop->ram_id, $activeRam) && in_array($checkLaptop->screen_id, $activeScreen) && in_array($checkLaptop->cpu_id, $activeCpu))
                                $data[] = new ListLaptopResource(productInfo::find($info['id']));
                        }
                    }
                }
            }
        } else {
            foreach ($rawInfo as $info) $data[] = new ListLaptopResource(productInfo::find($info['id']));
        }

        $res = array_slice($data, ($request->page - 1) * 12, 12);

        return response()->json([
            'type' => 'laptop',
            'filter' => $filter,
            'data' => $res,
            'cur_page' => $request->page,
            'max_page' => ceil(count($data) / 12),
        ]);
    }

    private function ramOption($requestRam): array
    {
        $ramLis = [];
        $ramCheck = [];
        $rams = [];
        foreach (Ram::all() as $item) {
            $ram_size = explode(', ', $item->value, 2)[0];
            if (!in_array($ram_size, $ramLis)) {
                $ramLis[] = $ram_size;
            }
        }
        if (!is_null($requestRam)) foreach ($requestRam as $searchRam) {
            $activeRams = Ram::where('value', 'LIKE', "%" . $searchRam . "%")->get(['id']);
            if (!is_null($activeRams)) {
                $ramCheck[] = $searchRam;
                $rams[] = ['value' => $searchRam, 'active' => true];
            }
        }
        foreach (array_diff($ramLis, $ramCheck) as $inactiveRam) {
            $rams[] = ['value' => $inactiveRam, 'active' => false];
        }
        return $rams;
    }

    private function screenOption($requestScreen): array
    {
        $screenList = [];
        $screenCheck = [];
        $screens = [];
        foreach (Screen::all() as $item) {
            $screen_size = explode(', ', $item->value, 2)[0];
            if (!in_array($screen_size, $screenList)) {
                $screenList[] = $screen_size;
            }
        }
        if (!is_null($requestScreen)) foreach ($requestScreen as $searchScreen) {
            $activeScreen = Screen::where('value', 'LIKE', "%" . $searchScreen . "%")->get(['id']);
            if (!is_null($activeScreen)) {
                $screenCheck[] = $searchScreen;
                $screens[] = ['value' => $searchScreen, 'active' => true];
            }
        }
        foreach (array_diff($screenList, $screenCheck) as $inactiveScreen) {
            $screens[] = ['value' => $inactiveScreen, 'active' => false];
        }
        return $screens;
    }

    private function cpuOption($requestCpu): array
    {
        $cpuList = [];
        $cpuCheck = [];
        $cpus = [];
        foreach (Cpu::all() as $item) {
            $cpu_value = explode(', ', $item->value, 2)[0];
            if (!in_array($cpu_value, $cpuList)) {
                $cpuList[] = $cpu_value;
            }
        }
        if (!is_null($requestCpu)) foreach ($requestCpu as $searchCpu) {
            $activeCpu = Cpu::where('value', 'LIKE', "%" . $searchCpu . "%")->get(['id']);
            if (!is_null($activeCpu)) {
                $cpuCheck[] = $searchCpu;
                $cpus[] = ['value' => $searchCpu, 'active' => true];
            }
        }
        foreach (array_diff($cpuList, $cpuCheck) as $inactiveScreen) {
            $cpus[] = ['value' => $inactiveScreen, 'active' => false];
        }
        return $cpus;
    }

    public
    function show($id): JsonResponse
    {
        $response = new detailLaptopDto();
        $response->info = $this->productService->getById($id);
        $response->specs = $this->laptopService->getSpecs($id);

        $response->image = $this->productService->getImages($id);
        $discount = ProductDiscount::query()->where('product_id', '=', $id)->first();
        if ($discount == null || strtotime($discount->start_time) > now()) $discount = null;
        $a = [
            'id' => $response->info->id,
            'info' => [
                'name' => $response->info->name,
                'guarantee' => $response->info->guarantee,
                'price' => $response->info->price,
                'brand' => Brand::where('id', $response->info->brand_id)->first()->brand,
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
            'images' => $response->image,
            'discount' => [
                "discount_percent" => $discount == null ? 0 : $discount->percent,
                "discount_price" => $discount == null ? 0 : $discount->discount_price
            ]
        ];
        return response()->json($a);
    }

    public
    function getUpdate($id): JsonResponse
    {
        $response = [];
        $response['info'] = $this->productService->getById($id);
        $response['spec'] = $this->laptopService->getSpecs($id, true);
//        $response['specList'] = $this->laptopService->getForm();
        $response['image'] = $this->productService->getImages($id);
        $a = [
            'info' => [
                'id' => $response['info']->id,
                'name' => $response['info']->name,
                'guarantee' => $response['info']->guarantee,
                'price' => $response['info']->price,
                'brand_id' => $response['info']->brand_id,
                'type_id' => $response['info']->type_id,
                'description' => $response['info']->description,
            ],
            'spec' => [
                'cpu_id' => $response['spec']->cpu_id,
                'gpu_id' => $response['spec']->gpu_id,
                'ram_id' => $response['spec']->ram_id,
                'size_id' => $response['spec']->size_id,
                'rom_id' => $response['spec']->rom_id,
                'screen_id' => $response['spec']->screen_id,
                'port_id' => $response['spec']->port_id,
                'os_id' => $response['spec']->os_id,
                'battery_id' => $response['spec']->battery_id,
                'weight_id' => $response['spec']->weight_id,
            ],
            'image' => $response['image'],
//            'spec_list' => $response['specList']
        ];
        return response()->json($a);
    }

    public
    function postUpdate(Request $request): JsonResponse
    {
        $err = $this->validate->checkPost($request);
        if (!is_null($err)) return response()->json($err, 422);
        $info = new postInfoDto;
        $specs = new postLaptopDto();
        foreach ($request->info as $key => $val) $info->$key = $val;
        if (isset($info)) {
            $specs->id = $info->id;
        }
        foreach ($request->spec as $key => $val) $specs->$key = $val;
        $this->productService->putInfo($info);
        $this->laptopService->putLaptop($specs);
        $this->productService->putImage($request->images, $info->id);
        return response()->json(['notify' => 'updated'], 202);

    }

    public function getCreate(): JsonResponse
    {
        return response()->json($this->laptopService->getForm());
    }

    public
    function postCreate(Request $request): JsonResponse
    {
        $err = $this->validate->checkPost($request);
        if (!is_null($err)) return response()->json($err, 422);
        if (count(productInfo::where('name', 'LIKE', '%' . $request->info['name'] . '%')->get()->toArray()) != 0) return response()->json(['error' => 'Already have product with name - ' . $request->info['name']], 422);
        if (count($request->image) < 3) return response()->json(['error' => 'Accept at least 3 image'], 400);
        $res = [];
        $postInfo = new postInfoDto;
        $postLaptop = new postLaptopDto;
        foreach ($request->info as $key => $val) {
            $postInfo->$key = $val;
        }
        $res['info'] = $this->productService->create($postInfo);
        foreach ($request->spec as $key => $val) $postLaptop->$key = $val;
        $postLaptop->id = $res['info']->id;
        $this->laptopService->create($postLaptop);
        $this->productService->createImages($request->image, $postLaptop->id);
        error_log('=================Insert new laptop completed!=================');
        return response()->json(['notify' => 'created'], 201);
    }
//
//    public
//    function adminProducts(): array
//    {
//        $res = [];
//        $tempAdd = [];
//        foreach ($this->productService->getByType(1) as $val) {
//            $tempProduct = $this->productService->getById($val->id);
//            $tempInfo = [];
//            $tempInfo['id'] = $tempProduct->id;
//            $tempInfo['name'] = $tempProduct->name;
//            $tempInfo['description'] = $tempProduct->description;
//            $tempInfo['brand'] = Brand::find($tempProduct->brand_id)->brand;
//            $tempInfo['price'] = $tempProduct->price;
//            $tempInfo['image'] = Image::where('info_id', '=', $tempProduct->id)->first()->link_image;
//            foreach ($this->laptopService->getSpecsAdmin($val->id) as $key => $value) $tempInfo[$key] = $value;
//            $tempAdd[] = $tempInfo;
//        }
//
//        $res['data'] = $tempAdd;
//        $res['filter'] = [
//            'Brand' => $this->brand->toArraysReact(1),
//            'Ram' => $this->ram->toArraysReact(),
//            'Rom' => $this->rom->toArraysReact(),
//            'Cpu' => $this->cpu->toArraysReact()
//        ];
//        return $res;
//    }

    public function adminProducts()
    {
        $data = adminIndex::collection(productInfo::where('type_id', '=', '1')->get());
        return response()->json(['result' => $data]);
    }
}
