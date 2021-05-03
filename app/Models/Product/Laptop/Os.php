<?php

namespace App\Models\Product\Laptop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Os extends Model
{
    use HasFactory;
    protected $table='laptop_os';

    public function allArr(): array
    {
        $temp = [];
        foreach (Os::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
