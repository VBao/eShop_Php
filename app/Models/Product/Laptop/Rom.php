<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rom extends Model
{
    use HasFactory;

    protected $table = 'laptop_roms';

    public function allArr(): array
    {
        $temp = [];
        foreach (Rom::all() as $item) {
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
