<?php

namespace App\Models\Province;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Province\Wards
 *
 * @method static Builder|Wards newModelQuery()
 * @method static Builder|Wards newQuery()
 * @method static Builder|Wards query()
 * @mixin Eloquent
 */
class Wards extends Model
{
    use HasFactory;

    protected $table = "wards";
}
