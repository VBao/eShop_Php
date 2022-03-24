<?php

namespace App\Models\Product;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Type
 *
 * @property int $id
 * @property string $type
 * @method static Builder|Type newModelQuery()
 * @method static Builder|Type newQuery()
 * @method static Builder|Type query()
 * @method static Builder|Type whereId($value)
 * @method static Builder|Type whereType($value)
 * @mixin Eloquent
 */
class Type extends Model
{
    protected $table = 'types';
    use HasFactory;
}
