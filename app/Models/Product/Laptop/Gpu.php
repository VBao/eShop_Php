<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Gpu
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Gpu newModelQuery()
 * @method static Builder|Gpu newQuery()
 * @method static Builder|Gpu query()
 * @method static Builder|Gpu whereId($value)
 * @method static Builder|Gpu whereValue($value)
 * @mixin Eloquent
 */
class Gpu extends Model
{
    use HasFactory;

    protected $table = "laptop_gpus";

    public function allArr(): array
    {
        $temp = [];
        foreach (Gpu::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
