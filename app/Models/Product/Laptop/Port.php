<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Port
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Port newModelQuery()
 * @method static Builder|Port newQuery()
 * @method static Builder|Port query()
 * @method static Builder|Port whereId($value)
 * @method static Builder|Port whereValue($value)
 * @mixin Eloquent
 */
class Port extends Model
{
    use HasFactory;

    protected $table = 'laptop_ports';

    public function allArr(): array
    {
        $temp = [];
        foreach (Port::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
