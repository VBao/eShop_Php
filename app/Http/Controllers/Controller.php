<?php

namespace App\Http\Controllers;

use App\Dto\productInfoGetList;
use App\Models\Product\Brand;
use App\Models\Product\productInfo;
use App\Models\Product\Type;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test($page=1)
    {
        $tempArr = [];
        foreach (productInfo::all()->makeHidden(['brand_id', 'type_id']) as $product) {
            $productDto = new productInfoGetList();
            $productDto->info = $product;
            $productDto->brand = Brand::where('id', $product->brand_id)->first();
            $productDto->type = Type::where('id', $product->type_id)->first();
            $tempArr[] = $productDto;
        }
        $res=array_slice($tempArr,15*($page-1),15);
        return response()->json($res);
    }
}
