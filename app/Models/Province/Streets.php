<?php

namespace App\Models\Province;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Province\Streets
 *
 * @method static Builder|Streets newModelQuery()
 * @method static Builder|Streets newQuery()
 * @method static Builder|Streets query()
 * @mixin Eloquent
 */
class Streets extends Model
{
    use HasFactory;

    protected $table = "street";
}
