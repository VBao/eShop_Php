<?php

namespace App\Models\Product\Drive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Product\Drive\DriveSpecs
 *
 * @method static find(mixed $id)
 * @property int $id
 * @property int $dimension_id
 * @property int $capacity_id
 * @property int $connect_id
 * @property int $type_id
 * @property int $read_id
 * @property int $write_id
 * @property int $rotation_id
 * @property int $cache_id
 * @property-read \App\Models\Product\Drive\DriveCache $caches
 * @property-read \App\Models\Product\Drive\DriveCapacity $capacities
 * @property-read \App\Models\Product\Drive\DriveDimension $dimensions
 * @property-read \App\Models\Product\Drive\DriveRead $reads
 * @property-read \App\Models\Product\Drive\DriveRotation $rotations
 * @property-read \App\Models\Product\Drive\DriveWrite $writes
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs query()
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereCacheId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereCapacityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereConnectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereDimensionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereReadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereRotationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriveSpecs whereWriteId($value)
 * @mixin \Eloquent
 */
class DriveSpecs extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * @var mixed
     */

//    public function types()
//    {
//        return $this->belongsTo(DriveType::class,'type_id');
//    }

    public function reads(): BelongsTo
    {
        return $this->belongsTo(DriveRead::class, 'read_id');
    }

    public function writes(): BelongsTo
    {
        return $this->belongsTo(DriveWrite::class, 'write_id');
    }

    public function caches(): BelongsTo
    {
        return $this->belongsTo(DriveCache::class, 'cache_id');
    }

    public function dimensions(): BelongsTo
    {
        return $this->belongsTo(DriveDimension::class, 'dimension_id');
    }

    public function capacities(): BelongsTo
    {
        return $this->belongsTo(DriveCapacity::class, 'capacity_id');
    }

    public function rotations(): BelongsTo
    {
        return $this->belongsTo(DriveRotation::class, 'rotation_id');
    }
}
