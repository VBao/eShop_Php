<?php

namespace App\Models\Product\Laptop;

use App\Models\Product\Image;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product\Laptop\laptopSpec
 *
 * @property int $id
 * @property int $cpu_id
 * @property int $gpu_id
 * @property int $ram_id
 * @property int $rom_id
 * @property int $os_id
 * @property int $battery_id
 * @property int $screen_id
 * @property int $weight_id
 * @property int $size_id
 * @property int $port_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Battery $battery
 * @property-read Cpu $cpu
 * @property-read Gpu $gpu
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read Os $os
 * @property-read Port $port
 * @property-read Ram $ram
 * @property-read Rom $rom
 * @property-read Screen $screen
 * @property-read Size $size
 * @property-read Weight $weight
 * @method static Builder|laptopSpec newModelQuery()
 * @method static Builder|laptopSpec newQuery()
 * @method static Builder|laptopSpec query()
 * @method static Builder|laptopSpec whereBatteryId($value)
 * @method static Builder|laptopSpec whereCpuId($value)
 * @method static Builder|laptopSpec whereCreatedAt($value)
 * @method static Builder|laptopSpec whereGpuId($value)
 * @method static Builder|laptopSpec whereId($value)
 * @method static Builder|laptopSpec whereOsId($value)
 * @method static Builder|laptopSpec wherePortId($value)
 * @method static Builder|laptopSpec whereRamId($value)
 * @method static Builder|laptopSpec whereRomId($value)
 * @method static Builder|laptopSpec whereScreenId($value)
 * @method static Builder|laptopSpec whereSizeId($value)
 * @method static Builder|laptopSpec whereUpdatedAt($value)
 * @method static Builder|laptopSpec whereWeightId($value)
 * @mixin Eloquent
 */
class laptopSpec extends Model
{
    use HasFactory;

    public function port(): BelongsTo
    {
        return $this->belongsTo(Port::class);
    }

    public function cpu(): BelongsTo
    {
        return $this->belongsTo(Cpu::class);
    }

    public function gpu(): BelongsTo
    {
        return $this->belongsTo(Gpu::class);
    }

    public function ram(): BelongsTo
    {
        return $this->belongsTo(Ram::class);
    }

    public function rom(): BelongsTo
    {
        return $this->belongsTo(Rom::class);
    }

    public function weight(): BelongsTo
    {
        return $this->belongsTo(Weight::class);
    }

    public function os(): BelongsTo
    {
        return $this->belongsTo(Os::class);
    }

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function battery(): BelongsTo
    {
        return $this->belongsTo(Battery::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
