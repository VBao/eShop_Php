<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Rom
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Rom newModelQuery()
 * @method static Builder|Rom newQuery()
 * @method static Builder|Rom query()
 * @method static Builder|Rom whereId($value)
 * @method static Builder|Rom whereValue($value)
 * @mixin Eloquent
 */
class Rom extends Model
{
    use HasFactory;

    protected $table = 'laptop_roms';

    public function allArr(): array
    {
        $temp = [];
        foreach (Rom::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }

    public function toArraysReact(): array
    {
        $res = [];
        foreach (Rom::all() as $rom) {
            $temp = [];
            $temp['value'] = $rom->value;
            $temp['text'] = $rom->value;
            $res[] = $temp;
        }
        return $res;
    }

}
