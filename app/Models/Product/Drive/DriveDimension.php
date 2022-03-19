<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveDimension
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveDimension newModelQuery()
 * @method static Builder|DriveDimension newQuery()
 * @method static Builder|DriveDimension query()
 * @method static Builder|DriveDimension whereId($value)
 * @method static Builder|DriveDimension whereValue($value)
 * @mixin Eloquent
 */
class DriveDimension extends Model
{
    use HasFactory;
}
