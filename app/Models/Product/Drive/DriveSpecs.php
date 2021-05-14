<?php

namespace App\Models\Product\Drive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriveSpecs extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * @var mixed
     */

    public function types()
    {
        return $this->belongsTo(DriveType::class,'_id');
    }

    public function reads()
    {
        return $this->belongsTo(DriveRead::class,'read_id');
    }

    public function writes()
    {
        return $this->belongsTo(DriveWrite::class,'write_id');
    }

    public function caches()
    {
        return $this->belongsTo(DriveCache::class,'cache_id');
    }

    public function dimensions()
    {
        return $this->belongsTo(DriveDimension::class,'dimension_id');
    }

    public function capacities()
    {
        return $this->belongsTo(DriveCapacity::class,'capacity_id');
    }

    public function rotations()
    {
        return $this->belongsTo(DriveRotation::class,'rotation_id');
    }
}
