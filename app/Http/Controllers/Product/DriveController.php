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
use App\Service\IDriveService;
use App\Service\IProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DriveController extends Controller
{
    protected IDriveService $driveService;
    protected IProductService $productService;
    protected Brand $brand;

    /**
     * DriveController constructor.
     * @param IDriveService $driveService
     * @param IProductService $productService
     * @param Brand $brand
     */
    public function __construct(IDriveService $driveService, IProductService $productService, Brand $brand)
    {
        $this->driveService = $driveService;
        $this->productService = $productService;
        $this->brand = $brand;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->driveService->list());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCreate()
    {
        return response()->json($this->driveService->getForm());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreate(Request $request)
    {
        $info=new postInfoDto;
        foreach ($request->info as $key => $val){
            $info->$key = $val;
        }
        $response = [];
        $response['info'] = $this->productService->create($info);
        $this->driveService->create($request->spec, $response['info']->id);
        $this->productService->createImages($request->images, $response['info']->id);
        return response()->json(['notify'=>'created'],201);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return response()->json($this->driveService->get($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpdate($id)
    {
        return response()->json(new DriveUpdateResource($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function postUpdate(Request $request)
    {
        $info=new postInfoDto;
        foreach ($request->info as $key => $val){
            $info->$key = $val;
        }
        $response = [];
        $response['info'] = $this->productService->putInfo($info);
        $drive=DriveSpecs::find($response['info']->id);
        foreach ($request->spec as $key => $value){
            if ($key=='drive_type_id') {
                $drive->type_id = $value;
            }else{
                $drive->$key=$value;
            }
        }
        $drive->save();
//        $this->driveService->update($request->spec, $response['info']->id);
        $this->productService->putImage($request->images, $response['info']->id);
        return response()->json(['notify'=>'updated'],202);

    }
    public function adminProducts()
    {
        $res = [];
        $tempAdd = [];
        foreach ($this->productService->getByType(2) as $key => $val) {
            $tempProduct = $this->productService->getById($val->id);
            $tempInfo = [];
            $tempInfo['id'] = $tempProduct->id;
            $tempInfo['name'] = $tempProduct->name;
            $tempInfo['description'] = $tempProduct->description;
            $tempInfo['brand'] = Brand::find($tempProduct->brand_id)->brand;
            foreach ($this->driveService->getSpecsAdmin($val->id) as $key => $value) $tempInfo[$key] = $value;
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
