<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveConnect
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveConnect newModelQuery()
 * @method static Builder|DriveConnect newQuery()
 * @method static Builder|DriveConnect query()
 * @method static Builder|DriveConnect whereId($value)
 * @method static Builder|DriveConnect whereValue($value)
 * @mixin Eloquent
 */
class DriveConnect extends Model
{
    use HasFactory;
}
