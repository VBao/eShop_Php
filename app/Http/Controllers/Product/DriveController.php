<?php

namespace App\Http\Controllers\Product;

use App\Dto\Info\postInfoDto;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriveUpdateResource;
use App\Models\Product\Drive\DriveSpecs;
use App\Service\IDriveService;
use App\Service\IProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DriveController extends Controller
{
    protected IDriveService $driveService;
    protected IProductService $productService;

    /**
     * DriveController constructor.
     * @param IDriveService $driveService
     * @param IProductService $productService
     */
    public function __construct(IDriveService $driveService, IProductService $productService)
    {
        $this->driveService = $driveService;
        $this->productService = $productService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($page)
    {
//        return response()->json($this->driveService->);

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
        $response['spec'] = $this->driveService->create($request->spec, $response['info']->id);
        unset($response['spec']->id);
        $response['image'] = $this->productService->createImages($request->image, $response['info']->id);
        return response()->json($response);
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
        $response['spec'] = $this->driveService->create($request->spec, $response['info']->id);
        unset($response['spec']->id);
        $response['image'] = $this->productService->putImage($request->image, $response['info']->id);
        return response()->json($response);
    }
}
