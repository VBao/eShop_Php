<?php

namespace App\Models\Product\Laptop;

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
}
