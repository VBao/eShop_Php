<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
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
        return response()->json($this->productService->brandIndex());
    }

    public function search(Request $request): JsonResponse
    {

        $filter = [];
        $filter['laptop'] = $this->laptopService->filterCheck($request->get('laptop')['brand'], $request->get('laptop')['ram'], $request->get('laptop')['screen'], $request->get('laptop')['cpu']);
        $filter['drive'] = $this->driveService->filterCheck($request->get('drive')['brand'], $request->get('drive')['capacity'], $request->get('drive')['type']);

//        $data = [];
//        $data[] = ;
        $data = array_merge($this->laptopService->postFilter($request->get('laptop')['brand'], $request->get('laptop')['ram'], $request->get('laptop')['screen'], $request->get('laptop')['cpu'], $request->get('price'), $request->get('keyword')),$this->driveService->postFilter($request->get('drive')['brand'], $request->get('drive')['capacity'], $request->get('drive')['type'], $request->get('price'), $request->get('keyword')));

        $result = array_slice($data, ($request->get('page') - 1) * 12, 12);

        return response()->json([
            'filter' => $filter,
            'data' => $result,
            'cur_page' => $request->get('page'),
            'max_page' => ceil(count($data) / 12)
        ]);
    }

    public function filter(Request $request): JsonResponse
    {
        $filters = $request->toArray();
        unset($filters['type_product']);
        if ($request->get('type_product') == 'laptop') {
            return response()->json($this->laptopService->filter($filters));
        } elseif ($request->get('type_product') == 'drive') {
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
            'start_date' => 'required|date|after:now|date_format:Y-m-d H:i',
            'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i'
        ]);
        if ($validator->fails()) return response()->json(['error' => $validator->errors()]);
        $product_check = ProductDiscount::query()->where('product_id', '=', $validator->getData()['product_id'])->get();
        if ($product_check != null) {
            foreach ($product_check as $item)
                if (($request->start_date <= $item->start_date && ($item->start_date <= $request->end_date && $request->end_date <= $item->end_date))
                    || (($item->start_date <= $request->start_date && $request->start_date <= $item->end_date) && $item->end_date <= $request->end_date)
                    || ($request->start_date <= $item->start_date && $item->end_date <= $request->end_date)
                    || ($request->start_date >= $item->start_date && $request->end_date <= $item->end_date))
                    return response()->json(['error' => 'Conflict start time ' . $item->start_date . ' or end time ' . $item->end_date]);
        }
        $discount = new ProductDiscount();
        $discount->created_at = now();
        $discount->updated_at = now();
        foreach ($validator->getData() as $key => $value) $discount->$key = $value;
        $current_price = productInfo::find($validator->getData()['product_id'])->price;
        $discount->discount_price = (int)round($current_price - ($current_price * $validator->getData()['percent']) / 100, -3);
        $discount->save();
        return response()->json(['result' => 'Successful']);
    }

    public
    function putDiscount(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'required|integer|exists:product_discounts',
            'percent' => 'integer|min:1|max:100',
            'start_date' => 'date|after:now|date_format:Y-m-d H:i',
            'end_date' => 'date|after:start_date|date_format:Y-m-d H:i',
        ]);
        if ($validator->fails()) return response()->json(['error' => $validator->errors()]);
        $discount = ProductDiscount::query()->find($request->id);
        $product_check = ProductDiscount::query()->where('product_id', '=', $discount->product_id)->get();
        if ($request->has('percent')) $discount->percent = $request->percent;
        if ($request->has('start_date') && $request->has('end_date')) {
            foreach ($product_check as $item) {
                if ((($request->start_date <= $item->start_date && ($item->start_date <= $request->end_date && $request->end_date <= $item->end_date))
                        || (($item->start_date <= $request->start_date && $request->start_date <= $item->end_date) && $item->end_date <= $request->end_date)
                        || ($request->start_date <= $item->start_date && $item->end_date <= $request->end_date)
                        || ($request->start_date >= $item->start_date && $request->get('end_date') <= $item->end_date)) && $item->id != $discount->id)
                    return response()->json(['error' => 'Conflict start time ' . $item->start_date . ' or end time ' . $item->end_date]);
            }
            $discount->start_date = $request->get('start_date');
            $discount->end_date = $request->get('end_date');
        } else {
            if ($request->has('start_date')) {
                if ($request->get('start_date') >= $discount->end_date) return response()->json(['error' => 'Start time must before end date - ' . $discount->end_date]);
                foreach ($product_check as $item) {
                    if ((($request->start_date <= $item->start_date && ($item->start_date <= $discount->end_date && $discount->end_date <= $item->end_date))
                            || (($item->start_date <= $request->start_date && $request->start_date <= $item->end_date) && $item->end_date <= $discount->end_date)
                            || ($request->start_date <= $item->start_date && $item->end_date <= $discount->end_date)
                            || ($request->start_date >= $item->start_date && $discount->end_date <= $item->end_date)) && $item->id != $discount->id)
                        return response()->json(['error' => 'Conflict start time ' . $item->start_date . ' or end time ' . $item->end_date]);
                }
                $discount->start_date = $request->start_date;
            }
            if ($request->has('end_date')) {
                if ($request->end_date <= $discount->start_date) return response()->json(['error' => 'End time must after start date - ' . $discount->start_date]);
                foreach ($product_check as $item) {
                    if ((($discount->start_date <= $item->start_date && ($item->start_date <= $discount->end_date && $discount->end_date <= $item->end_date))
                            || (($item->start_date <= $discount->start_date && $discount->start_date <= $item->end_date) && $item->end_date <= $discount->end_date)
                            || ($discount->start_date <= $item->start_date && $item->end_date <= $discount->end_date)
                            || ($discount->start_date >= $item->start_date && $discount->end_date <= $item->end_date)) && $item->id != $discount->id)
                        return response()->json(['error' => 'Conflict start time ' . $item->start_date . ' or end time ' . $item->end_date]);
                }
                $discount->end_date = $request->get('end_date');
            }
        }
        $discount->save();
        return response()->json(['result' => 'Success']);
    }

    public
    function delDiscount($id): JsonResponse
    {
        if (ProductDiscount::query()->find($id) == null) {
            return response()->json(['error' => 'Not found discount with id: ' . $id]);
        } else {
            ProductDiscount::query()->find($id)->delete();
            return response()->json(['result' => 'Success']);
        }
    }


}
