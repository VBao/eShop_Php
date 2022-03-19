<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Weight
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Weight newModelQuery()
 * @method static Builder|Weight newQuery()
 * @method static Builder|Weight query()
 * @method static Builder|Weight whereId($value)
 * @method static Builder|Weight whereValue($value)
 * @mixin Eloquent
 */
class Weight extends Model
{
    use HasFactory;

    protected $table = 'laptop_weights';

    public function allArr(): array
    {
        $temp = [];
        foreach (Weight::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
