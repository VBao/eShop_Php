<?php

namespace App\Models\Province;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Province\Provinces
 *
 * @method static Builder|Provinces newModelQuery()
 * @method static Builder|Provinces newQuery()
 * @method static Builder|Provinces query()
 * @mixin Eloquent
 */
class Provinces extends Model
{
    use HasFactory;

    protected $table = "province";

}
