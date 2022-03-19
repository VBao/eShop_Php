<?php

namespace App\Models\Product\Drive;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Drive\DriveWrite
 *
 * @property int $id
 * @property string $value
 * @method static Builder|DriveWrite newModelQuery()
 * @method static Builder|DriveWrite newQuery()
 * @method static Builder|DriveWrite query()
 * @method static Builder|DriveWrite whereId($value)
 * @method static Builder|DriveWrite whereValue($value)
 * @mixin Eloquent
 */
class DriveWrite extends Model
{
    use HasFactory;
}
