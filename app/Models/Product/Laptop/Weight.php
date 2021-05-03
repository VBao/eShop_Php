<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;
    protected $table='laptop_weights';

    public function allArr(): array
    {
        $temp = [];
        foreach (Weight::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
