<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Size
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Size newModelQuery()
 * @method static Builder|Size newQuery()
 * @method static Builder|Size query()
 * @method static Builder|Size whereId($value)
 * @method static Builder|Size whereValue($value)
 * @mixin Eloquent
 */
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
