<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Battery
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Battery newModelQuery()
 * @method static Builder|Battery newQuery()
 * @method static Builder|Battery query()
 * @method static Builder|Battery whereId($value)
 * @method static Builder|Battery whereValue($value)
 * @mixin Eloquent
 */
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
