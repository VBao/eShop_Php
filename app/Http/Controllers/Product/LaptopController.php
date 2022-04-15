<?php

namespace App\Http\Controllers\Product;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\detailLaptopDto;
use App\Dto\Laptop\postLaptopDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\adminIndex;
use App\Models\Product\Brand;
use App\Models\Product\Image;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Rom;
use App\Models\Product\productInfo;
use App\Models\ProductDiscount;
use App\Service\ILaptopService;
use App\Service\IProductService;
use App\Service\IValidate;
use Carbon\Carbon;
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

    public function postFilter(Request $request): JsonResponse
    {
        $filter = $this->laptopService->filterCheck($request->get('brand'), $request->get('ram'), $request->get('screen'), $request->get('cpu'));

        $data = $this->laptopService->postFilter($request->get('brand'), $request->get('ram'), $request->get('screen'), $request->get('cpu'), $request->get('price'));
        $data_page = array_slice($data, ($request->get('page') - 1) * 12, 12);
        return response()->json([
            'type' => 'laptop',
            'filter' => $filter,
            'data' => $data_page,
            'cur_page' => $request->get('page'),
            'max_page' => ceil(count($data) / 12),
        ]);
    }

    public function show($id): JsonResponse
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
                "discount_price" => $discount == null ? 0 : $discount->discount_price,
                "discount_start" => $discount == null ? 0 : $discount->start_date,
                "discount_end" => $discount == null ? 0 : $discount->end_date
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
        foreach ($request->get('info') as $key => $val) $info->$key = $val;
        if (isset($info)) {
            $specs->id = $info->id;
        }
        foreach ($request->get('spec') as $key => $val) $specs->$key = $val;
        $this->productService->putInfo($info);
        $this->laptopService->putLaptop($specs);
//        foreach ($request->get('image') as $k => $img) error_log($k . "\t" . $img);
        try {
            $this->productService->putImage($request->get('image'), $info->id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'please recheck image id'], 400);
        }

        return response()->json(['message' => 'updated'], 202);

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
        if (count(productInfo::where('name', 'LIKE', '%' . $request->get('info')['name'] . '%')->get()->toArray()) != 0) return response()->json(['error' => 'Already have product with name - ' . $request->get('info')['name']], 422);
        if (count($request->get('image')) < 3) return response()->json(['error' => 'Accept at least 3 image'], 400);
        if ($request->get('discount') !== null) {
            $validator = \Validator::make($request->get('discount'), [
                'percent' => 'required|integer|min:1|max:100',
                'start_date' => 'required|date|after:now|date_format:Y-m-d H:i',
                'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i'
            ]);
            if ($validator->fails()) return response()->json(['error' => $validator->errors()]);
        }
        $res = [];
        $postInfo = new postInfoDto;
        $postLaptop = new postLaptopDto;
        foreach ($request->get('info') as $key => $val) {
            $postInfo->$key = $val;
        }
        $res['info'] = $this->productService->create($postInfo);
        foreach ($request->get('spec') as $key => $val) $postLaptop->$key = $val;
        $postLaptop->id = $res['info']->id;
        $this->laptopService->create($postLaptop);
        $this->productService->createImages($request->get('image'), $postLaptop->id);
        if ($request->get('discount') !== null) {
            $discount = new ProductDiscount();
            $discount->created_at = now();
            $discount->updated_at = now();
            foreach ($validator->getData() as $key => $value) $discount->$key = $value;
            $discount->product_id = $postLaptop->id;
            $current_price = productInfo::find($postLaptop->id)->price;
            $discount->discount_price = (int)round($current_price - ($current_price * $validator->getData()['percent']) / 100, -3);
            $discount->save();
            return response()->json(['message' => 'success']);
        }
        error_log('================= Insert new laptop completed! =================');
        return response()->json(['message' => 'success'], 201);
    }

//
    public
    function adminProducts(Request $request): JsonResponse
    {
        $page = $request->query('page') == null ? 1 : $request->query('page');
        $count = productInfo::where('type_id', '=', '1')->count();
        $status = $this->productService->getStatus();
        $tempAdd = [];
        foreach ($this->productService->getByType(1) as $val) {
            $tempProduct = $this->productService->getById($val->id);
            $discounts = ProductDiscount::query()
                ->where('product_id', '=', $val->id)
                ->get();
            $discount = null;
            foreach ($discounts as $discount_temp) {
                if (Carbon::parse($discount_temp->start_date) > now() || Carbon::parse($discount_temp->end_date) < now()) {
                    $discount = $discount_temp;
                    break;
                }
            }
            $tempInfo = [];
            $tempInfo['id'] = $tempProduct->id;
            $tempInfo['name'] = $tempProduct->name;
            $tempInfo['description'] = $tempProduct->description;
            $tempInfo['brand'] = Brand::find($tempProduct->brand_id)->brand;
            $tempInfo['price'] = $tempProduct->price;
            $tempInfo['image'] = Image::where('info_id', '=', $tempProduct->id)->first()->link_image;
            $tempInfo["discount_percent"] = $discount ? $discount->percent : 0;
            $tempInfo["discount_price"] = $discount ? $discount->discount_price : 0;
            $tempInfo["discount_start"] = $discount ? $discount->start_date : 0;
            $tempInfo["discount_end"] = $discount ? $discount->end_date : 0;
            foreach ($this->laptopService->getSpecsAdmin($val->id) as $key => $value) $tempInfo[$key] = $value;
            $tempAdd[] = $tempInfo;
        }

        return response()->json([
            'filter' => [
                'Brand' => $this->brand->toArraysReact(1),
                'Ram' => $this->ram->toArraysReact(),
                'Rom' => $this->rom->toArraysReact(),
                'Cpu' => $this->cpu->toArraysReact()],
            'status' => $status,
            'data' => $tempAdd,
            'curr_page' => intval($page),
            'max_page' => ceil($count / 15)]);
    }

//    public function adminProducts(Request $request): JsonResponse
//    {
//        $page = $request->query('page') == null ? 1 : $request->query('page');
//        $count = productInfo::where('type_id', '=', '1')->count();
//        $laps = productInfo::where('type_id', '=', '1')->offset(($page - 1) * 15)->limit(15)->get();
//        $data = adminIndex::collection($laps);
//        $status = $this->productService->getStatus();
//        return response()->json([
//            'status' => $status,
//            'data' => $data,
//            'curr_page' => intval($page),
//            'max_page' => ceil($count / 15)]);
//    }

    private function dtoFromRequest()
    {

    }
}
