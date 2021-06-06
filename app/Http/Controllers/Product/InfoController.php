<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllSpecsResource;
use App\Http\Resources\SpecsListResource;
use App\Models\Product\Brand;
use App\Models\Product\Drive\DriveCapacity;
use App\Models\Product\Drive\DriveType;
use App\Models\Product\Laptop\Cpu;
use App\Models\Product\Laptop\Ram;
use App\Models\Product\Laptop\Screen;
use App\Models\Product\Type;
use App\Service\IDriveService;
use App\Service\ILaptopService;
use App\Service\IProductService;
use App\Service\SpecList;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->productService->brandIndex());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search($keywords)
    {
        return response()->json($this->productService->search($keywords));
    }

    public function filter(Request $request)
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

    public function getAllSpecs()
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
