<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Cpu
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Cpu newModelQuery()
 * @method static Builder|Cpu newQuery()
 * @method static Builder|Cpu query()
 * @method static Builder|Cpu whereId($value)
 * @method static Builder|Cpu whereValue($value)
 * @mixin Eloquent
 */
class Cpu extends Model
{
    use HasFactory;

    protected $table = "laptop_cpus";

    public function allArr(): array
    {
        $temp = [];
        foreach (Cpu::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }


}
