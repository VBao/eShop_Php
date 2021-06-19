<?php

namespace App\Http\Controllers;

use App\Models\Product\Brand;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="darius@matulionis.lt"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test($page = 1)
    {
        $tempArr = [];
        foreach (productInfo::all()->makeHidden(['brand_id', 'type_id']) as $product) {
            $productDto = new productInfoGetList();
            $productDto->info = $product;
            $productDto->brand = Brand::where('id', $product->brand_id)->first();
            $productDto->type = Type::where('id', $product->type_id)->first();
            $tempArr[] = $productDto;
        }
        $res = array_slice($tempArr, 15 * ($page - 1), 15);
        return response()->json($res);
    }
}
