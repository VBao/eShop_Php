<?php

namespace App\Http\Controllers\Product;

use App\Dto\Info\postInfoDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriveListResource;
use App\Http\Resources\DriveUpdateResource;
use App\Http\Resources\FilterResource;
use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveSpecs;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Image;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
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

    public function filter(): JsonResponse
    {

        $filter = [];
        $drive['id'] = Type::where('type', '=', 'Drive')->first()->id;
        $drive['value'] = (object)[
            "drive_type" => DriveType::all(),
            "capacities" => DriveCapacity::all(),

        ];
        $filter['filter'] = $drive;
        return response()->json($filter);
    }

    public function postFilter(Request $request): JsonResponse
    {
        $drive_brands = [];
        foreach (Brand::where('type_id', '=', 2)->get(['id', 'brand']) as $brand)
            $drive_brands[] = (object)[
                "id" => $brand->id,
                "value" => $brand->brand,
                "active" => in_array($brand->id, $request->brand_drive)
            ];
        $filter = (object)[
            'brands' => $drive_brands,
            'capacities' => $this->capacityOption($request->drive_capacities),
            'types' => $this->typeOption($request->drive_types)
        ];

        $rawInfo = [];
        if ($request->brand_drive != null) {
            if ($request->price != null) {
                foreach ($request->brand_drive as $brand)
                    $rawInfo = array_merge($rawInfo, productInfo::where('brand_id', '=', $brand)
                        ->whereBetween('price', [$request->price[0], $request->price[1]])->get('id')->toArray());
            } else {
                foreach ($request->brand_drive as $brand) {
                    $rawInfo = array_merge($rawInfo, productInfo::where('brand_id', '=', $brand)->get('id')->toArray());
                }
            }
        } else {
            $rawInfo = ($request->price != null) ? productInfo::where('type_id', '=', 2)->whereBetween('price', [$request->price[0], $request->price[1]])->get('id') :
                productInfo::where('type_id', '=', 2)->get('id');
        }
        $data = [];
        $activeType = [];
        foreach ($request->drive_types as $item) {
            foreach (DriveType::query()->where('value', 'LIKE', "%" . $item . "%")->get('id')->toArray() as $value)
                $activeType[] = $value['id'];
        }
        $activeCapacity = [];
        foreach ($request->drive_capacities as $item) {
            foreach (DriveCapacity::query()->where('value', 'LIKE', "%" . $item . "%")->get(['id'])->toArray() as $value)
                $activeCapacity[] = $value['id'];
        }
        if ($activeType != null || $activeCapacity != null) {
            if ($activeType == null) {
                foreach ($rawInfo as $info) {
                    $checkDrive = DriveSpecs::find($info['id']);
                    if (in_array($checkDrive->capacity_id, $activeCapacity))
                        $data[] = new DriveListResource(productInfo::find($info['id']));
                }
            } else {
                if ($activeCapacity == null) {
                    foreach ($rawInfo as $info) {
                        $checkDrive = DriveSpecs::find($info['id']);
                        if (in_array($checkDrive->type_id, $activeType))
                            $data[] = new DriveListResource(productInfo::find($info['id']));
                    }
                } else {
                    foreach ($rawInfo as $info) {
                        $checkDrive = DriveSpecs::find($info['id']);
                        if (in_array($checkDrive->type_id, $activeType) && in_array($checkDrive->capacity_id, $activeCapacity))
                            $data[] = new DriveListResource(productInfo::find($info['id']));
                    }
                }
            }
        } else {
            foreach ($rawInfo as $item) $data[] = new DriveListResource(productInfo::find($item['id']));
        }
        $res = array_slice($data, ($request->page - 1) * 12, 12);
        return response()->json([
            'type' => 'drive',
            'filter' => $filter,
            'data' => $res,
            'cur_page' => $request->page,
            'max_page' => ceil(count($data) / 12),
        ]);
    }

    private function capacityOption($requestCapacities): array
    {
        $capacityList = [];
        $capacityCheck = [];
        $capacities = [];
        foreach (DriveCapacity::all() as $item) {
            $capacity_value = explode(', ', $item->value, 2)[0];
            if (!in_array($capacity_value, $capacityList)) {
                $capacityList[] = $capacity_value;
            }
        }
        if (!is_null($requestCapacities)) foreach ($requestCapacities as $searchCapacity) {
            $activeType = DriveType::query()->where('value', 'LIKE', "%" . $searchCapacity . "%")->get(['id']);
            if (!is_null($activeType)) {
                $capacityCheck[] = $searchCapacity;
                $capacities[] = ['value' => $searchCapacity, 'active' => true];
            }
        }
        foreach (array_diff($capacityList, $capacityCheck) as $inactiveType) {
            $capacities[] = ['value' => $inactiveType, 'active' => false];
        }
        return $capacities;
    }

    private function typeOption($requestType): array
    {
        $typeList = [];
        $typeCheck = [];
        $types = [];
        foreach (DriveType::all() as $item) {
            $type_value = explode(', ', $item->value, 2)[0];
            if (!in_array($type_value, $typeList)) {
                $typeList[] = $type_value;
            }
        }
        if (!is_null($requestType)) foreach ($requestType as $searchType) {
            $activeType = DriveType::query()->where('value', 'LIKE', "%" . $searchType . "%")->get(['id']);
            if (!is_null($activeType)) {
                $typeCheck[] = $searchType;
                $types[] = ['value' => $searchType, 'active' => true];
            }
        }
        foreach (array_diff($typeList, $typeCheck) as $inactiveType) {
            $types[] = ['value' => $inactiveType, 'active' => false];
        }
        return $types;
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
        if (count(productInfo::where('name', 'LIKE', '%' . $request->info['name'] . '%')->get()->toArray()) != 0) return response()->json(['error' => 'Already have product with name - ' . $request->info['name']], 400);
        if (count($request->image) < 3) return response()->json(['error' => 'Accept at least 3 image'], 400);
        $info = new postInfoDto;
        foreach ($request->info as $key => $val) {
            $info->$key = $val;
        }
        $response = [];
        $response['info'] = $this->productService->create($info);
        $this->driveService->create($request->spec, $response['info']->id);
        $this->productService->createImages($request->image, $response['info']->id);
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
        foreach ($request->info as $key => $val) {
            $info->$key = $val;
        }
        $response = [];
        $response['info'] = $this->productService->putInfo($info);
        $drive = DriveSpecs::find($response['info']->id);
        foreach ($request->spec as $key => $value) {
            if ($key == 'drive_type_id') {
                $drive->type_id = $value;
            } else {
                $drive->$key = $value;
            }
        }
        $drive->save();
//        $this->driveService->update($request->spec, $response['info']->id);
        $this->productService->putImage($request->images, $response['info']->id);
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
