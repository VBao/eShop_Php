<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowListResource;
use App\Models\Cart;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
use App\Models\ProductDiscount;
use App\Service\IDriveService;
use App\Service\ILaptopService;
use App\Service\IProductService;
use App\Service\SpecList;
use Illuminate\Database\Eloquent\Model;
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
        return response()->json($this->productService->brandIndex());
    }

    public function search(Request $request): JsonResponse
    {
        foreach (productInfo::query()->where('name', 'LIKE', $request->keywords . '%')->get() as $item)
            $data_full[] = new ShowListResource($item);
        if ($request->has('page')) {
            $data = array_slice($data_full, ($request->page - 1) * 12, 12);
        } else {
            $data = array_slice($data_full, 1, 12);
        }
        return response()->json([
            'data' => $data,
            'cur_page' => $request->has('page') ? $request->page : 1,
            'max_page' => ceil(count($data_full) / 12)
        ]);
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
        $product_check = ProductDiscount::query()->where('product_id', '=', $validator->getData()['product_id'])->first();
        if ($product_check != null) {
            if (($product_check->start_date > $request->start_date && $product_check->start_date < $request->end_date) || ($product_check->end_date > $request->end_date && $product_check->end_date < $request->end_date)) {
                return response()->json(['error' => 'Conflict start time ' . $product_check->start_date . ' or end time ' . $product_check->end_date]);
            } else if ($product_check->start_date == $request->start_date) {
                $discount = $product_check;
                $discount->updated_at = now();
            } else {
                $discount = new ProductDiscount();
                $discount->created_at = now();
                $discount->updated_at = now();
            }
        } else {
            $discount = new ProductDiscount();
            $discount->created_at = now();
            $discount->updated_at = now();
        }
        foreach ($validator->getData() as $key => $value) $discount->$key = $value;
        $current_price = productInfo::find($validator->getData()['product_id'])->price;
        $discount->discount_price = (int)round($current_price - ($current_price * $validator->getData()['percent']) / 100, -3);
        $discount->save();
        return response()->json(['result' => 'Successful']);
    }

    public function delDiscount($id)
    {
        if (ProductDiscount::query()->find($id) == null) {
            return response()->json(['error' => 'Not found discount with id: ' . $id]);
        } else {
            ProductDiscount::query()->find($id)->delete();
            return response()->json(['result' => 'Success']);
        }

    }
}
