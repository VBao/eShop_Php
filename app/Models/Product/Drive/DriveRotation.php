<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveRotation
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveRotation newModelQuery()
 * @method static Builder|DriveRotation newQuery()
 * @method static Builder|DriveRotation query()
 * @method static Builder|DriveRotation whereId($value)
 * @method static Builder|DriveRotation whereValue($value)
 * @mixin Eloquent
 */
class DriveRotation extends Model
{
    use HasFactory;
}
