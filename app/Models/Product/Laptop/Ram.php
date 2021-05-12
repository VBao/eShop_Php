<?php

namespace App\Models\Product\Laptop;

use App\Models\Product\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    use HasFactory;
    protected $table='laptop_rams';

    public function allArr(): array
    {
        $temp = [];
        foreach (Ram::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
    public function toArraysReact()
    {
        $res=[];
        foreach (Ram::all() as $val){
            $temp=[];
            $temp['value']=$val->id;
            $temp['text']=$val->value;
            $res[]=$temp;
        }
        return $res;
    }
}
