<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveType
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveType newModelQuery()
 * @method static Builder|DriveType newQuery()
 * @method static Builder|DriveType query()
 * @method static Builder|DriveType whereId($value)
 * @method static Builder|DriveType whereValue($value)
 * @mixin Eloquent
 */
class DriveType extends Model
{
    use HasFactory;
}
