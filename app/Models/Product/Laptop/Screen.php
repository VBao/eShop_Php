<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasFactory;
    protected $table='laptop_screens';

    public function allArr(): array
    {
        $temp = [];
        foreach (Screen::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
