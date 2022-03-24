<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveCapacity
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveCapacity newModelQuery()
 * @method static Builder|DriveCapacity newQuery()
 * @method static Builder|DriveCapacity query()
 * @method static Builder|DriveCapacity whereId($value)
 * @method static Builder|DriveCapacity whereValue($value)
 * @mixin Eloquent
 */
class DriveCapacity extends Model
{
    use HasFactory;
}
