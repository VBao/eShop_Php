<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $table = 'laptop_sizes';

    public function allArr(): array
    {
        $temp = [];
        foreach (Size::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
