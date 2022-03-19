<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveRead
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveRead newModelQuery()
 * @method static Builder|DriveRead newQuery()
 * @method static Builder|DriveRead query()
 * @method static Builder|DriveRead whereId($value)
 * @method static Builder|DriveRead whereValue($value)
 * @mixin Eloquent
 */
class DriveRead extends Model
{
    use HasFactory;
}
