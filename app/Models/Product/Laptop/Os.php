<?php

namespace App\Models\Product\Laptop;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Laptop\Os
 *
 * @property int $id
 * @property string $value
 * @method static Builder|Os newModelQuery()
 * @method static Builder|Os newQuery()
 * @method static Builder|Os query()
 * @method static Builder|Os whereId($value)
 * @method static Builder|Os whereValue($value)
 * @mixin Eloquent
 */
class Os extends Model
{
    use HasFactory;

    protected $table = 'laptop_os';

    public function allArr(): array
    {
        $temp = [];
        foreach (Os::all() as $item) {
            $temp[] = $item;
        }
        return $temp;
    }
}
