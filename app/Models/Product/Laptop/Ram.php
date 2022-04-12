<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Ram
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Ram newModelQuery()
 * @method static Builder|Ram newQuery()
 * @method static Builder|Ram query()
 * @method static Builder|Ram whereId($value)
 * @method static Builder|Ram whereValue($value)
 * @mixin Eloquent
 */
class Ram extends Model
{
    use HasFactory;

    protected $table = 'laptop_rams';

    public function allArr(): array
    {
        $temp = [];
        foreach (Ram::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }

    public function toArraysReact(): array
    {
        $res = [];
        foreach (Ram::all() as $ram) {
            $temp = [];
            $temp['value'] = $ram->value;
            $temp['text'] = $ram->value;
            $res[] = $temp;
        }
        return $res;
    }

}
