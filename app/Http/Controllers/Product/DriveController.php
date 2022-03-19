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
use App\Service\IDriveService;
use App\Service\IProductService;
use App\Service\IValidate;
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

    public function getFilter(): JsonResponse
    {
        $filter['filter'] = $this->driveService->filterCheck();
        $filter['data'] = $this->driveService->list();
        return response()->json($filter);
    }

    public function postFilter(Request $request): JsonResponse
    {
        $filter = $this->driveService->filterCheck();
        $data = $this->driveService->postFilter($request->get('brand'), $request->get('capacity'), $request->get('type'), $request->get('price'));
        $data = array_slice($data, ($request->get('page') - 1) * 12, 12);
        return response()->json([
            'filter' => $filter,
            'data' => $data,
            'cur_page' => $request->get('page'),
            'max_page' => ceil(count(productInfo::where('type_id', '=', 2)->get()) / 12),
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
        $info = new postInfoDto;
        foreach ($request->get('info') as $key => $val) {
            $info->$key = $val;
        }
        $response = [];
        $response['info'] = $this->productService->create($info);
        $this->driveService->create($request->get('spec'), $response['info']->id);
        $this->productService->createImages($request->get('image'), $response['info']->id);
        return response()->json(['notify' => 'created'], 201);
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
//        $this->driveService->update($request->spec, $response['info']->id);
        $this->productService->putImage($request->get('images'), $response['info']->id);
        return response()->json(['notify' => 'updated'], 202);

    }

    public function adminProducts(): array
    {
        $res = [];
        $tempAdd = [];
        foreach ($this->productService->getByType(2) as $val) {
            $tempProduct = $this->productService->getById($val->id);
            $tempInfo = [];
            $tempInfo['id'] = $tempProduct->id;
            $tempInfo['name'] = $tempProduct->name;
            $tempInfo['created_at'] = $tempProduct->created_at;
            $tempInfo['updated_at'] = $tempProduct->updated_at;
            $tempInfo['description'] = $tempProduct->description;
            $tempInfo['brand'] = Brand::find($tempProduct->brand_id)->brand;
            $tempInfo['price'] = $tempProduct->price;
            $tempInfo['image'] = Image::where('info_id', '=', $tempProduct->id)->first()->link_image;
            foreach ($this->driveService->getSpecsAdmin($val->id) as $key1 => $value) $tempInfo[$key1] = $value;
            $tempAdd[] = $tempInfo;
        }
        $res['data'] = $tempAdd;
        $res['filter'] = [
            'Brand' => $this->brand->toArraysReact(2),
            'type' => FilterResource::collection(DriveType::all()),
            'capacity' => FilterResource::collection(DriveCapacity::all()),
        ];
        return $res;
    }
}
