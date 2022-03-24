<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveCache
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveCache newModelQuery()
 * @method static Builder|DriveCache newQuery()
 * @method static Builder|DriveCache query()
 * @method static Builder|DriveCache whereId($value)
 * @method static Builder|DriveCache whereValue($value)
 * @mixin Eloquent
 */
class DriveCache extends Model
{
    use HasFactory;
}
