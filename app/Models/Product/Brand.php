<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public function infos(){
        return $this->hasMany('App\Models\Product\productInfo','brand_id','id');
    }
}
