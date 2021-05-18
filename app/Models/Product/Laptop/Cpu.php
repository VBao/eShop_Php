<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpu extends Model
{
    use HasFactory;

    protected $table = "laptop_cpus";

    public function allArr(): array
    {
        $temp = [];
        foreach (Cpu::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }


    public function toArraysReact()
    {
        $res = [];
        foreach (Rom::all() as $val) {
            $temp = [];
            $temp['value'] = $val->value;
            $temp['text'] = $val->value;
            $res[] = $temp;
        }
        return $res;
    }
}
