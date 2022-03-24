<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Screen
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Screen newModelQuery()
 * @method static Builder|Screen newQuery()
 * @method static Builder|Screen query()
 * @method static Builder|Screen whereId($value)
 * @method static Builder|Screen whereValue($value)
 * @mixin Eloquent
 */
class Screen extends Model
{
    use HasFactory;

    protected $table = 'laptop_screens';

    public function allArr(): array
    {
        $temp = [];
        foreach (Screen::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
