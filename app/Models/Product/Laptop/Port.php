<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;
    protected $table='laptop_ports';
    public function allArr(): array
    {
        $temp = [];
        foreach (Port::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
