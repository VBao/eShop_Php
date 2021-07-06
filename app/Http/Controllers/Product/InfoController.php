<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
use App\Models\ProductDiscount;
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
     * @OA\Get (
     *     path="/api",
     *     tags={"product"},
     *     summary="Get products for home page",
     *     operationId="index",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
//        $this->offDiscount();
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

    public function setDiscount(Request $request)
    {
        $validator = \Validator::make($request->only('product_id', 'percent', 'start_date', 'end_date'
        ), [
            'product_id' => 'required|integer|exists:product_infos,id',
            'percent' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date|after:today|date_format:Y-m-d H:i',
            'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i'
        ]);
        if ($validator->fails()) return response()->json(['error' => $validator->errors()]);
        $discount = new ProductDiscount();
        foreach ($validator->getData() as $key => $value) $discount->$key = $value;
        $product = productInfo::find($validator->getData()['product_id']);
        $current_price = $product->price;
        $discount->discount_price = $current_price - ($current_price * $validator->getData()['percent']) / 100;
        $discount->created_at = now();
        $discount->updated_at = now();
        $product->discount = true;
        $discount->save();
        $product->save();
        return response()->json(['result' => 'Successful']);

    }

//    private function offDiscount()
//    {
//        $products = productInfo::where('discount', true)->get();
//        if ($products == null) return;
//        foreach ($products as $product) {
//            $discount = ProductDiscount::query()->where('product_id', '=', $product->id)->first();
//            if (strtotime($discount) - strtotime(now()) < 0) {
//                $product->discount = false;
//                $product->save();
//            }
//        }
//    }
}
