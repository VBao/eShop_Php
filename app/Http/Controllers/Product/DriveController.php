<?php

namespace App\Http\Controllers\Product;

use App\Dto\Info\postInfoDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriveUpdateResource;
use App\Http\Resources\FilterResource;
use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Models\ProductDiscount;
use App\Service\IDriveService;
use App\Service\IProductService;
use App\Service\IValidate;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriveController extends Controller
{
    protected IDriveService $driveService;
    protected IValidate $validate;
    protected IProductService $productService;
    protected Brand $brand;

    /**
     * DriveController constructor.
     * @param IDriveService $driveService
     * @param IProductService $productService
     * @param Brand $brand
     * @param IValidate $validate
     */
    public function __construct(IDriveService $driveService, IProductService $productService, Brand $brand, IValidate $validate)
    {
        $this->driveService = $driveService;
        $this->productService = $productService;
        $this->validate = $validate;
        $this->brand = $brand;
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->driveService->list());

    }

    public function postFilter(Request $request): JsonResponse
    {
        $filter = $this->driveService->filterCheck($request->get('brand'), $request->get('capacity'), $request->get('drive_type'));
        $data = $this->driveService->postFilter($request->get('brand'), $request->get('capacity'), $request->get('drive_type'), $request->get('price'));
        $data_page = array_slice($data, ($request->get('page') - 1) * 12, 12);
        return response()->json([
            'filter' => $filter,
            'data' => $data_page,
            'cur_page' => $request->get('page'),
            'max_page' => ceil(count($data) / 12),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function getCreate(): JsonResponse
    {
        return response()->json($this->driveService->getForm());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postCreate(Request $request): JsonResponse
    {
        $err = $this->validate->checkPost($request);
        if (!is_null($err)) return response()->json($err, 422);
        if (count(productInfo::where('name', 'LIKE', '%' . $request->get('info')['name'] . '%')->get()->toArray()) != 0) return response()->json(['error' => 'Already have product with name - ' . $request->get('info')['name']], 400);
        if (count($request->get('image')) < 3) return response()->json(['error' => 'Accept at least 3 image'], 400);
        if ($request->get('discount') !== null) {
            $validator = \Validator::make($request->get('discount'), [
                'percent' => 'required|integer|min:1|max:100',
                'start_date' => 'required|date|after:now|date_format:Y-m-d H:i',
                'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i'
            ]);
            if ($validator->fails()) return response()->json(['error' => $validator->errors()]);
        }
        $info = new postInfoDto;
        foreach ($request->get('info') as $key => $val) {
            $info->$key = $val;
        }
        $response = [];
        $response['info'] = $this->productService->create($info);
        $this->driveService->create($request->get('spec'), $response['info']->id);
        $this->productService->createImages($request->get('image'), $response['info']->id);
        if ($request->get('discount') !== null) {
            $discount = new ProductDiscount();
            $discount->created_at = now();
            $discount->updated_at = now();
            foreach ($validator->getData() as $key => $value) $discount->$key = $value;
            $discount->product_id = $response['info']->id;
            $current_price = productInfo::find($response['info']->id)->price;
            $discount->discount_price = (int)round($current_price - ($current_price * $validator->getData()['percent']) / 100, -3);
            $discount->save();
        }
        return response()->json(['message' => 'success'], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->driveService->get($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getUpdate(int $id): JsonResponse
    {
        return response()->json(new DriveUpdateResource($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postUpdate(Request $request): JsonResponse
    {
        $err = $this->validate->checkPost($request);
        if (!is_null($err)) return response()->json($err, 422);
        $info = new postInfoDto;
        foreach ($request->get('info') as $key => $val) {
            $info->$key = $val;
        }
        $response = [];
        $response['info'] = $this->productService->putInfo($info);
        $drive = DriveSpecs::find($response['info']->id);
        foreach ($request->get('spec') as $key => $value) {
            if ($key == 'drive_type_id') {
                $drive->type_id = $value;
            } else {
                $drive->$key = $value;
            }
        }
        $drive->save();
        $this->productService->putImage($request->get('image'), $response['info']->id);
        return response()->json(['message' => 'updated'], 202);

    }

    public function adminProducts(Request $request): array
    {
        $res = [];
        $tempAdd = [];
        $page = $request->query('page') == null ? 1 : $request->query('page');
        foreach ($this->productService->getByType(2) as $val) {
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
            $tempInfo['created_at'] = $tempProduct->created_at;
            $tempInfo['updated_at'] = $tempProduct->updated_at;
            $tempInfo['description'] = $tempProduct->description;
            $tempInfo['brand'] = Brand::find($tempProduct->brand_id)->brand;
            $tempInfo['price'] = $tempProduct->price;
            $tempInfo["discount_percent"] = $discount ? $discount->discount_price : 0;
            $tempInfo["discount_price"] = $discount ? $discount->discount_price : 0;
            $tempInfo['image'] = Image::where('info_id', '=', $tempProduct->id)->first()->link_image;
            foreach ($this->driveService->getSpecsAdmin($val->id) as $key1 => $value) $tempInfo[$key1] = $value;
            $tempAdd[] = $tempInfo;
        }
        $res['data'] = array_slice($tempAdd, ($page - 1) * 15, 15);
        $res['filter'] = [
            'Brand' => $this->brand->toArraysReact(2),
            'type' => FilterResource::collection(DriveType::all()),
            'capacity' => FilterResource::collection(DriveCapacity::all()),];
        $res['curr_page'] = intval($page);
        $res['max_page'] = ceil(count($tempAdd) / 15);
        return $res;
    }
}
