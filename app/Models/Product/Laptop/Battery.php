<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battery extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'laptop_batteries';

    public function allArr(): array
    {
        $temp = [];
        foreach (Battery::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
