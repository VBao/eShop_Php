<?php

namespace App\Models\Province;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Province\Districts
 *
 * @method static Builder|Districts newModelQuery()
 * @method static Builder|Districts newQuery()
 * @method static Builder|Districts query()
 * @mixin Eloquent
 */
class Districts extends Model
{
    use HasFactory;

    protected $table = "district";
}
