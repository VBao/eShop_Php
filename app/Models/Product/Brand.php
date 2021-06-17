<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function infos()
    {
        return $this->hasMany('App\Models\Product\productInfo', 'brand_id', 'id');
    }

    public function toArraysReact($id)
    {
        $res = [];
        foreach (Brand::where('type_id', $id)->get() as $brand) {
            $temp_brand = [];
            $temp_brand['value'] = $brand->brand;
            $temp_brand['text'] = $brand->brand;
            $res[] = $temp_brand;
        }
        return $res;

    }

}
