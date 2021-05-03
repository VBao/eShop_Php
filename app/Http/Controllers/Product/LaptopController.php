<?php

namespace App\Http\Controllers\Product;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\postLaptopDto;
use App\Http\Controllers\Controller;
use App\Service\ILaptopService;
use App\Service\IProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    protected ILaptopService $laptopService;
    protected IProductService $productService;

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
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }


    public function createForm(): JsonResponse
    {
        return response()->json($this->laptopService->getForm());
    }

    public function create(Request $request): JsonResponse
    {
        $res = [];
        $postInfo = new postInfoDto;
        $postLaptop = new postLaptopDto;
        foreach ($request->info as $key => $val) {
            $postInfo->$key = $val;
        }
        $res['info'] = $this->productService->create($postInfo);
        foreach ($request->laptop as $key => $val) $postLaptop->$key = $val;
        $postLaptop->id=$res['info']->id;
        $res['laptop']=$this->laptopService->create($postLaptop);
        $this->productService->createImages($request->image,$postLaptop->id);
        unset($res['laptop']->id);
        error_log('Insert completed');
        return response()->json($res);
    }
}
