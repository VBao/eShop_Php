<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gpu extends Model
{
    use HasFactory;
    protected $table="laptop_gpus";

    public function allArr(): array
    {
        $temp = [];
        foreach (Gpu::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
