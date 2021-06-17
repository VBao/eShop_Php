<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Type;
use App\Service\IDriveService;
use App\Service\ILaptopService;
use App\Service\IProductService;
use App\Service\SpecList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InfoController extends Controller
{

    private IProductService $productService;
    private ILaptopService $laptopService;
    private IDriveService $driveService;

//
//    public function list( $getType,$page = 1)
//    {
//        return response()->json(array_slice($this->infos->getInfosFull(), 15 * ($page - 1), 15),200);
//    }
    /**
     * InfoController constructor.
     * @param IProductService $productService
     * @param ILaptopService $laptopService
     * @param IDriveService $driveService
     */
    public function __construct(IProductService $productService, ILaptopService $laptopService, IDriveService $driveService)
    {
        $this->productService = $productService;
        $this->laptopService = $laptopService;
        $this->driveService = $driveService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->productService->brandIndex());
    }

    public function search($keywords): JsonResponse
    {
        return response()->json($this->productService->search($keywords));
    }

    public function filter(Request $request): JsonResponse
    {
        $filters = $request->toArray();
        unset($filters['type_product']);
        if ($request->type_product == 'laptop') {
            return response()->json($this->laptopService->filter($filters));
        } elseif ($request->type_product == 'drive') {
            return response()->json($this->driveService->filter($filters));
        }
        return response()->json(['error' => 'Invalid type']);
    }

    public function getAllSpecs(): JsonResponse
    {
        $specs = new SpecList();
        $types = [];
        foreach (Type::all() as $type) {
            $types[] = (object)[
                'id' => $type->id,
                'value' => $type->type
            ];
        }
        $res = (object)
        [
            'type' => $types,
            'laptop' => (object)$specs->laptop(),
            'drive' => (object)$specs->drive(),
        ];
        return response()->json($res);
    }
}
