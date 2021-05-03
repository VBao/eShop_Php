<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maxRam extends Model
{
    use HasFactory;
    protected $table='laptop_max_rams';

    public function allArr(): array
    {
        $temp = [];
        foreach (maxRam::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
